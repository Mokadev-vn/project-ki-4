<?php layout('admin.layouts.header'); ?>
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
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header border-0">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="mb-0">List Order</h3>
                        </div>
                    </div>
                </div>
                <!-- Light table -->
                <div class="table-responsive" data-toggle="list" data-list-values="[&quot;id&quot;,&quot;full_name&quot;,&quot;name_product&quot;,&quot;content&quot;,&quot;active&quot;mount&quot;]">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort" style="width: 5%" data-sort="id">Id</th>
                                <th scope="col" class="sort" style="width: 20%" data-sort="full_name">Name</th>
                                <th scope="col" class="sort" data-sort="name_product" style="width: 15%" data-sort="">Phone</th>
                                <th scope="col" class="sort" data-sort="content">Address</th>
                                <th scope="col" class="sort" style="width: 10%" data-sort="active">Status</th>
                                <th scope="col" style="width: 10%" data-sort="mount">Mount</th>
                                <th scope="col" style="width: 10%">Action</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            <?php foreach ($listPayment as $payment) : ?>
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="id mb-0 text-sm"><?= $payment['id'] ?></span>
                                            </div>
                                        </div>
                                    </th>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="full_name mb-0 text-sm"><?= $payment['full_name'] ?></span>
                                            </div>
                                        </div>
                                    </th>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="name_product mb-0 text-sm"><?= $payment['phone'] ?></span>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="content"><?= $payment['address'] ?></td>
                                    <td class="active"><?= orderStatus($payment['status']) ?></td>
                                    <td class="table-actions">
                                        <?= price($payment['total_mount']) ?>
                                    </td>
                                    <td>
                                        <a href="./order-detail/<?= $payment['id'] ?>" class="table-action return-a" data-toggle="tooltip" data-original-title="View Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Card footer -->
                <?= pagination($total_page, $page); ?>
            </div>
        </div>
    </div>
</div>
<!-- Footer -->
<?php layout('admin.layouts.footer'); ?>