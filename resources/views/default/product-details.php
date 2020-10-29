<?php layout('default.layouts.header', ['title' => $info['name']]) ?>

<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="<?= APP_CONFIG['url'] ?>"><i class="fa fa-home"></i> Home</a>
                    <a href="<?= APP_CONFIG['url'] . 'category/' . $category['slug'] ?>"><?= $category['name'] ?></a>
                    <span><?= $info['name'] ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Product Details Section Begin -->
<section class="product-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="product__details__pic">
                    <!-- <div class="product__details__pic__left product__thumb nice-scroll">
                        <a class="pt active" href="#product-1">
                            <img src="img/product/details/thumb-1.jpg" alt="">
                        </a>
                        <a class="pt" href="#product-2">
                            <img src="img/product/details/thumb-2.jpg" alt="">
                        </a>
                        <a class="pt" href="#product-3">
                            <img src="img/product/details/thumb-3.jpg" alt="">
                        </a>
                        <a class="pt" href="#product-4">
                            <img src="img/product/details/thumb-4.jpg" alt="">
                        </a>
                    </div> -->
                    <div class="product__details__slider__content">
                        <div class="product__details__pic__slider owl-carousel">
                            <img data-hash="product-1" class="product__big__img" src="<?= APP_CONFIG['uploads'] . $info['image'] ?>" alt="">
                            <!-- <img data-hash="product-2" class="product__big__img" src="img/product/details/product-3.jpg" alt="">
                            <img data-hash="product-3" class="product__big__img" src="img/product/details/product-2.jpg" alt="">
                            <img data-hash="product-4" class="product__big__img" src="img/product/details/product-4.jpg" alt=""> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="product__details__text">
                    <h3><?= $info['name'] ?> <span><?= $category['name'] ?></span></h3>
                    <div class="">
                        <h6 style="font-size: 14px"><i class="fa fa-eye" aria-hidden="true"></i> (<?= $info['count_views'] ?>) views</h6>
                    </div>
                    <!-- <div class="rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <span>( 138 reviews )</span>
                    </div> -->
                    <!-- <div class="product__details__price">$ 75.0 <span>$ 83.0</span></div> -->
                    <div class="product__details__price"><?= sale($info['price'], $info['sale']) ?></div>
                    <p><?= $info['description'] ?></p>
                    <div class="product__details__button">
                        <div class="quantity">
                            <span>Quantity:</span>
                            <div class="pro-qty">
                                <input type="text" id="qty" value="1">
                            </div>
                        </div>
                        <a href="#" class="cart-btn" id="add_cart" slug="<?= $info['slug'] ?>"><span class="icon_bag_alt"></span> Add to cart</a>
                        <ul>
                            <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                            <li><a href="#"><span class="icon_adjust-horiz"></span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="product__details__tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Description</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Comment ( <?= count($comments) ?> )</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <h6>Description</h6>
                            <p><?= $info['description'] ?></p>
                        </div>
                        <div class="tab-pane" id="tabs-3" role="tabpanel">
                            <h6>Comments ( <?= count($comments) ?> )</h6>
                            <div class="blog__details__comment">
                                <?php if (count($comments)) : ?>
                                    <?php foreach ($comments as $comment) : ?>
                                        <div class="blog__comment__item">
                                            <div class="blog__comment__item__pic">
                                                <img src="<?= APP_CONFIG['uploads'] . $comment['image'] ?>" alt="">
                                            </div>
                                            <div class="blog__comment__item__text">
                                                <h6><?= $comment['full_name'] ?></h6>
                                                <p><?= $comment['content'] ?>.</p>
                                                <ul>
                                                    <li><i class="fa fa-clock-o"></i> <?= formatDate($comment['create_at'], "H:i - d/m/Y") ?></li>
                                                </ul>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <p>Not Comment</p>
                                <?php endif; ?>
                            </div>
                            <?php if (getSession('user')) : ?>

                                <form class="mt-2">
                                    <div id="message" class="alert"></div>
                                    <?php csrf_field(); ?>
                                    <input type="hidden" id="id_product" value="<?= $info['id']; ?>">
                                    <div class="form-group">
                                        <label for="comment">Read Comment</label>
                                        <textarea class="form-control" id="comment" col="100" rows="3"></textarea>
                                        <p style="color: red" id="error-message"></p>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-success" id="send-comment">Comment</button>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="related__title">
                    <h5>RELATED PRODUCTS</h5>
                </div>
            </div>
            <?php foreach ($productCate as $product) : ?>
                <div class="col-lg-3 col-md-4 col-sm-6 <?= $product['slug_cate'] ?>">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="<?= APP_CONFIG['uploads'] . $product['image'] ?>">
                            <?php if ($product['sale'] != 0) : ?>
                                <div class="label sale">Sale - <?= $product['sale'] ?>% </div>
                            <?php endif; ?>
                            <?php if ($product['status'] == 1) : ?>
                                <div class="label stockout">out of stock</div>
                            <?php endif; ?>
                            <ul class="product__hover">
                                <li><a href="<?= APP_CONFIG['uploads'] . $product['image'] ?>" class="image-popup"><span class="arrow_expand"></span></a></li>
                                <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                <li><a href="#"><span class="icon_bag_alt"></span></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="<?= APP_CONFIG['url'] . 'product/' . $product['slug'] ?>"><?= $product['name'] ?></a></h6>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="product__price"><?= sale($product['price'], $product['sale']) ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<!-- Product Details Section End -->
<?php layout('default.layouts.footer'); ?>