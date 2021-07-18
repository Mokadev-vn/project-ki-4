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
                            <h3 class="mb-0">List Contact</h3>
                        </div>
                    </div>
                </div>
                <!-- Light table -->
                <div class="table-responsive" data-toggle="list" data-list-values="[&quot;id&quot;,&quot;name&quot;,&quot;email&quot;,&quot;title&quot;,&quot;reply&quot;]">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort" style="width: 5%" data-sort="id">Id</th>
                                <th scope="col" class="sort" data-sort="name">Name</th>
                                <th scope="col" class="sort" data-sort="email">Email</th>
                                <th scope="col" class="sort" data-sort="title">Title</th>
                                <th scope="col" class="sort" style="width: 5%" data-sort="reply">Reply</th>
                                <th scope="col" style="width: 10%"></th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            <?php
                            foreach ($listContact as $contact) :
                            ?>
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="id mb-0 text-sm"><?= $contact['id'] ?></span>
                                            </div>
                                        </div>
                                    </th>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="title mb-0 text-sm"><?= $contact['name'] ?></span>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="email">
                                        <?= $contact['email'] ?>
                                    </td>
                                    <td class="email">
                                        <?= $contact['title'] ?>
                                    </td>
                                    <td class="reply">
                                        <?= ($contact['reply'] == 0) ? 'False' : 'True'?>
                                    </td>
                                    <td class="table-actions">
                                        <a href="<?= APP_CONFIG['url'] ?>admin/contact/<?= $contact['id'] ?>" class="table-action return-a" data-toggle="tooltip" data-original-title="Reply Contact">
                                            <i class="fas fa-user-edit"></i>
                                        </a>
                                        <a href="#" class="table-action table-action-delete delete-contact" data-toggle="tooltip" id_category="<?= $contact['id'] ?>" data-original-title="Delete Contact">
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
                <?= pagination($total, $page); ?>
            </div>
        </div>
    </div>
</div>
<!-- Footer -->
<?php layout('admin.layouts.footer'); ?>