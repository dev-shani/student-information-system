<?php

class Admin_model extends CI_Model{


    function login($data){
        $res = $this->db->get_where('users',$data);
        if($res->num_rows() > 0){
            return $res->row();
        }else{
            return false;
        }
    }


    function add_user($data){
        $res = $this->db->insert('users', $data);
        if($res){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    function insert_allocated_subject($data){
        $res = $this->db->insert('allocated_subjects', $data);
        if($res){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    
    function add_student_class($data){
        $res = $this->db->insert('student_class', $data);
        if($res){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }


    function get_student_class($where){
        $res = $this->db->get_where('student_class', $where);
        if($res->num_rows() > 0){
            return $res->result();
        }else{
            return false;
        }
    }

    function update_student_class($data, $where){
        $res = $this->db->update('student_class', $data, $where);
        return ($res ? true : false);
    }

    function get_users($where = false){
        if($where){
            $this->db->where($where);
        }
        $res = $this->db->get('users');
        if($res->num_rows() > 0){
            return $res->result();
        }else{
            return false;
        }
    }

    function delete_user($where){
        $res = $this->db->delete('users', $where);
        return ($res ? true : false);
    }

    function update_user($data, $where){
        $res = $this->db->update('users', $data, $where);
        return ($res ? true : false);
    }
    
    
    
    function update_subject($data, $where){
        $res = $this->db->update('subjects', $data, $where);
        return ($res ? true : false);
    }


    function add_subject($data){
        $res = $this->db->insert('subjects', $data);
        if($res){
            return true;
        }else{
            return false;
        }
    }

    function delete_subject($where){
        $res = $this->db->delete('subjects', $where);
        return ($res ? true : false);
    }

    function get_subjects($where = false){
        if($where){
            $this->db->where($where);
        }
        $res = $this->db->get('subjects');
        if($res->num_rows() > 0){
            return $res->result();
        }else{
            return false;
        }
    }
    
    
    
    function get_classes($where = false){
        if($where){
            $this->db->where($where);
        }
        $res = $this->db->get('classes');
        if($res->num_rows() > 0){
            return $res->result();
        }else{
            return false;
        }
    }




    function insert_class($data){
        $res = $this->db->insert('classes', $data);
        if($res){
            return true;
        }else{
            return false;
        }
    }


    function delete_class($where){
        $res = $this->db->delete('classes', $where);
        return ($res ? true : false);
    }

    function update_class($data, $where){
        $res = $this->db->update('classes', $data, $where);
        return ($res ? true : false);
    }


}