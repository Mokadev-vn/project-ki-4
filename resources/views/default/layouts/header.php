<?php

use App\Models\Categories;
use App\Models\Cart;
use App\Models\Setting;

$categories = new Categories();
$listCategory = $categories->where('show_header',1)->get();

$setting = new Setting();
$infoSetting = $setting->getOne();

if (getSession('user')) {
    $carts = new Cart();
    $getCarts = $carts->where('user_id', getSession('user')['id'])->where('status', 0)->get();
} else {
    $getCarts = json_decode(getCookies('carts'), true);
}

$title = isset($title) ? $title : $infoSetting['title'];
$logo = isset($infoSetting['logo']) ? APP_CONFIG['url']."uploads/".$infoSetting['logo'] : APP_CONFIG['static']."assets/img/logo.png";


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ashion Template">
    <meta name="keywords" content="Ashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?></title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="<?= APP_CONFIG['static'] ?>assets/css/bootstrap/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="<?= APP_CONFIG['static'] ?>assets/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="<?= APP_CONFIG['static'] ?>assets/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="<?= APP_CONFIG['static'] ?>assets/css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="<?= APP_CONFIG['static'] ?>assets/css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="<?= APP_CONFIG['static'] ?>assets/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="<?= APP_CONFIG['static'] ?>assets/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="<?= APP_CONFIG['static'] ?>assets/css/style.css" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="offcanvas__close">+</div>
        <ul class="offcanvas__widget">
            <li><span class="icon_search search-switch"></span></li>
            <li><a href="#"><span class="icon_heart_alt"></span>
                    <div class="tip">2</div>
                </a></li>
            <li><a href="#"><span class="icon_bag_alt"></span>
                    <div class="tip">2</div>
                </a></li>
        </ul>
        <div class="offcanvas__logo">
            <a href="<?= APP_CONFIG['url'] ?>"><img src="" alt=""></a>
        </div>
        <div id="mobile-menu-wrap"></div>
        <div class="offcanvas__auth">
            <?php
            if (getSession('user')) :
            ?>
                <a href="<?= APP_CONFIG['url'] ?>profile">My Account <i class="fa fa-user" aria-hidden="true"></i></a>
                <a href="<?= APP_CONFIG['url'] ?>logout">Logout <i class="fa fa-sign-out" aria-hidden="true"></i></a>
            <?php else : ?>
                <a href="<?= APP_CONFIG['url'] ?>login">Login</a>
                <a href="<?= APP_CONFIG['url'] ?>register">Register</a>
            <?php endif; ?>
        </div>
    </div>
    <!-- Offcanvas Menu End -->

    <!-- Header Section Begin -->
    <header class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-lg-2">
                    <div class="header__logo">
                        <a href="<?= APP_CONFIG['url'] ?>"><img src="<?= $logo ?>" alt=""></a>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-7">
                    <nav class="header__menu">
                        <ul>
                            <li class="active"><a href="<?= APP_CONFIG['url'] ?>">Home</a></li>
                            <li><a href="<?= APP_CONFIG['url'] ?>shop">Shop</a></li>
                            <li><a href="#">Category</a>
                                <ul class="dropdown">
                                    <?php foreach ($listCategory as $category) : ?>
                                        <li><a href="<?= APP_CONFIG['url'] . 'category/' . $category['slug'] ?>"><?= $category['name'] ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                            <li><a href="<?= APP_CONFIG['url'] ?>blog">Blog</a></li>
                            <li><a href="#">Pages</a>

                            </li>
                            <li><a href="<?= APP_CONFIG['url'] ?>about-us">About Us</a></li>
                            <li><a href="<?= APP_CONFIG['url'] ?>contact">Contact</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="header__right">
                        <div class="header__right__auth">
                            <?php
                            if (getSession('user')) :
                            ?>
                                <a href="<?= APP_CONFIG['url'] ?>profile">My Account <i class="fa fa-user" aria-hidden="true"></i></a>
                                <a href="<?= APP_CONFIG['url'] ?>logout">Logout <i class="fa fa-sign-out" aria-hidden="true"></i></a>
                            <?php else : ?>
                                <a href="<?= APP_CONFIG['url'] ?>login">Login</a>
                                <a href="<?= APP_CONFIG['url'] ?>register">Register</a>
                            <?php endif; ?>
                        </div>
                        <ul class="header__right__widget">
                            <li><span class="icon_search search-switch"></span></li>
                            <li><a href="#"><span class="icon_heart_alt"></span>
                                    <div class="tip">2</div>
                                </a></li>
                            <li><a href="<?= APP_CONFIG['url'] ?>carts"><span class="icon_bag_alt"></span>
                                    <div class="tip"><?= count($getCarts) ?></div>
                                </a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="canvas__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header Section End -->