<?php
namespace App\Middleware;
use Core\App;

class FalseLogin{
    public function handle()
    {
        if (App::getSession('user')) {
            App::redirect('');
            return false;
        }
        return true;
    }
}