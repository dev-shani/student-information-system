<?php
    $this->load->view('inc/header');
    $this->load->view('inc/sidebar');
?>
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Subject Details</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Subjects Details</h6>
                        </div>
                        <div class="card-body">
                        <?php if($this->session->flashdata('errors')){ ?>
                            <div class="alert alert-danger text-center"><?= $this->session->flashdata('errors') ?></div>
                        <?php }else if($this->session->flashdata('success')){ ?>
                            <div class="alert alert-success text-center"><?= $this->session->flashdata('success')?></div>
                        <?php }?>
                            <div class="row text-white my-3 bg-primary rounded  p-3">
                                <div class="col-sm-6"><span class="font-weight-bold">Subject: </span><?= $subject ? $subject->subject_name : '' ?></div>
                                <div class="col-sm-6"><span class="font-weight-bold">Class: </span><?= $class ? $class->class_name : '' ?></div>
                                <div class="col-sm-6"><span class="font-weight-bold">Subject Code: </span><?= $subject ? $subject->subject_code : '' ?></div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>City</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($students): foreach($students as $k => $v): ?>
                                            <tr>
                                                <td><?= $v->first_name ?> <?= $v->last_name ?></td>
                                                <td><?= $v->email ?></td>
                                                <td><?= $v->phone ?></td>
                                                <td><?= $v->city ?></td>
                                            </tr>
                                        <?php endforeach; endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

<?php
    $this->load->view('inc/footer');