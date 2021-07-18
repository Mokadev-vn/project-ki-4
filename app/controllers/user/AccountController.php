<?php

namespace App\Controllers\User;

use Core\Controller;
use App\Models\User;
use App\Models\Cart;

class AccountController extends Controller
{
    public function login()
    {
        return $this->view('user.login');
    }

    public function postLogin()
    {
        $result = [
            'status' => 'error',
            'message' => '',
            'error' => false
        ];

        $csrf_token = request('csrf_token');
        $username = request('username');
        $password = request('password');

        if (!csrf_verify($csrf_token)) {
            $result['message'] = 'Có lỗi xảy ra!';
            echo json_encode($result);
            return;
        }

        if (!$username) {
            $result['error']['username'] = 'Bạn chưa nhập trường này!';
        }

        if (!$password) {
            $result['error']['password'] = 'Bạn chưa nhập trường này!';
        }

        if ($result['error']) {
            echo json_encode($result);
            return;
        }

        $user = new User();
        $data = $user->where('username', strtolower($username))->where('email', $username, '=', 'OR')->getOne();
        $data = (is_array($data)) ? $data : [];

        if (count($data) != 0) {
            if (password_verify($password, $data['password'])) {
                $infoUser = [
                    'id'        => $data['id'],
                    'username'  => $data['username'],
                    'role'      => $data['role'],
                    'email'     => $data['email'],
                    'full_name' => $data['full_name'],
                    'image'     => $data['image'],
                    'active'    => $data['active']
                ];
                setSession('user', $infoUser);
                $carts = json_decode(getCookies('carts'),true);
                if (count($carts) > 0) {
                    $cart = new Cart();

                    foreach ($carts as $ct) {
                        $getCart = $cart->where('product_id', $ct['id'])->where('user_id', $data['id'])->getOne();
                        if (!$getCart) {
                            $cart->user_id = $data['id'];
                            $cart->name = $ct['name'];
                            $cart->product_id = $ct['id'];
                            $cart->quantity = $ct['quantity'];
                            $cart->status = 0;
                            $cart->price = $ct['price'];
                            $cart->sale = $ct['sale'];
                            $cart->slug = $ct['slug'];
                            $cart->image = $ct['image'];
                            $cart->save();
                        } else {
                            $cart->quantity = $getCart['quantity'] + $ct['quantity'];
                            $cart->where('id', $getCart['id'])->update();
                        }
                    }
                    deleteCookies('carts');
                }

                $result['status'] = 'success';
                $result['message'] = 'Đăng Nhập Thành Công!';
                $result['role'] = $data['role'];
                echo json_encode($result);
                return;
            }
        }
        $result['message'] = 'Thông tin tài khoản mật khẩu không chính xác!';
        echo json_encode($result);
        return;
    }

    public function register()
    {
        return $this->view('user.register');
    }

