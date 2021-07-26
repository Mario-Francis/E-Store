<?php
// ini_set('max_execution_time', 120);
class Customers extends CI_Controller
{
    //constructor
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        //$this->load->library('session');
        $this->load->library('cart');
        $this->load->library("pagination");
    }

    //home, login and signup
    public function index()
    {
        //unset($_SESSION['c_det']);
        $data['title'] = 'Home';
        $data['jfile'] = 'basket';
        $data['jfile2'] = 'customer_signup_login';
        $data['jfile3'] = 'jquery.matchHeight';
        $data['jfile4'] = 'home';

        $this->load->model('categories_model');
        $this->load->model('products_model');
        $this->load->model('images_model');
        $this->load->model('ratings_model');

        //recently added products
        $prods = $this->products_model->r_get_all(18);
        $prods = $this->get_array_price($prods); //set sale price

        foreach ($prods as $p) {
            if (!$this->categories_model->is_flagged($p['cat_id'])) {
                $p['fpprice'] = number_format($p['pprice'], 2);
                $p['fcprice'] = number_format($p['cprice'], 2);
                $p['cat'] = $this->categories_model->get((int) $p['cat_id']);
                $p['data'] = urlencode(json_encode($p));
                $p['image'] = $this->images_model->get($p['id'])[0];
                $p['rating'] = $this->ratings_model->get($p['id']);
                $r_products[] = $p;
            }
        }
        $data['r_products'] = $r_products;
        $data['r_count'] = $this->products_model->get_all_count(0);

        //get special offers
        $s_products = [];
        $prods = $this->products_model->s_get_all(18);
        $prods = $this->get_array_price($prods); //set sale price

        foreach ($prods as $p) {
            if (!$this->categories_model->is_flagged($p['cat_id'])) {
                $p['fpprice'] = number_format($p['pprice'], 2);
                $p['fcprice'] = number_format($p['cprice'], 2);
                $p['cat'] = $this->categories_model->get((int) $p['cat_id']);
                $p['data'] = urlencode(json_encode($p));
                $p['image'] = $this->images_model->get($p['id'])[0];
                $p['rating'] = $this->ratings_model->get($p['id']);
                $s_products[] = $p;
            }
        }
        $data['s_products'] = $s_products;
        $data['s_count'] = $this->products_model->get_all_count(1);

        //get most picked products
        $prods = $this->get_most_picked();
        $prods = $this->get_array_price($prods); //set sale price

        foreach ($prods as $p) {
            if (!$this->categories_model->is_flagged($p['cat_id'])) {
                $p['fpprice'] = number_format($p['pprice'], 2);
                $p['fcprice'] = number_format($p['cprice'], 2);
                $p['cat'] = $this->categories_model->get((int) $p['cat_id']);
                $p['data'] = urlencode(json_encode($p));
                $p['image'] = $this->images_model->get($p['id'])[0];
                $p['rating'] = $this->ratings_model->get($p['id']);
                $m_products[] = $p;
            }
        }
        $data['m_products'] = $this->get_page_data($m_products, 18, 0);
        $data['m_count'] = count($prods);
        //get cart
        $data['cart'] = urlencode(json_encode($this->get_basket()));
        $data['cats'] = $this->categories_model->_get_all();

        $this->returnView('index', $data);
    }

    //get how long a merchant has been selling on the platform
    public function get_how_long($rt)
    {
        $ct = time();
        $rt = (int) $rt;
        //current date
        $cy = date('Y', $ct);
        $cm = date('m', $ct);
        $cd = date('d', $ct);
        //registered date
        $ry = date('Y', $rt);
        $rm = date('m', $rt);
        $rd = date('d', $rt);
        $date1 = date_create($cy . '-' . $cm . '-' . $cd);
        $date2 = date_create($ry . '-' . $rm . '-' . $rd);
        $diff = date_diff($date1, $date2);
        $dy = $diff->y;
        $dm = $diff->m;
        $dd = $diff->d;

        if ($dy != 0) {
            return ($dy == 1) ? $dy . ' year' : $dy . ' years';
        } else if ($dm != 0) {
            return ($dm == 1) ? $dm . ' month' : $dm . ' months';
        } else if ($dd != 0) {
            return ($dd == 1) ? $dd . ' day' : $dd . ' days';
        } else {
            return '';
        }
    }

    //view product details
    public function product($pid = 0)
    {
        //echo $pid;die();
        if ($pid != 0) {
            $pid = (int) $pid;
            $this->load->model('categories_model');
            $this->load->model('products_model');
            $this->load->model('images_model');
            $this->load->model('merchants_model');
            $this->load->model('percent_model');
            $this->load->model('ratings_model');

            $product = $this->products_model->get($pid);
            $product = $this->get_price($product); //set sale price
            //print_r($product);die();
            if (count($product) > 0) {
                if (!($this->categories_model->is_flagged($product['cat_id']) || $this->products_model->is_flagged($product['id']))) {
                    $product['fpprice'] = number_format($product['pprice'], 2);
                    $product['fcprice'] = number_format($product['cprice'], 2);
                    $product['cat'] = $this->categories_model->get((int) $product['cat_id']);
                    $product['data'] = urlencode(json_encode($product));
                    $product['images'] = $this->images_model->get($pid);
                    $product['merchant'] = $this->merchants_model->get((int) $product['mid']);
                    $product['how_long'] = $this->get_how_long((int) $product['merchant']['rdate']);
                    $product['days'] = $this->percent_model->get_days();
                    $product['dpercent'] = $this->percent_model->get_dpercent();
                    $product['rating'] = $this->ratings_model->get((int) $product['id']);
                    $product['suc'] = $this->get_ssale((int) $product['mid']);
                    if (isset($_SESSION['c_det'])) {
                        $product['login']['status'] = 'true';
                    } else {
                        $product['login']['status'] = 'false';
                    }

                    $data['title'] = $product['pname'];
                    $data['jfile'] = 'basket';
                    $data['jfile2'] = 'customer_signup_login';
                    $data['jfile3'] = 'product';
                    //$data['jfile4'] = 'mdb.min';
                    $data['product'] = $product;

                    //get cart
                    $data['cart'] = urlencode(json_encode($this->get_basket()));
                    $data['cats'] = $this->categories_model->_get_all();

                    $this->returnView('product', $data);
                } else {
                    redirect(base_url('customers'));
                }
            } else {
                redirect(base_url('customers'));
            }
        } else {
            redirect(base_url('customers'));
        }
    }

    //get cart
    public function get_cart()
    {
        $cart = $this->cart->contents(true);
        $ca = [];
        foreach ($cart as $id => $c) {
            $c['fsub'] = number_format($c['subtotal'], 2);
            $ca[] = $c;
        }
        return $ca;
    }

    //get basket
    public function get_basket()
    {
        $res['cart'] = $this->get_cart();
        $res['qty'] = $this->cart->total_items();
        $res['total'] = number_format($this->cart->total(), 2);
        return $res;
    }

    //view cart
    public function my_cart()
    {
        $data['title'] = 'My Cart';
        $data['jfile2'] = 'customer_signup_login';
        $data['jfile3'] = 'my_cart';

        $data['mcart'] = $this->get_basket();
        $this->load->model('categories_model');
        $data['cats'] = $this->categories_model->_get_all();

        $this->returnView('my_cart', $data);
    }

    //checkout
    public function checkout()
    {
        $mcart = $this->get_basket();
        if (isset($_SESSION['c_det']) && $mcart['qty'] > 0) {
            $data['title'] = 'Checkout';
            $data['jfile'] = 'checkout';
            $data['hide_search'] = 'true';
            $data['mcart'] = $this->get_basket();
            if ($data['mcart']['qty'] != 0) {

                $this->load->model('customers_model');
                $this->load->model('products_model');
                $this->load->model('categories_model');

                //get customer address
                $c_id = $_SESSION['c_det']['c_id'];
                $data['adres'] = $this->customers_model->get_adres($c_id);

                //get product delivery details -delivery fee and delivery mode
                $mode = 0;
                $total = 0;
                $tdfee = 0;
                foreach ($data['mcart']['cart'] as $p) {
                    $cat_id = (int) $this->products_model->get($p['id'])['cat_id'];
                    $cat = $this->categories_model->get($cat_id);
                    $p['dfee'] = $cat['dfee'] * $p['qty'];
                    $p['fdfee'] = number_format($p['dfee'], 2);
                    //echo $cat['dmode'];
                    $mode = $mode || (int) $cat['dmode'];
                    $tdfee += $p['dfee'];
                    $p['subtotal'] += $p['dfee'];
                    $p['fsub'] = number_format($p['subtotal'], 2);
                    $p['fprice'] = number_format($p['price'], 2);
                    $total += $p['subtotal'];
                    $cart[] = $p;
                }
                $data['mcart']['cart'] = $cart;
                $data['mcart']['total'] = $total;
                $data['mcart']['ftotal'] = number_format($total, 2);
                $data['mcart']['tdfee'] = $tdfee;
                if ($mode == 1) {
                    $data['mcart']['mode'] = 'true';
                } else {
                    $data['mcart']['mode'] = 'false';
                }
                $data['cats'] = $this->categories_model->_get_all();

                $this->session->set_userdata('temp_cart', $data['mcart']);
                $this->session->mark_as_temp('temp_cart', 21600);

                $this->returnView('checkout', $data);
            } else {
                redirect(base_url('customers/my_cart'));
            }
        } else {
            redirect(base_url('customers/my_cart'));
        }
    }

    public function send_paid_invoice_mail($oid)
    {
        $this->load->model('orders_model');
        $this->load->model('percent_model');
        $this->load->model('admin_model');
        $this->load->model('customers_model');

        $order = $this->orders_model->get((int) $oid);
        $this->orders_model->update_pstatus((int) $oid, 1);
        $mcart = unserialize($order['cart']);

        //admin details
        $admin = $this->admin_model->get();

        //get customer mobile
        $customer = $this->customers_model->get($order['cid']);
        $cphno = $customer['phno'];
        $cemail = $customer['email'];
        $cfname = $customer['fname'];

        $data['mcart'] = $mcart;
        $data['tid'] = $order['tid'];
        $data['method'] = $order['method'];
        $data['adres'] = $order['adres'];
        $data['discount'] = $order['discount'];
        $data['fdiscount'] = number_format($order['discount'], 2);
        $data['vat'] = $order['vat'];
        $data['fvat'] = number_format($order['vat'], 2);
        $data['total'] = $order['total'];
        $data['amt'] = round($order['total'], 2) * 100;
        $data['ftotal'] = number_format($order['total'], 2);
        $data['admin'] = $admin;
        $data['cphno'] = $cphno;
        $data['cemail'] = $cemail;
        $data['cfname'] = $cfname;
        $data['pstatus'] = 1;
        $data['days'] = $this->percent_model->get_days()['rate'];

        //generate pdf and send mail
        $msg = $this->load->view('customers/pmail_msg', $data, true); //html message
        $pdf_data = $this->load->view('customers/pdf_invoice', $data, true); //html invoice

        // Load pdf library
        $this->load->library('pdf');
        // Load HTML content
        $this->dompdf->loadHtml($pdf_data);
        // (Optional) Setup the paper size and orientation
        $this->dompdf->setPaper('A4', 'portrait');
        // Render the HTML as PDF
        $this->dompdf->render();
        //get rendered pdf data
        $output = $this->dompdf->output();

        $this->load->library('email');
        // $config['newline'] = "\r\n";
        // $config['charset'] = 'utf-8';
        // $config['wordwrap'] = true;
        // $config['smtp_timeout'] = 60;
        // $config['mailtype'] = 'html';
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'mail.mariofrancis.com.ng';
        $config['smtp_user'] = 'no_reply@mariofrancis.com.ng';
        $config['smtp_pass'] = '****';
        $config['smtp_port'] = 465;
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['smtp_crypto'] = 'ssl';
        $config['wordwrap'] = true;
        $config['newline'] = "\r\n";

        $this->email->initialize($config);

        $this->email->from('no_reply@mariofrancis.com.ng', 'Ex-Gstores <No Reply>', 'no_reply@mariofrancis.com.ng');
        $this->email->reply_to('no_reply@exgstores.com', 'Ex-Gstores');
        $this->email->to($cemail);
        //$this->email->cc($cemail);
        //$this->email->bcc('mariofrancis80@gmail.com');

        $this->email->subject('Payment Invoice');
        $this->email->message($msg);

        $this->email->set_header('From', 'Ex-Gstores <no_reply@mariofrancis.com.ng>');
        $this->email->set_header('X-Sender', 'Ex-Gstores <no_reply@mariofrancis.com.ng>');

        //attach file
        //$this->email->attach('./pdfs/invoice.pdf');
        $this->email->attach($output, '', 'invoice.pdf', 'application/pdf');

        try {
            if (!$this->email->send()) {
                //print error msg
                //echo $this->email->print_debugger();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function generate_invoice()
    {
        $this->load->model('percent_model');
        $this->load->model('admin_model');
        $this->load->model('customers_model');
        $this->load->model('orders_model');
        $this->load->model('percent_model');

        $data['mcart'] = $_SESSION['temp_cart'];
        $mcart = $_SESSION['temp_cart'];
        //echo json_encode($data['mcart']);
        $str_cart = serialize($data['mcart']);
        $cid = (int) $_SESSION['c_det']['c_id'];
        $tid = $this->gen_transaction_id(); //tid
        $method = $this->get_pay_method_code($mcart['pay_mode']);
        $adres = $mcart['adres'];
        //calculate discount
        $rate = $this->percent_model->get_dpercent()['rate'];
        $damt = $mcart['tdfee'] * ($rate / 100);
        $discount = $mcart['mode'] == 'true' ? 0 : ($method == 2 ? 0 : $damt);
        //calculate vat
        if ($method == 0) {
            $cvat = ($mcart['total'] - $discount) * (1.5 / 100);
            $vat = ($mcart['total'] - $discount) < 2500 ? $cvat : ($cvat + 100 > 2000 ? 2000 : $cvat + 100);
        } else {
            $vat = 0.00;
        }
        //calculate total
        $total = ($mcart['total'] - $discount) + $vat;

        //admin details
        $admin = $this->admin_model->get();

        //get customer mobile
        $customer = $this->customers_model->get($cid);
        $cphno = $customer['phno'];
        $cemail = $customer['email'];
        $cfname = $customer['fname'];

        $data['tid'] = $tid;
        $data['method'] = $method;
        $data['adres'] = $adres;
        $data['discount'] = $discount;
        $data['fdiscount'] = number_format($discount, 2);
        $data['vat'] = $vat;
        $data['fvat'] = number_format($vat, 2);
        $data['total'] = $total;
        $data['amt'] = round($total, 2) * 100;
        $data['ftotal'] = number_format($total, 2);
        $data['admin'] = $admin;
        $data['cphno'] = $cphno;
        $data['cemail'] = $cemail;
        $data['cfname'] = $cfname;
        $data['pstatus'] = 0;
        $data['days'] = $this->percent_model->get_days()['rate'];
        $oid = 0;
        //insert into orders table
        $r = $this->orders_model->add($cid, $tid, $str_cart, $discount, $vat, $total, $adres, $method);
        //$r['res']=true;
        if ($r['res']) {
            $oid = $r['id'];
            $data['oid'] = $oid;
            //generate pdf and send mail
            $msg = $this->load->view('customers/mail_msg', $data, true); //html message
            $pdf_data = $this->load->view('customers/pdf_invoice', $data, true); //html invoice

            //die();

            // Load pdf library
            $this->load->library('pdf');
            // Load HTML content
            $this->dompdf->loadHtml($pdf_data);
            // (Optional) Setup the paper size and orientation
            $this->dompdf->setPaper('A4', 'portrait');
            // Render the HTML as PDF
            $this->dompdf->render();
            //get rendered pdf data
            $output = $this->dompdf->output();

            //send mail
            $this->load->library('email');
            // $config['newline'] = "\r\n";
            // $config['charset'] = 'utf-8';
            // $config['wordwrap'] = true;
            // $config['smtp_timeout'] = 60;
            // $config['mailtype'] = 'html';
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'mail.mariofrancis.com.ng';
            $config['smtp_user'] = 'no_reply@mariofrancis.com.ng';
            $config['smtp_pass'] = '***';
            $config['smtp_port'] = 465;
            $config['mailtype'] = 'html';
            $config['charset'] = 'utf-8';
            $config['smtp_crypto'] = 'ssl';
            $config['wordwrap'] = true;
            $config['newline'] = "\r\n";

            $this->email->initialize($config);

            $this->email->from('no_reply@mariofrancis.com.ng', 'Ex-Gstores <No Reply>', 'no_reply@mariofrancis.com.ng');
            $this->email->reply_to('no_reply@mariofrancis.com.ng', 'Ex-Gstores');
            $this->email->to($cemail);
            //$this->email->cc($cemail);
            //$this->email->bcc('mariofrancis80@gmail.com');

            $this->email->subject('Payment Invoice');
            $this->email->message($msg);

            $this->email->set_header('From', 'Ex-Gstores <no_reply@mariofrancis.com.ng>');
            $this->email->set_header('X-Sender', 'Ex-Gstores <no_reply@mariofrancis.com.ng>');

            //attach file
            //$this->email->attach('./pdfs/invoice.pdf');
            $this->email->attach($output, '', 'invoice.pdf', 'application/pdf');

            try {
                if (!$this->email->send()) {
                    //print error msg
                    //echo $this->email->print_debugger();
                }
            } catch (Exception $e) {
            } finally {
                //clear cart
                $this->cart->destroy();
                //clear temp_session
                $this->session->unset_userdata('temp_cart');
                //delete pdf
                $this->delete_file('./pdfs/invoice.pdf');
                $this->session->set_userdata('invoice', $data);
                $this->session->mark_as_temp('invoice', 300);
            }
        } else {
            $this->session->set_userdata('c_err', 'Encountered an error placing your order! Please try again.');
            $this->session->mark_as_flash('c_err');
        }
    }
    //invoice
    public function invoice()
    {
        if (isset($_SESSION['c_det']) && isset($_SESSION['invoice'])) {
            $data = $_SESSION['invoice'];
            $data['title'] = 'Invoice';
            $data['jfile'] = 'jquery.PrintArea';
            $data['jfile2'] = 'invoice';
            $data['hide_search'] = 'true';

            $this->returnView('invoice', $data);
        } else {
            redirect(base_url('customers/my_cart'));
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
        $config['reuse_query_string'] = true;

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

    //search
    public function search($page = 1)
    {
        $data['title'] = 'Search Products or Categories';
        $data['jfile'] = 'basket';
        $data['jfile2'] = 'customer_signup_login';
        $data['jfile3'] = 'jquery.matchHeight';
        $data['jfile4'] = 'home';

        $this->load->model('categories_model');
        $this->load->model('products_model');
        $this->load->model('images_model');
        $this->load->model('ratings_model');

        if ($this->input->get('searchtxt') != null) {
            $stxt = trim($this->input->get('searchtxt'));
        } else {
            $stxt = '';
        }

        $results = [];
        if ($stxt != '') {
            $prods = $this->products_model->get_search($stxt);
            $prods = $this->get_array_price($prods); //set sale price

            foreach ($prods as $p) {
                if (!$this->categories_model->is_flagged($p['cat_id'])) {
                    $p['fpprice'] = number_format($p['pprice'], 2);
                    $p['fcprice'] = number_format($p['cprice'], 2);
                    $p['cat'] = $this->categories_model->get((int) $p['cat_id']);
                    $p['data'] = urlencode(json_encode($p));
                    $p['image'] = $this->images_model->get($p['id'])[0];
                    $p['rating'] = $this->ratings_model->get($p['id']);
                    $results[] = $p;
                }
            }
        }
        $res = $this->paginate($results, 'search', 24, $page, 2);
        $data['results'] = $res['data'];
        $data['links'] = $res['links'];
        $data['count'] = $res['count'];
        //get cart
        $data['cart'] = urlencode(json_encode($this->get_basket()));
        $data['cats'] = $this->categories_model->_get_all();

        $this->returnView('search', $data);
    }

    //check if pid exist in array
    public function pid_exist($arr, $pid)
    {
        $res = false;
        for ($i = 0; $i < count($arr); $i++) {
            if ((int) $arr[$i][0] == $pid) {
                $res = $i;
                break;
            }
        }
        return $res;
    }

    public function desc($arr)
    {
        for ($i = 0; $i < count($arr) - 1; $i++) {
            for ($j = 0; $j < count($arr) - 1; $j++) {
                if ($arr[$j + 1][1] > $arr[$j][1]) {
                    $temp = $arr[$j + 1];
                    $arr[$j + 1] = $arr[$j];
                    $arr[$j] = $temp;
                }
            }
        }
        return $arr;
    }

    //get most picked items
    public function get_most_picked()
    {
        $this->load->model('orders_model');
        $this->load->model('products_model');
        $orders = $this->orders_model->get_all();

        $pids = [];
        foreach ($orders as $o) {
            $cart = unserialize($o['cart'])['cart'];
            foreach ($cart as $p) {
                $r = $this->pid_exist($pids, (int) $p['id']);
                if ($r === false) {
                    $pids[] = array((int) $p['id'], 1);
                } else {
                    $pids[$r][1]++;
                }
            }
        }
        $pids = $this->desc($pids);
        $products = [];
        foreach ($pids as $p) {
            $prod = $this->products_model->get($p[0]);
            $products[] = $prod;
        }
        return $products;
    }

    //recently added products
    public function recently_added($page = 1)
    {
        $data['title'] = 'Recently Added Products';
        $data['jfile'] = 'basket';
        $data['jfile2'] = 'customer_signup_login';
        $data['jfile3'] = 'jquery.matchHeight';
        $data['jfile4'] = 'home';

        $this->load->model('categories_model');
        $this->load->model('products_model');
        $this->load->model('images_model');
        $this->load->model('ratings_model');

        $prods = $this->products_model->r_get_all(50);
        $prods = $this->get_array_price($prods); //set sale price
        $products = [];
        foreach ($prods as $p) {
            if (!$this->categories_model->is_flagged($p['cat_id'])) {
                $p['fpprice'] = number_format($p['pprice'], 2);
                $p['fcprice'] = number_format($p['cprice'], 2);
                $p['cat'] = $this->categories_model->get((int) $p['cat_id']);
                $p['data'] = urlencode(json_encode($p));
                $p['image'] = $this->images_model->get($p['id'])[0];
                $p['rating'] = $this->ratings_model->get($p['id']);
                $products[] = $p;
            }
        }
        //print_r($products);die();
        $res = $this->paginate($products, 'recently_added', 24, $page, 2);
        $data['products'] = $res['data'];
        $data['links'] = $res['links'];
        $data['count'] = $res['count'];
        //get cart
        $data['cart'] = urlencode(json_encode($this->get_basket()));
        $data['cats'] = $this->categories_model->_get_all();

        $this->returnView('recently_added', $data);
    }

    //special offers
    public function special_offers($page = 1)
    {
        $data['title'] = 'Special Offers';
        $data['jfile'] = 'basket';
        $data['jfile2'] = 'customer_signup_login';
        $data['jfile3'] = 'jquery.matchHeight';
        $data['jfile4'] = 'home';

        $this->load->model('categories_model');
        $this->load->model('products_model');
        $this->load->model('images_model');
        $this->load->model('ratings_model');

        $prods = $this->products_model->s_get_all(50);
        $prods = $this->get_array_price($prods); //set sale price
        $products = [];
        foreach ($prods as $p) {
            if (!$this->categories_model->is_flagged($p['cat_id'])) {
                $p['fpprice'] = number_format($p['pprice'], 2);
                $p['fcprice'] = number_format($p['cprice'], 2);
                $p['cat'] = $this->categories_model->get((int) $p['cat_id']);
                $p['data'] = urlencode(json_encode($p));
                $p['image'] = $this->images_model->get($p['id'])[0];
                $p['rating'] = $this->ratings_model->get($p['id']);
                $products[] = $p;
            }
        }
        //print_r($products);die();
        $res = $this->paginate($products, 'special_offers', 24, $page, 2);
        $data['products'] = $res['data'];
        $data['links'] = $res['links'];
        $data['count'] = $res['count'];
        //get cart
        $data['cart'] = urlencode(json_encode($this->get_basket()));
        $data['cats'] = $this->categories_model->_get_all();

        $this->returnView('special_offers', $data);
    }

    //most picked items
    public function most_picked($page = 1)
    {
        $data['title'] = 'Most Picked';
        $data['jfile'] = 'basket';
        $data['jfile2'] = 'customer_signup_login';
        $data['jfile3'] = 'jquery.matchHeight';
        $data['jfile4'] = 'home';

        $this->load->model('categories_model');
        $this->load->model('products_model');
        $this->load->model('images_model');
        $this->load->model('ratings_model');

        $prods = $this->get_most_picked();
        $prods = $this->get_array_price($prods); //set sale price
        $products = [];
        foreach ($prods as $p) {
            if (!$this->categories_model->is_flagged($p['cat_id'])) {
                $p['fpprice'] = number_format($p['pprice'], 2);
                $p['fcprice'] = number_format($p['cprice'], 2);
                $p['cat'] = $this->categories_model->get((int) $p['cat_id']);
                $p['data'] = urlencode(json_encode($p));
                $p['image'] = $this->images_model->get($p['id'])[0];
                $p['rating'] = $this->ratings_model->get($p['id']);
                $products[] = $p;
            }
        }
        //print_r($products);die();
        $res = $this->paginate($products, 'most_picked', 24, $page, 2);
        $data['products'] = $res['data'];
        $data['links'] = $res['links'];
        $data['count'] = $res['count'];
        //get cart
        $data['cart'] = urlencode(json_encode($this->get_basket()));
        $data['cats'] = $this->categories_model->_get_all();

        $this->returnView('most_picked', $data);
    }

    //orders
    public function my_orders($page = 1)
    {
        if (isset($_SESSION['c_det'])) {
            $data['title'] = 'My Orders';
            $data['jfile'] = 'basket';
            $data['jfile2'] = 'customer_signup_login';
            //$data['jfile3'] = 'jquery.matchHeight';
            $data['jfile3'] = 'my_orders';
            $data['hide_search'] = 'true';

            $this->load->model('orders_model');
            $this->load->model('categories_model');

            $cid = (int) $_SESSION['c_det']['c_id'];
            $orders = $this->orders_model->get_by_customer($cid);
            for ($i = 0; $i < count($orders); $i++) {
                $orders[$i]['cart'] = unserialize($orders[$i]['cart']);
            }
            $res = $this->paginate($orders, 'api_get_orders', 15, $page, 2);
            $data['orders'] = $res['data'];
            $data['links'] = $res['links'];
            $data['count'] = $res['count'];

            $data['cart'] = urlencode(json_encode($this->get_basket()));
            $data['cats'] = $this->categories_model->_get_all();

            $this->returnView('my_orders', $data);
        } else {
            redirect(base_url());
        }
    }

    //my profile
    public function my_profile()
    {
        if (isset($_SESSION['c_det'])) {
            $data['title'] = 'My Orders';
            $data['jfile'] = 'basket';
            $data['jfile2'] = 'customer_signup_login';
            $data['jfile3'] = 'my_profile';
            $data['hide_search'] = 'true';

            $this->load->model('customers_model');
            $this->load->model('categories_model');

            $cid = (int) $_SESSION['c_det']['c_id'];
            $data['customer'] = $this->customers_model->get($cid);

            $data['cart'] = urlencode(json_encode($this->get_basket()));
            $data['cats'] = $this->categories_model->_get_all();

            $this->returnView('my_profile', $data);
        } else {
            redirect(base_url());
        }
    }

    //change password
    public function change_password()
    {
        if (isset($_SESSION['c_det'])) {
            $data['title'] = 'Change Password';
            $data['jfile'] = 'basket';
            $data['jfile2'] = 'customer_signup_login';
            $data['jfile3'] = 'change_pswd';
            $data['hide_search'] = 'true';

            $this->load->model('categories_model');

            $data['cart'] = urlencode(json_encode($this->get_basket()));
            $data['cats'] = $this->categories_model->_get_all();

            $this->returnView('change_password', $data);
        } else {
            redirect(base_url());
        }
    }

    //about
    public function about()
    {
        $data['title'] = 'About';
        $data['jfile'] = 'basket';
        $data['jfile2'] = 'customer_signup_login';
        $data['hide_search'] = 'true';

        $this->load->model('categories_model');
        $this->load->model('percent_model');

        $data['days'] = $this->percent_model->get_days()['rate'];
        $data['cart'] = urlencode(json_encode($this->get_basket()));
        $data['cats'] = $this->categories_model->_get_all();

        $this->returnView('about', $data);
    }

    //about
    public function contact()
    {
        $data['title'] = 'Contact Us';
        $data['jfile'] = 'basket';
        $data['jfile2'] = 'customer_signup_login';
        $data['hide_search'] = 'true';

        $this->load->model('categories_model');
        $this->load->model('admin_model');

        $data['admin'] = $this->admin_model->get();
        $data['cart'] = urlencode(json_encode($this->get_basket()));
        $data['cats'] = $this->categories_model->_get_all();

        $this->returnView('contact', $data);
    }

    //logout
    public function logout()
    {
        $this->session->unset_userdata('c_det');
        redirect(base_url());
    }
    //==========================API===============================
    public function api_create_account()
    {
        $this->load->model('customers_model');

        $fname = trim($this->input->post('fname'));
        $lname = trim($this->input->post('lname'));
        $gender = trim($this->input->post('gender'));
        $adres = trim($this->input->post('adres'));
        $phno = trim($this->input->post('phno'));
        $email = trim($this->input->post('email'));
        $pswd = $this->input->post('pswd');
        $cpswd = $this->input->post('cpswd');

        if ($fname == '' || $lname == '' || $gender == '' || $adres == '' || $phno == '' || $email == '' || $pswd == '' || $cpswd == '') {
            $res['res'] = 'false';
            $res['err'] = 'All fields are required';
        } else if ($this->customers_model->email_exist($email)) {
            $res['res'] = 'false';
            $res['err'] = 'Email already exist';
        } else if (strlen($pswd) < 8) {
            $res['res'] = 'false';
            $res['err'] = 'Password must be up to eight(8) characters in length';
        } else if ($pswd != $cpswd) {
            $res['res'] = 'false';
            $res['err'] = 'Passwords do not match';
        } else {
            $dbres = $this->customers_model->create();
            if ($dbres) {
                $res['res'] = 'true';
                $res['err'] = '';
            } else {
                $res['res'] = 'false';
                $res['err'] = 'Encountered problem creating Merchant. Please try again!';
            }
        }
        echo json_encode($res);
    }

    public function api_login()
    {
        $this->load->model('customers_model');

        $email = trim($this->input->post('email'));
        $pswd = $this->input->post('pswd');
        $keep = $this->input->post('keep');

        if ($email == '' || $pswd == '') {
            $res['res'] = 'false';
            $res['err'] = 'Email and password fields are required';
        } else {
            $dbres = $this->customers_model->if_exist($email, $pswd);
            if (!$dbres) {
                $res['res'] = 'false';
                $res['err'] = 'Invalid email/password';
            } else {

                $c_id = $this->customers_model->get_id($email, $pswd);
                if ($this->customers_model->is_flagged((int) $c_id)) {
                    $res['res'] = 'false';
                    $res['err'] = 'Sorry! We encountered a problem logging you in. Contact our support team';
                } else {
                    $res['res'] = 'true';
                    $res['err'] = '';

                    $c_name = $this->customers_model->get_name($c_id);
                    $this->session->set_userdata('c_det', array('c_id' => $c_id, 'c_name' => $c_name));
                    if ($keep == 'true') {
                        //$this->session->mark_as_temp('c_det', 31104000); // Expires in a year
                        setcookie(session_name(), session_id(), time() + 31104000);
                    }
                    $res['c_id'] = $c_id;
                    $res['c_name'] = $c_name;
                }

            }
        }
        echo json_encode($res);
    }

    //get rating for a product by a particular customer
    public function api_get_single_rating()
    {
        if (isset($_SESSION['c_det'])) {
            $pid = (int) $this->input->get('pid');
            $cid = (int) $_SESSION['c_det']['c_id'];

            $this->load->model('ratings_model');
            if ($this->ratings_model->hasRate($cid, $pid)) {
                $res['res'] = 'true';
                $res['rate'] = $this->ratings_model->get_rate($cid, $pid);
            } else {
                $res['res'] = 'false';
                $res['rate'] = 0;
            }
            echo json_encode($res);
        } else {
            echo json_encode([]);
        }
    }

    //add new rating
    public function api_insert_rating()
    {
        if (isset($_SESSION['c_det'])) {
            $cid = (int) $_SESSION['c_det']['c_id'];
            $pid = (int) $this->input->post('pid');

            $this->load->model('ratings_model');
            $r = $this->ratings_model->create($cid);
            if ($r) {
                $res['res'] = 'true';
            } else {
                $res['res'] = 'false';
            }
            $res['rate'] = $this->ratings_model->get($pid);
            echo json_encode($res);
        } else {
            echo json_encode([]);
        }
    }

    //update rating
    public function api_update_rating()
    {
        if (isset($_SESSION['c_det'])) {
            $cid = (int) $_SESSION['c_det']['c_id'];
            $pid = (int) $this->input->post('pid');
            $rate = (int) $this->input->post('rate');

            $this->load->model('ratings_model');
            $r = $this->ratings_model->update($cid, $pid, $rate);
            if ($r) {
                $res['res'] = 'true';
            } else {
                $res['res'] = 'false';
            }
            $res['rate'] = $this->ratings_model->get($pid);
            echo json_encode($res);
        } else {
            echo json_encode([]);
        }
    }

    //add to cart
    public function api_add_to_cart()
    {
        $this->load->model('products_model');
        $this->load->model('images_model');
        $pid = $this->input->post('pid');
        $p = $this->products_model->get($pid);
        $p = $this->get_price($p); //set sale price
        //$this->session->mark_as_temp('cart_contents', 15552000);
        setcookie(session_name(), session_id(), time() + 31104000);
        $data = array(
            'id' => $p['id'],
            'qty' => 1,
            'price' => $p['cprice'],
            'mprice' => $p['mprice'],
            'name' => 'product',
            'pname' => $p['pname'],
            'fpath' => $this->images_model->get($p['id'])[0]['fpath'],
        );

        $rowid = $this->cart->insert($data);
        $res = $this->get_basket();
        $res['rowid'] = $rowid;

        //$this->cart->destroy();
        echo json_encode($res);
    }

    //update cart
    public function api_update_cart()
    {
        $rowid = $this->input->post('rowid');
        $qty = (int) $this->input->post('qty');

        $data = array(
            'rowid' => $rowid,
            'qty' => $qty,
        );

        $r = $this->cart->update($data);
        $res = $this->get_basket();
        $res['res'] = $r == true ? 'true' : 'false';
        $item = $this->cart->get_item($rowid);
        $res['fsub'] = number_format($item['subtotal'], 2);

        echo json_encode($res);
    }

    //remove from cart
    public function api_remove_from_cart()
    {
        $rowid = $this->input->post('rowid');

        $r = $this->cart->remove($rowid);
        $res = $this->get_basket();
        $res['res'] = $r == true ? 'true' : 'false';

        echo json_encode($res);
    }

    //generate invoice
    public function api_generate_invoice()
    {
        if (isset($_SESSION['temp_cart'])) {
            $_SESSION['temp_cart']['adres'] = $this->input->post('adres');
            $_SESSION['temp_cart']['pay_mode'] = $this->input->post('pay_mode');
            // $mcart = $_SESSION['temp_cart'];
            // $adres=$this->input->post('adres');
            // $pay_mode=$this->input->post('pay_mode');
            $res['res'] = 'true';
            $this->generate_invoice();
        } else {
            $res['res'] = 'false';
        }
        echo json_encode($res);
    }

    //add payment
    public function add_payment($oid, $pid, $method, $status)
    {
        $this->load->model('payments_model');
        return $this->payments_model->add($oid, $pid, $method, $status);
    }
    //verify transaction
    public function api_verify_payment()
    {
        $skey = 'sk_test_389e14457e1881a6ab59325b716670e6fa88d87b';
        $ref = $this->input->get('ref');
        $oid = (int) $this->input->get('oid');
        $result = array();
        $res = [];
        //The parameter after verify/ is the transaction reference to be verified
        $url = 'https://api.paystack.co/transaction/verify/' . $ref;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $skey]
        );
        $request = curl_exec($ch);
        curl_close($ch);

        //$res['result']=$request;
        if ($request) {
            $result = json_decode($request, true);
            //print_r($result);
            if ($result) {
                if (isset($result['data'])) {
                    //something came in
                    if ($result['data']['status'] == 'success') {
                        // the transaction was successful, you can deliver value
                        /*
                        @ also remember that if this was a card transaction, you can store the
                        @ card authorization to enable you charge the customer subsequently.
                        @ The card authorization is in:
                        @ $result['data']['authorization']['authorization_code'];
                        @ PS: Store the authorization with this email address used for this transaction.
                        @ The authorization will only work with this particular email.
                        @ If the user changes his email on your system, it will be unusable
                         */
                        //echo "Transaction was successful";
                        $res['res'] = 'true';
                        $res['msg'] = 'Transaction was successful';
                        $this->add_payment($oid, $ref, 'paystack', 1);
                        $this->send_paid_invoice_mail($oid);
                    } else {
                        // the transaction was not successful, do not deliver value'
                        // print_r($result);  //uncomment this line to inspect the result, to check why it failed.
                        //echo "Transaction was not successful: Last gateway response was: " . $result['data']['gateway_response'];
                        $res['res'] = 'false';
                        $res['msg'] = "Transaction was not successful";
                        // $res['msg']="Transaction was not successful: Last gateway response was: " . $result['data']['gateway_response'];
                        $this->add_payment($oid, $ref, 'paystack', 0);
                    }
                } else {
                    //echo $result['message'];
                    $res['res'] = 'false';
                    $res['msg'] = $result['message'];
                    $this->add_payment($oid, $ref, 'paystack', 0);
                }

            } else {
                //print_r($result);
                //die("Something went wrong while trying to convert the request variable to json. Uncomment the print_r command to see what is in the result variable.");
                $res['res'] = 'false';
                $res['msg'] = 'Something went wrong! Transaction was not successful';
                $this->add_payment($oid, $ref, 'paystack', 0);
            }
        } else {
            //var_dump($request);
            //die("Something went wrong while executing curl. Uncomment the var_dump line above this line to see what the issue is. Please check your CURL command to make sure everything is ok");
            $res['res'] = 'false';
            $res['msg'] = 'Something went wrong! Transaction was not successful';
            $this->add_payment($oid, $ref, 'paystack', 0);
        }
        echo json_encode($res);
    }

    //get orders
    public function api_get_orders()
    {
        if (isset($_SESSION['c_det'])) {
            $this->load->model('orders_model');
            $this->load->model('categories_model');

            $cid = (int) $_SESSION['c_det']['c_id'];
            $orders = $this->orders_model->get_by_customer($cid);
            for ($i = 0; $i < count($orders); $i++) {
                $orders[$i]['cart'] = unserialize($orders[$i]['cart']);
                $orders[$i]['fdate'] = date('M d, Y', (int) $orders[$i]['odate']);
            }
            $page = (int) ($this->uri->segment(2) ? $this->uri->segment(2) : 1);
            //echo $page;
            $res = $this->paginate($orders, 'api_get_orders', 15, $page, 2);
            $data['orders'] = $res['data'];
            $data['links'] = $res['links'];
            $data['count'] = $res['count'];

            echo json_encode($data);
        } else {
            echo json_encode([]);
        }
    }

    //cancel order
    public function api_cancel_order()
    {
        if (isset($_SESSION['c_det'])) {
            $oid = (int) $this->input->post('oid');

            $this->load->model('orders_model');
            $r = $this->orders_model->update_status($oid, 1);
            if ($r) {
                $res['res'] = 'true';
            } else {
                $res['res'] = 'false';
            }
            echo json_encode($res);
        } else {
            echo json_encode([]);
        }
    }

    //get single order
    public function api_get_order()
    {
        if (isset($_SESSION['c_det'])) {
            $oid = (int) $this->input->get('oid');
            $this->load->model('orders_model');

            $order = $this->orders_model->get($oid);
            $order['fdiscount'] = number_format($order['discount'], 2);
            $order['fvat'] = number_format($order['vat'], 2);

            echo json_encode($order);
        } else {
            echo json_encode([]);
        }
    }

    public function api_update_profile()
    {
        if (isset($_SESSION['c_det'])) {
            $cid = (int) ($_SESSION['c_det']['c_id']);

            $this->load->model('customers_model');
            $fname = trim($this->input->post('fname'));
            $lname = trim($this->input->post('lname'));
            $gender = trim($this->input->post('gender'));
            $adres = trim($this->input->post('adres'));
            $phno = trim($this->input->post('phno'));
            $email = trim($this->input->post('email'));

            $customer = $this->customers_model->get($cid);

            if ($fname == '' || $lname == '' || $gender == '' || $adres == '' || $phno == '' || $email == '') {
                $res['res'] = 'false';
                $res['err'] = 'All fields are required';
            } else if ($email != $customer['email'] && $this->customers_model->email_exist($email)) {
                $res['res'] = 'false';
                $res['err'] = 'Email already exists';
            } else {
                $dbres = $this->customers_model->update($cid);
                if ($dbres) {
                    $res['res'] = 'true';
                    $res['err'] = '';
                } else {
                    $res['res'] = 'false';
                    $res['err'] = 'Encountered problem updating your profile. Please try again!';
                }
            }
            echo json_encode($res);
        } else {
            echo json_encode([]);
        }
    }

    //change password
    public function api_change_password()
    {
        if (isset($_SESSION['c_det'])) {
            $this->load->model('customers_model');
            $cid = (int) $_SESSION['c_det']['c_id'];

            $cpswd = $this->input->post('cpswd');
            $npswd = $this->input->post('npswd');
            $npswd2 = $this->input->post('npswd2');
            $epswd = $this->customers_model->get($cid)['pswd'];

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
                $dbres = $this->customers_model->change_pswd($cid, $npswd);
                if ($dbres) {
                    $res['res'] = 'true';
                    $res['err'] = '';
                } else {
                    $res['res'] = 'false';
                    $res['err'] = 'Encountered a problem changing your password. Please try again!';
                }
            }
            echo json_encode($res);
        } else {
            echo json_encode([]);
        }
    }
    //========================
    public function mid_exist($cart, $mid)
    {
        $this->load->model('products_model');
        $res = false;
        foreach ($cart as $p) {
            $_mid = $this->products_model->get((int) $p['id'])['mid'];
            if ($_mid == $mid) {
                $res = true;
                break;
            }
        }
        return $res;
    }
    //no of successful sales
    public function get_ssale($mid)
    {
        $this->load->model('orders_model');
        $this->load->model('merchants_model');

        $orders = $this->orders_model->get_paid();
        $no = 0;
        foreach ($orders as $o) {
            $cart = unserialize($o['cart'])['cart'];
            if ($this->mid_exist($cart, $mid)) {
                $no++;
            }
        }
        return $no;
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
    //generate transaction id
    public function gen_transaction_id()
    {
        $alpha = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '=', '-', '.');
        $transaction_id = mt_rand(0, 9) . $alpha[mt_rand(0, 54)] . mt_rand(0, 9) . $alpha[mt_rand(0, 54)] . mt_rand(0, 9) . $alpha[mt_rand(0, 54)] . mt_rand(0, 9) . $alpha[mt_rand(0, 54)] . $alpha[mt_rand(0, 54)] . $alpha[mt_rand(0, 54)] . $alpha[mt_rand(0, 54)] . $alpha[mt_rand(0, 54)] . mt_rand(0, 9) . mt_rand(0, 9) . $alpha[mt_rand(0, 54)] . $alpha[mt_rand(0, 54)];

        $this->load->model('orders_model');
        if ($this->orders_model->t_exist($transaction_id)) {
            $transaction_id = $this->gen_transaction_id();
        } else {
            return $transaction_id;
        }
    }
    //get payment method code
    public function get_pay_method_code($pay_method)
    {
        if ($pay_method == 'paystack') {
            return 0;
        } else if ($pay_method == 'transfer') {
            return 1;
        } else if ($pay_method == 'delivery') {
            return 2;
        }
    }
    //get sale price for product array
    public function get_array_price($arr)
    {
        $this->load->model('percent_model');
        $rate = $this->percent_model->get()['rate'];
        for ($i = 0; $i < count($arr); $i++) {
            $arr[$i]['mprice'] = $arr[$i]['cprice'];
            $arr[$i]['mpprice'] = $arr[$i]['pprice'];
            $arr[$i]['pprice'] += ($rate / 100) * $arr[$i]['pprice'];
            $arr[$i]['cprice'] += ($rate / 100) * $arr[$i]['cprice'];
        }
        return $arr;
    }
    //get sale price for single product
    public function get_price($p)
    {
        $this->load->model('percent_model');
        $rate = $this->percent_model->get()['rate'];
        $p['mprice'] = $p['cprice'];
        $p['mpprice'] = $p['pprice'];
        $p['pprice'] += ($rate / 100) * $p['pprice'];
        $p['cprice'] += ($rate / 100) * $p['cprice'];
        return $p;
    }
    //return view
    public function returnView($view, $data)
    {
        $this->load->model('admin_model');
        $data['admin'] = $this->admin_model->get();

        $this->load->view('shared/header', $data);
        $this->load->view('customers/' . $view, $data);
        if (isset($data['jfile']) && $data['jfile'] == 'basket') {
            $this->load->view('shared/basket', $data);
        }
        if (isset($data['jfile2']) && $data['jfile2'] == 'customer_signup_login') {
            $this->load->view('shared/customer_signup_login', $data);
        }
        $this->load->view('shared/footer', $data);
    }
}
