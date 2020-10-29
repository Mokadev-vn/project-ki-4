<?php
$user = getSession('user');
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?= (isset($title)) ? $title : 'Admin' ?></title>
  <?php layout('admin.layouts.style'); ?>
</head>

<body>
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header d-flex align-items-center">
        <a class="navbar-brand" href="<?= APP_CONFIG['url'] ?>">
          <img src="<?= APP_CONFIG['static'] ?>assets/img/brand/blue.png" class="navbar-brand-img" alt="...">
        </a>
        <div class="ml-auto">
          <!-- Sidenav toggler -->
          <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <?php if (!isset($layoutUser)) : ?>
          <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Nav items -->
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="<?= APP_CONFIG['url'] ?>admin">
                  <i class="ni ni-archive-2 text-green"></i>
                  <span class="nav-link-text">Dashboards</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#navbar-tables" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-tables ">
                  <i class="ni ni-atom text-orange"></i>
                  <span class="nav-link-text">Products</span>
                </a>
                <div class="collapse" id="navbar-tables">
                  <ul class="nav nav-sm flex-column">
                    <li class="nav-item">
                      <a href="<?= APP_CONFIG['url'] ?>admin/product" class="nav-link">List Products</a>
                    </li>
                    <li class="nav-item">
                      <a href="<?= APP_CONFIG['url'] ?>admin/product/create" class="nav-link">Add Product</a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#navbar-categories" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-tables ">
                  <i class="ni ni-bullet-list-67 text-blue"></i>
                  <span class="nav-link-text">Categories</span>
                </a>
                <div class="collapse" id="navbar-categories">
                  <ul class="nav nav-sm flex-column">
                    <li class="nav-item">
                      <a href="<?= APP_CONFIG['url'] ?>admin/category" class="nav-link">List Categories</a>
                    </li>
                    <li class="nav-item">
                      <a href="<?= APP_CONFIG['url'] ?>admin/category/create" class="nav-link">Add Category</a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?= APP_CONFIG['url'] ?>admin/user">
                  <i class="ni ni-single-02 text-orange"></i>
                  <span class="nav-link-text">Users</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?= APP_CONFIG['url'] ?>admin/comment">
                  <i class="ni ni-badge text-orange"></i>
                  <span class="nav-link-text">Comments</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?= APP_CONFIG['url'] ?>admin/order">
                  <i class="ni ni-cart text-orange"></i>
                  <span class="nav-link-text">Orders</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?= APP_CONFIG['url'] ?>admin/contact">
                  <i class="ni ni-support-16 text-orange"></i>
                  <span class="nav-link-text">Contacts</span>
                </a>
              </li>
            </ul>

            <!-- Divider -->
            <hr class="my-3">
          </div>
        <?php else : ?>
          <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Nav items -->
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="<?= APP_CONFIG['url'] ?>profile">
                  <i class="ni ni-archive-2 text-green"></i>
                  <span class="nav-link-text">Profile</span>
                </a>
              </li>
              <?php if (getSession('user')['role'] == 1) : ?>
                <li class="nav-item">
                  <a class="nav-link" href="<?= APP_CONFIG['url'] ?>admin">
                    <i class="ni ni-spaceship text-red"></i>
                    <span class="nav-link-text">Admin Controls</span>
                  </a>
                </li>
              <?php endif; ?>
              <li class="nav-item">
                <a class="nav-link" href="<?= APP_CONFIG['url'] ?>user/orders">
                  <i class="ni ni-cart text-orange"></i>
                  <span class="nav-link-text">Orders</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?= APP_CONFIG['url'] ?>contact">
                  <i class="ni ni-support-16 text-red"></i>
                  <span class="nav-link-text">Contact</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?= APP_CONFIG['url'] ?>user/change-password">
                  <i class="ni ni-lock-circle-open"></i>
                  <span class="nav-link-text">Change Password</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?= APP_CONFIG['url'] ?>logout">
                  <i class="ni ni-user-run text-blue"></i>
                  <span class="nav-link-text">Logout</span>
                </a>
              </li>
            </ul>

            <!-- Divider -->
            <hr class="my-3">
          </div>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Navbar links -->
          <ul class="navbar-nav align-items-center ml-md-auto">
            <li class="nav-item d-xl-none">
              <!-- Sidenav toggler -->
              <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </div>
            </li>
            <li class="nav-item d-sm-none">
              <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                <i class="ni ni-zoom-split-in"></i>
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ni ni-ungroup"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-dark bg-default dropdown-menu-right">
                <div class="row shortcuts px-4">
                  <a href="#!" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-red">
                      <i class="ni ni-calendar-grid-58"></i>
                    </span>
                    <small>Calendar</small>
                  </a>
                  <a href="#!" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-orange">
                      <i class="ni ni-email-83"></i>
                    </span>
                    <small>Email</small>
                  </a>
                  <a href="#!" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-info">
                      <i class="ni ni-credit-card"></i>
                    </span>
                    <small>Payments</small>
                  </a>
                  <a href="#!" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-green">
                      <i class="ni ni-books"></i>
                    </span>
                    <small>Reports</small>
                  </a>
                  <a href="#!" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-purple">
                      <i class="ni ni-pin-3"></i>
                    </span>
                    <small>Maps</small>
                  </a>
                  <a href="#!" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-yellow">
                      <i class="ni ni-basket"></i>
                    </span>
                    <small>Shop</small>
                  </a>
                </div>
              </div>
            </li>
          </ul>
          <ul class="navbar-nav align-items-center ml-auto ml-md-0">
            <li class="nav-item dropdown">
              <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="media align-items-center">
                  <span class="avatar avatar-sm rounded-circle">
                    <img alt="Image placeholder" src="<?= APP_CONFIG['url'] ?>uploads/<?= $user['image'] ?>">
                  </span>
                  <div class="media-body ml-2 d-none d-lg-block">
                    <span class="mb-0 text-sm  font-weight-bold"><?= $user['full_name'] ?></span>
                  </div>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header noti-title">
                  <h6 class="text-overflow m-0">Welcome!</h6>
                </div>
                <div class="dropdown-divider"></div>
                <a href="<?= APP_CONFIG['url'] ?>user/change-password" class="dropdown-item">
                  <i class="ni ni-lock-circle-open"></i>
                  <span>Change Password</span>
                </a>
                <a href="<?= APP_CONFIG['url'] ?>logout" class="dropdown-item">
                  <i class="ni ni-user-run"></i>
                  <span>Logout</span>
                </a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>