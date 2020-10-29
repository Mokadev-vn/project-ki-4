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
                            <h3 class="mb-0">List Users</h3>
                        </div>
                    </div>
                </div>
                <!-- Light table -->
                <div class="table-responsive" data-toggle="list" data-list-values="[&quot;id&quot;,&quot;name&quot;, &quot;username&quot;, &quot;email&quot;, &quot;active&quot;, &quot;role&quot;]">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort" data-sort="id">Id</th>
                                <th scope="col" class="sort" data-sort="name">Full Name</th>
                                <th scope="col" class="sort" data-sort="username">Username</th>
                                <th scope="col" class="sort" data-sort="email">Email</th>
                                <th scope="col" class="sort" data-sort="active">Active</th>
                                <th scope="col" class="sort" data-sort="role">Role</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            <?php
                            foreach ($listUser as $user) :
                            ?>
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="id mb-0 text-sm"><?= $user['id'] ?></span>
                                            </div>
                                        </div>
                                    </th>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <a href="#" class="avatar rounded-circle mr-3">
                                                <img alt="Image placeholder" src="<?= APP_CONFIG['url'] ?>uploads/<?= $user['image'] ?>">
                                            </a>
                                            <div class="media-body">
                                                <span class="name mb-0 text-sm"><?= $user['full_name'] ?></span>
                                            </div>
                                        </div>
                                    </th>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="username mb-0 text-sm"><?= $user['username'] ?></span>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="email">
                                        <?= $user['email'] ?>
                                    </td>
                                    <td class="active">
                                        <?= ($user['active'] == 1) ? 'True' : 'False' ?>
                                    </td>
                                    <td class="role">
                                        <?= ($user['role'] == 1) ? '<span class="badge badge-pill badge-danger">Admin</span>' : '<span class="badge badge-pill badge-default">Member</span>' ?>
                                    </td>
                                    <td class="table-actions">
                                        <a href="<?= APP_CONFIG['url'] ?>admin/user/<?= $user['username'] ?>" class="table-action return-a" data-toggle="tooltip" data-original-title="Edit User">
                                            <i class="fas fa-user-edit"></i>
                                        </a>
                                        <a href="#" class="table-action table-action-delete delete-member" data-toggle="tooltip" username="<?= $user['username'] ?>" data-original-title="Delete User">
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