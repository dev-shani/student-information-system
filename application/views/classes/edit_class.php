<?php
    $this->load->view('inc/header');
    $this->load->view('inc/sidebar');
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit subject</h1>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">Edit class</div>
            <div class="card-body">
                    <form method="post" action="" enctype="multipart/form-data">
                    <?php if($this->session->flashdata('errors')){ ?>
                        <div class="alert alert-danger text-center"><?= $this->session->flashdata('errors') ?></div>
                    <?php }else if($this->session->flashdata('success')){ ?>
                        <div class="alert alert-success text-center"><?= $this->session->flashdata('success')?></div>
                    <?php }?>
                    <!-- Form Group (username)-->
                    <div class="form-group">
                        <label class="small mb-1" for="inputclassname">class Name</label>
                        <input class="form-control" value="<?= ($class ? $class->class_name : '') ?>" name="class_name" id="classname" type="text" placeholder="Enter class name">
                    </div>
                    <!-- Save changes button-->
                    <button class="btn btn-primary" type="submit">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    $this->load->view('inc/footer');