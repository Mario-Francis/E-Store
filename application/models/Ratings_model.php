<?php

class Ratings_model extends CI_Model{
    //constructor
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    //create
    public function create($cid){
        $data=array(
            'cid'=>(int)$cid,
            'pid'=>(int)$this->input->post('pid'),
            'rate'=>(int)$this->input->post('rate')
        );
        return $this->db->insert('ratings', $data);
    }

     //update
     public function update($cid, $pid, $rate){
        $data=array(
            'rate'=>(int)$this->input->post('rate')
        );
        $this->db->where('cid', (int)$cid);
        $this->db->where('pid', (int)$pid);

        return $this->db->update('ratings', $data);
    }

     //get rating for a particular product
     public function get($pid){
        $query = $this->db->get_where('ratings', array('pid'=>(int)$pid));
        $res = $query->result_array();
        $rquery = $this->db->get_where('rate', array('id'=>1));
        $row = $rquery->row_array();
        $mes = (int)$row['measure'];
        if(count($res) > 0){
            $rate = 0;
            $sum = 0;
            $rno = count($res);
            for($i=0;$i < $rno;$i++){
                $sum+=(int)$res[$i]['rate'];
            }
            $rate = $sum / count($res);
            $cal = ($rno/$mes)*5;
            $r = ($rate+$cal)/2;
            $r = round($r);
            return $r;
        }else{
            return 0;
        }
    }

    //delete ratings for a particular product
    public function delete($pid){
        return $this->db->delete('ratings', array('pid', (int)$pid));
    }

    //check if a customer have rated a particular product
    public function hasRate($cid, $pid){
        $this->db->where('cid', (int)$cid);
        $this->db->where('pid', (int)$pid);
        $query = $this->db->get('ratings');
        $row=$query->result_array();
        if(count($row) > 0){
            return true;
        }else{
            return false;
        }
    }

    //get customer rate
    public function get_rate($cid, $pid){
        $this->db->where('cid', (int)$cid);
        $this->db->where('pid', (int)$pid);
        $query = $this->db->get('ratings');
        $row=$query->row_array();
        return $row['rate'];
    }
}

?>