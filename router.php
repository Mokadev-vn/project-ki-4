<?php

use Core\Router;



$router = new Router();

//home
$router->get('/', 'App\Controllers\HomeController@index');

/**
 * Router Admin
 */
$router->middleware('AuthAdmin')->get('/admin', 'App\Controllers\Admin\HomeController@index');

// router admin product
$router->middleware('AuthAdmin')->group('/admin/product',[
    ['GET', '', 'App\Controllers\Admin\ProductController@index'],
    ['GET', '/create', 'App\Controllers\Admin\ProductController@create'],
    ['POST', '/create', 'App\Controllers\Admin\ProductController@postCreate'],
    ['GET', '/{id}/update', 'App\Controllers\Admin\ProductController@update'],
    ['POST', '/{id}/update', 'App\Controllers\Admin\ProductController@postUpdate'],
    ['POST', '/delete', 'App\Controllers\Admin\ProductController@delete'],

]);

// router admin category
$router->middleware('AuthAdmin')->group('/admin/category',[
    ['GET', '', 'App\Controllers\Admin\CategoryController@index'],
    ['GET', '/create', 'App\Controllers\Admin\CategoryController@create'],
    ['POST', '/create', 'App\Controllers\Admin\CategoryController@postCreate'],
    ['GET', '/{id}/update', 'App\Controllers\Admin\CategoryController@update'],
    ['POST', '/{id}/update', 'App\Controllers\Admin\CategoryController@postUpdate'],
    ['POST', '/delete', 'App\Controllers\Admin\CategoryController@delete'],
]);

// router admin user 
$router->middleware('AuthAdmin')->group('/admin/user',[
    ['GET', '', 'App\Controllers\Admin\UserController@index'],
    ['POST', '/delete', 'App\Controllers\Admin\UserController@delete'],
    ['GET', '/{username}', 'App\Controllers\Admin\UserController@update'],
    ['POST', '/{username}', 'App\Controllers\Admin\UserController@postUpdate'],
]);

//router admin contact
$router->middleware('AuthAdmin')->group('/admin/contact',[
    ['GET', '', 'App\Controllers\Admin\ContactController@index'],
    ['GET', '/{id}', 'App\Controllers\Admin\ContactController@viewer'],
    ['POST', '/{id}', 'App\Controllers\Admin\ContactController@post'],
]);

// router admin comment
$router->middleware('AuthAdmin')->get('/admin/comment', 'App\Controllers\Admin\CommentController@index');
$router->middleware('AuthAdmin')->post('/admin/comment/delete','App\Controllers\Admin\CommentController@delete');

$router->middleware('AuthAdmin')->get('/admin/api/chart', 'App\Controllers\Admin\ApiController@chart');

$router->middleware('AuthAdmin')->get('/admin/setting', 'App\Controllers\Admin\HomeController@setting');
$router->middleware('AuthAdmin')->post('/admin/setting','App\Controllers\Admin\HomeController@editSetting');

// router admin orders
$router->middleware('AuthAdmin')->get('/admin/order','App\Controllers\Admin\OrderController@index');


/**
 * User
 */

// auth
$router->middleware('falseLogin')->get('/register', 'App\Controllers\User\AccountController@register');
$router->middleware('falseLogin')->post('/register', 'App\Controllers\User\AccountController@postRegister');
$router->middleware('falseLogin')->get('/login', 'App\Controllers\User\AccountController@login');
$router->middleware('falseLogin')->post('/login', 'App\Controllers\User\AccountController@postLogin');
$router->middleware('falseLogin')->get('/reset-password', 'App\Controllers\User\AccountController@resetPassword');
$router->middleware('falseLogin')->post('/reset-password', 'App\Controllers\User\AccountController@postReset');
$router->middleware('falseLogin')->get('/reset-password/{username}/{hash}', 'App\Controllers\User\AccountController@changerReset');
$router->middleware('falseLogin')->post('/reset-password/{username}/{hash}', 'App\Controllers\User\AccountController@postChangerReset');
$router->get('/logout', 'App\Controllers\User\AccountController@logout');

//page

$router->get('/contact', 'App\Controllers\PageController@contact');
$router->post('/contact', 'App\Controllers\PageController@postContact');

$router->get('/shop','App\Controllers\PageController@shop');

$router->get('/product/{slug}', 'App\Controllers\HomeController@product');
$router->get('/category/{slug}', 'App\Controllers\HomeController@category');
$router->get('/search', 'App\Controllers\HomeController@search');

$router->middleware('checkLogin')->post('/comment', 'App\Controllers\HomeController@postComment');
$router->middleware('checkLogin')->get('/profile', 'App\Controllers\User\AccountController@profile');
$router->middleware('checkLogin')->post('/profile', 'App\Controllers\User\AccountController@postProfile');
$router->middleware('checkLogin')->get('/user/change-password', 'App\Controllers\User\AccountController@changePassword');
$router->middleware('checkLogin')->post('/user/change-password', 'App\Controllers\User\AccountController@postChangePassword');
$router->middleware('checkLogin')->get('/user/orders', 'App\Controllers\User\CartController@order');
$router->get('/add-cart/{slug}', 'App\Controllers\User\CartController@addCart');
$router->get('/carts', 'App\Controllers\User\CartController@cart');
$router->post('/cart/delete', 'App\Controllers\User\CartController@delete');
$router->post('/cart/update', 'App\Controllers\User\CartController@update');


$router->get('/blog', function(){
    echo "Tính năng đang được phát triển vui lòng quay lại sau";
});

$router->get('/about-us', function(){
    echo "Tính năng đang được phát triển vui lòng quay lại sau";
});

$router->execute();
