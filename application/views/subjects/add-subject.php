<?php
    $this->load->view('inc/header');
    $this->load->view('inc/sidebar');
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Add subject</h1>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">Add subject</div>
            <div class="card-body">
                    <form method="post" action="" enctype="multipart/form-data">
                    <?php if($this->session->flashdata('errors')){ ?>
                        <div class="alert alert-danger text-center"><?= $this->session->flashdata('errors') ?></div>
                    <?php }else if($this->session->flashdata('success')){ ?>
                        <div class="alert alert-success text-center"><?= $this->session->flashdata('success')?></div>
                    <?php }?>
                    <!-- Form Group (username)-->
                    <div class="form-group">
                        <label class="small mb-1" for="inputid">Class</label>
                        <select name="class_id" id="" class="form-control">
                            <option value="">Choose class...</option>
                            <?php if($classes): foreach($classes as $k => $v): ?>
                                <option value="<?= $v->id ?>"><?= $v->class_name ?></option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="small mb-1" for="inputsubjectname">Subject Name</label>
                        <input class="form-control" value="" name="subject_name" id="subjectname" type="text" placeholder="Enter subject name">
                    </div>
                    <!-- Form Row-->
                    <div class="form-row">
                        <!-- Form Group (first name)-->
                        <div class="form-group col-md-6">
                            <label class="small mb-1" for="inputsubjectcode">Subject Code</label>
                            <input class="form-control" value="" name="subject_code" id="inputsubjectcode" type="text" placeholder="Enter subject code">
                        </div>
                    </div>
                    <!-- Save changes button-->
                    <button class="btn btn-primary" type="submit">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    $this->load->view('inc/footer');