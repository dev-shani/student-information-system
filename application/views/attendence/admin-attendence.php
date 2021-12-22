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

                        <select class="form-control mb-4" name="classes" id="">
                                <option value="">Choose class</option>
                                <?php if($classes): foreach($classes as $k => $v): ?>
                                    <option value="<?= $v->id ?>"><?= $v->class_name ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                            <select class="form-control mb-4" name="student" id="">
                                <option value="">Choose student</option>
                            </select>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Attendence</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="student_attendance">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

<?php
    $this->load->view('inc/footer');

?>

<script>
    $(document).ready(function(){
        $(document).on('change','select[name=classes]',function(){
            let classId = $(this).val();

            if(classId != ''){
                $.ajax({
                url: `<?= base_url('admin/get_class_student') ?>`,
                method: 'POST',
                data: {class_id: classId},
                success: function(response){
                    res = JSON.parse(response);
                    console.log(res);
                    let students = res.data;
                    let html = `<option value="">Choose student...</option>`;
                    for(let i =0; i < students.length; i++){
                        if(students[i] != ''){
                            html += `<option value="${students[i].id}">${students[i].first_name} ${students[i].last_name}</option>`;
                        }
                    }

                    $('select[name=student]').empty();
                    $('select[name=student]').append(html);

                }
            })
            }
        })


        $(document).on('change','select[name=student]',function(){
            let student_id = $(this).val();

            if(student_id != ''){
                $.ajax({
                url: `<?= base_url('admin/get_student_attendance') ?>`,
                method: 'POST',
                data: {student_id: student_id},
                success: function(response){
                    res = JSON.parse(response);
                    let attendance = res.data;
                    let html = ``;
                    for(let i =0; i < attendance.length; i++){
                        if(attendance[i] != ''){
                            html += `<tr>`;
                            if(attendance[i].attendence == 1){
                                html += `  <td>Present</td>`;
                            }else if(attendance[i].attendence == 2){
                                html += `  <td>Leave</td>`;
                            }else if(attendance[i].attendence == 0){
                                html += `  <td>Absent</td>`;
                            }
                            html += `  <td>${attendance[i].date}</td>`;
                            html += `</tr>`;
                        }
                    }

                    $('.student_attendance').empty();
                    $('.student_attendance').append(html);


                }
            })
            }
        })
    });
</script>