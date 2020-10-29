<?php
namespace Core;

use PDO;
use PDOException;

class DB{
    public static $config = [];

    public static function connectDB()
    {
        if (count(self::$config)) {
            try {
                $dns = "mysql:dbname=" . self::$config['dbname'] . ";host=" . self::$config['host'].";charset=".self::$config['charset'];
                $username = self::$config['username'];
                $password = self::$config['password'];
                return new PDO($dns, $username, $password);
            } catch (PDOException $e) {
                return "Connection failed: " . $e->getMessage();
            }
        }
    }

    public static function query($sql){
        $conn = DB::connectDB();
        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}