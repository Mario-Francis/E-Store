<?php

class Admin_model extends CI_Model{
     //constructor
     public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    //get
    public function get()
    {
        $query = $this->db->get('admin');
        return $query->row_array();
    }

    //update password
    public function change_pswd($pswd){
        $data=array(
            'pswd'=>$pswd
        );
        return $this->db->update('admin', $data);
    }

    //update profile
    public function update_profile(){
        $data=array(
            'uname'=>$this->input->post('uname'),
            'email'=>$this->input->post('email'),
            'phno'=>$this->input->post('phno'),
            'phno2'=>$this->input->post('phno2')==''?null:$this->input->post('phno2'),
            'adres'=>$this->input->post('adres'),
            'bank'=>$this->input->post('bank'),
            'acc_type'=>$this->input->post('acc_type'),
            'acc_name'=>$this->input->post('acc_name'),
            'acc_no'=>$this->input->post('acc_no')
        );
        return $this->db->update('admin', $data);
    }
}

?>