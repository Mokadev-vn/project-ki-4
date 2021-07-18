<?php

namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\Categories;

class CategoryController extends Controller
{
    public function index()
    {
        $category = new Categories();
        $page = (request('page')) ? request('page') : 1;
        $limit = 5;

        $pagination = handlPagination($limit, $page, 'product_types');
        $data = $category->limit($limit, $pagination['start'])->get();

        return $this->view('admin.category.index', ['category' => $data, 'page' => $page, 'total' => $pagination['total']]);
    }

    public function create()
    {
        return $this->view('admin.category.create');
    }

    public function postCreate()
    {
        $result = [
            'status' => 'error',
            'message' => '',
            'error' => false
        ];

        $csrf_token = request('csrf_token');
        $name = request('name');
        $show_menu = request('show_menu');
        $show_header = request('show_header');
        $show_slide = request('show_slide');
        $image = fileRequest('image');


        if (!csrf_verify($csrf_token)) {
            $result['message'] = 'Có lỗi xảy ra!';
            echo json_encode($result);
            return;
        }

        if (!$name || strlen($name) < 3) {
            $result['error']['name'] = 'Không được bỏ trống trường này và phải trên 3 kí tự!';
        }

        if (!$show_menu) {
            $result['error']['show_menu'] = 'Phải chọn trường này!';
        }

        if (!$show_header) {
            $result['error']['show_header'] = 'Phải chọn trường này!';
        }

        if (!$show_slide) {
            $result['error']['show_slide'] = 'Phải chọn trường này!';
        }

        if (!$image) {
            $result['error']['image'] = 'Phải chọn ảnh!';
        }

        if ($result['error']) {
            echo json_encode($result);
            return;
        }

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

        $category = new Categories();

        $category->name = $name;
        $category->show_menu = $show_menu;
        $category->show_header = $show_header;
        $category->show_slide = $show_slide;
        $category->slug = slug($name, 'product_types');
        $category->image = $imageUpload;

        if ($category->save()) {
            $result['status'] = 'success';
            $result['message'] = 'Thêm danh mục mới thành công!';
            echo json_encode($result);
            return;
        }

        $result['message'] = 'Có lỗi xảy ra zzz!';
        echo json_encode($result);
    }

    public function update($id)
    {
        $category = new Categories();
        $infoCate = $category->where('id', $id)->getOne();
        if (!$infoCate) {
            echo 'Danh mục không tồn tại';
            return;
        }
        return $this->view('admin.category.update', $infoCate);
    }

    public function postUpdate($id)
    {

        $result = [
            'status' => 'error',
            'message' => '',
            'error' => false
        ];

        $csrf_token = request('csrf_token');
        $name = request('name');
        $show_menu = request('show_menu');
        $show_header = request('show_header');
        $show_slide = request('show_slide');
        $image = fileRequest('image');

        if (!csrf_verify($csrf_token)) {
            $result['message'] = 'Có lỗi xảy ra!';
            echo json_encode($result);
            return;
        }

        if (!$name || strlen($name) < 3) {
            $result['error']['name'] = 'Không được bỏ trống trường này và phải trên 3 kí tự!';
        }

        if (!$show_menu) {
            $result['error']['show_menu'] = 'Phải chọn trường này!';
        }

        if (!$show_header) {
            $result['error']['show_header'] = 'Phải chọn trường này!';
        }

        if (!$show_slide) {
            $result['error']['show_slide'] = 'Phải chọn trường này!';
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


        if ($result['error']) {
            echo json_encode($result);
            return;
        }

        $category = new Categories();
        $slug = $category->where('id', $id)->getOne();

        $category->where('id', $id);
        $category->name = $name;
        $category->show_menu = $show_menu;
        $category->show_header = $show_header;
        $category->show_slide = $show_slide;

        if (isset($imageUpload)) $category->image = $imageUpload;
        if ($slug['name'] != $name) {
            $category->slug = slug($name, 'product_types');
        }

        if ($category->update()) {
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

        $id = request('id');

        if (!$id) {
            $result['error'] = true;
            echo json_encode($result);
            return;
        }

        $id = trim($id, ',');

        $listId = explode(',', $id);

        $product = new Categories();
        foreach ($listId as $is) {
            $product->where('id', $is);
            $product->delete();
        }
        $result['success'] = true;
        echo json_encode($result);
        return;
    }
}
