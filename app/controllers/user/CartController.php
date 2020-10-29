<?php

namespace App\Controllers\User;

use Core\Controller;
use App\Models\Product;
use App\Models\Cart;

class CartController extends Controller
{
    public function addCart($slug)
    {
        $product = new Product();
        $cart = new Cart();
        $check = $product->where('slug', $slug)->getOne();

        if (!$check) {
            return $this->view('errors.404');
        }

        $qty = (request('qty')) ? request('qty') : 1;

        if (getSession('user')) {
            $getCart = $cart->where('product_id', $check['id'])->where('user_id', getSession('user')['id'])->getOne();
            if (!$getCart) {
                $cart->user_id = getSession('user')['id'];
                $cart->name = $check['name'];
                $cart->product_id = $check['id'];
                $cart->quantity = $qty;
                $cart->status = 0;
                $cart->price = $check['price'];
                $cart->sale = $check['sale'];
                $cart->slug = $check['slug'];
                $cart->image = $check['image'];
                $cart->save();
            } else {
                $cart->quantity = $getCart['quantity'] + $qty;
                $cart->where('id', $getCart['id'])->update();
            }
            redirect('carts');
            return;
        }

        $cartCookie = json_decode(getCookies('carts'), true);


        if (isset($cartCookie[$check['id']])) {
            $cartCookie[$check['id']]['quantity'] = $cartCookie[$check['id']]['quantity'] + $qty;
            $cartCookie = json_encode($cartCookie);
            setCookies('carts', $cartCookie, 1000000);
        } else {
            $cartCookie[$check['id']] = [
                'id' => $check['id'],
                'slug' => $check['slug'],
                'name' => $check['name'],
                'image' => $check['image'],
                'price' => $check['price'],
                'sale' => $check['sale'],
                'quantity' => $qty
            ];
            $cartCookie = json_encode($cartCookie);
            setCookies('carts', $cartCookie, 1000000);
        }

        redirect('carts');
    }

    public function cart(){
        $user = getSession('user');
        if($user){
            $cart = new Cart();
            $getCart = $cart->where('user_id', $user['id'])->get();
        }else{
            $getCart = json_decode(getCookies('carts'), true);
        }
        return $this->view('default.cart', ['carts' => $getCart]);
    }

    public function delete(){
        $id = request('id');

        if(!$id){
            return;
        }

        $user = getSession('user');

        if($user){
            $cart = new Cart();
            $cart->where('id',$id)->where('user_id',$user['id'])->delete();
        }else{
            $cartCookie = json_decode(getCookies('carts'), true);
            if (isset($cartCookie[$id])) {
                unset($cartCookie[$id]);
                $cartCookie = json_encode($cartCookie);
                setCookies('carts', $cartCookie, 1000000);
            }

        }
    }
}
