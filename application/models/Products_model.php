<?php

class Products_model extends CI_Model
{
    //constructor
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //add
    public function add($mid)
    {
        $data = array(
            'mid' => (int) $mid,
            'cat_id' => (int) $this->input->post('cid'),
            'pname' => $this->input->post('pname'),
            'pprice' => $this->input->post('pprice')==''?null:(float) $this->input->post('pprice'),
            'cprice' => (float) $this->input->post('cprice'),
            'descrip' => $this->input->post('descrip'),
            'adate' => time(),
        );
        $res['res'] = $this->db->insert('products', $data);
        $res['id'] = $this->db->insert_id();
        return $res;
    }

    //update
    public function update()
    {
        $pid = (int) $this->input->post('pid');
        $this->db->where('id', $pid);
        $data = array(
            'cat_id' => (int) $this->input->post('cat'),
            'pname' => $this->input->post('pname'),
            'pprice' => $this->input->post('pprice')==''?null:(float) $this->input->post('pprice'),
            'cprice' => (float) $this->input->post('cprice'),
            'descrip' => $this->input->post('descrip'),
        );
        return $this->db->update('products', $data);
    }

    //get all
    public function get_all()
    {
        $this->db->order_by('adate', 'DESC');
        $query = $this->db->get('products');
        return $query->result_array();
    }

    public function get_all_count($s)
    {
        $this->db->where('status', 0);
        $this->db->where('astatus', 0);
        if ($s == 1) {
            $this->db->where('special', 1);
        }
        $this->db->order_by('adate', 'DESC');
        return $this->db->count_all_results('products');
    }
    //get_all: last 10
    public function get_recent()
    {
        $this->db->order_by('adate', 'DESC');
        $this->db->limit('10');
        $query = $this->db->get('products');
        return $query->result_array();
    }
    //get top 18 recently added products
    public function r_get_all($limit)
    {
        $this->db->where('status', 0);
        $this->db->where('astatus', 0);
        $this->db->order_by('adate', 'DESC');
        $query = $this->db->get('products', 0, $limit);
        return $query->result_array();
    }

    //get special offers
    public function s_get_all($limit)
    {
        $this->db->where('status', 0);
        $this->db->where('astatus', 0);
        $this->db->where('special', 1);
        $this->db->order_by('adate', 'DESC');
        $query = $this->db->get('products', 0, $limit);
        return $query->result_array();
    }

    //get all not flagged
    public function _get_all()
    {
        $this->db->where('status', 0);
        $this->db->where('astatus', 0);
        $this->db->order_by('adate', 'DESC');
        $query = $this->db->get('products');
        return $query->result_array();
    }

    //get
    public function get($pid)
    {
        $this->db->where('id', (int) $pid);
        $query = $this->db->get('products');
        return $query->row_array();
    }

    //get product name
    public function get_name($pid)
    {
        $this->db->where('id', (int) $pid);
        $query = $this->db->get('products');
        return $query->row_array()['pname'];
    }

    //get by category
    public function get_by_cat($cid)
    {
        $this->db->where('cat_id', (int) $cid);
        $this->db->order_by('adate', 'DESC');
        $query = $this->db->get('products');
        return $query->result_array();
    }

    //get by merchant
    public function get_by_merchant($mid)
    {
        $this->db->where('mid', (int) $mid);
        $this->db->order_by('adate', 'DESC');
        $query = $this->db->get('products');
        return $query->result_array();
    }

    //get by category not flagged
    public function _get_by_cat($cid)
    {
        $this->db->where('cat_id', (int) $cid);
        $this->db->where('status', 0);
        $this->db->where('astatus', 0);
        $this->db->order_by('adate', 'DESC');
        $query = $this->db->get('products');
        return $query->result_array();
    }

    //get by search
    public function get_by_search($cid, $stxt)
    {   
        $this->db->select('*');
        $this->db->from('products');
        
        $this->db->join('categories', 'categories.id = products.cat_id', 'inner');
        $this->db->join('merchants', 'merchants.id = products.mid', 'inner');
        $this->db->order_by('products.adate', 'DESC');
        $this->db->group_start();
        if((int)$cid!=0){
            $this->db->where('products.cat_id', (int)$cid);
        }
        $this->db->group_start();
        $this->db->like('products.pname', $stxt);
        $this->db->or_like('merchants.mname', $stxt);
        $this->db->group_end();
        $this->db->group_end();
        
        $query = $this->db->get();
        return $query->result_array();
    }

    //get customer search
    public function get_search($stxt)
    {   
        $stxt = $stxt=='*'?'':$stxt;
        $this->db->select('products.*, categories.cat');
        $this->db->from('products');
        
        $this->db->join('categories', 'categories.id = products.cat_id', 'inner');
        $this->db->order_by('products.adate', 'DESC');
        $this->db->like('categories.cat', $stxt);
        $this->db->or_like('products.pname', $stxt);
        
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();
    }

    //update status
    public function update_status($pid, $status)
    {
        $this->db->where('id', (int) $pid);
        $data = array(
            'status' => (int) $status,
        );
        return $this->db->update('products', $data);
    }

    //update astatus
    public function update_astatus($pid, $status)
    {
        $this->db->where('id', (int) $pid);
        $data = array(
            'astatus' => (int) $status,
        );
        return $this->db->update('products', $data);
    }

    //update all astatus for a merchant
    public function _update_astatus($mid, $status)
    {
        $this->db->where('mid', (int) $mid);
        $data = array(
            'astatus' => (int) $status,
        );
        return $this->db->update('products', $data);
    }

    //update special offers
    public function update_special($pid, $status)
    {
        $this->db->where('id', (int) $pid);
        $data = array(
            'special' => (int) $status,
        );
        return $this->db->update('products', $data);
    }

    //update avail
    public function update_avail($pid, $status)
    {
        $this->db->where('id', (int) $pid);
        $data = array(
            'avail' => (int) $status,
        );
        return $this->db->update('products', $data);
    }

    //delete
    public function delete($pid)
    {
        return $this->db->delete('products', array('id' => (int) $pid));
    }

    //check if flagged
    public function is_flagged($pid)
    {
        $pid = (int) $pid;
        $this->db->where('id', $pid);
        $this->db->where('status', 1);
        $this->db->or_where('astatus', 1);
        $query = $this->db->get('products');
        $result = $query->result_array();
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    //search ---- pagination

}
