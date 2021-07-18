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
        <div class="col-xl-6 order-xl-1">
            <div class="card card-profile">
                <div class="card-header border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                    <h5 class="h2">
                        <?= $title ?>
                    </h5>
                    <div class="d-flex justify-content-between h4">Name: <?= $name ?></div>
                    <div class="d-flex justify-content-between h4">Email: <?= $email ?></div>
                    <div class="h3 font-weight-300">
                        <span class="badge badge-pill <?= ($reply == 1) ? 'badge-success' : 'badge-danger' ?> "><i class="ni ni-email-83"></i> <?= ($reply == 1) ? 'Reply' : 'Not Reply' ?></span>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="h4">
                        <span class="">Message:</span>
                    </div>
                    <blockquote class="blockquote">
                        <p class="mb-0"><?= $message ?></p>
                    </blockquote>
                </div>
            </div>
        </div>
        <div class="col-xl-6 order-xl-2">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <h3 class="mb-0">Reply Contact</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <form>
                        <?php csrf_field(); ?>
                        <input type="hidden" id="id" value="<?= $id ?>">
                        <div class="form-group row">
                            <label for="product-name" class="col-md-2 col-form-label form-control-label">Title</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" id="title" value="" require>
                            </div>
                            <p class="text-danger small mr-3 ml-3 mt-1" id="error-title"></p>
                        </div>
                        <div class="form-group row">
                            <label for="product-name" class="col-md-2 col-form-label form-control-label">Email:</label>
                            <div class="col-md-10">
                                <input class="form-control" id="email" type="text" value="<?= $email ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message" class=" form-control-label">Message</label>
                            <textarea class="form-control" id="message" rows="8" name="message"></textarea>
                            <p class="text-danger small mr-3 ml-3 mt-1" id="error-message"></p>
                        </div>
                        <button type="button" class="btn btn-success btn-lg btn-block" id="reply-email">Send Mail</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer -->
<?php layout('admin.layouts.footer'); ?>