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

    public function set_timetable(){
        $user = get_user_details();
        $allocated_classes = $this->teacher_model->get_allocated_subject(['teacher_id' => $user->id]);
        // preview($allocated_classes);
        if($allocated_classes){
            foreach($allocated_classes as $k => $v){
                $class = $this->admin_model->get_classes(['id' => $v->class_id]);
                $classes[] = $class ? $class[0] : '';
            }

        }
        $data['classes'] = $classes ? $classes : '';
        $errors = 0;
        if($this->input->post()){
            $class_id = $this->input->post('class_id');
            $timetable = $this->input->post('timetable');
            if($timetable){
                foreach($timetable as $k => $v){
                    $v = (object) $v;
                    $tt_data = [
                        'teacher_id' => $user->id,
                        'class_id' => $class_id,
                        'subject_id' => $v->subject_id,
                        'time_from' => $v->time_from,
                        'time_to' => $v->time_to,
                        'status' => NOT_APPROVED
                    ];

                    $res = $this->teacher_model->insert_timetable($tt_data);
                    if(!$res){
                        $errors++;
                    }
                }
            }

            if(!$errors){
                $this->session->set_flashdata('success', 'TimeTable inserted successfully');
                redirect(base_url('teacher/set_timetable'));
            }else{
                $this->session->set_flashdata('errors', 'Something went wrong!');
                redirect(base_url('teacher/set_timetable'));
            }
        }
        $this->load->view('timetables/set-timetable', $data);
    }

    public function timetables(){
        $user = get_user_details();
        $timetable = $this->teacher_model->get_timetables(['teacher_id' => $user->id]);
        $final_table = [];
        if($timetable){
            foreach($timetable as $k => $v){
                $class = $this->admin_model->get_classes(['id' => $v->class_id]);
                $v->class_detail = $class ? $class[0] : '';
                $subject = $this->admin_model->get_subjects(['id' => $v->subject_id]);
                $v->subject_detail = $subject ? $subject[0] : '';
                $final_table[] = $v;
            }
        }
        $data['timetables'] = $final_table ? $final_table : '';
        $this->load->view('timetables/timetable-listing', $data);
    }

    public function delete_timetable($id){
        $res = $this->teacher_model->delete_timetable(['id' => $id]);
        if($res){
            $this->session->set_flashdata('success', 'Timetable deleted successfully');
            redirect(base_url('teacher/timetables'));
            
        }else{
            $this->session->set_flashdata('errors', 'Something went wrong!');
            redirect(base_url('teacher/timetables'));
        }
    }

    public function update_timetable($id){
        $timetable = $this->teacher_model->get_timetables(['id' => $id]);
        $final_table = [];
        if($timetable){
            foreach($timetable as $k => $v){
                $class = $this->admin_model->get_classes(['id' => $v->class_id]);
                $v->class_detail = $class ? $class[0] : '';
                $subject = $this->admin_model->get_subjects(['id' => $v->subject_id]);
                $v->subject_detail = $subject ? $subject[0] : '';
                $final_table[] = $v;
            }
        }
        // preview($final_table);
        $data['time_table'] = $final_table[0];


        if($this->input->post()){
            // preview($this->input->post());
            $time_from = $this->input->post('time_from');
            $time_to = $this->input->post('time_to');

            $time_data = [
                'time_from' => $time_from,
                'time_to' => $time_to
            ];

            $res = $this->teacher_model->update_timetable($time_data, ['id' => $id]);
            if($res){
                $this->session->set_flashdata('success', 'Timetable updated successfully');
                redirect(base_url('teacher/update_timetable/'.$id));
                
            }else{
                $this->session->set_flashdata('errors', 'Something went wrong!');
                redirect(base_url('teacher/update_timetable/'.$id));
            }
        }



        $this->load->view('timetables/edit-timetable', $data);
    }


    public function attendence(){
        $user = get_user_details();
        $attendence = $this->db->get_where('attendance', ['teacher_id' => $user->id])->result();
        if($attendence){
            foreach($attendence as $k => $v){
                $st_data = $this->admin_model->get_users(['id' => $v->student_id]);
                $v->student_data = $st_data ? $st_data[0] : '';
            }
        }
        $data['attendence'] = $attendence ? $attendence : '';
        $this->load->view('attendence/attendence_list', $data);
    }

    public function set_attendence(){
        $students = get_teacher_students();
        $data['students'] = $students ? $students : '';


        if($this->input->post()){
            $user = get_user_details();
            $date = $this->input->post('date');
            $attendence = $this->input->post('attendence');
            $res = true;
            if($attendence){
                foreach($attendence as $k => $v){
                    print_r($v);
                    $temp = [
                        'teacher_id' => $user->id,
                        'date' => $date,
                        'student_id' => $v['student_id'],
                        'attendence' => $v['attendence']
                    ];

                    $res = $this->db->insert('attendance', $temp);
                    if(!$res){
                        $res = false;
                    }
                }
            }


            if($res){
                $this->session->set_flashdata('success', 'Attendance marked successfully');
                redirect(base_url('teacher/attendence/'));
                
            }else{
                $this->session->set_flashdata('errors', 'Something went wrong!');
                redirect(base_url('teacher/attendence/'.$id));
            }

        }
        
        $this->load->view('attendence/set-attendence', $data);
    }

    public function set_marks(){
        $students  = get_teacher_students_with_subjects();
        $data['students'] = $students ? $students : '';
        

        if($this->input->post()){
            // preview($this->input->post());
            $user = get_user_details();
            $marks = $this->input->post('marks');
            $res = true;
            if($marks){
                foreach($marks as $k => $v){
                    $v = (object) $v;
                    $marks_data = [
                        'date' => $v->date,
                        'teacher_id' => $user->id,
                        'subject_id' => $v->subject_id,
                        'student_id' => $v->student_id,
                        'total_marks' => $v->total_marks,
                        'obtained_marks' => $v->obtained_marks
                    ];
                    $res = $this->db->insert('marks', $marks_data);
                    if(!$res){
                        $res = false;
                    }
                }
            }

            if($res){
                $this->session->set_flashdata('success', 'Marks added successfully');
                redirect(base_url('teacher/set_marks/'));
                
            }else{
                $this->session->set_flashdata('errors', 'Something went wrong!');
                redirect(base_url('teacher/set_marks/'.$id));
            }
        }

        $this->load->view('marks/set_marks', $data);

    }
}