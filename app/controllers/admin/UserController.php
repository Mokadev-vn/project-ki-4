<?php

namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $user = new User();

        $page = (request('page')) ? request('page') : 1;
        $limit = 4;

        $pagination = handlPagination($limit, $page, 'users');
        $fields = ['id', 'full_name', 'email', 'username', 'active', 'image', 'role'];

        $listUser = $user->params($fields)->limit($limit, $pagination['start'])->get();

        return $this->view('admin.user.index', ['listUser' => $listUser, 'page' => $page, 'total' => $pagination['total']]);
    }

    public function update($username)
    {
        $user = new User();
        $fields = ['id', 'full_name', 'email', 'username', 'birthday', 'active', 'image', 'role'];
        $dataUser = $user->params($fields)->where('username', $username)->getOne();

        if (!$dataUser) {
            echo "Khong ton tai!";
            return;
        }

        return $this->view('admin.user.update', $dataUser);
    }

    public function postUpdate($username)
    {
        $result = [
            'status' => 'error',
            'message' => '',
            'error' => false
        ];

        $csrf_token = request('csrf_token');
        $full_name = request('full_name');
        $email = request('email');
        $active = request('active');
        $role = request('role');
        $birthday = request('birthday');

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

        if (!$active) {
            $result['error']['active'] = 'Không được bỏ trống trường này!';
        }

        if (!$birthday) {
            $result['error']['birthday'] = 'Vui lòng chọn ngày sinh!';
        }

        if (!$role) {
            $result['error']['role'] = 'Không được bỏ trống trường này!';
        }

        if ($result['error']) {
            echo json_encode($result);
            return;
        }

        $user = new User();
        $user->where('username', $username);
        $user->full_name = $full_name;
        $user->birthday = $birthday;
        $user->email = $email;
        $user->active = $active;
        $user->role = $role;

        if ($user->update()) {
            $result['status'] = 'success';
            $result['message'] = 'Update thành công!';
            echo json_encode($result);
            return;
        }

        $result['message'] = 'Có lỗi xảy ra zzz!';
        echo json_encode($result);
    }

    public function delete()
    {
        $result = [
            'error' => false,
            'success' => false,
        ];

        $username = request('username');

        if (!$username) {
            $result['error'] = true;
            echo json_encode($result);
            return;
        }

        $user = new User();

        $user->where('username', $username);
        $user->delete();

        $result['success'] = true;
        echo json_encode($result);
        return;
    }
}
