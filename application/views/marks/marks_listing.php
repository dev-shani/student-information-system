<?php
    $this->load->view('inc/header');
    $this->load->view('inc/sidebar');
?>
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Marks</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Marks</h6>
                        </div>
                        <div class="card-body">
                        <?php if($this->session->flashdata('errors')){ ?>
                            <div class="alert alert-danger text-center"><?= $this->session->flashdata('errors') ?></div>
                        <?php }else if($this->session->flashdata('success')){ ?>
                            <div class="alert alert-success text-center"><?= $this->session->flashdata('success')?></div>
                        <?php }?>

                            <select class="form-control mb-4" name="subject" id="">
                                <option value="">Choose subject</option>
                                <?php if($subjects): foreach($subjects as $k => $v): ?>
                                    <option value="<?= $v->subject_id ?>"><?= $v->subject?> of class <?= $v->class?></option>
                                <?php endforeach; endif; ?>
                            </select>
                            <select class="form-control mb-4" name="student" id="">
                                <option value="">Choose student</option>
                            </select>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Subject</th>
                                            <th>Total marks</th>
                                            <th>Obtained Marks</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="student_marks">
                                        
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
        $(document).on('change','select[name=subject]',function(){
            let subjectId = $(this).val();

            if(subjectId != ''){
                $.ajax({
                url: `<?= base_url('teacher/get_students') ?>`,
                method: 'POST',
                data: {subject_id: subjectId},
                success: function(response){
                    res = JSON.parse(response);
                    let students = res.data;
                    let html = `<option value="">Choose student</option>`;
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
            let subject_id = $('select[name=subject]').val();

            if(student_id != ''){
                $.ajax({
                url: `<?= base_url('teacher/get_marks') ?>`,
                method: 'POST',
                data: {student_id: student_id, subject_id: subject_id},
                success: function(response){
                    res = JSON.parse(response);
                    let subject = res.data.subject_details;
                    let marks = subject.marks;
                    console.log(res);
                    let html = ``;
                    for(let i =0; i < marks.length; i++){
                        if(marks[i] != ''){
                            html += `<tr>
                                    <td>${subject.subject_name}</td>
                                    <td>${marks[i].total_marks}</td>
                                    <td>${marks[i].obtained_marks}</td>
                                    <td>${marks[i].date}</td>
                            </tr>`;
                        }
                    }

                    $('.student_marks').empty();
                    $('.student_marks').append(html);

                }
            })
            }
        })
    });
</script>