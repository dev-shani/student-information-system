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