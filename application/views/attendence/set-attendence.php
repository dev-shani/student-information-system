<?php
    $this->load->view('inc/header');
    $this->load->view('inc/sidebar');
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Set Attendance</h1>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">Set Attendance</div>
            <div class="card-body">
                    <form method="post" action="" enctype="multipart/form-data">
                    <?php if($this->session->flashdata('errors')){ ?>
                        <div class="alert alert-danger text-center"><?= $this->session->flashdata('errors') ?></div>
                    <?php }else if($this->session->flashdata('success')){ ?>
                        <div class="alert alert-success text-center"><?= $this->session->flashdata('success')?></div>
                    <?php }?>
                    <!-- Form Group (username)-->
                    <div class="form-group">
                        <label class="small mb-1" for="inputid">Choose Date</label>
                        <input type="date" name="date" id="" class="form-control">
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Attendance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; if($students): foreach($students as $k => $v): ?>
                                <tr>
                                    <th><?= $v->first_name ?></th>
                                    <th><?= $v->email ?></th>
                                    <th>
                                        <select name="attendence" id="" class="form-control">
                                            <option value="">Choose..</option>
                                            <option value="<?= PRESENT ?>">Present</option>
                                            <option value="<?= ABSENT ?>">Absent</option>
                                            <option value="<?= LEAVE ?>">Leave</option>
                                        </select>
                                        <input type="hidden" name="student_id" value="<?= $v->id ?>">
                                    </th>
                                </tr>
                            <?php $i++; endforeach; endif; ?>
                        </tbody>
                    </table>
                    <!-- Save changes button-->
                    <button class="btn btn-primary" type="submit">Mark Attendance</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    $this->load->view('inc/footer');