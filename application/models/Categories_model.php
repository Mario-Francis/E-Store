<?php

class Categories_model extends CI_Model{
    //constructor
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    //create
    public function create(){
        $data=array(
            'cat'=>$this->input->post('cat'),
            'dfee'=>$this->input->post('dfee')==''?500:(float)$this->input->post('dfee'),
            'dmode'=>(int)$this->input->post('dmode')
        );
        return $this->db->insert('categories', $data);
    }

    //update
    public function update(){
        $cid = (int)$this->input->post('cid');
        $data=array(
            'cat'=>$this->input->post('cat'),
            'dfee'=>$this->input->post('dfee')==''?500:(float)$this->input->post('dfee'),
            'dmode'=>(int)$this->input->post('dmode')
        );
        $this->db->where('id', $cid);
        return $this->db->update('categories', $data);
    }

    //get
    public function get($cid){
        $this->db->where('id', (int)$cid);
        $query = $this->db->get('categories');
        return $query->row_array();
    }

    //get all
    public function get_all(){
        $this->db->order_by('cat', 'ASC');
        $query = $this->db->get('categories');
        return $query->result_array();
    }

    //get all unflagged
    public function _get_all(){
        $this->db->where('status', 0);
        $this->db->order_by('cat', 'ASC');
        $query = $this->db->get('categories');
        return $query->result_array();
    }

    //update status
    public function update_status($cid, $status){
        $data=array(
            'status'=>(int)$status
        );
        $this->db->where('id', (int)$cid);
        return $this->db->update('categories', $data);
    }

    //check if category already exist
    public function exists($cat){
        $this->db->where('LOWER(cat)', strtolower($cat));
        $query = $this->db->get('categories');
        $result = $query->result_array();
        if(count($result) > 0){
            return true;
        }else{
            return false;
        }
    }

    //check if flagged
    public function is_flagged($cid){
        //echo $cid;
        $this->db->where('id', (int)$cid);
        $this->db->where('status', 1);
        $query = $this->db->get('categories');
        $result = $query->result_array();
        //echo json_encode($result);
        if(count($result) > 0){
            return true;
        }else{
            return false;
        }
    }
}

?>