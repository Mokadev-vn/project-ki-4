<?php layout('admin.layouts.header'); ?>
<!-- Header page -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Categories</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Categories</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="<?= APP_CONFIG['url']; ?>admin/category/create" class="btn btn-sm btn-neutral">New</a>
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
                            <h3 class="mb-0">List Categories</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="#" class="btn btn-sm btn-danger btn-round btn-icon" data-toggle="tooltip" data-original-title="Edit product" id="delete-categories">
                                <span class="btn-inner--icon"><i class="fas fa-trash"></i></span>
                                <span class="btn-inner--text">Delete</span>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Light table -->
                <div class="table-responsive" data-toggle="" data-list-values="[&quot;id&quot;,&quot;name&quot;]">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" style="width: 5%">
                                    <div class="custom-control custom-checkbox" id="check-all">
                                        <input class="custom-control-input" id="table-check-all" data-toggle="toggle" type="checkbox">
                                        <label class="custom-control-label" for="table-check-all"></label>
                                    </div>
                                </th>
                                <th scope="col" class="sort" style="width: 5%" data-sort="id">Id</th>
                                <th scope="col" class="sort" data-sort="name">Name</th>
                                <th scope="col" class="sort" style="width: 5%" data-sort="show">Show Index</th>
                                <th scope="col" style="width: 10%"></th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            <?php
                            foreach ($data['category'] as $category) :
                            ?>
                                <tr>
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input input-change" id="<?= $category['id'] ?>" type="checkbox" value="<?= $category['id'] ?>">
                                            <label class="custom-control-label" for="<?= $category['id'] ?>"></label>
                                        </div>
                                    </th>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="id mb-0 text-sm"><?= $category['id'] ?></span>
                                            </div>
                                        </div>
                                    </th>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <a href="#" class="avatar rounded-circle mr-3">
                                                <img alt="Image placeholder" src="<?= APP_CONFIG['url'] ?>uploads/<?= $category['image'] ?>">
                                            </a>
                                            <div class="media-body">
                                                <span class="name mb-0 text-sm"><?= $category['name'] ?></span>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="price">
                                        <?= ($category['show_index'] == 1) ? 'Show' : 'Hidden' ?>
                                    </td>
                                    <td class="table-actions">
                                        <a href="<?= APP_CONFIG['url'] ?>admin/category/<?= $category['id'] ?>/update" class="table-action" data-toggle="tooltip" data-original-title="Edit Category">
                                            <i class="fas fa-user-edit"></i>
                                        </a>
                                        <a href="#" class="table-action table-action-delete delete-category" data-toggle="tooltip" id_category="<?= $category['id'] ?>" data-original-title="Delete Category">
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