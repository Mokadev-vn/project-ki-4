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
                <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                    <div class="d-flex justify-content-between">
                        <a href="#" class="btn btn-sm btn-danger mr-4 ">Delete</a>
                        <a href="#" class="btn btn-sm btn-default float-right">Send Mail</a>
                    </div>
                </div>
                <div class="card-body pt-0">
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
                        <input type="hidden" id="user-id" value="<?= $username ?>">
                        <div class="form-group row">
                            <label for="product-name" class="col-md-2 col-form-label form-control-label">Full Name:</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" id="full_name" value="<?= $full_name ?>" require>
                            </div>
                            <p class="text-danger small mr-3 ml-3 mt-1" id="error-full_name"></p>
                        </div>
                        <div class="form-group row">
                            <label for="product-name" class="col-md-2 col-form-label form-control-label">Username:</label>
                            <div class="col-md-10">
                                <input class="form-control" id="username" type="text" value="<?= $username ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="product-name" class="col-md-2 col-form-label form-control-label">Email:</label>
                            <div class="col-md-10">
                                <input class="form-control" type="email" id="email" value="<?= $email ?>" require>
                            </div>
                            <p class="text-danger small mr-3 ml-3 mt-1" id="error-email"></p>
                        </div>
                        <div class="form-group row">
                            <label for="product-name" class="col-md-2 col-form-label form-control-label">Birthday:</label>
                            <div class="col-md-10">
                                <input class="form-control" type="date" id="birthday" value="<?= $birthday ?>" require>
                            </div>
                            <p class="text-danger small mr-3 ml-3 mt-1" id="error-birthday"></p>
                        </div>
                        <div class="form-group row">
                            <label for="active" class="col-md-2 col-form-label form-control-label">Active</label>
                            <div class="col-md-10">
                                <select class="form-control" id="active">
                                    <option value="1" <?= ($active == 1) ? 'selected' : '' ?>>True</option>
                                    <option value="2" <?= ($active == 2) ? 'selected' : '' ?>>False</option>
                                </select>
                            </div>
                            <p class="text-danger small mr-3 ml-3 mt-1" id="error-active"></p>
                        </div>
                        <div class="form-group row">
                            <label for="role" class="col-md-2 col-form-label form-control-label">Role</label>
                            <div class="col-md-10">
                                <select class="form-control" id="role">
                                    <option value="1" <?= ($role == 1) ? 'selected' : '' ?>>Admin</option>
                                    <option value="2" <?= ($role == 2) ? 'selected' : '' ?>>Member</option>
                                </select>
                            </div>
                            <p class="text-danger small mr-3 ml-3 mt-1" id="error-role"></p>
                        </div>
                        <button type="button" class="btn btn-success btn-lg btn-block" id="update-member">Update Member</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer -->
<?php layout('admin.layouts.footer'); ?>