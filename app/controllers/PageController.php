<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Categories;

class PageController extends Controller
{
    public function contact()
    {
        return $this->view('default.contact');
    }

    public function postContact()
    {
        $csrf_token = request('csrf_token');
        $name = request('name');
        $email = request('email');
        $message = request('message');

        $errorName = '';
        $errorEmail = '';
        $errorMessage = '';

        if (!csrf_verify($csrf_token)) {
            $error = 'Có lỗi xảy ra!';
            return $this->view('default.contact', ['error' => $error]);
        }

        if (strlen($name) < 3 || strlen($name) > 30) {

            $errorName = 'Tên không hợp lệ!';
        }

        if (!preg_match("/^[a-z][a-z0-9_\.]{1,32}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$/", $email)) {
            $errorEmail = 'Vui lòng nhập đúng định dạng mail';
        }

        if(!$message){
            $errorMessage = "Không được để trống!";
        }

        if($errorName.$errorEmail.$errorMessage != ''){
            return $this->view('default.contact', ['errorName' => $errorName, 'errorEmail' => $errorEmail, 'errorMessage' => $errorMessage]);
        }

        $title = "Email request!";

        $contact = new Contact();
        $contact->name = $name;
        $contact->email = $email;
        $contact->title = $title;
        $contact->message = $message;
        $contact->reply = 0;

        if (!$contact->save()) {
            $error = 'Có lỗi xảy ra vui lòng thử lại!';
            return $this->view('default.contact', ['error' => $error]);
        }

        // $htmlEmail = "Email: $email - Message: $message"; 
        // $logEmail = sendMail('nhantu1001@gmail.com', 'Admin', 'Contact - Web', $htmlEmail);

        // if (!$logEmail) {
        //     $error = 'Có lỗi xảy ra vui lòng thử lại!';
        //     return $this->view('default.contact', ['error' => $error]);
        // }

        return $this->view('default.contact',['success' => 'Cảm ơn bạn đã gửi contact!']);
        
    }

    public function shop(){
        $product = new Product();
        $categories = new Categories();
        $listCate = $categories->get();
        
        $page = (request('page')) ? request('page') : 1;
        $limit = 6;
        $pagination = handlPagination($limit, $page, 'products');
        $listProduct = $product->limit($limit, $pagination['start'])->get();

        return $this->view('default.shop',['categories'=> $listCate, 'listProduct' => $listProduct, 'page' => $page, 'total' => $pagination['total']]);
    }
}
