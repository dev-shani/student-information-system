<?php

class Admin extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->helper('common_helper');
        $this->load->model('admin_model');
    }

    public function home(){
        if(!$this->session->userdata('is_logged_in')){
            redirect(base_url('admin/login'));
        }
        $this->load->view('inc/header');
        $this->load->view('inc/sidebar');
        $this->load->view('admin/home');
        $this->load->view('inc/footer');
    }

    public function about(){
        $this->load->view('inc/header');
        $this->load->view('inc/sidebar');
        $this->load->view('admin/about');
        $this->load->view('inc/footer');
    }

    public function not_found(){
        $this->load->view('inc/header');
        $this->load->view('inc/sidebar');
        $this->load->view('admin/404');
        $this->load->view('inc/footer');
    }


    public function approval_requests(){
        $data['requests'] = $this->admin_model->get_users(['status' => NOT_APPROVED]);
        $this->load->view('approval-request', $data);
    }

    public function approve_user($id){
        $res = $this->admin_model->update_user(['status' => APPROVED], ['id' => $id]);
        if($res){
            $this->session->set_flashdata('success', 'User has been approved successfully');
            redirect(base_url('admin/approval_requests'));
            
        }else{
            $this->session->set_flashdata('errors', 'Something went wrong!');
            redirect(base_url('admin/approval_requests'));
        }
    }

    public function login(){
        if($this->input->post()){
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $data = [
                'email' => $email,
                'password' => md5($password)
            ];
            $user = $this->admin_model->login($data);
            if($user){
                if($user->status == APPROVED){
                    $this->session->set_userdata('is_logged_in', true);
                    $this->session->set_userdata('user_id', $user->id);
                    redirect(base_url('admin/home'));
                }else{
                    $this->session->set_flashdata('error','Your regestration is not approved yet');
                    redirect(base_url('admin/login'));
                }
                
            }else{
                $this->session->set_flashdata('error','Invalid credentails!');
                redirect(base_url('admin/login'));
            }
        }
        $this->load->view('login');
    }

    public function logout(){
        $this->session->unset_userdata('is_logged_in');
        $this->session->unset_userdata('user_id');
        redirect(base_url('admin/login'));
    }

    public function signup(){

        $classes = $this->admin_model->get_classes();
        $data['classes'] = $classes ? $classes : '';


        if($this->input->post()){
            // preview($this->input->post());
            $first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last_name');
            $email = $this->input->post('email');
            $address = $this->input->post('address');
            $role = $this->input->post('role');
            if($role == STUDENT){
                $class_id = $this->input->post('class_id');
                $subjects = $this->input->post('subjects');
            }

            $user_data = [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'address' => $address,
                'role' => $role,
                'status' => NOT_APPROVED,
            ];


            $user_id = $this->admin_model->add_user($user_data);
            if($user_id){
                if($role == STUDENT){
                    if($subjects){
                        foreach($subjects as $k => $v){
                            $temp_data = [
                                'class_id' => $class_id,
                                'subject_id' => $v,
                                'student_id' => $user_id
                            ];

                            $this->admin_model->add_student_subject($temp_data);
                        }

                        $class_data = [
                            'class_id' => $class_id,
                            'student_id' => $user_id
                        ];

                        $this->admin_model->add_student_class($class_data);
                    }
                }
                $this->session->set_flashdata('success', 'Application submitted successfully for approval');
                redirect(base_url('admin/signup'));
            }else{
                $this->session->set_flashdata('errors', 'Something went wrong!');
                redirect(base_url('admin/signup'));
            }
        }


        $this->load->view('signup', $data);
    }



    


    // ==================== Subjects section ======================



    public function subjects(){
        $subjects = $this->admin_model->get_subjects();
        if($subjects){
            $data['subjects'] = $subjects;
        }else{
            $data['subjects'] = '';
        }
        $this->load->view('Subjects/subject-listing', $data);
    }

    public function add_subject(){
        $classes = $this->admin_model->get_classes();
        $data['classes'] = ($classes ? $classes : '');
        if($this->input->post()){
            $subject_name = $this->input->post('subject_name');
            $subject_code = $this->input->post('subject_code');
            $class_id = $this->input->post('class_id');

            $errors = '';

            $errors .= (!$subject_name ? "Please enter subject name<br>" : '');
            $errors .= (!$subject_code ? "Please enter subject code<br>" : '');

            if(!$errors){
                $data = [
                    'subject_name' => $subject_name,
                    'subject_code' => $subject_code,
                    'class_id' => $class_id
                ];
    
                $res = $this->admin_model->add_subject($data);
                if($res){
                    $this->session->set_flashdata('success', 'Subject inserted successfully');
                    redirect(base_url('admin/add_subject'));
                }else{
                    $this->session->set_flashdata('errors', 'Something went wrong!');
                    redirect(base_url('admin/add_subject'));
                }
            }else{
                $this->session->set_flashdata('errors', $errors);
                redirect(base_url('admin/add_subject'));
            }
        }
        $this->load->view('Subjects/add-subject', $data);
    }

    public function delete_subject($id){
        $res = $this->admin_model->delete_subject(['id' => $id]);
        if($res){
            $this->session->set_flashdata('success', 'Subject deleted successfully');
            redirect(base_url('admin/subjects'));
            
        }else{
            $this->session->set_flashdata('errors', 'Something went wrong!');
            redirect(base_url('admin/subjects'));
        }
    }

    public function edit_subject($id){
        $subject = $this->admin_model->get_subjects(['id' => $id]);
        $data['subject'] = $subject ? $subject[0] : '';

        if($this->input->post()){
            $subject_name = $this->input->post('subject_name');
            $subject_code = $this->input->post('subject_code');
            $errors = '';

            $errors .= (!$subject_name ? "Please enter subject name<br>" : '');
            $errors .= (!$subject_code ? "Please enter subject code<br>" : '');

            if(!$errors){
                $data = [
                    'subject_name' => $subject_name,
                    'subject_code' => $subject_code,
                ];
    
                $res = $this->admin_model->update_subject($data, ['id' => $id]);
                if($res){
                    $this->session->set_flashdata('success', 'Subject updated successfully');
                    redirect(base_url('admin/edit_subject/'.$id));
                }else{
                    $this->session->set_flashdata('errors', 'Something went wrong!');
                    redirect(base_url('admin/edit_subject/'.$id));
                }
            }else{
                $this->session->set_flashdata('errors', $errors);
                redirect(base_url('admin/edit_subject/'.$id));
            }
        }
        $this->load->view('Subjects/edit_subject', $data);
    }


    public function allocate_subject(){
        $teachers = $this->admin_model->get_users(['role' => TEACHER]);
        $data['teachers'] = $teachers ? $teachers : '';
        $classes = $this->admin_model->get_classes();
        $data['classes'] = $classes ? $classes : '';

        if($this->input->post()){
            // preview($_POST);
            $teacher_id = $this->input->post('teacher_id');
            $class_id = $this->input->post('class_id');
            $subject_id = $this->input->post('subject_id');
            $errors = '';

            if(!$errors){
                $temp_data = [
                    'teacher_id' => $teacher_id,
                    'class_id' => $class_id,
                    'subject_id' => $subject_id
                ];

                $res = $this->admin_model->insert_allocated_subject($temp_data);
                if($res){
                    $this->session->set_flashdata('success', 'Subject allocated successfully');
                    redirect(base_url('admin/allocate_subject'));
                }else{
                    $this->session->set_flashdata('errors', 'Something went wrong!');
                    redirect(base_url('admin/allocate_subject'));
                }
            }
            
        }
        $this->load->view('Subjects/allocate-subject', $data);
    }




    // ==================== Subjects section ======================



    // ==================== Teacher section ======================



    public function teachers(){
        $teachers = $this->admin_model->get_users(['role' => TEACHER]);
        $data['teachers'] = ($teachers ? $teachers : '');
        $this->load->view('teachers/teacher-listing', $data);
    }

    public function delete_teacher($id){
        $res = $this->admin_model->delete_user(['id' => $id]);
        if($res){
            $this->session->set_flashdata('success', 'User deleted successfully');
            redirect(base_url('admin/teachers'));
            
        }else{
            $this->session->set_flashdata('errors', 'Something went wrong!');
            redirect(base_url('admin/teachers'));
        }
    }


    public function add_teacher(){
        if($this->input->post()){
            // preview($this->input->post());
            $id_card = $this->input->post('user_idCard');
            $fname = $this->input->post('user_fname');
            $lname = $this->input->post('user_lname');
            $email = $this->input->post('user_email');
            $phone = $this->input->post('user_phone');
            $password = $this->input->post('user_password');
            $confirm_password = $this->input->post('user_confirm_password');
            $city = $this->input->post('user_city');
            $salary = $this->input->post('user_salary');


            $errors = true;

            if($errors){
                $user_data = [
                    'cnic' => $id_card,
                    'first_name' => $fname,
                    'last_name' => $lname,
                    'email' => $email,
                    'phone' => $phone,
                    'password' => md5($password),
                    'city' => $city,
                    'salary' =>  $salary,
                    'role' => TEACHER,
                    'status' => APPROVED
                ];

                $res = $this->admin_model->add_user($user_data);

                if($res){
                    $this->session->set_flashdata('success', 'Teacher inserted successfully');
                    redirect(base_url('admin/teachers'));
                }else{
                    $this->session->set_flashdata('errors', 'Something went wrong!');
                    redirect(base_url('admin/teachers'));
                }
            }else{
                $this->session->set_flashdata('errors', $errors);
                redirect(base_url('admin/teachers'));
            }
        }
        $this->load->view('teachers/add-teacher');
    }

    public function edit_teacher($id){
        $teacher = $this->admin_model->get_users(['id' => $id]);
        $data['teacher'] = ($teacher ? $teacher[0] : '');
        if($this->input->post()){
            // preview($this->input->post());
            $id_card = $this->input->post('user_idCard');
            $fname = $this->input->post('user_fname');
            $lname = $this->input->post('user_lname');
            $email = $this->input->post('user_email');
            $phone = $this->input->post('user_phone');
            $city = $this->input->post('user_city');
            $salary = $this->input->post('user_salary');


            $errors = true;

            if($errors){
                $user_data = [
                    'cnic' => $id_card,
                    'first_name' => $fname,
                    'last_name' => $lname,
                    'email' => $email,
                    'phone' => $phone,
                    'city' => $city,
                    'salary' =>  $salary,
                ];

                $res = $this->admin_model->update_user($user_data,['id' => $id]);

                if($res){
                    $this->session->set_flashdata('success', 'Data updated successfully');
                    redirect(base_url('admin/edit_teacher/'.$id));
                }else{
                    $this->session->set_flashdata('errors', 'Something went wrong!');
                    redirect(base_url('admin/edit_teacher/'.$id));
                }
            }else{
                $this->session->set_flashdata('errors', $errors);
                redirect(base_url('admin/teachers'));
            }
        }

        $this->load->view('teachers/edit_teacher', $data);
    }




    // ==================== Teacher section ======================




    
    // ==================== Student section ======================



    public function students(){
        $students = $this->admin_model->get_users(['role' => STUDENT]);
        $data['students'] = ($students ? $students : '');
        $this->load->view('students/student-listing', $data);
    }

    public function add_student(){
        $classes = $this->admin_model->get_classes();
        $data['classes'] = ($classes ? $classes : '');

        if($this->input->post()){
            // preview($_POST);
            $fname = $this->input->post('user_fname');
            $lname = $this->input->post('user_lname');
            $email = $this->input->post('user_email');
            $phone = $this->input->post('user_phone');
            $city = $this->input->post('user_city');
            $password = $this->input->post('user_password');
            $confirm_password = $this->input->post('user_confirm$confirm_password');
            $fee = $this->input->post('user_fee');
            $class_id = $this->input->post('class_id');
            $errors = '';

            if(!$errors){
                $user_data = [
                    'first_name' => $fname,
                    'last_name' => $lname,
                    'password' => md5($password),
                    'phone' => $phone,
                    'city' => $city,
                    'fee' => $fee,
                    'phone' => $phone,
                    'role' => STUDENT,
                    'status' => APPROVED
                ];


                $user_id = $this->admin_model->add_user($user_data);
                if($user_id){
                    $sc_data = [
                        'student_id' => $user_id,
                        'class_id' => $class_id,
                    ];
                    $res = $this->admin_model->add_student_class($sc_data);

                    if($res){
                        $this->session->set_flashdata('success', 'Student inserted successfully');
                        redirect(base_url('admin/students'));
                    }else{
                        $this->session->set_flashdata('errors', 'Something went wrong!');
                        redirect(base_url('admin/students'));
                    }
                }
            }
            
        }

        $this->load->view('students/add-student', $data);
    }

    public function edit_student($id){
        $student = $this->admin_model->get_users(['id' => $id]);
        $data['student'] = $student ? $student[0] : '';
        $classes = $this->admin_model->get_classes();
        $data['classes'] = ($classes ? $classes : '');
        $class_data = $this->admin_model->get_student_class(['student_id' => $id]);
        $data['class_id'] = $class_data ? $class_data[0]->class_id : '';


        if($this->input->post()){
            // preview($_POST);
            $fname = $this->input->post('user_fname');
            $lname = $this->input->post('user_lname');
            $email = $this->input->post('user_email');
            $phone = $this->input->post('user_phone');
            $city = $this->input->post('user_city');
            $fee = $this->input->post('user_fee');
            $class_id = $this->input->post('class_id');
            $errors = '';

            if(!$errors){
                $user_data = [
                    'first_name' => $fname,
                    'last_name' => $lname,
                    'phone' => $phone,
                    'city' => $city,
                    'fee' => $fee,
                    'email' => $email,
                    'phone' => $phone,
                ];


                $user_updated = $this->admin_model->update_user($user_data, ['id' => $id]);
                if($user_updated){
                    $sc_data = [
                        'student_id' => $id,
                        'class_id' => $class_id,
                    ];
                    $res = $this->admin_model->update_student_class($sc_data, ['id' => $class_data[0]->id]);

                    if($res){
                        $this->session->set_flashdata('success', 'Student updated successfully');
                        redirect(base_url('admin/edit_student/'.$id));
                    }else{
                        $this->session->set_flashdata('errors', 'Something went wrong!');
                        redirect(base_url('admin/students/'.$id));
                    }
                }
            }
            
        }

        $this->load->view('students/edit-student', $data);
    }

    public function delete_student($id){
        $res = $this->admin_model->delete_user(['id' => $id]);
        if($res){
            $this->session->set_flashdata('success', 'User deleted successfully');
            redirect(base_url('admin/students'));
            
        }else{
            $this->session->set_flashdata('errors', 'Something went wrong!');
            redirect(base_url('admin/students'));
        }
    }




    // ==================== Student section ======================



    // ==================== Classes section ======================



    public function classes(){
        $classes = $this->admin_model->get_classes();
        $data['classes'] = ($classes ? $classes : '');
        $this->load->view('classes/class-listing', $data);
    }

    public function add_class(){
        if($this->input->post()){
            $class_name = $this->input->post('class_name');
            $errors = '';

            if(!$errors){
                $class_data = [
                    'class_name' => $class_name,
                ];

                $res = $this->admin_model->insert_class($class_data);

                if($res){
                    $this->session->set_flashdata('success', 'Class inserted successfully');
                    redirect(base_url('admin/classes'));
                }else{
                    $this->session->set_flashdata('errors', 'Something went wrong!');
                    redirect(base_url('admin/classes'));
                }
            }else{
                $this->session->set_flashdata('errors', $errors);
                redirect(base_url('admin/classes'));
            }
        }
        $this->load->view('classes/add_class');
    }


    public function delete_class($id){
        $res = $this->admin_model->delete_class(['id' => $id]);
        if($res){
            $this->session->set_flashdata('success', 'Class deleted successfully');
            redirect(base_url('admin/classes'));
            
        }else{
            $this->session->set_flashdata('errors', 'Something went wrong!');
            redirect(base_url('admin/classes'));
        }
    }

    public function edit_class($id){
        $class = $this->admin_model->get_classes(['id' => $id]);
        $data['class'] = ($class ? $class[0] : '');

        if($this->input->post()){
            $class_name = $this->input->post('class_name');
            $errors = '';

            if(!$errors){
                $class_data = [
                    'class_name' => $class_name,
                ];

                $res = $this->admin_model->update_class($class_data, ['id' => $id]);

                if($res){
                    $this->session->set_flashdata('success', 'Class updated successfully');
                    redirect(base_url('admin/edit_class/'.$id));
                }else{
                    $this->session->set_flashdata('errors', 'Something went wrong!');
                    redirect(base_url('admin/edit_class/'.$id));
                }
            }else{
                $this->session->set_flashdata('errors', $errors);
                redirect(base_url('admin/edit_class/'.$id));
            }
        }


        $this->load->view('classes/edit_class', $data);
    }




    // ==================== Classes section ======================

    public function get_subjects(){
        $class_id = $this->input->post('class_id');

        $subjects = $this->admin_model->get_subjects(['class_id' => $class_id]);
        if($subjects){
            ajax_response(true, $subjects, 'Data found successfully');
        }else{
            ajax_response(false, [], 'Data not found!');
        }
    }

}

