<?php layout('default.layouts.header', ['title' => 'Carts']) ?>
<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="./index.html"><i class="fa fa-home"></i> Home</a>
                    <span>Shopping cart</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Shop Cart Section Begin -->
<section class="shop-cart spad">
    <div class="container">
        <?php $totals = 0; ?>
        <?php if (count($carts)) : ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shop__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($carts as $cart) : ?>
                                    <tr class="product_cart" id="<?= $cart['id'] ?>">
                                        <td class="cart__product__item">
                                            <img src="<?= APP_CONFIG['uploads'] . $cart['image'] ?>" alt="">
                                            <div class="cart__product__item__title">
                                                <h6><a href="<?= APP_CONFIG['url'].'product/'. $cart['slug'] ?>"><?= $cart['name'] ?></a></h6>
                                                <div class="rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                            </div>
                                        </td>
                                        <?php
                                        $price = ($cart['sale'] == 0) ? $cart['price'] : $cart['price'] - $cart['price'] * ($cart['sale'] / 100);
                                        $total = $price * $cart['quantity'];
                                        $totals += $total;
                                        ?>
                                        <td class="cart__price"><?= price($price) ?></td>
                                        <td class="cart__quantity">
                                            <div class="pro-qty">
                                                <input type="text" value="<?= $cart['quantity'] ?>">
                                            </div>
                                        </td>
                                        <td class="cart__total"><?= price($total) ?></td>
                                        <td class="cart__close"><span class="icon_close delete_cart" cart_id="<?= $cart['id'] ?>"></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <div class="row mb-4">
                <h4>Không có sản phẩm nào</h4>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="cart__btn">
                    <a href="<?= APP_CONFIG['url']; ?>">Continue Shopping</a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="cart__btn update__btn">
                    <a href="#" id="update_cart"><span class="icon_loading"></span> Update cart</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <!-- <div class="discount__content">
                    <h6>Discount codes</h6>
                    <form action="#">
                        <input type="text" placeholder="Enter your coupon code">
                        <button type="submit" class="site-btn">Apply</button>
                    </form>
                </div> -->
            </div>
            <div class="col-lg-4 offset-lg-2">
                <div class="cart__total__procced">
                    <h6>Cart total</h6>
                    <ul>
                        <li>Total Product <span><?= count($carts) ?></span></li>
                        <li>Total <span><?= price($totals) ?></span></li>
                    </ul>
                    <a href="#" class="primary-btn">Proceed to checkout</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Shop Cart Section End -->
<?php layout('default.layouts.footer'); ?>