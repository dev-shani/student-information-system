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
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Date</th>
                                <th>Total Marks</th>
                                <th>Obtained Marks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; if($students): foreach($students as $k => $v): ?>
                                <tr>
                                    <th><?= $v->first_name ?></th>
                                    <th><?= $v->email ?></th>
                                    <th><?= $v->subject_details->subject_name ?></th>
                                    <th><input class="form-control" type="date" name="marks[<?= $i ?>][date]" id=""></th>
                                    <th><input class="form-control" type="number" name="marks[<?= $i ?>][total_marks]" id=""></th>
                                    <th><input class="form-control" type="number" name="marks[<?= $i ?>][obtained_marks]" id=""></th>
                                    <input type="hidden" name="marks[<?= $i ?>][student_id]" value="<?= $v->id ?>">
                                    <input type="hidden" name="marks[<?= $i ?>][subject_id]" value="<?= $v->subject_details->id ?>">
                                </tr>
                            <?php $i++; endforeach; endif; ?>
                        </tbody>
                    </table>
                    <!-- Save changes button-->
                    <button class="btn btn-primary" type="submit">Save Marks</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    $this->load->view('inc/footer');