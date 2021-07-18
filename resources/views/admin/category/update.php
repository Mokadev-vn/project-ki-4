<?php layout('admin.layouts.header'); ?>
<!-- Header page -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Tables</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Tables</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tables</li>
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
                <div class="card-header">
                    <h3 class="mb-0">Update Category</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <div id="message"></div>
                    <form>
                        <?php csrf_field(); ?>
                        <input type="hidden" id="category-id" value="<?= $id ?>">
                        <div class="form-group row">
                            <label for="product-name" class="col-md-2 col-form-label form-control-label">Category Name:</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" id="category-name" value="<?= $name ?>" require>
                            </div>
                            <p class="text-danger small mr-3 ml-3 mt-1" id="error-name"></p>
                        </div>
                        <div class="form-group row">
                            <label for="show" class="col-md-2 col-form-label form-control-label">Show Menu</label>
                            <div class="col-md-10">
                                <select class="form-control" id="show_menu">
                                    <option value="1" <?= ($show_menu == 1) ? "selected" : '' ?>>True</option>
                                    <option value="2" <?= ($show_menu == 2) ? "selected" : '' ?>>False</option>
                                </select>
                            </div>
                            <p class="text-danger small mr-3 ml-3 mt-1" id="error-show_menu"></p>
                        </div>
                        <div class="form-group row">
                            <label for="show" class="col-md-2 col-form-label form-control-label">Show Header</label>
                            <div class="col-md-10">
                                <select class="form-control" id="show_header">
                                    <option value="1" <?= ($show_header == 1) ? "selected" : '' ?>>True</option>
                                    <option value="2" <?= ($show_header == 2) ? "selected" : '' ?>>False</option>
                                </select>
                            </div>
                            <p class="text-danger small mr-3 ml-3 mt-1" id="error-show_header"></p>
                        </div>
                        <div class="form-group row">
                            <label for="show" class="col-md-2 col-form-label form-control-label">Show Index</label>
                            <div class="col-md-10">
                                <select class="form-control" id="show_slide">
                                    <option value="1" <?= ($show_slide == 1) ? "selected" : '' ?>>True</option>
                                    <option value="2" <?= ($show_slide == 2) ? "selected" : '' ?>>False</option>
                                </select>
                            </div>
                            <p class="text-danger small mr-3 ml-3 mt-1" id="error-show_slide"></p>
                        </div>
                        <div class="form-group row">
                            <label for="image-product" class="col-md-2 col-form-label form-control-label">Image Old</label>
                            <div class="col-md-5">
                                <img src="<?= APP_CONFIG['url'] ?>uploads/<?= $image ?>" class="img-fluid rounded" alt="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="image-category" class="col-md-2 col-form-label form-control-label">Image</label>
                            <div class="col-md-10">
                            <input type="file" class="form-control" id="image-category">
                            </div>
                            <p class="text-danger small mr-3 ml-3 mt-1" id="error-image"></p>
                        </div>
                        <button type="button" class="btn btn-success btn-lg btn-block" id="update-category">Update Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer -->
<?php layout('admin.layouts.footer'); ?>