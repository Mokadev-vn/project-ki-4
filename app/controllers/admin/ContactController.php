<?php

namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\Contact;

class ContactController extends Controller
{

    public function index()
    {
        $contact = new Contact();
        $page = (request('page')) ? request('page') : 1;
        $limit = 5;
        $pagination = handlPagination($limit, $page, 'contacts');

        $listContact = $contact->limit($limit, $pagination['start'])->get();
        return $this->view('admin.contact.index', ['listContact' => $listContact, 'page' => $page, 'total' => $pagination['total']]);
    }

    public function viewer($id)
    {
        $contact = new Contact();

        $check = $contact->where('id', $id)->getOne();

        if ($check) {
            return $this->view('admin.contact.view', $check);
        }

        return $this->view('errors.404');
    }

    public function post($id)
    {
        $result = [
            'status' => 'error',
            'message' => '',
            'error' => false
        ];

        $csrf_token = request('csrf_token');
        $title      = request('title');
        $email      = request('email');
        $message    = request('message');

        if (!csrf_verify($csrf_token)) {
            $result['message'] = 'Có lỗi xảy ra!';
            echo json_encode($result);
            return;
        }

        if (!$title || strlen($title) < 3) {
            $result['error']['title'] = 'Không được bỏ trống trường này và phải trên 3 kí tự!';
        }

        if (!$message || strlen($message) < 5) {
            $result['error']['message'] = 'Không được bỏ trống trường này và phải trên 5 kí tự!';
        }

        if (!preg_match("/^[a-z][a-z0-9_\.]{1,32}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$/", $email)) {
            $result['error']['email'] = 'Vui lòng nhập đúng định dạng mail';
        }

        if ($result['error']) {
            echo json_encode($result);
            return;
        }

        $logEmail = sendMail($email, "User", $title, $message);

        if ($logEmail) {
            $result['status'] = 'success';
            $result['message'] = 'Send Mail Successfully!';
            $contact = new Contact();

            $contact->where('id',$id);
            $contact->reply = 1;
            $contact->update();
            
            echo json_encode($result);
            return;
        }

        $result['message'] = 'Có lỗi xảy ra zzz!';
        echo json_encode($result);
    }
}
