<?php

class Merchants extends CI_Controller
{
    //constructor
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library("pagination");
    }

    //login
    public function index()
    {
        if(!isset($_SESSION['merchant'])){
            $data['title'] = 'Merchant Login';
            $this->load->view('merchants/index', $data);
        }else{
            redirect(base_url('merchant/home'));
        }
    }

    //home
    public function home()
    {
        if(isset($_SESSION['merchant'])){
            $data['title'] = 'Merchant Home';

        $this->load->model('orders_model');
        $this->load->model('merchants_model');
        $this->load->model('products_model');

        $mid = (int) $_SESSION['merchant']['id'];
        $r_orders = $this->orders_model->get_mrecent();
        $m_orders = [];

        foreach ($r_orders as $r) {
            if (count($m_orders) < 10) {
                $cart = unserialize($r['cart']);
                $qty = 0;
                $total = 0;
                foreach ($cart['cart'] as $p) {
                    $_mid = (int) ($this->products_model->get($p['id']))['mid'];
                    if ($_mid == $mid) {
                        $qty += (int) $p['qty'];
                        $total += (float) $p['mprice'] * (int) $p['qty'];
                    }
                }
                if ($qty != 0) {
                    $temp = array('tid' => $r['tid'], 'qty' => $qty, 'total' => $total, 'date' => $r['odate']);
                    $m_orders[] = $temp;
                }
            }
        }
        $data['orders'] = $m_orders;
        $this->returnView('home', $data);
        }else{
            redirect(base_url('merchant'));
        }
    }

    //New product
    public function new_product()
    {
        if(isset($_SESSION['merchant'])){
            $data['title'] = 'New Product';
        $data['jfile'] = 'new_product';

        $this->load->model('categories_model');
        $this->load->model('percent_model');

        $data['rate'] = ($this->percent_model->get())['rate'];
        $data['cats'] = $this->categories_model->get_all();

        $this->returnView('new_product', $data);
        }else{
            redirect(base_url('merchant'));
        }
    }

    //get pagination custom config
    public function get_custom_pagination_config()
    {
        $config['full_tag_open'] = '<ul class="pagination mul">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = '<i class="fa fa-angle-double-left"></i>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = '<i class="fa fa-angle-double-right"></i>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = '<i class="fa fa-chevron-right"></i>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '<i class="fa fa-chevron-left"></i>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $config['attributes'] = array('class' => 'page-link jclick');
        return $config;
    }
    //get page data
    public function get_page_data($arr, $limit, $start)
    {
        $cnt = count($arr);
        if ($cnt > 0) {
            if ($start >= $cnt) {
                $start = 0;
            }
            for ($i = $start; $i < ($start + $limit); $i++) {
                if ($i < $cnt) {
                    $res[] = $arr[$i];
                }
            }
            return $res;
        } else {
            return $arr;
        }
    }

    //check if page index is valid
    public function is_page_valid($arr, $limit, $page)
    {
        $res = false;
        $count = count($arr);
        $max = ceil($count / $limit);
        $max = $max==0?1:$max;
        if ($page >= 1 && $page <= $max) {
            $res = true;
        }
        return $res;
    }

    //get paginated pages for data
    public function paginate($data, $path, $per_page, $page = 1, $segment = 3)
    {
        $config = $this->get_custom_pagination_config();
        $config['use_page_numbers'] = true;
        $config["base_url"] = base_url() . $path;
        $config["total_rows"] = count($data);
        $config["per_page"] = $per_page;
        $config["uri_segment"] = $segment;

        $this->pagination->initialize($config);
        
        if (!$this->is_page_valid($data, $per_page, $page)) {
            redirect(base_url($path));
        }
        
        $start = $per_page * ($page - 1);
        $res["data"] = $this->get_page_data($data, $config["per_page"], $start);
        $res["links"] = $this->pagination->create_links();

        if ($page == 1) {
            $res['count'] = 1;
        } else {
            $res['count'] = ($per_page * ($page - 1)) + 1;
        }

        return $res;
    }

    //View products
    public function view_products($page = 1)
    {
        if(isset($_SESSION['merchant'])){
            $data['title'] = 'View Products';
        $data['jfile'] = 'view_products';

        $this->load->model('categories_model');
        $this->load->model('products_model');
        $this->load->model('percent_model');

        $data['rate'] = ($this->percent_model->get())['rate'];

        $data['cats'] = $this->categories_model->get_all();
        $products = $this->products_model->get_by_merchant($_SESSION['merchant']['id']);

        for ($i = 0; $i < count($products); $i++) {
            $products[$i]['cat'] = ($this->categories_model->get($products[$i]['cat_id']))['cat'];
            $products[$i]['price'] = number_format($products[$i]['cprice'], 2);
            $products[$i]['date'] = $this->f_date($products[$i]['adate']);
        }
        //$data['products'] = $products;
        $res = $this->paginate($products, 'merchant/view_products', 25, $page);
        $data['products'] = $res['data'];
        $data['links'] = $res['links'];
        $data['count'] = $res['count'];

        $this->returnView('view_products', $data);
        }else{
            redirect(base_url('merchant'));
        }
    }

    //image manager
    public function image_manager($page = 1)
    {
        if (isset($_SESSION['merchant'])) {
            $data['title'] = 'Image Manager';
            //$data['jfile'] = 'jquery.matchHeight';
            $data['jfile2'] = 'dropzone.min';
            $data['jfile3'] = 'image_manager';

            $this->load->model('products_model');

            $mid = (int) $_SESSION['merchant']['id'];
            $data['products'] = $this->products_model->get_by_merchant($mid);

            $images = $this->get_all_mimages();

            $data['images'] = $images;
            $res = $this->paginate($images, 'merchants/image_manager', 24, $page);
            $data['images'] = $res['data'];
            $data['count'] = $res['count'];
            $data['links'] = $res['links'];

            $this->returnView('image_manager', $data);
        } else {
            redirect(base_url('merchant'));
        }
    }

    //get all images for a particular merchant
    public function get_all_mimages()
    {
        $this->load->model('images_model');
        $this->load->model('products_model');

        $mid = (int) $_SESSION['merchant']['id'];
        $data['products'] = $this->products_model->get_by_merchant($mid);
        for ($i = 0; $i < count($data['products']); $i++) {
            $imgs = $this->images_model->get((int) $data['products'][$i]['id']);
            //echo 'Count: '.count($imgs);

            foreach ($imgs as $img) {
                if (count($imgs) > 1) {
                    $img['status'] = 0;
                } else {
                    $img['status'] = 1;
                }
                $img['pname'] = $this->products_model->get_name((int) $data['products'][$i]['id']);
                $images[] = $img;
            }
        }
        return $images;
    }

    //orders
    public function orders($page = 1)
    {
        if(isset($_SESSION['merchant'])){
            $data['title'] = 'Orders';

        $this->load->model('orders_model');
        $this->load->model('merchants_model');
        $this->load->model('products_model');

        $mid = (int) $_SESSION['merchant']['id'];
        $orders = $this->orders_model->get_all();
        $m_orders = [];

        foreach ($orders as $r) {
            $cart = unserialize($r['cart']);
            $qty = 0;
            $total = 0;
            $mcart = [];
            foreach ($cart['cart'] as $p) {
                $_mid = (int) ($this->products_model->get($p['id']))['mid'];
                if ($_mid == $mid) {
                    $qty += (int) $p['qty'];
                    $p['stotal'] = (float) $p['mprice'] * (int) $p['qty'];
                    $total += $p['stotal'];
                    $mcart[] = $p;
                }
            }
            if ($qty != 0) {
                //$temp = array('tid' => $r['tid'], 'qty' => $qty, 'total' => $total, 'date' => $r['odate']);
                $r['qty'] = $qty;
                $r['cart'] = $mcart;
                $r['total'] = $total;
                $m_orders[] = $r;
            }

        }
        $res = $this->paginate($m_orders, 'merchants/orders', 15, $page);
        $data['orders'] = $res['data'];
        $data['links'] = $res['links'];
        $data['count'] = $res['count'];

        $this->returnView('orders', $data);
        }else{
            redirect(base_url('merchant'));
        }
    }

    //calculate amt to be paid or paid to a merchant for an order
    public function calc_m_amt($cart, $mid)
    {
        $total = 0;
        foreach ($cart as $p) {
            if (($this->products_model->get((int) $p['id']))['mid'] == $mid) {
                $total += ((float) $p['mprice']) * (int) $p['qty'];
            }
        }
        return array('mid' => $mid, 'amt' => $total);
    }
    public function mrec_exist($mrecs, $oid, $mid)
    {
        $res = false;
        foreach ($mrecs as $m) {
            if ($m['mid'] == $mid && $m['oid'] == $oid) {
                $res = true;
            }
        }
        return $res;
    }
    //get payments to merchants record
    public function get_mpay($paid_orders, $status)
    {
        $this->load->model('merchants_pay_model');
        //$this->load->model('merchants_model');
        $this->load->model('products_model');

        $mid = (int) $_SESSION['merchant']['id'];
        $mrecords = [];
        for ($i = 0; $i < count($paid_orders); $i++) {
            $cart = unserialize($paid_orders[$i]['cart'])['cart'];
            foreach ($cart as $p) {
                $_mid = (int) ($this->products_model->get((int) $p['id']))['mid'];
                if ($_mid == $mid) {
                    if ($this->mrec_exist($mrecords, $paid_orders[$i]['id'], $_mid) == false) {
                        if ($this->merchants_pay_model->is_exist($paid_orders[$i]['id'], $_mid) == $status) {
                            $temp = $this->calc_m_amt($cart, $mid);
                            $temp['oid'] = $paid_orders[$i]['id'];
                            $temp['tid'] = $paid_orders[$i]['tid'];
                            if ($status) {
                                $temp['date'] = ($this->merchants_pay_model->get($paid_orders[$i]['id'], $mid))['pdate'];
                            }
                            $mrecords[] = $temp;
                        }
                        //$temp['mname']=($this->merchants_model->get($mid))['mname'];
                        //$temp['status']=$this->merchants_pay_model->is_exist($paid_orders[$i]['id'], $mid)?1:0;
                    }
                }
            }
        }
        return $mrecords;
    }
    //payments and debts
    public function pending_payments($page = 1)
    {
        if(isset($_SESSION['merchant'])){
            $data['title'] = 'Pending Payments';
        //$data['jfile'] = 'payments_to_merchants';

        $this->load->model('orders_model');

        $paid_orders = $this->orders_model->get_paid();
        $mrecords = $this->get_mpay($paid_orders, false);
        $res = $this->paginate($mrecords, 'merchants/pending_payments/', 25, $page);
        $data['records'] = $res['data'];
        $data['links'] = $res['links'];
        $data['count'] = $res['count'];
        //print_r($data['records']);
        $this->returnView('pending_payments', $data);
        }else{
            redirect(base_url('merchant'));
        }
    }

    //received payments
    public function received_payments($page = 1)
    {
        if(isset($_SESSION['merchant'])){
            $data['title'] = 'Received Payments';
        //$data['jfile'] = 'payments_to_merchants';

        $this->load->model('orders_model');

        $paid_orders = $this->orders_model->get_paid();
        $mrecords = $this->get_mpay($paid_orders, true);
        //print_r($mrecords);
        $res = $this->paginate($mrecords, 'merchants/received_payments/', 25, $page);
        $data['records'] = $res['data'];//print_r($res['data']);
        $data['links'] = $res['links'];
        $data['count'] = $res['count'];
        //print_r($data['records']);
        $this->returnView('received_payments', $data);
        }else{
            redirect(base_url('merchant'));
        }
    }

    //view and edit profile
    public function view_profile()
    {
        if(isset($_SESSION['merchant'])){
            $data['title'] = 'View Profile';
        $data['jfile'] = 'view_profile';

        $this->load->model('merchants_model');

        $mid = (int) $_SESSION['merchant']['id'];
        $data['merchant'] = $this->merchants_model->get($mid);

        $this->returnView('view_profile', $data);
        }else{
            redirect(base_url('merchant'));
        }
    }

    //change password
    public function change_password()
    {
        if(isset($_SESSION['merchant'])){
            $data['title'] = 'Change Password';
            $data['jfile'] = 'mchange_password';

            $this->returnView('change_password', $data);
        }else{
            redirect(base_url('merchant'));
        }
    }

    //logout
    public function logout()
    {
        $this->session->unset_userdata('merchant');
        redirect(base_url('merchants'));
    }
    //==========================API===============================
    //new product
    public function api_new_product()
    {
        if(isset($_SESSION['merchant'])){
            $mid = $_SESSION['merchant']['id'];
        $cat_id = $this->input->post('cid');
        $pname = trim($this->input->post('pname'));
        $pprice = trim($this->input->post('pprice'));
        $cprice = trim($this->input->post('cprice'));
        $descrip = trim($this->input->post('descrip'));
        $fpath = '';

        if ($cat_id == '' || $pname == '' || $cprice == '' || $descrip == '') {
            $res['res'] = 'false';
            $res['err'] = 'All fields are required';
        } else if (count($_FILES) < 1) {
            $res['res'] = 'false';
            $res['err'] = 'No image selected';
        } else {
            $this->load->model('images_model');
            $this->load->model('products_model');
            $ures = $this->images_model->upload();
            if ($ures['res'] == 'false') {
                $res['res'] = 'false';
                $res['err'] = $ures['data'];
            } else {
                $fpath = $ures['data']['fpath'];
                $dbres = $this->products_model->add($mid);
                if (!$dbres['res']) {
                    $res['res'] = 'false';
                    $res['err'] = 'Encountered problem adding product.Try again!';
                    $this->images_model->delete_file('./' . $fpath);
                } else {
                    $pid = $dbres['id'];
                    $ires = $this->images_model->add($pid, $fpath);
                    if (!$ires) {
                        $res['res'] = 'false';
                        $res['err'] = 'Encountered problem adding image.Try again!';
                        $this->images_model->delete_file('./' . $fpath);
                        $this->products_model->delete($pid);
                    } else {
                        $res['res'] = 'true';
                        $res['err'] = '';
                    }
                }
            }
        }
        echo json_encode($res);
        }else{
            echo json_encode([]);
        }
    }

    //login
    public function api_login()
    {
        $this->load->model('merchants_model');

        $email = trim($this->input->post('email'));
        $pswd = $this->input->post('pswd');

        if ($email == '' || $pswd == '') {
            $res['res'] = 'false';
            $res['err'] = 'Both fields are required';
        } else {
            //$det = $this->merchants_model->_get($email, $pswd);
            if (!$this->merchants_model->isExist($email, $pswd)) {
                $res['res'] = 'false';
                $res['err'] = 'Invalid email/password';
            } else {
                $det = $this->merchants_model->_get($email, $pswd);
                if ($this->merchants_model->isFlagged($det['id'])) {
                    $res['res'] = 'false';
                    $res['err'] = 'A problem was encountered logging you in. Contact our support team';
                } else {
                    $res['res'] = 'true';
                    $res['err'] = '';
                    $this->session->set_userdata('merchant', $det);
                }
            }
        }
        echo json_encode($res);
    }

    //get a product
    public function api_get_product()
    {
        if(isset($_SESSION['merchant'])){
            $this->load->model('categories_model');
        $this->load->model('products_model');

        $pid = (int) $this->input->get('pid');
        $res = $this->products_model->get($pid);
        $res['cat'] = ($this->categories_model->get($res['cat_id']))['cat'];

        echo json_encode($res);
        }else{
            echo json_encode([]);
        }
    }

    //update product
    public function api_update_product()
    {
        if(isset($_SESSION['merchant'])){
            $cat_id = (int) $this->input->post('cat');
        $pname = trim($this->input->post('pname'));
        $pprice = trim($this->input->post('pprice'));
        $cprice = trim($this->input->post('cprice'));
        $descrip = trim($this->input->post('descrip'));

        if ($cat_id == '' || $pname == '' || $cprice == '' || $descrip == '') {
            $res['res'] = 'false';
            $res['err'] = 'All fields are required';
        } else {
            $this->load->model('products_model');

            $dbres = $this->products_model->update();
            if (!$dbres) {
                $res['res'] = 'false';
                $res['err'] = 'Encountered problem updating product.Try again!';
            } else {
                $res['res'] = 'true';
                $res['err'] = '';
            }
        }
        echo json_encode($res);
        }else{
            echo json_encode([]);
        }
    }

    //get products
    public function api_get_products()
    {
        if(isset($_SESSION['merchant'])){
            $page = (int) $this->input->get('page');
        $this->load->model('categories_model');
        $this->load->model('products_model');

        $data['cats'] = $this->categories_model->get_all();
        $products = $this->products_model->get_by_merchant($_SESSION['merchant']['id']);

        for ($i = 0; $i < count($products); $i++) {
            $products[$i]['cat'] = ($this->categories_model->get($products[$i]['cat_id']))['cat'];
            $products[$i]['price'] = number_format($products[$i]['cprice'], 2);
            $products[$i]['date'] = $this->f_date($products[$i]['adate']);
        }

        $res = $this->paginate($products, 'merchants/view_products', 25, $page);

        $data['products'] = $res['data'];
        $data['count'] = $res['count'];
        echo json_encode($data);
        }else{
            echo json_encode([]);
        }
    }

    //flag product
    public function api_flag_product()
    {
        $this->load->model('products_model');

        $pid = (int) $this->input->get('pid');
        $r = $this->products_model->update_status($pid, 1);
        if ($r) {
            $res['res'] = 'true';
        } else {
            $res['res'] = 'false';
        }
        echo json_encode($res);
    }

    //unflag product
    public function api_unflag_product()
    {
        $this->load->model('products_model');

        $pid = (int) $this->input->get('pid');
        $r = $this->products_model->update_status($pid, 0);
        if ($r) {
            $res['res'] = 'true';
        } else {
            $res['res'] = 'false';
        }
        echo json_encode($res);
    }

    //mark product available
    public function api_avail_product()
    {
        $this->load->model('products_model');

        $pid = (int) $this->input->get('pid');
        $r = $this->products_model->update_avail($pid, 1);
        if ($r) {
            $res['res'] = 'true';
        } else {
            $res['res'] = 'false';
        }
        echo json_encode($res);
    }

    //mark product unavailable
    public function api_unavail_product()
    {
        $this->load->model('products_model');

        $pid = (int) $this->input->get('pid');
        $r = $this->products_model->update_avail($pid, 0);
        if ($r) {
            $res['res'] = 'true';
        } else {
            $res['res'] = 'false';
        }
        echo json_encode($res);
    }

    //mark product special
    public function api_mark_special()
    {
        $this->load->model('products_model');

        $pid = (int) $this->input->get('pid');
        $r = $this->products_model->update_special($pid, 1);
        if ($r) {
            $res['res'] = 'true';
        } else {
            $res['res'] = 'false';
        }
        echo json_encode($res);
    }

    //mark product unavailable
    public function api_unmark_special()
    {
        $this->load->model('products_model');

        $pid = (int) $this->input->get('pid');
        $r = $this->products_model->update_special($pid, 0);
        if ($r) {
            $res['res'] = 'true';
        } else {
            $res['res'] = 'false';
        }
        echo json_encode($res);
    }

    //get product images via product id
    public function api_fetch_pimages($page = 1)
    {
        $pid = (int) $this->input->get('pid');

        if ($pid == 0) {
            $images = $this->get_all_mimages();
        } else {
            $this->load->model('images_model');
            $this->load->model('products_model');
            $imgs = $this->images_model->get($pid);
            foreach ($imgs as $img) {
                if (count($imgs) > 1) {
                    $img['status'] = 0;
                } else {
                    $img['status'] = 1;
                }
                $img['pname'] = $this->products_model->get_name($pid);
                $images[] = $img;
            }
        }

        $res = $this->paginate($images, 'merchants/image_manager', 24, $page);
        echo json_encode($res);
    }

    //get a particular page via api
    public function api_get_page($page = 1)
    {
        //$index = (int)$this->input->get('page');

        $images = $this->get_all_mimages();
        $res = $this->paginate($images, 'merchants/image_manager', 24, $page);
        echo json_encode($res);
    }

    //dropzone image uplaod
    public function api_upload_pimage()
    {
        $pid = $this->input->post('pid');

        if ($pid == '') {
            $res['res'] = 'false';
            $res['err'] = 'Select a product';
        } else if (count($_FILES) < 1) {
            $res['res'] = 'false';
            $res['err'] = 'No image selected';
        } else {
            $this->load->model('images_model');
            $ures = $this->images_model->upload();
            if ($ures['res'] == 'false') {
                $res['res'] = 'false';
                $res['err'] = $ures['data'];
            } else {
                $fpath = $ures['data']['fpath'];

                $pid = (int) $pid;
                $ires = $this->images_model->add($pid, $fpath);
                if (!$ires) {
                    $res['res'] = 'false';
                    $res['err'] = 'Encountered problem uploading image.Try again!';
                    $this->images_model->delete_file('./' . $fpath);
                } else {
                    $res['res'] = 'true';
                    $res['err'] = '';
                }
            }
        }
        echo json_encode($res);
    }

    //del image
    public function api_del_image()
    {
        $id = (int) $this->input->get('id');

        $this->load->model('images_model');
        $img = $this->images_model->_get($id);
        $dbres = $this->images_model->delete($id);
        if (!$dbres) {
            $res['res'] = 'false';
            $res['err'] = 'Encountered problem deleting image.Try again!';
        } else {
            $this->images_model->delete_file('./' . $img['fpath']);
            $res['res'] = 'true';
            $res['err'] = '';
        }
        echo json_encode($res);
    }

    //update profile
    public function api_update_profile()
    {
        if(isset($_SESSION['merchant'])){
            $mid = (int) ($_SESSION['merchant']['id']);

        $this->load->model('merchants_model');
        $mname = trim($this->input->post('mname'));
        $adres1 = trim($this->input->post('adres1'));
        $adres2 = trim($this->input->post('adres2'));
        $phno1 = trim($this->input->post('phno1'));
        $phno2 = trim($this->input->post('phno2'));
        $email = trim($this->input->post('email'));
        $bank = trim($this->input->post('bank'));
        $acc_type = trim($this->input->post('acc_type'));
        $acc_name = trim($this->input->post('acc_name'));
        $acc_no = trim($this->input->post('acc_no'));

        $merch = $this->merchants_model->get($mid);

        if ($mname == '' || $adres1 == '' || $phno1 == '' || $email == '' ||$bank==''||$acc_type==''||$acc_name==''||$acc_no=='') {
            $res['res'] = 'false';
            $res['err'] = 'All relevant fields are required';
        } else if ($email != $merch['email'] && $this->merchants_model->emailExists($email)) {
            $res['res'] = 'false';
            $res['err'] = 'Email already exists';
        } else {
            $dbres = $this->merchants_model->update($mid);
            if ($dbres) {
                $res['res'] = 'true';
                $res['err'] = '';
            } else {
                $res['res'] = 'false';
                $res['err'] = 'Encountered problem updating your profile. Please try again!';
            }
        }
        echo json_encode($res);
        }else{
            echo json_encode([]);
        }
    }

    //change password
    public function api_change_password()
    {
        if(isset($_SESSION['merchant'])){
            $this->load->model('merchants_model');

        $mid = (int) ($_SESSION['merchant']['id']);

        $cpswd = $this->input->post('cpswd');
        $npswd = $this->input->post('npswd');
        $npswd2 = $this->input->post('npswd2');
        $epswd = ($this->merchants_model->get($mid))['pswd'];

        if ($cpswd == '' || $npswd == '' || $npswd2 == '') {
            $res['res'] = 'false';
            $res['err'] = 'All fields are required';
        } else if ($cpswd != $epswd) {
            $res['res'] = 'false';
            $res['err'] = 'Invalid current password';
        } else if (strlen($npswd) < 8) {
            $res['res'] = 'false';
            $res['err'] = 'New password must be up to eight(8) characters in length';
        } else if ($npswd == $epswd) {
            $res['res'] = 'false';
            $res['err'] = 'New password can\'t be the same with old password';
        } else if ($npswd != $npswd2) {
            $res['res'] = 'false';
            $res['err'] = 'New passwords don\'t match';
        } else {
            $dbres = $this->merchants_model->change_pswd($mid, $npswd);
            if ($dbres) {
                $res['res'] = 'true';
                $res['err'] = '';
            } else {
                $res['res'] = 'false';
                $res['err'] = 'Encountered a problem changing your password. Please try again!';
            }
        }
        echo json_encode($res);
        }else{
            echo json_encode([]);
        }
    }
    //=============================================================

    public function f_date($ts)
    {
        $date = date('F d, Y', (int) $ts);
        return $date;
    }

    //return view
    public function returnView($view, $data)
    {
        if (isset($_SESSION['merchant'])) {
            $this->load->model('admin_model');
            $data['admin']=$this->admin_model->get();
            $this->load->view('shared/merchants_header', $data);
            $this->load->view('merchants/' . $view, $data);
            $this->load->view('shared/merchants_footer', $data);
        } else {
            redirect(base_url('merchant'));
        }
    }
}
