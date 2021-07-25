<?php

class Orders_model extends CI_Model
{
    //constructor
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //create
    public function add($cid, $tid, $cart, $discount, $vat, $total, $adres, $method)
    {
        $data = array(
            'cid' => (int) $cid,
            'tid' => $tid,
            'cart' => $cart,
            'discount' => (float) $discount,
            'vat' => (float) $vat,
            'total' => (float) $total,
            'adres' => $adres,
            'method' => (int) $method,
            'odate' => time()
        );
        $res['res'] = $this->db->insert('orders', $data);
        $res['id'] = $this->db->insert_id();
        return $res;
    }

    //update destination address
    public function update_adres()
    {
        $oid = (int) $this->input->post('oid');
        $data = array(
            'adres' => $this->input->post('adres')
        );
        $this->db->where('id', $oid);
        return $this->db->update('orders', $data);
    }

    //update payment status: Not paid=0, Paid=1
    public function update_pstatus($oid, $status)
    {
        $oid = (int) $oid;
        $data = array(
            'pstatus' => (int)$status
        );
        $this->db->where('id', $oid);
        return $this->db->update('orders', $data);
    }

    //update delivery status: pending=0, Transit=1, delivered=2
    public function update_dstatus($oid, $status)
    {
        $oid = (int) $oid;
        $data = array(
            'dstatus' => (int)$status
        );
        $this->db->where('id', $oid);
        return $this->db->update('orders', $data);
    }

    //update order status: active=0, cancelled=1
    public function update_status($oid, $status)
    {
        $oid = (int) $oid;
        $data = array(
            'status' => (int)$status
        );
        $this->db->where('id', $oid);
        return $this->db->update('orders', $data);
    }
    
    //get an order
    public function get($oid)
    {
        $this->db->where('id', (int) $oid);
        $query = $this->db->get('orders');
        return $query->row_array();
    }

    //get all orders
    public function get_all()
    {
        $this->db->order_by('odate', 'DESC');
        $query = $this->db->get('orders');
        return $query->result_array();
    }

    //get all paid orders
    public function get_paid()
    {
        $this->db->where('pstatus', 1);
        $this->db->where('status', 0);
        $this->db->order_by('odate', 'DESC');
        $query = $this->db->get('orders');
        return $query->result_array();
    }
    //get all not paid orders
    public function get_not_paid()
    {
        $this->db->where('pstatus', 0);
        $this->db->where('status', 0);
        $this->db->order_by('odate', 'DESC');
        $query = $this->db->get('orders');
        return $query->result_array();
    }

    //get all active orders
    public function get_active()
    {
        $this->db->where('status', 0);
        $this->db->order_by('odate', 'DESC');
        $query = $this->db->get('orders');
        return $query->result_array();
    }

    //get all cancelled orders
    public function get_cancelled()
    {
        $this->db->where('status', 1);
        $this->db->order_by('odate', 'DESC');
        $query = $this->db->get('orders');
        return $query->result_array();
    }

    //get_all: last 10
    public function get_recent()
    {
        $this->db->where('dstatus', 0);
        $this->db->where('status', 0);
        $this->db->order_by('odate', 'DESC');
        $this->db->limit('10');
        $query = $this->db->get('orders');
        return $query->result_array();
    }

    //get_all for merchant
    public function get_mrecent()
    {
        $this->db->where('dstatus', 0);
        $this->db->where('status', 0);
        $this->db->order_by('odate', 'DESC');
        $query = $this->db->get('orders');
        return $query->result_array();
    }

    //get by customer
    public function get_by_customer($cid){
        $this->db->where('cid', (int)$cid);
        $this->db->where('status', 0);
        $this->db->order_by('odate', 'DESC');
        $query = $this->db->get('orders');
        return $query->result_array();
    }

    //get by search
    public function get_by_search($stxt)
    {   
        $stxt = $stxt=='*'?'':$stxt;
        $this->db->select('orders.*, customers.fname, customers.lname');
        $this->db->from('orders');
        
        $this->db->join('customers', 'customers.id = orders.cid', 'inner');
        $this->db->order_by('orders.odate', 'DESC');
        $this->db->like('orders.tid', $stxt);
        $this->db->or_like('customers.fname', $stxt);
        $this->db->or_like('customers.lname', $stxt);
        $this->db->or_like('CONCAT(customers.fname, \' \', customers.lname)', $stxt);
        $this->db->or_like('CONCAT(customers.lname, \' \', customers.fname)', $stxt);
        
        $query = $this->db->get();
        return $query->result_array();
    }


    //check if transaction id exist
    public function t_exist($tid){
        $this->db->where('tid', $tid);
        $query = $this->db->get('orders');
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

}
