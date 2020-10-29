<?php layout('default.layouts.header', ['title' => 'Shop']) ?>
<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="<?= APP_CONFIG['url'] ?>"><i class="fa fa-home"></i> Home</a>
                    <span>Shop</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Shop Section Begin -->
<section class="shop spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3">
                <div class="shop__sidebar">
                    <div class="sidebar__categories">
                        <div class="section-title">
                            <h4>Categories</h4>
                        </div>
                        <div class="categories__accordion">
                            <div class="accordion" id="accordionExample">
                                <?php foreach ($categories as $category) : ?>
                                    <div class="card">
                                        <div class="card-heading">
                                            <a href="<?= APP_CONFIG['url'] . 'category/' . $category['slug'] ?>"><?= $category['name'] ?></a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-9 col-md-9">
                <div class="row">
                    <?php if (count($listProduct) == 0) : ?>
                        <h6>Không có sản phẩm nào</h6>
                    <?php else : ?>
                        <?php foreach ($listProduct as $product) : ?>
                            <div class="col-lg-4 col-md-6">
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
                                        <h6><a href="<?= APP_CONFIG['url'] . "product/" . $product['slug'] ?>"><?= $product['name'] ?></a></h6>
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
                    <?php endif; ?>
                    <?= paginationDefault($data['total'], $data['page']); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Shop Section End -->
<?php layout('default.layouts.footer'); ?>