<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once(APPPATH . 'controllers/FbCtrl.php');

class Home extends FbCtrl
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->model('user_model', 'user');
    }

    /* STEP 1 for market place info */

    public function step1()
    {
        $data['title'] = 'Azon Software | Account Setup';
        $data['isRequired'] = TRUE;
        $this->load->view('header_new', $data);
        $this->load->view('step1');
    }

    /* STEP 2 for market place info */

    public function step2()
    {
        $data['title'] = 'Azon Software | Account Setup';
        $data['isRequired'] = TRUE;
        $this->load->view('header_new', $data);
        $this->load->view('step2');
    }

    /* STEP 3 for enter market place details */

    public function step3()
    {
        $arrUserData = $this->session->userdata('logged_in');
        $data['isRequired'] = TRUE;
        $data['title'] = 'Azon Software | Account Setup';
        $data['mwsInfo'] = $this->user->getMwsInfo($arrUserData['id']);
//	$strFacebookUrl = $this->getFacebookAuthUrl();
        if ($this->input->post()) {
            $this->form_validation->set_rules('seller_id', 'Seller ID', 'required');
            $this->form_validation->set_rules('marketplace_id', 'Marketplace ID', 'required');
            $this->form_validation->set_rules('aws_auth_token', 'AWS auth token', 'required');
            if ($this->form_validation->run() == TRUE) {
                $this->user->saveMwsdata($this->input->post(), $arrUserData['id']);
                /*redirect('fbSynch');*/
                redirect('home/step4');
            } else {
                $this->load->view('header_new', $data);
                $this->load->view('step3', $data);
            }
        } else {
            $this->load->view('header_new', $data);
            $this->load->view('step3', $data);
        }
    }

    /* STEP 2 for market place info */

    public function step4()
    {
        $data['title'] = 'Azon Software | Account Setup';
        $data['isRequired'] = TRUE;
        $data['strFacebookUrl'] = $this->getFacebookAuthUrl();
        $this->load->view('header_new', $data);
        $this->load->view('step4');
    }


    /* Add MWS details and save it to DB */

    public function index()
    {
        $strFacebookUrl = $this->getFacebookAuthUrl();
        $data['isRequired'] = TRUE;
        if ($this->input->post()) {
            $this->form_validation->set_rules('seller_id', 'Seller ID', 'required');
            $this->form_validation->set_rules('marketplace_id', 'Marketplace ID', 'required');
            $this->form_validation->set_rules('aws_auth_token', 'AWS auth token', 'required');
            if ($this->form_validation->run() == TRUE) {
                $arrUserData = $this->session->userdata('logged_in');
                $this->user->saveMwsdata($this->input->post(), $arrUserData['id']);
                redirect('home');
            } else {
                $this->load->view('header');
                $this->load->view('mws_credentials', array('strFacebookUrl' => $strFacebookUrl));
                $this->load->view('footer');
            }
        } else {
            $this->load->view('header');
            $this->load->view('mws_credentials', array('strFacebookUrl' => $strFacebookUrl));
            $this->load->view('footer');
        }
    }

    /* Home FB synch */

    public function fbSynch()
    {
       /* $data['strFacebookUrl'] = $this->getFacebookAuthUrl(); */
        $arrUserData = $this->session->userdata('logged_in');
        $data['isRequired'] = TRUE;
        $data['mwsInfo'] = $this->user->getMwsInfo($arrUserData['id']);
        $data['usaOrderCount'] = $this->user->getOrderCount('US',$arrUserData['id']);
        $data['caOrderCount'] = $this->user->getOrderCount('CA',$arrUserData['id']);
        $data['mxOrderCount'] = $this->user->getOrderCount('MX-MEX',$arrUserData['id']);
        $data['arrRes'] = $arrUserData;
        $data['title'] = 'Azon Software | Dashboard';
        $data['selected'] = 'fbSynch';
        $this->load->view('header_new', $data);
        $this->load->view('sidebar', $data);
        $this->load->view('fb_synch');
    }

    /* Contacts */

    public function contact()
    {
        $data['title'] = 'Azon Software | Contact';
        $data['isRequired'] = TRUE;
        $data['selected'] = 'contact';

        if (true == $this->input->post()) {
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('message', 'Message', 'required');
            if ($this->form_validation->run() == TRUE) {
                $mail = $this->load->view('email_template/email_header', array(), true);
                $mail .= $this->load->view('email_template/contactus_view', array("email_heading" => "Contact Us Email",
                    "content" => '<p style="color:#4b4b4b;margin:0;font-size:16px">Name : ' . $this->input->post('name') . '</p>
                 <p style="color:#4b4b4b;margin:0;font-size:16px">Email : ' . $this->input->post('email') . '</p>
                 <p style="color:#4b4b4b;margin:0;font-size:16px">Message : ' . $this->input->post('message') . '</p><p>&nbsp;</p>'), true);
                $mail .= $this->load->view('email_template/email_footer', array(), true);

                mymail('azonservices@gmail.com', "Contact Us Email", $mail);
                $this->session->set_flashdata('message', 'Email sent successfully.');
            } else {

            }
        }

        $this->load->view('header_new', $data);
        $this->load->view('sidebar', $data);
        $this->load->view('contact');
    }

    /* Settings */

    public function settings()
    {
        $data['isRequired'] = TRUE;
        $arrUserData = $this->session->userdata('logged_in');
        $data['mwsInfo'] = $this->user->getMwsInfo($arrUserData['id']);
        /*$data['fbInfo'] = $this->user->getFbInfo($arrUserData['id']); */
        $data['title'] = 'Azon Software | Setting';
        $data['selected'] = 'settings';
        $this->load->view('header_new', $data);
        $this->load->view('sidebar', $data);
        $this->load->view('settings', $data);
    }

    /* Profile */

    public function profile()
    {
        $data['isRequired'] = TRUE;
        $arrUserData = $this->session->userdata('logged_in');
        $data['userInfo'] = $this->user->getUserInfo($arrUserData['id']);
        $data['title'] = 'Azon Software | Profile';
        $data['selected'] = 'profile';
        if ($this->input->post()) {
            $this->form_validation->set_rules('email', 'Email', 'required|callback_check_email');
            if ($this->form_validation->run() == TRUE) {
                $this->user->saveProfileData(array('first_name' => $this->input->post('first_name'), 'last_name' => $this->input->post('last_name'), 'email' => $this->input->post('email'), 'company' => $this->input->post('company'), 'website_url' => $this->input->post('website_url')), $arrUserData['id']);
                $this->session->set_flashdata('success', 'Your changes has been saved!!');
                redirect('home/profile');
            } else {
                $this->load->view('header_new', $data);
                $this->load->view('sidebar', $data);
                $this->load->view('profile', $data);
            }
        } else {
            $this->load->view('header_new', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('profile', $data);
        }
    }

    /* Check user email */

    function check_email()
    {
        $arrUserData = $this->session->userdata('logged_in');
        if ($this->db->select('id')->from('users')->where(array('id !=' => $arrUserData['id'], 'email' => $this->input->post('email')))->get()->num_rows() > 0) {
            $this->form_validation->set_message('check_email', 'This email is already taken,try with diffrent.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /* Change password the user... */

    public function changePassword()
    {
        $data['isRequired'] = TRUE;
        if ($this->input->post()) {
            $arrUserData = $this->session->userdata('logged_in');
            $data['userInfo'] = $this->user->getUserInfo($arrUserData['id']);
            $data['title'] = 'Azon Software | Profile';
            $data['selected'] = 'profile';
            $arrUserData = $this->session->userdata('logged_in');
            $this->form_validation->set_rules('old_password', 'Old Password', 'required|callback_checkOldPass');
            $this->form_validation->set_rules('new_password', 'New Password', 'required|matches[confirm_password]');
            $this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required');
            if ($this->form_validation->run() == TRUE) {
                $this->user->changePassword(md5($this->input->post('new_password'), $arrUserData['id']));
                $this->session->set_flashdata('success', 'Your password has been changed successfully.');
                redirect('home/profile');
            } else {
                $this->load->view('header_new', $data);
                $this->load->view('sidebar', $data);
                $this->load->view('profile', $data);
            }
        } else {
            $this->load->view('header_new', $data);
            $this->load->view('sidebar', $data);
            $this->load->view('profile', $data);
        }
    }

    /* Check user old Password */

    function checkOldPass()
    {
        $arrUserData = $this->session->userdata('logged_in');
        if ($this->db->select('id')->from('users')->where(array('id' => $arrUserData['id'], 'password' => md5($this->input->post('old_password'))))->get()->num_rows() > 0) {
            return TRUE;
        } else {
            $this->form_validation->set_message('checkOldPass', 'Your current password are wrong.');
            return FALSE;
        }
    }

    /* Logout */

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }

    /* MWS  customers list */

    public function customers()
    {
        $this->load->view('header');
        $this->load->view('customers');
        $this->load->view('footer');
    }

    /* Ajax request for customers... */

    public function getCustomers()
    {
        $arrUserData = $this->session->userdata('logged_in');
        $intUserId = $arrUserData['id'];
        $sLimit = "";
        $lenght = 10;
        $str_point = 0;

        $query = "select mws_orders.id,mws_orders.buyer_first_name,mws_orders.buyer_last_name,mws_orders.buyer_email from mws_orders where user_id = $intUserId ";

        $col_sort = array("id", "buyer_first_name", "buyer_last_name", "buyer_email");
        $order_by = "id";
        $temp = 'desc';

        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $words = $_GET['sSearch'];
            $query .= "AND (`mws_orders`.`buyer_first_name` REGEXP '$words'
                           OR `mws_orders`.`buyer_last_name` REGEXP '$words'
                           OR `mws_orders`.`buyer_email` REGEXP '$words')";
        }

        if (isset($_GET['iSortCol_0'])) {
            $index = $_GET['iSortCol_0'];
            $temp = $_GET['sSortDir_0'] === 'asc' ? 'asc' : 'desc';
            $order_by = $col_sort[$index];
        }
        $query .= "GROUP BY buyer_email ORDER BY " . $order_by . " " . $temp . " ";

        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $str_point = intval($_GET['iDisplayStart']);
            $lenght = intval($_GET['iDisplayLength']);
            $query_res = $query . " LIMIT " . $str_point . "," . $lenght;
        } else {
            $query_res = $query;
        }
        $res = $this->db->query($query_res);
        $count_res = $this->db->query($query);
        $result = $res->result_array();
        $count_result = $count_res->result_array();
        $total_record = count($count_result);
        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $total_record,
            "iTotalDisplayRecords" => $total_record,
            "aaData" => array()
        );
        foreach ($result as $val) {
            $output['aaData'][] = array("DT_RowId" => $val['id'], $val['id'], $val['buyer_first_name'], $val['buyer_last_name'], $val['buyer_email'], '<a class="btn btn-xs btn-success">View Orders</a>');
        }

        echo json_encode($output);
        die;
    }

}
