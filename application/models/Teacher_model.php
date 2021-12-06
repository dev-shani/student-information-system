<?php

class Teacher_model extends CI_Model{

    public function get_allocated_subject($where){
        $res = $this->db->get_where('allocated_subjects', $where);
        if($res->num_rows() > 0){
            return $res->result();
        }else{
            return false;
        }
    }

    public function insert_timetable($data){
        $res = $this->db->insert('timetables', $data);
        if($res){
            return true;
        }else{
            return false;
        }
    }
    
    public function get_class_students($where){
        $res = $this->db->get_where('student_class', $where);
        if($res->num_rows() > 0){
            return $res->result();
        }else{
            return false;
        }
    }


}