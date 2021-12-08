<?php
    $this->load->view('inc/header');
    $this->load->view('inc/sidebar');
?>
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Subjects</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Subjects</h6>
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
                                            <th>Subject Name</th>
                                            <th>Class</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($timetables): foreach($timetables as $k => $v): ?>
                                            <tr>
                                                <td><?= $v->class_detail ? $v->subject_detail->subject_name : 'N/A' ?></td>
                                                <td><?= $v->class_detail ? $v->class_detail->class_name : 'N/A' ?></td>
                                                <td><?= date('H:i', strtotime($v->time_from)) ?></td>
                                                <td><?= date('H:i', strtotime($v->time_to)) ?></td>
                                                <td><?= $v->status == APPROVED ? '<span class="text-success">Approved</span>' :'<span class="text-danger">Not Approved</span>'; ?></td>
                                                <td>
                                                    <a class='btn btn-success' href="<?= base_url("admin/approve_timetable/{$v->id}") ?>"><i class="fa fa-check"></i> Approve</a>
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