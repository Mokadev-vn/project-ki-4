<?php

namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\Product;
use App\Models\Categories;

class ProductController extends Controller
{
    public function index()
    {

        $product = new Product();
        $page = (request('page')) ? request('page') : 1;
        $limit = 5;

        $pagination = handlPagination($limit, $page, 'products');


        $data = $product->query("SELECT p.*, pt.name as type_name FROM products as p JOIN product_types as pt ON p.product_type_id = pt.id ORDER BY p.id DESC LIMIT " . $pagination['start'] . ", $limit");

        return $this->view('admin.product.index', ['product' => $data, 'page' => $page, 'total' => $pagination['total']]);
    }

    public function create()
    {
        $categories = new Categories();
        $data = $categories->get();

        return $this->view('admin.product.create', $data);
    }

    public function postCreate()
    {
        $result = [
            'status' => 'error',
            'message' => '',
            'error' => false
        ];

        $csrf_token  = request('csrf_token');
        $name        = request('name');
        $description = request('description');
        $price       = request('price');
        $sale        = (request('sale')) ? request('sale') : 0;
        $status      = request('status');
        $category    = request('category');
        $image       = fileRequest('image');

        if (!csrf_verify($csrf_token)) {
            $result['message'] = 'Có lỗi xảy ra!';
            echo json_encode($result);
            return;
        }

        if (!$name || strlen($name) < 3) {
            $result['error']['name'] = 'Không được bỏ trống trường này và phải trên 3 kí tự!';
        }

        if (!$price || $price < 0) {
            $result['error']['price'] = 'Không được bỏ trống trường này và phải lớn hơn 0!';
        }

        if ($sale < 0 || $sale > 100) {
            $result['error']['sale'] = 'Không được bỏ trống trường này và phải trong khoảng 0-100!';
        }

        if (!$status) {
            $result['error']['status'] = 'Phải chọn status!';
        }

        if (!$category) {
            $result['error']['category'] = 'Phải chọn 1 danh mục!';
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

        $product = new Product();
        $product->name        = $name;
        $product->price       = $price;
        $product->sale        = $sale;
        $product->image       = $imageUpload;
        $product->slug        = slug($name, 'products');
        $product->description = $description;
        $product->create_at   = now();
        $product->status      = $status;
        $product->count_views = 0;
        $product->product_type_id = $category;

        if ($product->save()) {
            $result['status'] = 'success';
            $result['message'] = 'Thêm sản phẩm mới thành công!';
            echo json_encode($result);
            return;
        }

        $result['message'] = 'Có lỗi xảy ra zzz!';
        echo json_encode($result);
    }

    public function update($id)
    {
        $product = new Product();
        $categories = new Categories();

        $cate = $categories->get();
        $product->where('id', $id);
        $infoProduct = $product->getOne();
        if (!$infoProduct) {
            echo "Sản phẩm không tồn tại";
            return;
        }
        return $this->view('admin.product.update', ['cate' => $cate, 'product' => $infoProduct]);
    }

    public function postUpdate($id)
    {
        $result = [
            'status' => 'error',
            'message' => '',
            'error' => false
        ];

        $csrf_token  = request('csrf_token');
        $name        = request('name');
        $description = request('description');
        $price       = request('price');
        $sale        = (request('sale')) ? request('sale') : 0;
        $status      = request('status');
        $category    = request('category');
        $image       = fileRequest('image');

        if (!csrf_verify($csrf_token)) {
            $result['message'] = 'Có lỗi xảy ra!';
            echo json_encode($result);
            return;
        }

        if (!$name || strlen($name) < 3) {
            $result['error']['name'] = 'Không được bỏ trống trường này và phải trên 3 kí tự!';
        }

        if (!$price || $price < 0) {
            $result['error']['price'] = 'Không được bỏ trống trường này và phải lớn hơn 0!';
        }

        if ($sale < 0 || $sale > 100) {
            $result['error']['sale'] = 'Không được bỏ trống trường này và phải trong khoảng 0-100!';
        }

        if (!$status) {
            $result['error']['status'] = 'Phải chọn status!';
        }


        if (!$category) {
            $result['error']['category'] = 'Phải chọn 1 danh mục!';
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

        $product = new Product();

        $slug = $product->where('id', $id)->getOne();

        $product->where('id', $id);
        $product->name = $name;
        $product->price = $price;
        $product->sale = $sale;

        if ($slug['name'] != $name) {
            $product->slug = slug($name, 'products');
        }

        if (isset($imageUpload)) $product->image = $imageUpload;
        $product->description = $description;
        $product->status = $status;
        $product->product_type_id = $category;

        if ($product->update()) {
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

        $product = new Product();
        foreach ($listId as $is) {
            $product->where('id', $is);
            $product->delete();
        }
        $result['success'] = true;
        echo json_encode($result);
        return;
    }
}
