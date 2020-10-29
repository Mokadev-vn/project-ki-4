<?php
namespace Core;

class Middleware {
    public static array $middleware;
    
    public $result = '';
    public function __construct(string $middlName){
        if(array_key_exists($middlName, self::$middleware)){
            $class = new self::$middleware[$middlName]();
            $this->result = $class->handle();
        }
    }

    public function get(){
        return $this->result;
    }

}