<?php


class Student extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->model('teacher_model');
        $this->load->helper('common_helper');
    }

    public function assigned_classes(){
        $user = get_user_details();
        if($user->role == PARENT){
            $st_id = $this->db->get_where('parent_student', ['parent_id' => $user->id])->row();
            $user = $this->db->get_where('users',['id' => $st_id->student_id])->row();
        }
        $subjects = $this->teacher_model->get_student_subjects(['student_id' => $user->id]);
        // preview($subjects);
        if($subjects){
            foreach($subjects as $k => $v){
                $timetable = $this->teacher_model->get_timetables(['subject_id' => $v->id,'status' => APPROVED]);
                $v->timetable = $timetable ? $timetable : '';
                $subject = $this->admin_model->get_subjects(['id' => $v->id]);
                $v->timetable->subject_detail = $subject ? $subject[0] : '';
                $final_table[] = $v;
            }
        }
        $data['timetables'] = $final_table ? $final_table[0] : '';
        
        $this->load->view('classes/assigned_classes', $data);
    }


    public function attendence(){
        $user = get_user_details();
        if($user->role == PARENT){
            $st_id = $this->db->get_where('parent_student', ['parent_id' => $user->id])->row();
            $user = $this->db->get_where('users',['id' => $st_id->student_id])->row();
        }
        $attendence = $this->db->get('attendance', ['student_id' => $user->id])->result();
        $data['attendence'] = $attendence ? $attendence : '';
        $this->load->view('attendence/student-attendence', $data);
    }

    public function marks(){
        $user = get_user_details();
        $subjects = [];
        if($user->role == PARENT){
            $st_id = $this->db->get_where('parent_student', ['parent_id' => $user->id])->row();
            $user = $this->db->get_where('users',['id' => $st_id->student_id])->row();
        }
        $subject_ids = $this->db->get_where('student_subject',['student_id' => $user->id])->result();
        if($subject_ids){
            foreach($subject_ids as $k => $v){
                $sb = $this->db->get_where('subjects', ['id' => $v->subject_id]);
                $subjects[] = $sb->num_rows() > 0 ? $sb->row() : '';
            }
        }
        $data['subjects'] = $subjects ? $subjects : '';
        $this->load->view('marks/student_marks', $data);
    }


    public function get_marks(){
        $user = get_user_details();
        $marks = [];
        if($user->role == PARENT){
            $st_id = $this->db->get_where('parent_student', ['parent_id' => $user->id])->row();
            $user = $this->db->get_where('users',['id' => $st_id->student_id])->row();
        }

        if($this->input->post()){
            $subject_id = $this->input->post('subject_id');
            $subject = $this->db->get_where('subjects',['id' => $subject_id])->row();
            $marks = $this->db->get_where('marks', ['subject_id' => $subject_id, 'student_id' => $user->id]);
            $data['subject_details'] = $subject ? $subject : '';
            $data['subject_details']->marks = $marks->num_rows() > 0 ? $marks->result() :'';

            ajax_response(true, $data, 'Data found');
        }
    }


}