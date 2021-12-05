<?php
    $this->load->view('inc/header');
    $this->load->view('inc/sidebar');
?>
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Classes</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Classes</h6>
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
                                            <th>Class Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($classes): foreach($classes as $k => $v): ?>
                                            <tr>
                                                <td><?= $v->class_name ?></td>
                                                <td>
                                                    <a class='text-danger' href="<?= base_url("admin/delete_class/{$v->id}") ?>"><i class="fa fa-trash"></i></a>
                                                    <a class='text-primary' href="<?= base_url("admin/edit_class/{$v->id}") ?>"><i class="fa fa-edit"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

<?php
    $this->load->view('inc/footer');