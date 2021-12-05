<?php
    $this->load->view('inc/header');
    $this->load->view('inc/sidebar');
?>
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Students</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Students</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Subjects Code</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($students): foreach($students as $k => $v): ?>
                                            <tr>
                                                <td><?= $v->first_name ?> <?= $v->last_name ?></td>
                                                <td><?= $v->role ?></td>
                                                <td><a class='text-danger' href="#"><i class="fa fa-trash"></i></a></td>
                                            </tr>
                                        <?php endforeach; endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

<?php
    $this->load->view('inc/footer');