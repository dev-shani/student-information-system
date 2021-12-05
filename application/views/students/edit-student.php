<?php
    $this->load->view('inc/header');
    $this->load->view('inc/sidebar');
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Add student</h1>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">Add student</div>
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
                                <option value="<?= $v->id ?>" <?= ($v->id == $class_id ? 'selected' : '') ?>><?= $v->class_name ?></option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                    <!-- Form Row-->
                    <div class="form-row">
                        <!-- Form Group (first name)-->
                        <div class="form-group col-md-6">
                            <label class="small mb-1" for="inputFirstName">First name</label>
                            <input class="form-control" value="<?= ($student ? $student->first_name : '') ?>" name="user_fname" id="inputFirstName" type="text" placeholder="Enter your first name">
                        </div>
                        <!-- Form Group (last name)-->
                        <div class="form-group col-md-6">
                            <label class="small mb-1" for="inputLastName">Last name</label>
                            <input class="form-control" name="user_lname" id="inputLastName" type="text" placeholder="Enter your last name" value="<?= ($student ? $student->last_name : '') ?>">
                        </div>
                    </div>
                    <!-- Form Group (email address)-->
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="small mb-1" for="inputEmailAddress">Email address</label>
                            <input class="form-control" id="inputEmailAddress" type="email" placeholder="Enter email address" name="user_email" value="<?= ($student ? $student->email : '') ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="small mb-1" for="inputPhone">Phone number</label>
                            <input class="form-control" id="inputPhone" name="user_phone" type="tel" placeholder="Enter your phone number" value="<?= ($student ? $student->phone : '') ?>">
                        </div>
                    </div>
                                        <!-- Form Row-->
                    <div class="form-row">
                        <!-- Form Group (phone number)-->
                        <div class="form-group col-md-6">
                            <label class="small mb-1" for="inputCity">City</label>
                            <input class="form-control" id="inputCity" type="text" placeholder="City" name="user_city" value="<?= ($student ? $student->city : '') ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="small mb-1" for="inputFee">Fee</label>
                            <input class="form-control" id="inputFee" type="text" placeholder="Fee" name="user_fee" value="<?= ($student ? $student->fee : '') ?>">
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