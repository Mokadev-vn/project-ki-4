<?php

namespace App\Controllers\User;

use Core\Controller;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\PaymentDetail;


class OrderController extends Controller
{
    public function index()
    {
        $user = getSession('user');
        $payment = new Payment();
        $page = (request('page')) ? request('page') : 1;
        $limit = 5;

        $total = $payment->where('user_id', $user['id'])->get();
        $count = count($total);
        $total_page = ceil($count / $limit);
        if ($page > $total_page) {
            $page = $total_page;
        } else if ($page < 1) {
            $page = 1;
        }

        $start = ($page - 1) * $limit;

        $listPayment =  $payment->where('user_id', $user['id'])->limit($limit, $start)->get();
        return $this->view('user.order', compact('listPayment', 'total_page', 'page'));
    }

    public function checkout()
    {
        $user = getSession('user');

        $cart = new Cart();
        $getCart = $cart->where('user_id', $user['id'])->where('status', 0)->get();
        if (count($getCart) <= 0) {
            return redirect('carts');
        }
        return $this->view('default.checkout', ['carts' => $getCart, 'user' => $user]);
    }

    public function postCheckout()
    {
        $user = getSession('user');

        $cart = new Cart();
        $getCart = $cart->where('user_id', $user['id'])->where('status', 0)->get();

        $csrf_token = request('csrf_token');
        $fullName   = request('full_name');
        $email      = request('email');
        $phone      = request('phone');
        $address    = request('address');
        $city       = request('city');
        $notes      = request('notes');
        $total_mount = request('total_mount');
        $error      = [];


        if (!csrf_verify($csrf_token)) {
            $error = [
                'default' => "Có lỗi xảy ra!"
            ];
            return $this->view('default.checkout', ['error' => $error, 'carts' => $getCart, 'user' => $user]);
        }

        if (strlen($fullName) < 3 || strlen($fullName) > 30) {
            $error['full_name'] = 'Tên không hợp lệ!';
        }

        if (strlen($address) < 3) {
            $error['address'] = 'Địa chỉ không hợp lệ!';
        }

        if (strlen($city) < 3) {
            $error['city'] = 'Địa chỉ không hợp lệ!';
        }

        if (!preg_match("/^[a-z][a-z0-9_\.]{1,32}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$/", $email)) {
            $error['email'] = 'Vui lòng nhập đúng định dạng mail';
        }

        if (!preg_match("/^(84|0[3|5|7|8|9])+([0-9]{8})\b$/", $phone)) {
            $error['phone'] = 'Vui lòng nhập đúng định dạng số điện thoại';
        }

        if (count($error) > 0) {
            $error['default'] = "Vui lòng điền đúng thông tin!";
            return $this->view('default.checkout', ['error' => $error, 'carts' => $getCart, 'user' => $user]);
        }

        $payment = new Payment();
        $payment_detail = new PaymentDetail();

        $payment->user_id = $user['id'];
        $payment->full_name = $fullName;
        $payment->email = $email;
        $payment->phone = $phone;
        $payment->address = $address;
        $payment->city = $city;
        $payment->notes = $notes;
        $payment->total_mount = $total_mount;
        $id_payment = $payment->save();

        foreach ($getCart as $c) {
            $payment_detail->payment_id = $id_payment;
            $payment_detail->cart_id = $c['id'];
            $payment_detail->save();
        }
        $cart->status = 1;
        $cart->where('user_id', $user['id'])->update();

        return redirect('user/orders');
    }

    public function detail($id)
    {
        $user = getSession('user');
        $payment = new Payment();
        $payment_detail = new PaymentDetail();
        $dataPaymentDetail = $payment_detail->join('carts c', 'c.id = p.cart_id')->where('p.payment_id', $id)->get();
        $dataPayment = $payment->where('id', $id)->where('user_id', $user['id'])->getOne();

        if (!$dataPayment || count($dataPaymentDetail) <= 0) {
            return redirect('404');
        }
        return $this->view('user.order-detail', compact('dataPayment', 'dataPaymentDetail'));
    }

    public function cancel()
    {
        $result = [
            'status' => 'error',
            'message' => '',
            'error' => false
        ];

        $payment = new Payment();
        $id = request('id');
        $data = $payment->where('id', $id)->getOne();

        if (!$data) {
            $result['message'] = 'Lỗi! Đơn hàng không tồn tại!';
            echo json_encode($result);
            return;

        }

        $user = getSession('user');
        $payment = new Payment();
        $payment->status = 3;
        $data = $payment->where('id', $id)->where('user_id', $user['id'])->update();

        if ($data) {
            $result['status'] = 'success';
            $result['message'] = 'Update thành công!';
            echo json_encode($result);
            return;
        }

        $result['message'] = 'Có lỗi xảy ra!';
        echo json_encode($result);
    }
}
