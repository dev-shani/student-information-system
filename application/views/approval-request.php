<?php
    $this->load->view('inc/header');
    $this->load->view('inc/sidebar');
?>
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Approval Requests</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Approval Requests</h6>
                        </div>
                        <div class="card-body">
                        <?php if($this->session->flashdata('errors')){ ?>
                            <div class="alert alert-danger text-center"><?= $this->session->flashdata('errors') ?></div>
                        <?php }else if($this->session->flashdata('success')){ ?>
                            <div class="alert alert-success text-center"><?= $this->session->flashdata('success')?></div>
                        <?php }?>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($requests): foreach($requests as $k => $v): ?>
                                            <tr>
                                                <td><?= $v->first_name ?> <?= $v->last_name ?></td>
                                                <?php
                                                    if($v->role == ADMIN){
                                                        $role = 'Admin';
                                                    }else if($v->role == STUDENT){
                                                        $role = 'Student';
                                                    }else if($v->role == TEACHER){
                                                        $role = 'Teacher';
                                                    }else if($v->role == PARENT){
                                                        $role = 'Parent';
                                                    }
                                                ?>
                                                <td><?= $role ?></td>
                                                <td><a class='btn btn-success' href="<?= base_url("admin/approve_user/{$v->id}") ?>">Approve</a></td>
                                            </tr>
                                        <?php endforeach; endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

<?php
    $this->load->view('inc/footer');