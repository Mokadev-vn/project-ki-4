<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Product;
use App\Models\Categories;
use App\Models\Comment;

class HomeController extends Controller
{

    public function index()
    {
        $products = new Product();
        $categories = new Categories();


        //$product = $products->query("SELECT p.*, pt.slug as slug_cate FROM products p join product_types pt ON p.product_type_id = pt.id ORDER BY p.id DESC LIMIT 24");

        $product = $products->params(['p.*', 'pt.slug as slug_cate'])->join("product_types pt", "p.product_type_id = pt.id")->orderBy("p.id")->limit(24)->get();

        //$listCates = $categories->query("SELECT pt.*, count(p.id) as total FROM product_types pt JOIN products p ON pt.id = p.product_type_id WHERE pt.show_index = 1 GROUP BY pt.id LIMIT 5");
        $listCates = $categories->params(['p.*', 'count(pd.id) as total'])->join('products pd', 'p.id = pd.product_type_id')->where('p.show_header', 1)->groupBy('p.id')->limit(5)->get();
        $listSlide = $categories->where('show_slide',1)->get(5);

        $hotTrend = $products->orderBy('count_views')->limit(3)->get();
        $sale = $products->orderBy('sale')->limit(3)->get();

        $data = [
            'categories' => $listCates,
            'products' => $product,
            'hotTrend' => $hotTrend,
            'listSale' => $sale,
            'slider' => $listSlide
        ];
        return $this->view('default.index', $data);
    }

    public function search(){
        $query = request('q');

        $product = new Product();
        $result = $product->query("SELECT * FROM products WHERE name LIKE ?",['%' . $query . '%']);
        
        $categories = new Categories();
        $listCate = $categories->get();

        if(!$query || count($result) == 0){
            return $this->view('default.search', ['categories' => $listCate,'error' =>'Không có sản phẩm với từ khóa: <span class="font-weight-bold">'.$query.'</span>']);
        }

        return $this->view('default.search',['categories' => $listCate, 'listProduct' => $result]);

    }

    public function product($slug)
    {
        $product = new Product();
        $info = $product->where('slug', $slug)->getOne();
        if (!$info) {
            return view('errors.404');
        }

        $categories = new Categories();
        $cate = $categories->where('id', $info['product_type_id'])->getOne();

        $comment = new Comment();

        $comments = $comment->params(['c.*', 'u.full_name', 'u.id', 'u.image'])->join('users u', 'c.user_id = u.id')->where('c.product_id', $info['id'])->where('c.active','1')->get();

        $arrayView = json_decode(getCookies('viewer'), true);

        if (!in_array($info['id'], $arrayView)) {
            $arrayView[] = $info['id'];
            $value = json_encode($arrayView);
            setCookies('viewer', $value);

            $product->where('id', $info['id']);
            $product->count_views = $info['count_views'] + 1;
            $product->update();
        }

        $productCate = $product->where('product_type_id',$info['product_type_id'])->orderBy('RAND()')->limit(4)->get();

        return $this->view('default.product-details', ['info' => $info, 'category' => $cate, 'comments' => $comments, 'productCate'=>$productCate]);
    }

    public function category($slug)
    {
        $categories = new Categories();
        $get = $categories->where('slug', $slug)->getOne();

        if(!$get){
            return $this->view('errors.404');
        }

        $product = new Product();
        $listCate = $categories->get();

        $products = $product->where('product_type_id', $get['id'])->get();

        return $this->view('default.category',['categories'=>$listCate, 'listProduct' => $products, 'infoCate' => $get]);
    }


    public function postComment()
    {
        $result = [
            'status' => 'error',
            'message' => '',
            'error' => false
        ];

        $csrf_token = request('csrf_token');
        $id_product = request('id_product');
        $message    = request('comment');

        if (!csrf_verify($csrf_token)) {
            $result['message'] = 'Có lỗi xảy ra!';
            echo json_encode($result);
            return;
        }

        $product = new Product();
        $check = $product->where('id', $id_product)->getOne();

        if (!$id_product && !$check) {
            $result['message'] = 'Có lỗi xảy ra!';
            echo json_encode($result);
            return;
        }

        if (!$message) {
            $result['error']['message'] = 'Không được bỏ trống trường này!';
        }

        if ($result['error']) {
            echo json_encode($result);
            return;
        }
        $user_id = getSession('user')['id'];
        $comment = new Comment();
        $comment->content = $message;
        $comment->product_id = $id_product;
        $comment->user_id = $user_id;
        $comment->create_at = now();
        $comment->active = 1;

        if ($comment->save()) {
            $result['status'] = 'success';
            $result['message'] = 'Send Comment Successfully!';
            echo json_encode($result);
            return;
        }

        $result['message'] = 'Có lỗi xảy ra!';
        echo json_encode($result);
    }
}
