<?php

class Merchants_model extends CI_Model{
    //constructor
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    //add
    public function create(){
        $data=array(
            'mname'=>$this->input->post('mname'),
            'adres1'=>$this->input->post('adres1'),
            'adres2'=>$this->input->post('adres2')==''?NULL:$this->input->post('adres2'),
            'phno1'=>$this->input->post('phno1'),
            'phno2'=>$this->input->post('phno2')==''?NULL:$this->input->post('phno2'),
            'email'=>$this->input->post('email'),
            'pswd'=>$this->input->post('pswd'),
            'rdate'=>time()
        );
        return $this->db->insert('merchants', $data);
    }

    //update
    public function update($mid){
        $data=array(
            'mname'=>$this->input->post('mname'),
            'adres1'=>$this->input->post('adres1'),
            'adres2'=>$this->input->post('adres2')==''?NULL:$this->input->post('adres2'),
            'phno1'=>$this->input->post('phno1'),
            'phno2'=>$this->input->post('phno2')==''?NULL:$this->input->post('phno2'),
            'email'=>$this->input->post('email'),
            'bank'=>$this->input->post('bank'),
            'acc_type'=>$this->input->post('acc_type'),
            'acc_name'=>$this->input->post('acc_name'),
            'acc_no'=>$this->input->post('acc_no')
        );
        $this->db->where('id', (int)$mid);
        return $this->db->update('merchants', $data);
    }

    //check if email exist
    public function emailExists($email){
        $this->db->where('LOWER(email)', strtolower($email));
        $query = $this->db->get('merchants');
        $result = $query->result_array();
        if(count($result) > 0){
            return true;
        }else{
            return false;
        }
    }
    
    //check if exist
    public function isExist($email, $pswd){
        $this->db->where('LOWER(email)', strtolower($email));
        $this->db->where('pswd', $pswd);
        $query = $this->db->get('merchants');
        $result = $query->result_array();
        if(count($result) > 0){
            return true;
        }else{
            return false;
        }
    }

    //check if flagged
    public function isFlagged($mid){
        $this->db->where('id', (int)$mid);
        $this->db->where('status', 1);
        $query = $this->db->get('merchants');
        $result = $query->result_array();
        if(count($result) > 0){
            return true;
        }else{
            return false;
        }
    }


    //get all merchants
    public function get_all(){
        $this->db->order_by('rdate', 'DESC');
        $query = $this->db->get('merchants');
        return $query->result_array();
    }

    //get single merchant
    public function get($mid){
        $this->db->where('id', (int)$mid);
        $query = $this->db->get('merchants');
        return $query->row_array();
    }

    //get single merchant
    public function _get($email, $pswd){
        $this->db->where('LOWER(email)', strtolower($email));
        $this->db->where('pswd', $pswd);
        $query = $this->db->get('merchants');
        return $query->row_array();
    }

    //update status
    public function update_status($mid, $status){
        $data=array(
            'status'=>(int)$status
        );
        $this->db->where('id', (int)$mid);
        return $this->db->update('merchants', $data);
    }

    //change password
    public function change_pswd($mid, $pswd){
        $this->db->where('id', (int)$mid);
        $data=array(
            'pswd'=>$pswd
        );
        return $this->db->update('merchants', $data);
    }
    
}

?>