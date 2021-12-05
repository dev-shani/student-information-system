<?php

class Teacher extends CI_Controller{


    public function __construct(){
        parent::__construct();
        $this->load->model('teacher_model');
        $this->load->model('admin_model');
        $this->load->helper('common_helper');
    }

    public function allocated_subjects(){
        $user = get_user_details();
        $ids = $this->teacher_model->get_allocated_subject(['teacher_id' => $user->id]);
        $subject_class = [];
        foreach($ids as $k => $v){
            $subject = $this->admin_model->get_subjects(['id' => $v->subject_id]);
            $tem_sub = $subject ? $subject[0]->subject_name : '';
            $class = $this->admin_model->get_classes(['id' => $v->class_id]);
            $tem_cls = $class ? $class[0]->class_name : '';
            $subject_class[] = (object)[
                'id' => $v->subject_id,
                'subject' => $tem_sub,
                'class' => $tem_cls
            ];
        }
        $data['subjects'] = $subject_class;
        $this->load->view('subjects/allocated-subjects', $data);
    }

    public function subject_details($id){
        $subject = $this->admin_model->get_subjects(['id' => $id]);
        $data['subject'] = $subject ? $subject[0] : '';
        $class = $this->admin_model->get_classes(['id' => $data['subject']->class_id]);
        $data['class'] = $class ? $class[0] : '';
        $student_ids = $this->teacher_model->get_class_students(['class_id' => $class[0]->id]);
        $students = [];
        if($student_ids){
            foreach($student_ids as $k => $v){
                $st = $this->admin_model->get_users(['id' => $v->student_id]);
                if($st){
                    $students[] = $st[0];
                }
            }
        }
        $data['students'] = $students ? $students : '';
        $this->load->view('subjects/subject_details', $data);
    }

}