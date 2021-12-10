<?php
    $this->load->view('inc/header');
    $this->load->view('inc/sidebar');
?>
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Attendence</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Attendence</h6>
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
                                            <th>Attendence</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($attendence): foreach($attendence as $k => $v): ?>
                                            <tr>
                                                <?php
                                                    if($v->attendence == PRESENT){
                                                        $at = 'Present';
                                                    }else if($v->attendence == ABSENT){
                                                        $at = 'Absent';
                                                    }else if($v->attendence == LEAVE){
                                                        $at = 'Leave';
                                                    }
                                                ?>
                                                <td><?= $at ?></td>
                                                <td><?= date('d M, Y', strtotime($v->date)) ?></td>
                                            </tr>
                                        <?php endforeach; endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

<?php
    $this->load->view('inc/footer');