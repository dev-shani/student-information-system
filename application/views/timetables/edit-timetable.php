<?php
    $this->load->view('inc/header');
    $this->load->view('inc/sidebar');
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Update TimeTable</h1>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">Update TimeTable</div>
            <div class="card-body">
                    <form method="post" action="" enctype="multipart/form-data">
                    <?php if($this->session->flashdata('errors')){ ?>
                        <div class="alert alert-danger text-center"><?= $this->session->flashdata('errors') ?></div>
                    <?php }else if($this->session->flashdata('success')){ ?>
                        <div class="alert alert-success text-center"><?= $this->session->flashdata('success')?></div>
                    <?php }?>
                    <div id="timetable">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Class</th>
                                    <th>From</th>
                                    <th>To</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= $time_table->subject_detail? $time_table->subject_detail->subject_name : '' ?></td>
                                    <td><?= $time_table->class_detail? $time_table->class_detail->class_name : '' ?></td>
                                    <td><input type="time" name="time_from" value="<?= date('H:i', strtotime($time_table->time_from)) ?>"></td>
                                    <td><input type="time" name="time_to" value="<?= date('H:i', strtotime($time_table->time_to)) ?>"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Save changes button-->
                    <button class="btn btn-primary" type="submit">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    $this->load->view('inc/footer');
?>
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
                    let html = `<table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Subject</th>
                                <th>From</th>
                                <th>To</th>
                            </tr>
                            </thead>
                            <tbody>
                        `;
                    for(let i=0; i< subjects.length; i++){
                        html += `<tr>`;
                        html += `<td><input type="hidden" name="timetable[${i}][subject_id]" value="${subjects[i].id}">${subjects[i].subject_name}</td>`;
                        html += `<td><input type="time" name="timetable[${i}][time_from]"></td>`;
                        html += `<td><input type="time" name="timetable[${i}][time_to]"></td>`;
                        html += `</tr>`;
                    }

                    html += `</tbody></table>`;
                    $('#timetable').empty();
                    $('#timetable').append(html);
                },
                error: function(err){
                    console.log(err);
                }
            })
        })

    })
</script>