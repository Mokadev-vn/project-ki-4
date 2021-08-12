<?php layout('default.layouts.header', ['title' => "Checkout"]) ?>
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

<!-- Checkout Section Begin -->
<section class="checkout spad">
    <div class="container">
        <form action="" class="checkout__form" method="post">
            <?php csrf_field(); ?>
            <div class="row">
                <div class="col-lg-8">
                    <h5>Billing detail</h5>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="checkout__form__input">
                                <p>Full Name <span>*</span></p>
                                <input type="text" name="full_name" value="<?= $user['full_name'] ?>">
                                <div class="invalid-feedback">
                                    <?= isset($error['full_name']) ? $error['full_name'] : '' ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="checkout__form__input">
                                <p>Address <span>*</span></p>
                                <input type="text" name="address" placeholder="Street Address">
                                <div class="invalid-feedback">
                                    <?= isset($error['address']) ? $error['address'] : '' ?>
                                </div>
                            </div>
                            <div class="checkout__form__input">
                                <p>Town/City <span>*</span></p>
                                <input type="text" name="city" placeholder="City ">
                                <div class="invalid-feedback">
                                    <?= isset($error['city']) ? $error['city'] : '' ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout__form__input">
                                <p>Phone <span>*</span></p>
                                <input type="text" name="phone">
                                <div class="invalid-feedback">
                                    <?= isset($error['phone']) ? $error['phone'] : '' ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout__form__input">
                                <p>Email <span>*</span></p>
                                <input type="text" name="email" value="<?= $user['email'] ?>">
                                <div class="invalid-feedback">
                                    <?= isset($error['email']) ? $error['email'] : '' ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="checkout__form__input">
                                <p>Oder notes</p>
                                <input type="text" name="notes" placeholder="Note about your order, e.g, special noe for delivery">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="checkout__order">
                        <h5>Your order</h5>
                        <div class="checkout__order__product">
                            <ul>
                                <li>
                                    <span class="top__text">Product</span>
                                    <span class="top__text__right">Total</span>
                                </li>
                                <?php $totals = 0; ?>
                                <?php foreach ($carts as $key => $cart) : ?>
                                    
                                    <?php
                                        $price = ($cart['sale'] == 0) ? $cart['price'] : $cart['price'] - $cart['price'] * ($cart['sale'] / 100);
                                        $total = $price * $cart['quantity'];
                                        $totals += $total;
                                    ?>
                                    <li><?= $key + 1 ?>. <?= $cart['name'] ?> <span><?= price($total) ?></span></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="checkout__order__total">
                            <ul>
                                <li>Subtotal <span><?= price($totals) ?></span></li>
                                <li>Total <span><?= price($totals) ?></span></li>
                                <input type="hidden" name="total_mount" value="<?= $totals ?>">
                            </ul>
                        </div>
                        <div class="checkout__order__widget">
                            <label for="check-payment">
                                Payment on delivery.
                                <input type="checkbox" id="check-payment" checked>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <button type="submit" class="site-btn">Place oder</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- Checkout Section End -->
<?php layout('default.layouts.footer'); ?>