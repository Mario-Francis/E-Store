<?php

class Merchants_pay_model extends CI_Model
{
    //constructor
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //create
    public function add($oid, $mid, $amt)
    {
        $data = array(
            'oid' => (int) $oid,
            'mid' => (int) $mid,
            'amt' => (float) $amt,
            'pdate' => time()
        );
        return $this->db->insert('merchants_pay', $data);
    }

    //check if exist
    public function is_exist($oid, $mid){
        $this->db->where('oid', (int)$oid);
        $this->db->where('mid', (int)$mid);
        $query = $this->db->get('merchants_pay');
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    //get
    public function get($oid, $mid){
        $this->db->where('oid', (int)$oid);
        $this->db->where('mid', (int)$mid);
        $query = $this->db->get('merchants_pay');
        return $query->row_array();
    }

    // //update payment id
    // public function update_pid($id, $pid)
    // {
    //     $id = (int) $id;
    //     $data = array(
    //         'pid' => $pid
    //     );
    //     $this->db->where('id', $id);
    //     return $this->db->update('payments', $data);
    // }

    // //update payment status: Attempt=0, Paid=1
    // public function update_status($id, $status)
    // {
    //     $id = (int) $id;
    //     $data = array(
    //         'status' => (int)$status
    //     );
    //     $this->db->where('id', $id);
    //     return $this->db->update('payments', $data);
    // }

    
    //get an payment
    // public function get($id)
    // {
    //     $this->db->where('id', (int) $id);
    //     $query = $this->db->get('merchants_pay');
    //     return $query->row_array();
    // }

    //get all payments
    public function get_all()
    {
        $this->db->order_by('pdate', 'DESC');
        $query = $this->db->get('merchants_pay');
        return $query->result_array();
    }

    //get all attempted payments
    // public function get_attempts()
    // {
    //     $this->db->where('status', 0);
    //     $this->db->order_by('pdate', 'DESC');
    //     $query = $this->db->get('payments');
    //     return $query->result_array();
    // }

    // //get all paid payments
    // public function get_paid()
    // {
    //     $this->db->where('status', 1);
    //     $this->db->order_by('pdate', 'DESC');
    //     $query = $this->db->get('payments');
    //     return $query->result_array();
    // }

    //delete
    public function delete($oid, $mid){
        return $this->db->delete('merchants_pay', array('oid'=> (int)$oid, 'mid'=> (int)$mid));
    }

}
