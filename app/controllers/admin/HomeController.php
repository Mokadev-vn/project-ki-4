<?php
namespace App\Controllers\Admin;
use Core\Controller;
use App\Models\Product;
use App\Models\User;

class HomeController extends Controller{
    public function index(){
        $product = new Product();
        $totalProduct = $product->params(['COUNT(*) AS total'])->getOne();

        $user = new User();
        $totalUser = $user->params(['COUNT(*) AS total'])->getOne();

        $totalSale = $product->params(['COUNT(*) AS total'])->where('sale',0,'>')->getOne();

        return $this->view('admin.index',['totalProduct'=>$totalProduct['total'], 'totalUser'=>$totalUser['total'], 'totalSale'=>$totalSale['total']]);
    }
}