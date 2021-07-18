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
                    <h3 class="mb-0">Setting Website</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <div id="message"></div>
                    <form>
                        <?php csrf_field(); ?>
                        <div class="form-group row">
                            <label for="product-name" class="col-md-2 col-form-label form-control-label">Title Name:</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" id="name" placeholder="Title Name ..." require value="<?= isset($infoSetting['title']) ? $infoSetting['title'] : ''?>">
                            </div>
                            <p class="text-danger small mr-3 ml-3 mt-1" id="error-name"></p>
                        </div>
                        <div class="form-group row">
                            <label for="image-category" class="col-md-2 col-form-label form-control-label">Logo</label>
                            <div class="col-md-10">
                            <input type="file" class="form-control" id="image">
                            </div>
                            <p class="text-danger small mr-3 ml-3 mt-1" id="error-image"></p>
                        </div>
                        <?php if(isset($infoSetting['logo'])): ?>
                        <div class="form-group row">
                            <label for="image-product" class="col-md-2 col-form-label form-control-label">Image Old</label>
                            <div class="col-md-5">
                                <img src="<?= APP_CONFIG['url'] ?>uploads/<?= $infoSetting['logo'] ?>" class="img-fluid rounded" alt="">
                            </div>
                        </div>
                        <?php endif; ?>
                        <button type="button" class="btn btn-success btn-lg btn-block" id="update-setting">Save Setting</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer -->
<?php layout('admin.layouts.footer'); ?>