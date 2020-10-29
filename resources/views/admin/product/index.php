<?php layout('admin.layouts.header'); ?>
<!-- Header page -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Products</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Products</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="<?= APP_CONFIG['url']; ?>/admin/product/create" class="btn btn-sm btn-neutral">New</a>
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
                            <h3 class="mb-0">List Products</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="#" class="btn btn-sm btn-danger btn-round btn-icon" data-toggle="tooltip" data-original-title="Edit product" id="delete-products">
                                <span class="btn-inner--icon"><i class="fas fa-trash"></i></span>
                                <span class="btn-inner--text">Delete</span>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Light table -->
                <div class="table-responsive" data-toggle="" data-list-values="[&quot;id&quot;,&quot;name&quot;, &quot;price&quot;, &quot;categories&quot;, &quot;views&quot;]">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">
                                    <div class="custom-control custom-checkbox" id="check-all">
                                        <input class="custom-control-input" id="table-check-all" data-toggle="toggle" type="checkbox">
                                        <label class="custom-control-label" for="table-check-all"></label>
                                    </div>
                                </th>
                                <th scope="col" class="sort" data-sort="id">Id</th>
                                <th scope="col" class="sort" data-sort="name">Name</th>
                                <th scope="col" class="sort" data-sort="price">Price</th>
                                <th scope="col" class="sort" data-sort="categories">Categories</th>
                                <th scope="col" class="sort" data-sort="views">Views</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            <?php
                            foreach ($data['product'] as $product) :
                            ?>
                                <tr>
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input input-change" id="<?= $product['id'] ?>" name="productId[]" type="checkbox" value="<?= $product['id'] ?>">
                                            <label class="custom-control-label" for="<?= $product['id'] ?>"></label>
                                        </div>
                                    </th>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="id mb-0 text-sm"><?= $product['id'] ?></span>
                                            </div>
                                        </div>
                                    </th>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <a href="#" class="avatar rounded-circle mr-3">
                                                <img alt="Image placeholder" src="<?= APP_CONFIG['url'] ?>uploads/<?= $product['image'] ?>">
                                            </a>
                                            <div class="media-body">
                                                <span class="name mb-0 text-sm"><?= $product['name'] ?></span>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="price">
                                        <?= price($product['price']) ?>
                                    </td>
                                    <td class="categories">
                                        <?= $product['type_name'] ?>
                                    </td>
                                    <td class="views">
                                        <?= $product['count_views'] ?>
                                    </td>
                                    <td class="table-actions">
                                        <a href="<?= APP_CONFIG['url'] ?>admin/product/<?= $product['id'] ?>/update" class="table-action" data-toggle="tooltip" data-original-title="Edit product">
                                            <i class="fas fa-user-edit"></i>
                                        </a>
                                        <a href="#" class="table-action table-action-delete delete-product" data-toggle="tooltip" id_product="<?= $product['id'] ?>" data-original-title="Delete product">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- Card footer -->
                <?= pagination($data['total'], $data['page']); ?>
            </div>
        </div>
    </div>
</div>
<!-- Footer -->
<?php layout('admin.layouts.footer'); ?>