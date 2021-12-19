<?php


function preview($data){
    echo "<pre>";print_r($data);exit;
}

function ajax_response($status, $data, $message){
    $res = [
        'status' => $status,
        'data' => $data,
        'message' => $message,
    ];


    echo json_encode($res);
    exit;
}

function get_user_details(){
    $ci = &get_instance();
    $user = $ci->db->get_where('users',['id' => $ci->session->userdata('user_id')]);
    return $user->num_rows() > 0 ? $user->row() : '';
}

function get_teacher_students(){
    $ci = &get_instance();
    $user = get_user_details();
    $ci->load->model('teacher_model');
    $ci->load->model('admin_model');
    $subjects = $ci->teacher_model->get_allocated_subject(['teacher_id' => $user->id]);
        $subject_arr = [];
        $student_ids = [];
        $students = [];
        if($subjects){
            foreach($subjects as $k => $v){
                $subject_arr[] = $v->subject_id;
            }
        }

        if($subject_arr){
            foreach($subject_arr as $k => $v){
                $temp = $ci->teacher_model->get_student_subjects(['subject_id' => $v]);
                $student_ids[] = $temp ? $temp[0]->student_id : '';
            }
        }
        if($student_ids){
            foreach($student_ids as $k => $v){
                $temp = $ci->admin_model->get_users(['id' => $v]);
                $students[] = $temp ? $temp[0] : '';
            }
        }

        if($students){
            return $students;
        }else{
            return false;
        }
}



function get_teacher_students_with_subjects(){
    $ci = &get_instance();
    $user = get_user_details();
    $ci->load->model('teacher_model');
    $ci->load->model('admin_model');
    $subjects = $ci->teacher_model->get_allocated_subject(['teacher_id' => $user->id]);
        $subject_arr = [];
        $student_ids = [];
        $students = [];
        if($subjects){
            foreach($subjects as $k => $v){
                $subject_arr[] = $v->subject_id;
            }
        }

        if($subject_arr){
            foreach($subject_arr as $k => $v){
                $temp = $ci->teacher_model->get_student_subjects(['subject_id' => $v]);
                $subject = $ci->admin_model->get_subjects(['id' => $temp[0]->subject_id]);
                $student = $ci->admin_model->get_users(['id' => $temp[0]->student_id]);
                $student = $student ? $student[0]  :'';
                $student->subject_details = $subject ? $subject[0] : '';
                $students[] = $student;
                
            }
        }

        if($students){
            return $students;
        }else{
            return false;
        }
}

