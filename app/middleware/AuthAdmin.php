<?php
namespace App\Middleware;
use Core\App;

class AuthAdmin{
    public function handle()
    {
        if (!App::getSession('user') && App::getSession('user')['role'] != 1) {
            App::redirect('');
            return false;
        }
        return true;
    }
}