<?php

class Images_model extends CI_Model
{
    //constructor
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //add
    public function add($pid, $fpath)
    {
        $data = array(
            'pid' => (int) $pid,
            'fpath' => $fpath,
        );
        return $this->db->insert('images', $data);
    }

    //get all images
    public function get_all()
    {
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('images');
        return $query->result_array();
    }

    //get all under a product
    public function get($pid)
    {
        $this->db->where('pid', (int) $pid);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('images');
        return $query->result_array();
    }

    //get a single image
    public function _get($id)
    {
        $this->db->where('id', (int) $id);
        $query = $this->db->get('images');
        return $query->row_array();
    }

    //delete all images under a product
    public function _delete($pid){
        return $this->db->delete('images', array('pid'=> (int)$pid));
    }

    //delete
    public function delete($id){
        return $this->db->delete('images', array('id'=> (int)$id));
    }

    //======================IMAGE UPLOAD AND MANIPULATION===========================
    //upload image
    public function upload()
    {
        $filename = $this->get_filename();
        $config['upload_path'] = './images/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = 5000; //max-size 5mb
        // $config['max_width'] = 2048;
        // $config['max_height'] = 1024;
        $config['file_name'] = $filename;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
            $res['res'] = 'false';
            $res['data'] = $this->upload->display_errors();
        } else {
            $data = $this->upload->data();
            $config['image_library'] = 'gd2';
            $config['source_image'] = './images/' . $data["file_name"];
            $config['create_thumb'] = false;
            $config['maintain_ratio'] = true;
            $config['quality'] = ($data['image_width'] > 1024) ? '10%' : '20%';
            $config['width'] = ($data['image_width'] > 768) ? 768 : $data['image_width'];
            $config['height'] = ($data['image_height'] > 768) ? 768 : $data['image_height'];
            $config['new_image'] = './images/' . $data["file_name"];
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            $this->compress($config['source_image'], $config['new_image'], ($data['image_width'] > 1024) ? 85 : 90);

            $res['res'] = 'true';
            $res['data'] = $this->upload->data();
            $res['data']['fpath'] = 'images/' . $filename;
        }
        return $res;
    }

    //get file name
    public function get_filename()
    {
        $fname = $_FILES['file']['name'];
        $arr = explode('.', $fname);
        return $arr[0] . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . '.' . $arr[count($arr) - 1];
    }

    //custom method for compressing image
    public function compress($source, $destination, $quality)
    {
        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg') {
            $image = imagecreatefromjpeg($source);
        } elseif ($info['mime'] == 'image/jpg') {
            $image = imagecreatefromjpeg($source);
        } elseif ($info['mime'] == 'image/gif') {
            $image = imagecreatefromgif($source);
        } elseif ($info['mime'] == 'image/png') {
            $image = imagecreatefrompng($source);
        }

        imagejpeg($image, $destination, $quality);

        return $destination;
    }

    //delete file from folder
    public function delete_file($fpath)
    {
        if (file_exists($fpath)) {
            unlink($fpath);
            return true;
        } else {
            // File not found.
            return false;
        }
    }
}
