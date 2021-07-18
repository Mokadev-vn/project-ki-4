<?php
namespace App\Controllers\Admin;
use Core\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Setting;

class HomeController extends Controller{
    public function index(){
        $product = new Product();
        $totalProduct = $product->params(['COUNT(*) AS total'])->getOne();

        $user = new User();
        $totalUser = $user->params(['COUNT(*) AS total'])->getOne();

        $totalSale = $product->params(['COUNT(*) AS total'])->where('sale',0,'>')->getOne();

        return $this->view('admin.index',['totalProduct'=>$totalProduct['total'], 'totalUser'=>$totalUser['total'], 'totalSale'=>$totalSale['total']]);
    }

    public function setting(){
        $setting = new Setting();
        $infoSetting = $setting->getOne();
        return $this->view('admin.setting', compact('infoSetting'));
    }
    
    public function editSetting(){
        $result = [
            'status' => 'error',
            'message' => '',
            'error' => false
        ];

        $csrf_token = request('csrf_token');
        $name = request('name');
        $image = fileRequest('image');

        if (!csrf_verify($csrf_token)) {
            $result['message'] = 'Có lỗi xảy ra!';
            echo json_encode($result);
            return;
        }

        if (!$name || strlen($name) < 3) {
            $result['error']['name'] = 'Không được bỏ trống trường này và phải trên 3 kí tự!';
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

        $category = new Setting();
        $category->title = $name;
        if (isset($imageUpload)) $category->logo = $imageUpload;
        if ($category->update()) {
            $result['status'] = 'success';
            $result['message'] = 'Update thành công!';
            echo json_encode($result);
            return;
        }

        $result['message'] = 'Có lỗi xảy ra zzz!';
        echo json_encode($result);
    }
}