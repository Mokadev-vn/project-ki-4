<?php
namespace App\Middleware;
use Core\App;

class CheckLogin{
    public function handle()
    {
        if (!App::getSession('user')) {
            App::redirect('login');
            return false;
        }
        return true;
    }
}