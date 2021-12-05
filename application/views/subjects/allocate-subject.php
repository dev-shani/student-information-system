<?php
    $this->load->view('inc/header');
    $this->load->view('inc/sidebar');
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Allocate subject</h1>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">Allocate subject</div>
            <div class="card-body">
                    <form method="post" action="" enctype="multipart/form-data">
                    <?php if($this->session->flashdata('errors')){ ?>
                        <div class="alert alert-danger text-center"><?= $this->session->flashdata('errors') ?></div>
                    <?php }else if($this->session->flashdata('success')){ ?>
                        <div class="alert alert-success text-center"><?= $this->session->flashdata('success')?></div>
                    <?php }?>
                    <!-- Form Group (username)-->
                    <div class="form-group">
                        <label class="small mb-1" for="inputid">Teacher</label>
                        <select name="teacher_id" id="" class="form-control">
                            <option value="">Choose Teacher...</option>
                            <?php if($teachers): foreach($teachers as $k => $v): ?>
                                <option value="<?= $v->id ?>"><?= $v->first_name ?> <?= $v->last_name ?></option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>

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
                        <select name="subject_id" id="subject_list" class="form-control">
                            <option value="">Choose subject...</option>
                        </select>
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
                    html = ``;
                    for(let i=0; i< subjects.length; i++){
                        html += `<option value=${subjects[i].id}>${subjects[i].subject_name}</option>`;
                    }

                    $('#subject_list').append(html);
                },
                error: function(err){
                    console.log(err);
                }
            })
        })

    })
</script>