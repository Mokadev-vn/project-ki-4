<?php layout('admin.layouts.header',['title' => 'Update Product']); ?>
<!-- Header page -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Update</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="<?= APP_CONFIG['url'] ?>admin"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="<?= APP_CONFIG['url'] ?>admin/product">Product</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update</li>
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
                <div class="card-header">
                    <h3 class="mb-0">Update Product</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <div id="message"></div>
                    <form>
                        <?php csrf_field(); ?>
                        <input type="hidden" id="id" value="<?= $data['product']['id'] ?>">
                        <div class="form-group row">
                            <label for="product-name" class="col-md-2 col-form-label form-control-label">Product Name:</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" id="product-name" value="<?= $data['product']['name'] ?>" require>
                            </div>
                            <p class="text-danger small mr-3 ml-3 mt-1" id="error-name"></p>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label form-control-label" for="description">Description: </label>
                            <div class="col-md-10">
                                <textarea class="form-control" id="description" rows="3"><?= $data['product']['description'] ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="price" class="col-md-2 col-form-label form-control-label">Price:</label>
                            <div class="col-md-10">
                                <input class="form-control" type="number" value="<?= $data['product']['price'] ?>" id="price" require>
                            </div>
                            <p class="text-danger small mr-3 ml-3 mt-1" id="error-price"></p>
                        </div>
                        <div class="form-group row">
                            <label for="sale" class="col-md-2 col-form-label form-control-label">Sale</label>
                            <div class="col-md-10">
                                <input class="form-control" type="number" value="<?= $data['product']['sale'] ?>" id="sale">
                            </div>
                            <p class="text-danger small mr-3 ml-3 mt-1" id="error-sale"></p>
                        </div>
                        <div class="form-group row">
                            <label for="status" class="col-md-2 col-form-label form-control-label">Status</label>
                            <div class="col-md-10">
                                <select class="form-control" id="status">
                                    <option value="2" <?= ($data['product']['status']) == 2 ? 'selected' : '' ?>>Show</option>
                                    <option value="1" <?= ($data['product']['status']) == 1 ? 'selected' : '' ?>>Hidden</option>
                                </select>
                            </div>
                            <p class="text-danger small mr-3 ml-3 mt-1" id="error-status"></p>
                        </div>
                        <div class="form-group row">
                            <label for="category" class="col-md-2 col-form-label form-control-label">Category</label>
                            <div class="col-md-10">
                                <select class="form-control" id="category">
                                    <?php foreach ($data['cate'] as $category) : ?>
                                        <option value="<?= $category['id'] ?>" <?= ($category['id'] == $data['product']['product_type_id']) ? 'selected' : '' ?>><?= $category['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <p class="text-danger small mr-3 ml-3 mt-1" id="error-category"></p>
                        </div>
                        <div class="form-group row">
                            <label for="image-product" class="col-md-2 col-form-label form-control-label">Image Old</label>
                            <div class="col-md-5">
                                <img src="<?= APP_CONFIG['url'] ?>uploads/<?= $data['product']['image'] ?>" class="img-fluid rounded" alt="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="image-product" class="col-md-2 col-form-label form-control-label">Image New</label>
                            <div class="col-md-10">
                                <input type="file" class="form-control" id="image-product">
                            </div>
                            <p class="text-danger small mr-3 ml-3 mt-1" id="error-image"></p>
                        </div>
                        <button type="button" class="btn btn-success btn-lg btn-block" id="update-product">Update Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer -->
<?php layout('admin.layouts.footer'); ?>