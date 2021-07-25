<?php

class Customers_model extends CI_Model
{
    //constructor
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //create
    public function create()
    {
        $data = array(
            'fname' => $this->input->post('fname'),
            'lname' => $this->input->post('lname'),
            'gender' => $this->input->post('gender'),
            'adres' => $this->input->post('adres'),
            'phno' => $this->input->post('phno'),
            'email' => $this->input->post('email'),
            'pswd' => $this->input->post('pswd'),
            'rdate' => time(),
        );
        return $this->db->insert('customers', $data);
    }

    //create
    public function update($cid)
    {
        $this->db->where('id', (int)$cid);
        $data = array(
            'fname' => $this->input->post('fname'),
            'lname' => $this->input->post('lname'),
            'gender' => $this->input->post('gender'),
            'adres' => $this->input->post('adres'),
            'phno' => $this->input->post('phno'),
            'email' => $this->input->post('email')
        );
        return $this->db->update('customers', $data);
    }

    //change pswd
    public function change_pswd($cid, $pswd){
        $this->db->where('id', (int)$cid);
        $data = array(
            'pswd' => $pswd
        );
        return $this->db->update('customers', $data);
    }
    //get_all
    public function get_all()
    {
        $this->db->order_by('rdate', 'DESC');
        $query = $this->db->get('customers');
        return $query->result_array();
    }
    //get_all: last 10
    public function get_recent()
    {
        $this->db->order_by('rdate', 'DESC');
        $this->db->limit('10');
        $query = $this->db->get('customers');
        return $query->result_array();
    }

    //get
    public function get($id)
    {
        $this->db->where('id', (int) $id);
        $query = $this->db->get('customers');
        return $query->row_array();
    }

    //update status
    public function update_status($id, $status)
    {
        $data = array(
            'status' => (int) $status,
        );
        $this->db->where('id', (int) $id);
        return $this->db->update('customers', $data);
    }

    //update mail status
    public function update_mstatus($id, $mstatus)
    {
        $data = array(
            'mstatus' => (int) $mstatus,
        );
        $this->db->where('id', (int) $id);
        return $this->db->update('customers', $data);
    }

    //get full name
    public function get_name($id)
    {
        $row = $this->get((int) $id);
        return $row['fname'] . ' ' . $row['lname'];
    }

    //get adres
    public function get_adres($id)
    {
        $row = $this->get((int) $id);
        return $row['adres'];
    }

    //login - check if email and pswd exists
    public function if_exist($email, $pswd)
    {
        $this->db->where('LOWER(email)', strtolower($email));
        $this->db->where('pswd', $pswd);
        $query = $this->db->get('customers');
        $result = $query->result_array();
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    //check if email exists
    public function email_exist($email)
    {
        $this->db->where('LOWER(email)', strtolower($email));
        $query = $this->db->get('customers');
        $result = $query->result_array();
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    //get id with email and pswd
    public function get_id($email, $pswd)
    {
        $this->db->where('LOWER(email)', strtolower($email));
        $this->db->where('pswd', $pswd);
        $query = $this->db->get('customers');
        $row = $query->row_array();
        return $row['id'];
    }

    //check if flagged
    public function is_flagged($id)
    {
        $this->db->where('id', (int) $id);
        $this->db->where('status', 1);
        $query = $this->db->get('customers');
        $result = $query->result_array();
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    //get all subscribers---mstatus=1
    public function get_subscribers()
    {
        $this->db->where('mstatus', 1);
        $this->db->order_by('rdate', 'DESC');
        $query = $this->db->get('customers');
        return $query->result_array();
    }
}
