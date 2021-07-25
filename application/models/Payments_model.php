<?php

class Payments_model extends CI_Model
{
    //constructor
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //create
    public function add($oid, $pid, $method, $status)
    {
        $data = array(
            'oid' => (int) $oid,
            'pid' => $pid,
            'method' => $method,
            'status' => (int)$status,
            'pdate' => time()
        );
        return $this->db->insert('payments', $data);
    }

    //update payment id
    public function update_pid($id, $pid)
    {
        $id = (int) $id;
        $data = array(
            'pid' => $pid
        );
        $this->db->where('id', $id);
        return $this->db->update('payments', $data);
    }

    //update payment status: Attempt=0, Paid=1
    public function update_status($id, $status)
    {
        $id = (int) $id;
        $data = array(
            'status' => (int)$status
        );
        $this->db->where('id', $id);
        return $this->db->update('payments', $data);
    }

    
    //get an payment
    public function get($id)
    {
        $this->db->where('id', (int) $id);
        $query = $this->db->get('payments');
        return $query->row_array();
    }

    //get all payments
    public function get_all()
    {
        $this->db->order_by('pdate', 'DESC');
        $query = $this->db->get('payments');
        return $query->result_array();
    }

    //get all attempted payments
    public function get_attempts()
    {
        $this->db->where('status', 0);
        $this->db->order_by('pdate', 'DESC');
        $query = $this->db->get('payments');
        return $query->result_array();
    }

    //get all paid payments
    public function get_paid()
    {
        $this->db->where('status', 1);
        $this->db->order_by('pdate', 'DESC');
        $query = $this->db->get('payments');
        return $query->result_array();
    }

    //delete by order id
    public function delete($oid){
        return $this->db->delete('payments', array('oid'=> (int)$oid));
    }

}
