<?php

namespace Core;

use Core\DB;
use Exception;
use PDO;

class Model
{

    public $connect;
    protected $table;
    private $groupBy         = [];
    private $query           = '';
    private $data            = [];
    private $where           = [];
    private $having          = [];
    private $join            = [];
    private $lastInsertId    = "";
    private $orderBy         = [];
    private $limit           = [];
    private $params          = [];
    private $rowCount        = 0;
    private $updateColumns   = [];
    protected $lastError     = '';
    protected $lastErrorCode = '';

    public function __construct()
    {
        $this->connect = DB::connectDB();
    }


    public function insert(array $data)
    {
        $fields = '';
        $values = '';
        $bindData = [];

        foreach ($data as $key => $value) {
            $fields .= ", $key";
            $values .= ", ? ";
            $bindData[] = $value;
        }

        $this->query         = "INSERT INTO " . $this->table . "(" . trim($fields, ',') . ") VALUES (" . trim($values, ',') . ")";
        
        $stmt                = $this->connect->prepare($this->query);
        $status              = $stmt->execute($bindData);
        $this->rowCount      = $stmt->rowCount();
        $this->lastError     = $stmt->errorInfo();
        $this->lastErrorCode = $stmt->errorCode();
        $this->reset();


        if ($status && $this->connect->lastInsertId() > 0) {
            $this->lastInsertId = $this->connect->lastInsertId();
            return (int) $this->lastInsertId;
        }

        return $status;
    }

    public function save()
    {
        if (count($this->data)) {
            return $this->insert($this->data);
        }
        return false;
    }


    public function get()
    {
        $fields = "*";
        if (count($this->params)) {
            $fields = implode(",", $this->params);
        }

        $this->query  = "SELECT $fields FROM $this->table";
        $this->buildJoin();

        if (count($this->where)) {
            $where = ' WHERE ';
            foreach ($this->where as $wheres) {
                $where .= implode(" ", $wheres);
            }
            $this->query .= $where;
        }

        $this->buildOrderBy();
        $this->buildGroupBy();

        if (count($this->limit)) {
            $this->query .= ' LIMIT ' . $this->limit['start'] . ' , ' . $this->limit['limit'];
        }

        $stmt = $this->connect->prepare($this->query);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $this->reset();
        return $stmt->fetchAll();
    }

    public function getOne()
    {
        $fields = "*";
        if (count($this->params)) {
            $fields = implode(",", $this->params);
        }

        $this->query  = "SELECT $fields FROM $this->table";
        $this->buildJoin();
        if (count($this->where)) {
            $where = ' WHERE ';
            foreach ($this->where as $wheres) {
                $where .= implode(" ", $wheres);
            }
            $this->query .= $where;
        }

        $stmt = $this->connect->prepare($this->query);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $this->reset();
        return $stmt->fetch();
    }

    public function update()
    {
        $set = '';
        $data = $this->data;
        $values = [];

        foreach ($data as $key => $value) {
            $set .= "$key = ?,";
            $values[] = $value;
        }

        $this->query = "UPDATE " . $this->table . " SET " . trim($set, ',');

        if (count($this->where)) {
            $where = ' WHERE ';
            foreach ($this->where as $wheres) {
                $where .= implode(" ", $wheres);
            }
            $this->query .= $where;
        }

        $stmt                = $this->connect->prepare($this->query);
        $status              = $stmt->execute($values);
        $this->rowCount      = $stmt->rowCount();
        $this->lastError     = $stmt->errorInfo();
        $this->lastErrorCode = $stmt->errorCode();
        $this->reset();
        return $status;
    }

    public function delete()
    {
        $this->query = "DELETE FROM $this->table";
        if (count($this->where)) {
            $where = ' WHERE ';
            foreach ($this->where as $wheres) {
                $where .= implode(" ", $wheres);
            }
            $this->query .= $where;
        }

        $stmt                = $this->connect->prepare($this->query);
        $status              = $stmt->execute();
        $this->rowCount      = $stmt->rowCount();
        $this->lastError     = $stmt->errorInfo();
        $this->lastErrorCode = $stmt->errorCode();
        $this->reset();
        return $status;
    }

    public function query($sql, $params = [])
    {
        $stmt = $this->connect->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute($params);
        $this->reset();
        return $stmt->fetchAll();
    }


    public function groupBy($groupByField)
    {
        $groupByField    = preg_replace("/[^-a-z0-9\.\(\),_\*]+/i", '', $groupByField);
        $this->groupBy[] = $groupByField;
        return $this;
    }

    public function join($joinTable, $joinCondition, $joinType = '')
    {
        $allowedTypes = array('LEFT', 'RIGHT', 'OUTER', 'INNER', 'LEFT OUTER', 'RIGHT OUTER');
        $joinType     = strtoupper(trim($joinType));

        if ($joinType && !in_array($joinType, $allowedTypes)) {
            throw new Exception('Wrong JOIN type: ' . $joinType);
        }

        $this->join[] = [$joinType, $joinTable, $joinCondition];

        return $this;
    }

    private function buildJoin()
    {
        if (!count($this->join)) {
            return;
        }

        $short = substr($this->table, 0, 1);
        $this->query .= " $short ";

        foreach ($this->join as $data) {
            list($joinType, $joinTable, $joinCondition) = $data;
            $this->query .= " JOIN $joinType $joinTable ON $joinCondition";
        }
    }

    private function buildGroupBy(){
        
        if (!count($this->groupBy)) {
            return;
        }
        list($field) = $this->groupBy;
        $this->query .= " GROUP BY $field";
    }

    private function buildOrderBy()
    {
        if (!count($this->orderBy)) {
            return;
        }
        list($field, $direction) = $this->orderBy;
        $this->query .= " ORDER BY $field $direction";
        return;
    }

    public function orderBy($orderByField, $orderbyDirection = "DESC")
    {
        $allowedDirection = ["ASC", "DESC"];
        $orderbyDirection = strtoupper(trim($orderbyDirection));
        $orderByField     = preg_replace("/[^-a-z0-9\.\(\),_`\*\'\"]+/i", '', $orderByField);

        if (empty($orderbyDirection) || !in_array($orderbyDirection, $allowedDirection)) {
            throw new Exception('Wrong order direction: ' . $orderbyDirection);
        }

        $this->orderBy[] = $orderByField;
        $this->orderBy[] = $orderbyDirection;
        return $this;
    }

    public function where($whereProp, $whereValue = 'NULL', $operator = '=', $cond = 'AND')
    {
        if (count($this->where) == 0) {
            $cond = '';
        }
        $whereValue = "'$whereValue'";
        $this->where[] = [$cond, $whereProp, $operator, $whereValue];
        return $this;
    }

    public function limit($limit, $start = 0)
    {
        $this->limit = ['limit' => $limit, 'start' => $start];
        return $this;
    }

    public function params(array $fields)
    {
        $this->params = $fields;
        return $this;
    }

    public function now($func = "NOW()")
    {
        return $func;
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    private function reset()
    {
        $this->groupBy         = [];
        $this->having          = [];
        $this->join            = [];
        $this->lastInsertId    = "";
        $this->lockInShareMode = false;
        $this->nestJoin        = false;
        $this->orderBy         = [];
        $this->params          = [];
        $this->query           = '';
        $this->queryOptions    = [];
        $this->queryType       = '';
        $this->rowCount        = 0;
        $this->updateColumns   = [];
        $this->where           = [];
        $this->data            = [];
    }
}
