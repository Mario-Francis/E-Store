<?php

class Percent_model extends CI_Model{
    //constructor
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    //percent merchant sale id=1, up-front payment discount percent id=2, no of working days for delivery id = 3
    //update percent sales
    public function update($percent){
        $data=array(
            'rate'=>(float)$percent
        );
        $this->db->where('id', 1);
        return $this->db->update('percent', $data);
    }

    //get percent sales
    public function get(){
        $this->db->where('id', 1);
        $query = $this->db->get('percent');
        return $query->row_array();
    }

    //update pre-payment discount for delivery 
    public function update_dpercent($percent){
        $data=array(
            'rate'=>(float)$percent
        );
        $this->db->where('id', 2);
        return $this->db->update('percent', $data);
    }

    //get pre-payment discount for delivery 
    public function get_dpercent(){
        $this->db->where('id', 2);
        $query = $this->db->get('percent');
        return $query->row_array();
    }

     //update no of days for delivery
     public function update_days($days){
        $data=array(
            'rate'=>(int)$days
        );
        $this->db->where('id', 3);
        return $this->db->update('percent', $data);
    }

    //get no of days for delivery 
    public function get_days(){
        $this->db->where('id', 3);
        $query = $this->db->get('percent');
        return $query->row_array();
    }

}

?>