    public function postRegister()
    {
        $result = [
            'status' => 'error',
            'message' => '',
            'error' => false
        ];

        $csrf_token = request('csrf_token');
        $fullName   = request('full_name');
        $email      = request('email');
        $username   = request('username');
        $password   = request('password');
        $cfPassword = request('cf_password');
        $birthday = request('birthday');

        if (!csrf_verify($csrf_token)) {
            $result['message'] = 'Có lỗi xảy ra!';
            echo json_encode($result);
            return;
        }

        if (
            !preg_match('/^[a-zA-Z_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶ" +
    "ẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợ" +
    "ụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\\s]+$/', $fullName)
            || strlen($fullName) < 3
            || strlen($fullName) > 30
        ) {

            $result['error']['full_name'] = 'Tên không hợp lệ!';
        }

        if (!$birthday) {
            $result['error']['birthday'] = 'Vui lòng chọn ngày sinh!';
        }

        if (!preg_match('/^[A-Za-z0-9_-]{3,16}$/', $username)) {
            $result['error']['username'] = 'Username không chứa kí tự đặc biệt và trong khoảng 3 - 16 kí tự!';
        }


        if (strlen($password) < 6 || (strlen(str_replace(" ", "", $password)) != strlen($password))) {
            $result['error']['password'] = "Mật khẩu không được chứa khoảng trắng và nhiều hơn 6 kí tự!";
        }

        if (!preg_match("/^[a-z][a-z0-9_\.]{1,32}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$/", $email)) {
            $result['error']['email'] = 'Vui lòng nhập đúng định dạng mail';
        }

        if ($password != $cfPassword) {
            $result['error']['cf_password'] = "Mật khẩu không trùng nhau!";
        }

        if ($result['error']) {
            echo json_encode($result);
            return;
        }

        $username = strtolower($username);

        $user = new User();
        $getUser = $user->where('username', $username)->getOne();
        $getEmail = $user->where('email', $email)->getOne();

        if ($getEmail) {
            $result['message'] = 'Email đã tồn tại';
            echo json_encode($result);
            return;
        }

        if ($getUser) {
            $result['message'] = 'Username đã tồn tại';
            echo json_encode($result);
            return;
        }

        $user->username = $username;
        $user->password = password_hash($password, PASSWORD_BCRYPT);
        $user->email = $email;
        $user->birthday = $birthday;
        $user->full_name = $fullName;
        $user->active = 2;
        $user->image = 'user.jpg';
        $user->role = 2;

        if ($user->save()) {
            $result['status'] = 'success';
            $result['message'] = 'Đăng kí tài khoản thành công';
            echo json_encode($result);
            return;
        }

        $result['message'] = 'Có lỗi xảy ra!';
        echo json_encode($result);
    }

    public function resetPassword()
    {
        return $this->view('user.reset-password');
    }

    public function postReset()
    {
        $result = [
            'status' => 'error',
            'message' => '',
            'error' => false
        ];

        $csrf_token = request('csrf_token');
        $username = request('username');

        if (!csrf_verify($csrf_token)) {
            $result['message'] = 'Có lỗi xảy ra!';
            echo json_encode($result);
            return;
        }

        if (!$username) {
            $result['error']['username'] = 'Bạn chưa nhập trường này!';
        }

        if ($result['error']) {
            echo json_encode($result);
            return;
        }

        $user = new User();
        $check = $user->where('email', $username)->where('username', strtolower($username), '=', 'OR')->getOne();

        if (!$check) {
            $result['message'] = 'Email hoặc username không tồn tại!';
            echo json_encode($result);
            return;
        }

        $hash = md5($check['password'] . 'mokadev');

        $url = APP_CONFIG['url'] . 'reset-password/' . $check['username'] . '/' . $hash;

        $htmlEmail = '<!doctype html><html lang="en-US"><head> <meta content="text/html; charset=utf-8" http-equiv="Content-Type" /> <title>Reset Password Email</title> <meta name="description" content="Reset Password Email"> <style type="text/css"> a:hover {text-decoration: underline !important;} </style></head><body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0"> <!--100% body table--> <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8" style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: Open Sans, sans-serif;"> <tr> <td> <table style="background-color: #f2f3f8; max-width:670px; margin:0 auto;" width="100%" border="0" align="center" cellpadding="0" cellspacing="0"> <tr> <td style="height:80px;">&nbsp;</td> </tr> <tr> <td style="text-align:center;"> <a href="#" title="logo" target="_blank"> <img width="60" src="https://i.ibb.co/hL4XZp2/android-chrome-192x192.png" title="logo" alt="logo"> </a> </td> </tr> <tr> <td style="height:20px;">&nbsp;</td> </tr> <tr> <td> <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" style="max-width:670px;background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);"> <tr> <td style="height:40px;">&nbsp;</td> </tr> <tr> <td style="padding:0 35px;"> <h1 style="color:#1e1e2d; font-weight:500; margin:0;font-size:32px;font-family:Rubik,sans-serif;">You have requested to reset your password</h1> <span style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;"></span> <p style="color:#455056; font-size:15px;line-height:24px; margin:0;"> We cannot simply send you your old password. A unique link to reset your password has been generated for you. To reset your password, click the following link and follow the instructions. </p> <a href="' . $url . '" style="background:#20e277;text-decoration:none !important; font-weight:500; margin-top:35px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;">Reset Password</a> </td> </tr> <tr> <td style="height:40px;">&nbsp;</td> </tr> </table> </td> <tr> <td style="height:20px;">&nbsp;</td> </tr> <tr> <td style="text-align:center;"> <p style="font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353); line-height:18px; margin:0 0 0;">&copy; <strong>MokaDEV</strong></p> </td> </tr> <tr> <td style="height:80px;">&nbsp;</td> </tr> </table> </td> </tr> </table></body></html>';

        $logEmail = sendMail($check['email'], $check['full_name'], 'Reset Password', $htmlEmail);

        if (!$logEmail) {
            $result['message'] = 'Có lỗi xảy ra vui lòng thử lại!';
            echo json_encode($result);
            return;
        }

        $result['status'] = 'success';
        $result['message'] = 'Vui lòng check mail để lấy lại password!';
        echo json_encode($result);
    }

    public function changerReset($username, $hash)
    {

        $user = new User();
        $check = $user->where('username', $username)->getOne();

        if (!$check) {
            return $this->view('user.change-reset', ['active' => false]);
        }

        $hash1 = md5($check['password'] . 'mokadev');

        if ($hash1 == $hash) {
            return $this->view('user.change-reset', ['active' => true, 'username' => $username, 'hash' => $hash]);
        }

        return $this->view('user.change-reset', ['active' => false]);
    }

    public function postChangerReset($username, $hash)
    {
        $result = [
            'status' => 'error',
            'message' => '',
            'error' => false
        ];

        $csrf_token = request('csrf_token');
        $password   = request('password');
        $rePassword = request('re_password');

        if (!csrf_verify($csrf_token)) {
            $result['message'] = 'Có lỗi xảy ra!';
            echo json_encode($result);
            return;
        }

        if (strlen($password) < 6 || (strlen(str_replace(" ", "", $password)) != strlen($password))) {
            $result['error']['password'] = "Mật khẩu không được chứa khoảng trắng và nhiều hơn 6 kí tự!";
        }

        if ($password != $rePassword) {
            $result['error']['re-password'] = "Mật khẩu không trùng nhau!";
        }

        if ($result['error']) {
            echo json_encode($result);
            return;
        }

        $user = new User();
        $check = $user->where('username', $username)->getOne();

        if (!$check) {
            $result['message'] = 'Username không tồn tại!';
            echo json_encode($result);
            return;
        }

        $hash1 = md5($check['password'] . 'mokadev');

        if ($hash != $hash1) {
            $result['message'] = 'Mày định bug à!';
            echo json_encode($result);
            return;
        }

        $user->where('username', $username);
        $user->password = password_hash($password, PASSWORD_BCRYPT);
        if ($user->update()) {
            $result['status'] = 'success';
            $result['message'] = 'Changer new password successfully!';
            echo json_encode($result);
            return;
        }

        $result['message'] = 'Có lỗi xảy ra vui lòng thử lại!';
        echo json_encode($result);
    }

    public function logout()
    {
        if (destroySession('user')) {
            redirect('');
        }
    }

    public function profile()
    {
        $user = new User();
        $username = getSession('user')['username'];
        $fields = ['id', 'full_name', 'email', 'username', 'birthday', 'active', 'image', 'role'];
        $dataUser = $user->params($fields)->where('username', $username)->getOne();
        return $this->view('user.profile', $dataUser);
    }

    public function postProfile()
    {
        $result = [
            'status' => 'error',
            'message' => '',
            'error' => false
        ];

        $csrf_token = request('csrf_token');
        $full_name = request('full_name');
        $email = request('email');
        $birthday = request('birthday');
        $image = fileRequest('image');

        if (!csrf_verify($csrf_token)) {
            $result['message'] = 'Có lỗi xảy ra!';
            echo json_encode($result);
            return;
        }

        if (
            !preg_match('/^[a-zA-Z_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶ" +
    "ẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợ" +
    "ụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\\s]+$/', $full_name)
            || strlen($full_name) < 3
            || strlen($full_name) > 30
        ) {

            $result['error']['full_name'] = 'Tên không hợp lệ!';
        }

        if (!preg_match("/^[a-z][a-z0-9_\.]{1,32}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$/", $email)) {
            $result['error']['email'] = 'Vui lòng nhập đúng định dạng mail';
        }

        $user = new User();
        $emailUser = getSession('user')['email'];
        $check = $user->where('email', $email)->where('email', $emailUser, '<>')->getOne();

        if ($check) {
            $result['error']['email'] = 'Email đã tồn tại vui lòng nhập mail khác!';
        }

        if (!$birthday) {
            $result['error']['birthday'] = 'Vui lòng chọn ngày sinh!';
        }


        if ($result['error']) {
            echo json_encode($result);
            return;
        }

        if ($image) {
            $typeImage = ["image/png", "image/jpeg", "image/gif", "image/jpg"];

            $imageUpload = uploadFile($image, $typeImage);
            if (!$imageUpload) {
                $result['error']['image'] = 'File sai định dạng!';
                echo json_encode($result);
                return;
            }
            if ($imageUpload == 'size') {
                $result['error']['image'] = 'File quá giới hạn kích thước 1,5MB!';
                echo json_encode($result);
                return;
            }
        }


        $username = getSession('user')['username'];
        $user->where('username', $username);
        $user->full_name = $full_name;
        $user->birthday = $birthday;
        $user->email = $email;
        if (isset($imageUpload)) $user->image = $imageUpload;

        if ($user->update()) {
            $result['status'] = 'success';
            $result['message'] = 'Update thành công!';
            echo json_encode($result);
            return;
        }

        $result['message'] = 'Có lỗi xảy ra zzz!';
        echo json_encode($result);
    }

    public function changePassword()
    {
        $user = new User();
        $username = getSession('user')['username'];
        $fields = ['id', 'full_name', 'email', 'username', 'birthday', 'active', 'image', 'role'];
        $dataUser = $user->params($fields)->where('username', $username)->getOne();
        return $this->view('user.change-password', $dataUser);
    }

    public function postChangePassword()
    {
        $result = [
            'status' => 'error',
            'message' => '',
            'error' => false
        ];

        $csrf_token = request('csrf_token');
        $oldPassword = request('old_password');
        $password   = request('password');
        $rePassword = request('re_password');
        $username = getSession('user')['username'];

        if (!csrf_verify($csrf_token)) {
            $result['message'] = 'Có lỗi xảy ra!';
            echo json_encode($result);
            return;
        }

        $user = new User();
        $check = $user->where('username', $username)->getOne();

        if (!password_verify($oldPassword, $check['password'])) {
            $result['error']['old_password'] = "Mật khẩu không đúng!";
            echo json_encode($result);
            return;
        }

        if (strlen($password) < 6 || (strlen(str_replace(" ", "", $password)) != strlen($password))) {
            $result['error']['password'] = "Mật khẩu không được chứa khoảng trắng và nhiều hơn 6 kí tự!";
        }

        if ($password != $rePassword) {
            $result['error']['rePassword'] = "Mật khẩu không trùng nhau!";
        }

        if ($result['error']) {
            echo json_encode($result);
            return;
        }

        $user->where('username', $username);
        $user->password = password_hash($password, PASSWORD_BCRYPT);
        if ($user->update()) {
            $result['status'] = 'success';
            $result['message'] = 'Changer new password successfully!';
            echo json_encode($result);
            return;
        }

        $result['message'] = 'Có lỗi xảy ra vui lòng thử lại!';
        echo json_encode($result);
    }
}
