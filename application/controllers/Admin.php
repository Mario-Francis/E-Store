<?php

class Admin extends CI_Controller
{
    //constructor
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library("pagination");
    }

    //login page
    public function index()
    {
        if(!isset($_SESSION['admin'])){
            $data['title'] = 'Admin Login';
            $this->load->view('admin/index', $data);
        }else{
            redirect(base_url('admin/home'));
        }
    }

    //home
    public function home()
    {
        if(isset($_SESSION['admin'])){
            $data['title'] = 'Admin Home';

        $this->load->model('customers_model');
        $this->load->model('products_model');
        $this->load->model('categories_model');
        $this->load->model('merchants_model');
        $this->load->model('orders_model');

        $crecent = $this->customers_model->get_recent();
        $data['crecent'] = $crecent;
        $precent = $this->products_model->get_recent();
        for ($i = 0; $i < count($precent); $i++) {
            $precent[$i]['cat'] = ($this->categories_model->get((int) $precent[$i]['cat_id']))['cat'];
            $precent[$i]['merchant'] = ($this->merchants_model->get((int) $precent[$i]['mid']))['mname'];
        }
        $data['precent'] = $precent;
        $orders = $this->orders_model->get_recent();
        for ($i = 0; $i < count($orders); $i++) {
            $orders[$i]['qty'] = (unserialize($orders[$i]['cart']))['qty'];
            $customer = $this->customers_model->get((int) $orders[$i]['cid']);
            $orders[$i]['cname'] = $customer['fname'] . ' ' . $customer['lname'];
        }
        $data['orders'] = $orders;

        $this->returnView('home', $data);
        }else{
            redirect(base_url('admin'));
        }
    }

    //create merchant
    public function create_merchant()
    {
        $data['title'] = 'Create Merchant';
        $data['jfile'] = 'create_merchant';

        $this->returnView('create_merchant', $data);
    }

    //view merchants
    public function view_merchants($page = 1)
    {
        if(isset($_SESSION['admin'])){
            $data['title'] = 'View Merchants';
        $data['jfile'] = 'view_merchants';

        $this->load->model('merchants_model');
        $merchants = $this->merchants_model->get_all();
        $res = $this->paginate($merchants, 'admin/view_merchants', 25, $page);
        $data['merchants'] = $res['data'];
        $data['links'] = $res['links'];
        $data['count'] = $res['count'];
        $this->returnView('view_merchants', $data);
        }else{
            redirect(base_url('admin'));
        }
    }

    //create category
    public function create_category()
    {
        $data['title'] = 'Create Category';
        $data['jfile'] = 'create_category';

        $this->returnView('create_category', $data);
    }

    //view categories
    public function view_categories($page = 1)
    {
        if(isset($_SESSION['admin'])){
            $data['title'] = 'Categories';
        $data['jfile'] = 'view_categories';

        $this->load->model('categories_model');
        $cats = $this->categories_model->get_all();
        $res = $this->paginate($cats, 'admin/view_categories', 25, $page);
        $data['cats'] = $res['data'];
        $data['links'] = $res['links'];
        $data['count'] = $res['count'];

        $this->returnView('view_categories', $data);
        }else{
            redirect(base_url('admin'));
        }
    }

    //view customers
    public function view_customers($page = 1)
    {
        if(isset($_SESSION['admin'])){
            $data['title'] = 'Customers';
        $data['jfile'] = 'view_customers';

        $this->load->model('customers_model');
        $customers = $this->customers_model->get_all();
        $res = $this->paginate($customers, 'admin/view_customers', 25, $page);
        $data['customers'] = $res['data'];
        $data['links'] = $res['links'];
        $data['count'] = $res['count'];

        $this->returnView('view_customers', $data);
        }else{
            redirect(base_url('admin'));
        }
    }

    //set percentage
    public function percentage()
    {
        if(isset($_SESSION['admin'])){
            $data['title'] = 'Set Percentage';
        $data['jfile'] = 'percentage';

        $this->load->model('percent_model');
        $rate = $this->percent_model->get();
        $data['rate'] = $rate['rate'];

        $this->returnView('percentage', $data);
        }else{
            redirect(base_url('admin'));
        }
    }

    //set pre-payment delivery discount percentage
    public function d_percentage()
    {
        if(isset($_SESSION['admin'])){
            $data['title'] = 'Set Delivery Percentage';
        $data['jfile'] = 'd_percentage';

        $this->load->model('percent_model');
        $rate = $this->percent_model->get_dpercent();
        $data['rate'] = $rate['rate'];

        $this->returnView('d_percentage', $data);
        }else{
            redirect(base_url('admin'));
        }
    }

    //set number of days for delivery
    public function d_days()
    {
        if(isset($_SESSION['admin'])){
            $data['title'] = 'Set Delivery Days';
        $data['jfile'] = 'd_days';

        $this->load->model('percent_model');
        $rate = $this->percent_model->get_days();
        $data['rate'] = $rate['rate'];

        $this->returnView('d_days', $data);
        }else{
            redirect(base_url('admin'));
        }
    }

    //change password
    public function change_password()
    {
        $data['title'] = 'Change Password';
        $data['jfile'] = 'change_password';

        $this->returnView('change_password', $data);
    }

    //edit profile
    public function edit_profile()
    {
        if(isset($_SESSION['admin'])){
            $data['title'] = 'Edit Profile';
        $data['jfile'] = 'edit_profile';

        $this->load->model('admin_model');
        $data['admin'] = $this->admin_model->get();

        $this->returnView('edit_profile', $data);
        }else{
            redirect(base_url('admin'));
        }
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
        $max = $max == 0 ? 1 : $max;
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
    //view products
    public function view_products($page = 1)
    {
        if(isset($_SESSION['admin'])){
            $data['title'] = 'Products';
        $data['jfile'] = 'a_view_products';

        $this->load->model('categories_model');
        $this->load->model('products_model');
        $this->load->model('percent_model');

        $data['cats'] = $this->categories_model->get_all();
        $products = $this->products_model->get_all();
        $rate = ($this->percent_model->get())['rate'];

        for ($i = 0; $i < count($products); $i++) {
            $products[$i]['cat'] = ($this->categories_model->get($products[$i]['cat_id']))['cat'];
            $products[$i]['price'] = number_format($products[$i]['cprice'], 2);
            $sprice = $products[$i]['cprice'] + (($rate / 100) * $products[$i]['cprice']);
            $products[$i]['sprice'] = number_format($sprice, 2);
            $products[$i]['date'] = $this->f_date($products[$i]['adate']);
        }
        //$data['products'] = $products;
        $res = $this->paginate($products, 'admin/api_get_cproducts', 20, $page);
        $data['products'] = $res['data'];
        $data['links'] = $res['links'];
        $data['count'] = $res['count'];

        $this->returnView('view_products', $data);
        }else{
            redirect(base_url('admin'));
        }
    }

    //view customer order records
    public function customer_records($cid = 0, $page = 1)
    {
        if(isset($_SESSION['admin'])){
            if ($cid != 0) {
                $data['title'] = 'Customer Records';
                $data['jfile'] = 'customer_records';
    
                $this->load->model('orders_model');
                $this->load->model('customers_model');
    
                $orders = $this->orders_model->get_by_customer($cid);
                $data['cname'] = $this->customers_model->get_name($cid);
                for ($i = 0; $i < count($orders); $i++) {
                    $orders[$i]['cart'] = unserialize($orders[$i]['cart']);
                }
                
                $res = $this->paginate($orders, 'admin/customer_records/' . $cid, 10, $page, 4);
                //print_r($orders);die();
                $data['orders'] = $res['data'];
                $data['links'] = $res['links'];
                $data['count'] = $res['count'];
    
                $this->returnView('customer_records', $data);
            } else {
                redirect(base_url('admin/view_customers'));
            }
        }else{
            redirect(base_url('admin'));
        }
    }

    //view orders
    public function orders($page = 1)
    {
        if(isset($_SESSION['admin'])){
            $data['title'] = 'Orders';
        $data['jfile'] = 'a_orders';

        $this->load->model('orders_model');
        $this->load->model('customers_model');

        $orders = $this->orders_model->get_all();
        for ($i = 0; $i < count($orders); $i++) {
            $orders[$i]['cart'] = unserialize($orders[$i]['cart']);
            $orders[$i]['cname'] = $this->customers_model->get_name($orders[$i]['cid']);
        }
        $res = $this->paginate($orders, 'admin/api_get_orders', 15, $page);
        $data['orders'] = $res['data'];
        $data['links'] = $res['links'];
        $data['count'] = $res['count'];

        $this->returnView('orders', $data);
        }else{
            redirect(base_url('admin'));
        }
    }

    //customer payments
    public function customer_payments($page = 1)
    {
        if(isset($_SESSION['admin'])){
            $data['title'] = 'Customer Payments';
        //$data['jfile'] = 'customer_payments';

        $this->load->model('payments_model');
        $this->load->model('customers_model');
        $this->load->model('orders_model');

        $payments = $this->payments_model->get_all();
        for ($i = 0; $i < count($payments); $i++) {
            $order = $this->orders_model->get($payments[$i]['oid']);
            $payments[$i]['cname'] = $this->customers_model->get_name($order['cid']);
            $payments[$i]['tid'] = $order['tid'];
            $payments[$i]['payid'] = $payments[$i]['pid'] == null ? '---' : $payments[$i]['pid'];
            $payments[$i]['amt'] = number_format($order['total'], 2);
        }
        $res = $this->paginate($payments, 'admin/customer_payments/', 25, $page);
        $data['payments'] = $res['data'];
        $data['links'] = $res['links'];
        $data['count'] = $res['count'];

        $this->returnView('customer_payments', $data);
        }else{
            redirect(base_url('admin'));
        }
    }

    //calculate amt to be paid or paid to a merchant for an order
    public function calc_m_amt($cart, $mid){
        $total=0;
        foreach($cart as $p){
            if(($this->products_model->get((int)$p['id']))['mid']==$mid){
                $total+=((float)$p['mprice'])*(int)$p['qty'];
            }
        }
        return array('mid'=>$mid, 'amt'=>$total);
    }
    public function mrec_exist($mrecs, $oid, $mid){
        $res=false;
        foreach($mrecs as $m){
            if($m['mid']==$mid && $m['oid']==$oid){
                $res=true;
            }
        }
        return $res;
    }
    //get payments to merchants record
    public function get_mpay($paid_orders){
        $this->load->model('merchants_pay_model');
        $this->load->model('merchants_model');
        $this->load->model('products_model');

        $mrecords=[];
        for($i=0;$i<count($paid_orders);$i++){
            $cart = unserialize($paid_orders[$i]['cart'])['cart'];
            foreach($cart as $p){
                $mid = (int)($this->products_model->get((int)$p['id']))['mid'];
                
                if($this->mrec_exist($mrecords, $paid_orders[$i]['id'], $mid)==false){
                    $temp = $this->calc_m_amt($cart, $mid);
                    $temp['oid']=$paid_orders[$i]['id'];
                    $temp['tid']=$paid_orders[$i]['tid'];
                    $temp['mname']=($this->merchants_model->get($mid))['mname'];
                    $temp['status']=$this->merchants_pay_model->is_exist($paid_orders[$i]['id'], $mid)?1:0;
                    $mrecords[]=$temp;
                }
            }
        }
        return $mrecords;
    }
    //payments and debts
    public function payments_to_merchants($page=1){
        if(isset($_SESSION['admin'])){
            $data['title'] = 'Payments to Merchants';
        $data['jfile'] = 'payments_to_merchants';

        $this->load->model('orders_model');

        $paid_orders = $this->orders_model->get_paid();
        $mrecords = $this->get_mpay($paid_orders);
        $res = $this->paginate($mrecords, 'admin/payments_to_merchants/', 25, $page);
        $data['records'] = $res['data'];
        $data['links'] = $res['links'];
        $data['count'] = $res['count'];
        //print_r($data['records']);
        $this->returnView('payments_to_merchants', $data);
        }else{
            redirect(base_url('admin'));
        }
    }
    //logout
    public function logout()
    {
        $this->session->unset_userdata('admin');
        redirect(base_url('admin/index'));
    }
    //=====================API===================================================
    //create merchants
    public function api_create_merchant()
    {
        if(isset($_SESSION['admin'])){
            $this->load->model('merchants_model');

        $mname = trim($this->input->post('mname'));
        $adres1 = trim($this->input->post('adres1'));
        $adres2 = trim($this->input->post('adres2'));
        $phno1 = trim($this->input->post('phno1'));
        $phno2 = trim($this->input->post('phno2'));
        $email = trim($this->input->post('email'));
        $pswd = $this->input->post('pswd');
        $cpswd = $this->input->post('cpswd');

        if ($mname == '' || $adres1 == '' || $phno1 == '' || $email == '' || $pswd == '' || $cpswd == '') {
            $res['res'] = 'false';
            $res['err'] = 'All relevant fields are required';
        } else if ($this->merchants_model->emailExists($email)) {
            $res['res'] = 'false';
            $res['err'] = 'Email already exists';
        } else if (strlen($pswd) < 8) {
            $res['res'] = 'false';
            $res['err'] = 'Password must be up to eight(8) characters in length';
        } else if ($pswd != $cpswd) {
            $res['res'] = 'false';
            $res['err'] = 'Passwords do not match';
        } else {
            $dbres = $this->merchants_model->create();
            if ($dbres) {
                $res['res'] = 'true';
                $res['err'] = '';
            } else {
                $res['res'] = 'false';
                $res['err'] = 'Encountered problem creating Merchant. Please try again!';
            }
        }
        echo json_encode($res);
        }else{
            echo json_encode([]);
        }
    }

    //get a merchant
    public function api_get_merchant()
    {
        if(isset($_SESSION['admin'])){
            $this->load->model('merchants_model');

        $mid = (int) $this->input->get('mid');
        $res['merch'] = $this->merchants_model->get($mid);
        echo json_encode($res);
        }else{
            echo json_encode([]);
        }
    }

    //flag merchant
    public function api_flag_merchant()
    {
        $this->load->model('merchants_model');
        $this->load->model('products_model');

        $mid = (int) $this->input->get('mid');
        $r = $this->merchants_model->update_status($mid, 1);
        if ($r) {
            $res['res'] = 'true';
            //flag all products for merchant
            $this->products_model->_update_astatus($mid, 1);
        } else {
            $res['res'] = 'false';
        }
        echo json_encode($res);
    }

    //unflag merchant
    public function api_unflag_merchant()
    {
        $this->load->model('merchants_model');
        $this->load->model('products_model');

        $mid = (int) $this->input->get('mid');
        $r = $this->merchants_model->update_status($mid, 0);
        if ($r) {
            $res['res'] = 'true';
            //unflag all products for merchant
            $this->products_model->_update_astatus($mid, 0);
        } else {
            $res['res'] = 'false';
        }
        echo json_encode($res);
    }

    //create category
    public function api_create_category()
    {
        if(isset($_SESSION['admin'])){
            $this->load->model('categories_model');

        $cat = trim($this->input->post('cat'));
        $dfee = trim($this->input->post('dfee'));
        $dmode = trim($this->input->post('dmode'));

        if ($cat == '') {
            $res['res'] = 'false';
            $res['err'] = 'Category name field is required';
        } else if ($this->categories_model->exists($cat)) {
            $res['res'] = 'false';
            $res['err'] = 'A category exists with same name';
        } else {
            $dbres = $this->categories_model->create();
            if ($dbres) {
                $res['res'] = 'true';
                $res['err'] = '';
            } else {
                $res['res'] = 'false';
                $res['err'] = 'Encountered problem creating Category. Please try again!';
            }
        }
        echo json_encode($res);
        }else{
            echo json_encode([]);
        }
    }

    //get single category
    public function api_get_category()
    {
        $this->load->model('categories_model');

        $cid = (int) $this->input->get('cid');
        $res['cat'] = $this->categories_model->get($cid);
        echo json_encode($res);
    }

    //get all categories
    public function api_get_categories()
    {
        $this->load->model('categories_model');

        $res['cats'] = $this->categories_model->get_all();
        echo json_encode($res);
    }

    //flag category
    public function api_flag_category()
    {
        $this->load->model('categories_model');

        $cid = (int) $this->input->get('cid');
        $r = $this->categories_model->update_status($cid, 1);
        if ($r) {
            $res['res'] = 'true';
        } else {
            $res['res'] = 'false';
        }
        echo json_encode($res);
    }

    //unflag category
    public function api_unflag_category()
    {
        $this->load->model('categories_model');

        $cid = (int) $this->input->get('cid');
        $r = $this->categories_model->update_status($cid, 0);
        if ($r) {
            $res['res'] = 'true';
        } else {
            $res['res'] = 'false';
        }
        echo json_encode($res);
    }

    //update category
    public function api_update_category()
    {
        $this->load->model('categories_model');

        $cat = trim($this->input->post('cat'));
        $cid = (int) $this->input->post('cid');
        $category = $this->categories_model->get($cid);

        if ($cat == '') {
            $res['res'] = 'false';
            $res['err'] = 'Category name field is required';
        } else if ($this->categories_model->exists($cat) && $cat != $category['cat']) {
            $res['res'] = 'false';
            $res['err'] = 'A category exists with same name';
        } else {
            $dbres = $this->categories_model->update();
            if ($dbres) {
                $res['res'] = 'true';
                $res['err'] = '';
            } else {
                $res['res'] = 'false';
                $res['err'] = 'Encountered problem creating Category. Please try again!';
            }
        }
        echo json_encode($res);
    }

    //get a customer
    public function api_get_customer()
    {
        $this->load->model('customers_model');

        $cid = (int) $this->input->get('cid');
        $customer = $this->customers_model->get($cid);
        $customer['fdate'] = $this->f_date($customer['rdate']);
        $res['customer'] = $customer;
        echo json_encode($res);
    }

    //flag customer
    public function api_flag_customer()
    {
        $this->load->model('customers_model');

        $cid = (int) $this->input->get('cid');
        $r = $this->customers_model->update_status($cid, 1);
        if ($r) {
            $res['res'] = 'true';
        } else {
            $res['res'] = 'false';
        }
        echo json_encode($res);
    }

    //unflag customer
    public function api_unflag_customer()
    {
        $this->load->model('customers_model');

        $cid = (int) $this->input->get('cid');
        $r = $this->customers_model->update_status($cid, 0);
        if ($r) {
            $res['res'] = 'true';
        } else {
            $res['res'] = 'false';
        }
        echo json_encode($res);
    }

    //get percentage
    public function api_get_percentage()
    {
        $this->load->model('percent_model');

        $rate = $this->percent_model->get();
        $res['rate'] = $rate;
        echo json_encode($res);
    }

    //get delivery percentage
    public function api_get_dpercentage()
    {
        $this->load->model('percent_model');

        $rate = $this->percent_model->get_dpercent();
        $res['rate'] = $rate;
        echo json_encode($res);
    }

    //get delivery days
    public function api_get_days()
    {
        $this->load->model('percent_model');

        $rate = $this->percent_model->get_days();
        $res['rate'] = $rate;
        echo json_encode($res);
    }

    //update percentage
    public function api_update_percentage()
    {
        $this->load->model('percent_model');

        $rate = trim($this->input->post('rate'));
        if ($rate == '') {
            $res['res'] = 'false';
            $res['err'] = 'Field cannot be left empty';
        } else if ((float) $rate > 100 || (float) $rate < 0) {
            $res['res'] = 'false';
            $res['err'] = 'Invalid input';
        } else {
            $dbres = $this->percent_model->update($rate);
            if ($dbres) {
                $res['res'] = 'true';
                $res['err'] = '';
            } else {
                $res['res'] = 'false';
                $res['err'] = 'Encountered a problem updating the percentage. Please try again!';
            }
        }
        echo json_encode($res);
    }

    //update delivery percentage
    public function api_update_dpercentage()
    {
        $this->load->model('percent_model');

        $rate = trim($this->input->post('rate'));
        if ($rate == '') {
            $res['res'] = 'false';
            $res['err'] = 'Field cannot be left empty';
        } else if ((float) $rate > 100 || (float) $rate < 0) {
            $res['res'] = 'false';
            $res['err'] = 'Invalid input';
        } else {
            $dbres = $this->percent_model->update_dpercent($rate);
            if ($dbres) {
                $res['res'] = 'true';
                $res['err'] = '';
            } else {
                $res['res'] = 'false';
                $res['err'] = 'Encountered a problem updating the delivery percentage. Please try again!';
            }
        }
        echo json_encode($res);
    }

    //update delivery days
    public function api_update_days()
    {
        $this->load->model('percent_model');

        $rate = trim($this->input->post('rate'));
        if ($rate == '') {
            $res['res'] = 'false';
            $res['err'] = 'Field cannot be left empty';
        } else if ((float) $rate > 30 || (float) $rate < 0) {
            $res['res'] = 'false';
            $res['err'] = 'Invalid input';
        } else {
            $dbres = $this->percent_model->update_days($rate);
            if ($dbres) {
                $res['res'] = 'true';
                $res['err'] = '';
            } else {
                $res['res'] = 'false';
                $res['err'] = 'Encountered a problem updating the delivery days. Please try again!';
            }
        }
        echo json_encode($res);
    }

    //login
    public function api_login()
    {
        $this->load->model('admin_model');

        $uname = trim($this->input->post('uname'));
        $pswd = $this->input->post('pswd');

        if ($uname == '' || $pswd == '') {
            $res['res'] = 'false';
            $res['err'] = 'Both fields are required';
        } else {
            $det = $this->admin_model->get();
            if ($uname != $det['uname'] || $pswd != $det['pswd']) {
                $res['res'] = 'false';
                $res['err'] = 'Invalid username/password';
            } else {
                $res['res'] = 'true';
                $res['err'] = '';
                $this->session->set_userdata('admin', 'admin');
            }
        }
        echo json_encode($res);
    }

    //change password
    public function api_change_password()
    {
        $this->load->model('admin_model');

        $cpswd = $this->input->post('cpswd');
        $npswd = $this->input->post('npswd');
        $npswd2 = $this->input->post('npswd2');
        $epswd = ($this->admin_model->get())['pswd'];

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
            $dbres = $this->admin_model->change_pswd($npswd);
            if ($dbres) {
                $res['res'] = 'true';
                $res['err'] = '';
            } else {
                $res['res'] = 'false';
                $res['err'] = 'Encountered a problem changing your password. Please try again!';
            }
        }
        echo json_encode($res);
    }

    //update profile
    public function api_update_profile()
    {
        $this->load->model('admin_model');
        $r = $this->admin_model->update_profile();
        if ($r) {
            $res['res'] = 'true';
        } else {
            $res['res'] = 'false';
            $res['err'] = 'Something went wrong! Encountered an error updating profile. Try again.';
        }
        echo json_encode($res);
    }

    //flag product
    public function api_flag_product()
    {
        $this->load->model('products_model');

        $pid = (int) $this->input->get('pid');
        $r = $this->products_model->update_astatus($pid, 1);
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
        $r = $this->products_model->update_astatus($pid, 0);
        if ($r) {
            $res['res'] = 'true';
        } else {
            $res['res'] = 'false';
        }
        echo json_encode($res);
    }

    //get a product
    public function api_get_product()
    {
        $this->load->model('categories_model');
        $this->load->model('products_model');
        $this->load->model('merchants_model');

        $pid = (int) $this->input->get('pid');
        $res = $this->products_model->get($pid);
        $res['cat'] = ($this->categories_model->get($res['cat_id']))['cat'];
        $res['fprice'] = number_format($res['cprice'], 2);
        $res['date'] = date('M d, Y', $res['adate']);
        $res['merchant'] = $this->merchants_model->get($res['mid']);
        echo json_encode($res);
    }

    //get products
    public function api_get_cproducts($page = 1)
    {
        $cid = (int) $this->input->get('cid');

        $this->load->model('categories_model');
        $this->load->model('products_model');
        $this->load->model('percent_model');

        if ($cid == 0) {
            $products = $this->products_model->get_all();
        } else {
            $products = $this->products_model->get_by_cat($cid);
        }
        $rate = ($this->percent_model->get())['rate'];

        for ($i = 0; $i < count($products); $i++) {
            $products[$i]['cat'] = ($this->categories_model->get($products[$i]['cat_id']))['cat'];
            $products[$i]['price'] = number_format($products[$i]['cprice'], 2);
            $sprice = $products[$i]['cprice'] + (($rate / 100) * $products[$i]['cprice']);
            $products[$i]['sprice'] = number_format($sprice, 2);
            $products[$i]['date'] = $this->f_date($products[$i]['adate']);
        }
        //$data['products'] = $products;
        $res = $this->paginate($products, 'admin/api_get_cproducts', 25, $page);
        $data['products'] = $res['data'];
        $data['links'] = $res['links'];
        $data['count'] = $res['count'];
        echo json_encode($data);
    }

    //get products
    public function api_get_csproducts($page = 1)
    {
        $cid = (int) $this->input->get('cid');
        $stxt = $this->input->get('stxt');
        if (trim($stxt) != '') {
            $this->load->model('categories_model');
            $this->load->model('products_model');
            $this->load->model('percent_model');
            $this->load->model('merchants_model');

            $products = $this->products_model->get_by_search($cid, $stxt);
            $rate = ($this->percent_model->get())['rate'];

            for ($i = 0; $i < count($products); $i++) {
                $products[$i]['cat'] = ($this->categories_model->get($products[$i]['cat_id']))['cat'];
                $products[$i]['price'] = number_format($products[$i]['cprice'], 2);
                $sprice = $products[$i]['cprice'] + (($rate / 100) * $products[$i]['cprice']);
                $products[$i]['sprice'] = number_format($sprice, 2);
                $products[$i]['date'] = $this->f_date($products[$i]['adate']);
            }
            //$data['products'] = $products;
            $res = $this->paginate($products, 'admin/api_get_csproducts', 25, $page);
            $data['products'] = $res['data'];
            $data['links'] = $res['links'];
            $data['count'] = $res['count'];
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function api_get_orders($page = 1)
    {
        $stxt = $this->input->get('stxt');
        if (trim($stxt) != '') {
            $this->load->model('orders_model');
            $this->load->model('customers_model');

            $orders = $this->orders_model->get_by_search($stxt);
            for ($i = 0; $i < count($orders); $i++) {
                $orders[$i]['cart'] = unserialize($orders[$i]['cart']);
                $orders[$i]['cname'] = $this->customers_model->get_name($orders[$i]['cid']);
                $orders[$i]['fdate']=date('M d, Y', $orders[$i]['odate']);
            }
            $res = $this->paginate($orders, 'admin/api_get_orders/', 15, $page);
            $data['orders'] = $res['data'];
            $data['links'] = $res['links'];
            $data['count'] = $res['count'];
            echo json_encode($data);
        } else {
            echo json_encode([]);
        }
    }

    //check if merchant exist in array
    public function m_exist($arr, $m)
    {
        $res = false;
        for ($i = 0; $i < count($arr); $i++) {
            if ($arr[$i]['id'] == $m['id']) {
                $res = $i;
                break;
            }
        }
        return $res;
    }

    //get single order
    public function api_get_order()
    {
        $oid = (int) $this->input->get('oid');
        $this->load->model('orders_model');
        $this->load->model('customers_model');
        $this->load->model('merchants_model');
        $this->load->model('products_model');

        $order = $this->orders_model->get($oid);
        $order['fdiscount'] = number_format($order['discount'], 2);
        $order['fvat'] = number_format($order['vat'], 2);
        $order['customer'] = $this->customers_model->get($order['cid']);

        $merchants = [];
        $cart = unserialize($order['cart'])['cart'];
        foreach ($cart as $p) {
            $mid = ($this->products_model->get($p['id']))['mid'];
            $m = $this->merchants_model->get($mid);
            //$m['pname']=$p['pname'];
            $k = $this->m_exist($merchants, $m);
            //echo 'Key = '.$k;
            if ($k === false) {
                $m['pnames'][] = $p['pname'];
                $merchants[] = $m;
                //echo 'Key = '.$k;
            } else {
                $merchants[$k]['pnames'][] = $p['pname'];
            }
        }
        $order['merchants'] = $merchants;
        echo json_encode($order);
    }

    //update order payment status
    public function api_update_pstatus()
    {
        $oid = (int) $this->input->post('oid');
        $status = (int) $this->input->post('status');

        $this->load->model('orders_model');
        $this->load->model('payments_model');

        $order = $this->orders_model->get($oid);
        $r = $this->orders_model->update_pstatus($oid, $status);
        if ($r) {
            if ($status == 0) {
                //remove from payment table
                $this->payments_model->delete($oid);
            } else {
                $method = $order['method'] == 0 ? 'paystack' : ($order['method'] == 1 ? 'transfer' : 'delivery');
                $this->payments_model->add($oid, null, $method, 1);
            }
            $res['res'] = 'true';
        } else {
            $res['res'] = 'false';
        }
        echo json_encode($res);
    }

    //update order delivery status
    public function api_update_dstatus()
    {
        $oid = (int) $this->input->post('oid');
        $status = (int) $this->input->post('status');

        $this->load->model('orders_model');
        $r = $this->orders_model->update_dstatus($oid, $status);
        if ($r) {
            $res['res'] = 'true';
        } else {
            $res['res'] = 'false';
        }
        echo json_encode($res);
    }

    //update order status
    public function api_update_status()
    {
        $oid = (int) $this->input->post('oid');
        $status = (int) $this->input->post('status');

        $this->load->model('orders_model');
        $r = $this->orders_model->update_status($oid, $status);
        if ($r) {
            $res['res'] = 'true';
        } else {
            $res['res'] = 'false';
        }
        echo json_encode($res);
    }

    //mark debt to merchant paid (1) or unpaid (0)
    public function api_mpay(){
        $oid = (int) $this->input->post('oid');
        $mid = (int) $this->input->post('mid');
        $amt = (float) $this->input->post('amt');
        $status = (int) $this->input->post('status');
        $this->load->model('merchants_pay_model');

        if($status==0){
            $r = $this->merchants_pay_model->delete($oid, $mid);
        }else{
            $r = $this->merchants_pay_model->add($oid, $mid, $amt);
        }
        if($r){
            $res['res']='true';
        }else{
            $res['res']='false';
        }
        echo json_encode($res);
    }

    //get payment to merchant info
    public function api_get_mpayments(){
        $oid = (int) $this->input->get('oid');
        $mid = (int) $this->input->get('mid');

        $this->load->model('orders_model');
        $this->load->model('merchants_model');
        $this->load->model('products_model');

        $order = $this->orders_model->get((int)$oid);
        $merchant = $this->merchants_model->get((int)$mid);

        $cart = (unserialize($order['cart']))['cart'];
        $mcart=[];
        $total=0;
        foreach($cart as $p){
            $_mid = ($this->products_model->get((int)$p['id']))['mid'];
            if($mid==$_mid){
                $p['stotal'] = (float)$p['mprice'] * (int)$p['qty'];
                $total += $p['stotal'];
                $p['fstotal']=number_format($p['stotal'], 2);
                $p['fmprice']=number_format($p['mprice'], 2);
                $mcart[]=$p;
            }
        }
        $data['total']=number_format($total, 2);
        $data['merchant']=$merchant;
        $data['cart']=$mcart;
        echo json_encode($data);
    }
    //=============================================================

    public function f_date($ts)
    {
        $date = date('F d, Y', (int) $ts);
        return $date;
    }
    public function test()
    {
        $this->load->view('admin/test');
    }
    //return view
    public function returnView($view, $data)
    {
        if (isset($_SESSION['admin'])) {
            $this->load->model('admin_model');
            $data['admin']=$this->admin_model->get();
            $this->load->view('shared/admin_header', $data);
            $this->load->view('admin/' . $view, $data);
            $this->load->view('shared/admin_footer', $data);
        } else {
            redirect(base_url('admin'));
        }
    }
}
