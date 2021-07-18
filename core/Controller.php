<?php
namespace Core;

class Controller {

    public function view($nameView, $data = []){
        extract($data);
        $nameView = str_replace('.', DIRECTORY_SEPARATOR, $nameView) . '.php';
        if(file_exists("resources/views/$nameView")){
            include_once("resources/views/$nameView");
        }
    }

}