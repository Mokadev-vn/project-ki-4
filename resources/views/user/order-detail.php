<?php layout('admin.layouts.header', ['layoutUser' => true, 'title' => 'Change Password']); ?>
<!-- Header page -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Profile</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Profile</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
    <div class="row mt--5">
        <div class="col-md-10 ml-auto mr-auto">
            <div class="card card-upgrade">
                <div class="card-header text-center border-bottom-0">
                    <h4 class="card-title">Order Details</h4>
                    <p class="card-category">Name: <?= $dataPayment['full_name'] ?> | Phone: <?= $dataPayment['phone'] ?> | Address: <?= $dataPayment['address'] ?></p>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-upgrade">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">Product</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dataPaymentDetail as $detail) : ?>
                                    <?php
                                    $price = ($detail['sale'] == 0) ? $detail['price'] : $detail['price'] - $detail['price'] * ($detail['sale'] / 100);
                                    $total = $price * $detail['quantity'];
                                    ?>
                                    <tr>
                                        <td><?= $detail['name'] ?></td>
                                        <td class="text-center"><?= saleOrder($detail['price'], $detail['sale']) ?></td>
                                        <td class="text-center"><?= $detail['quantity'] ?></td>
                                        <td class="text-center"><?= price($total) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center">Total: <?= price($dataPayment['total_mount']) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer -->
<?php layout('admin.layouts.footer'); ?>