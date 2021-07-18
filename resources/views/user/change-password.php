<?php layout('admin.layouts.header',['layoutUser'=> true, 'title'=>'Change Password']); ?>
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
        <div class="col-xl-4 order-xl-2">
            <div class="card card-profile">
                <img src="<?= APP_CONFIG['uploads'] ?>cover-user.jpg" alt="Image placeholder" class="card-img-top">
                <div class="row justify-content-center">
                    <div class="col-lg-3 order-lg-2">
                        <div class="card-profile-image">
                            <a href="#">
                                <img src="<?= APP_CONFIG['uploads'] . $image ?>" class="rounded-circle">
                            </a>
                        </div>
                    </div>
                </div>
               
                <div class="card-body pt-5 mt-4">
                    <div class="text-center">
                        <h5 class="h2">
                            <?= $full_name ?>
                        </h5>
                        <div class="h3 font-weight-300">
                            <span class="badge badge-pill <?= ($role == 1) ? 'badge-danger' : 'badge-success' ?>"><i class="ni ni-single-02"></i> <?= ($role == 1) ? 'Admin' : 'Member' ?></span>
                        </div>
                        <div class="h4 mt-4">
                            <span class="">Birthday: <?= formatDate($birthday) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 order-xl-1">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <h3 class="mb-0">Update User</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <div id="message"></div>
                    <form>
                        <?php csrf_field(); ?>
                        <div class="form-group row">
                            <label for="product-name" class="col-md-3 col-form-label form-control-label">Old Password:</label>
                            <div class="col-md-9">
                                <input class="form-control" type="password" id="old_password" value="" require>
                            </div>
                            <p class="text-danger small mr-3 ml-3 mt-1" id="error-old_password"></p>
                        </div>
                        <div class="form-group row">
                            <label for="product-name" class="col-md-3 col-form-label form-control-label">New Password:</label>
                            <div class="col-md-9">
                                <input class="form-control" type="password" id="password" value="" require>
                            </div>
                            <p class="text-danger small mr-3 ml-3 mt-1" id="error-password"></p>
                        </div>
                        <div class="form-group row">
                            <label for="product-name" class="col-md-3 col-form-label form-control-label">Re Password:</label>
                            <div class="col-md-9">
                                <input class="form-control" type="password" id="rePassword" value="" require>
                            </div>
                            <p class="text-danger small mr-3 ml-3 mt-1" id="error-rePassword"></p>
                        </div>
                        <button type="button" class="btn btn-success btn-lg btn-block" id="change-password">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer -->
<?php layout('admin.layouts.footer'); ?>