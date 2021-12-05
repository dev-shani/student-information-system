<?php
    $this->load->view('inc/header');
    $this->load->view('inc/sidebar');
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Add teacher</h1>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">Add teacher</div>
            <div class="card-body">
                    <form method="post" action="" enctype="multipart/form-data">
                    <?php if($this->session->flashdata('errors')){ ?>
                        <div class="alert alert-danger text-center"><?= $this->session->flashdata('errors') ?></div>
                    <?php }else if($this->session->flashdata('success')){ ?>
                        <div class="alert alert-success text-center"><?= $this->session->flashdata('success')?></div>
                    <?php }?>
                    <!-- Form Group (username)-->
                    <div class="form-group">
                        <label class="small mb-1" for="inputid">ID Card</label>
                        <input class="form-control" value="" name="user_idCard" id="inputid" type="text" placeholder="Enter your ID card number">
                    </div>
                    <!-- Form Row-->
                    <div class="form-row">
                        <!-- Form Group (first name)-->
                        <div class="form-group col-md-6">
                            <label class="small mb-1" for="inputFirstName">First name</label>
                            <input class="form-control" value="" name="user_fname" id="inputFirstName" type="text" placeholder="Enter your first name">
                        </div>
                        <!-- Form Group (last name)-->
                        <div class="form-group col-md-6">
                            <label class="small mb-1" for="inputLastName">Last name</label>
                            <input class="form-control" name="user_lname" id="inputLastName" type="text" placeholder="Enter your last name" value="">
                        </div>
                    </div>
                    <!-- Form Group (email address)-->
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="small mb-1" for="inputEmailAddress">Email address</label>
                            <input class="form-control" id="inputEmailAddress" type="email" placeholder="Enter email address" name="user_email" value="">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="small mb-1" for="inputPhone">Phone number</label>
                            <input class="form-control" id="inputPhone" name="user_phone" type="tel" placeholder="Enter your phone number" value="">
                        </div>
                    </div>

                                        <!-- Form Row-->
                    <div class="form-row">
                        <!-- Form Group (phone number)-->
                        <div class="form-group col-md-6">
                            <label class="small mb-1" for="inputPassword">Password</label>
                            <input class="form-control" id="inputPassword" type="password" placeholder="Enter password" name="user_password">
                        </div>
                        <!-- Form Group (birthday)-->
                        <div class="form-group col-md-6">
                            <label class="small mb-1" for="inputConfirmpass">Confirm Password</label>
                            <input class="form-control" id="inputConfirmpass" type="password" name="user_confirm_password" placeholder="Confirm password">
                        </div>
                    </div>
                                        <!-- Form Row-->
                    <div class="form-row">
                        <!-- Form Group (phone number)-->
                        <div class="form-group col-md-6">
                            <label class="small mb-1" for="inputCity">City</label>
                            <input class="form-control" id="inputCity" type="text" placeholder="City" name="user_city" value="">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="small mb-1" for="inputSalary">Salary</label>
                            <input class="form-control" id="inputSalary" type="text" placeholder="Salary" name="user_salary" value="">
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