<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register | SIS</title>


    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css')?>" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/css/sb-admin-2.css')?>" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row align-items-center">
                    <div class="col-lg-5 d-none d-lg-block">
                        <h1 class="text-dark text-center">Student Information System</h1>
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" method='post'>
                            <?php if($this->session->flashdata('errors')){ ?>
                                <div class="alert alert-danger text-center"><?= $this->session->flashdata('errors') ?></div>
                            <?php }else if($this->session->flashdata('success')){ ?>
                                <div class="alert alert-success text-center"><?= $this->session->flashdata('success')?></div>
                            <?php }?>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" name="first_name" class="form-control" id="exampleFirstName"
                                            placeholder="First Name">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="last_name" class="form-control" id="exampleLastName"
                                            placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" id="exampleInputEmail"
                                        placeholder="Email Address">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" name="password" class="form-control"
                                            id="exampleInputPassword" placeholder="Password">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" name="confirm_password" class="form-control"
                                            id="exampleRepeatPassword" placeholder="Repeat Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="address" class="form-control" id="exampleInputEmail"
                                        placeholder="Your Address">
                                </div>
                                <div class="form-group">
                                    <select name="role" id="role" class="form-control">
                                        <option value="">Choose option...</option>
                                        <option value="<?= STUDENT ?>">Student</option>
                                        <option value="<?= TEACHER ?>">Teacher</option>
                                        <option value="<?= PARENT ?>">Parent</option>
                                    </select>
                                </div>
                                <div class="" id="student_info">
                                    <!-- Form Group (username)-->
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputid">Class</label>
                                        <select name="class_id" id="class_id" class="form-control">
                                            <option value="">Choose class...</option>
                                            <?php if($classes): foreach($classes as $k => $v): ?>
                                                <option value="<?= $v->id ?>"><?= $v->class_name ?></option>
                                            <?php endforeach; endif; ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="small mb-1" for="inputid">Subject</label>
                                        <div id="subject_box">

                                        </div>
                                    </div>
                                </div>

                                <div id="parent_info">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputid">Class</label>
                                        <select class="student_class form-control" name="class_id" id="class_id" class="form-control">
                                            <option value="">Choose class...</option>
                                            <?php if($classes): foreach($classes as $k => $v): ?>
                                                <option value="<?= $v->id ?>"><?= $v->class_name ?></option>
                                            <?php endforeach; endif; ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="small mb-1" for="inputid">Child</label>
                                        <select name="student_id" id="student_id" class="form-control">
                                            <option value="">Choose student...</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-primary btn-user btn-block" value="Register Account">
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="<?= base_url('admin/login') ?>">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js')?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/js/sb-admin-2.min.js')?>"></script>

</body>

<script>
    $(document).ready(function(){

        $(document).on('change', '#class_id', function(){
            let classId = $(this).val();

            $.ajax({
                url : `<?= base_url('admin/get_subjects') ?>`,
                method: 'POST',
                data: {class_id : classId},
                success: function(response){
                    res = JSON.parse(response);
                    subjects = res.data;
                    html = ``;
                    for(let i=0; i< subjects.length; i++){
                        html += `<input class="mr-2" type="checkbox" name="subjects[]" value=${subjects[i].id}><label class="mr-2">${subjects[i].subject_name}</label>`;
                    }
                    $('#subject_box').empty();
                    $('#subject_box').append(html);
                },
                error: function(err){
                    console.log(err);
                }
            })
        })

        $(document).on('change', '#role', function(){
            if($(this).val() == <?= STUDENT ?>){
                $('#student_info').show();
                $('#parent_info').hide();
            }else if($(this).val() == <?= PARENT ?>){

                $('#student_info').hide();
                $('#parent_info').show();

            }else{
                $('#student_info').hide();
                $('#parent_info').hide();
            }
        })

        $(document).on('change', '.student_class', function(){
            let classId = $(this).val();

            $.ajax({
                url : `<?= base_url('admin/get_class_student') ?>`,
                method: 'POST',
                data: {class_id : classId},
                success: function(response){
                    res = JSON.parse(response);
                    console.log(res.data);
                    students = res.data;
                    html = `<option value="">Choose student...</option>`;
                    console.log(students.length);
                    for(let i=0; i< students.length; i++){
                        if(students[i] != ""){
                            html += `<option value="${students[i].id}">${students[i].first_name} ${students[i].last_name}</option>`;
                        }
                    }
                    $('#student_id').empty();
                    $('#student_id').append(html);
                },
                error: function(err){
                    console.log(err);
                }
            })
        })

    })
</script>

</html>