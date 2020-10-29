<?php layout('user.layouts.header', ['title' => 'Reset Password']); ?>
<!-- Main content -->
<div class="main-content">
  <!-- Header -->
  <div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
    <div class="container">
      <div class="header-body text-center mb-7">
        <div class="row justify-content-center">
          <div class="col-xl-5 col-lg-6 col-md-8 px-5">
            <h1 class="text-white">Reset Password!</h1>
            <p class="text-lead text-white">Sign in to use our features</p>
          </div>
        </div>
      </div>
    </div>
    <div class="separator separator-bottom separator-skew zindex-100">
      <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
        <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
      </svg>
    </div>
  </div>
  <!-- Page content -->
  <div class="container mt--8 pb-5">
    <div class="row justify-content-center">
      <div class="col-lg-5 col-md-7">
        <div class="card bg-secondary border-0 mb-0">
          <div class="card-body px-lg-5 py-lg-5">
            <div class="text-center text-muted mb-4">
              <small>Enter your email or username to retrieve your password!</small>
            </div>
            <div id="message">
            </div>
            <form role="form">
              <?php csrf_field(); ?>
              <div class="form-group mb-3">
                <div class="input-group input-group-merge input-group-alternative">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
                  </div>
                  <input class="form-control" id="username" placeholder="Email or username" type="text" require>
                </div>
                <p class="text-danger small mr-3 ml-3 mt-1" id="error-username"></p>
              </div>
              <div class="text-center">
                <button type="button" class="btn btn-primary my-4" id="reset-password">Reset</button>
              </div>
            </form>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-6">
            <a href="<?= APP_CONFIG['url'] ?>login" class="text-light"><small>Login Account</small></a>
          </div>
          <div class="col-6 text-right">
            <a href="<?= APP_CONFIG['url'] ?>register" class="text-light"><small>Create new account</small></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php layout('user.layouts.footer'); ?>