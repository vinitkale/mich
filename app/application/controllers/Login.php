<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model', 'user');
    }

    /* Login user for access */

    public function index()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('home/step1');
        }
        $data['title'] = 'Azon Software | Login';
        if ($this->input->post()) {
            $this->form_validation->set_rules('username', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');
            if ($this->form_validation->run() == TRUE) {
                $arrRes = $this->user->checkUser($this->input->post('username'), $this->input->post('password'));
                if ($arrRes) {
                    if (0 == $arrRes['active']) {
                        $this->session->set_flashdata('error', 'Your account is not active,please check your email to activate it.');
                        redirect('login');
                    } else {
                        $this->session->set_userdata('logged_in', $arrRes);
                        if(($arrRes['audience_id'] != '' && $arrRes['access_token'] != '') && (FALSE != $this->user->getMwsInfo($arrRes['id']))){
                            redirect('dashboard');
                        }elseif(FALSE == $this->user->getMwsInfo($arrRes['id'])){
                            redirect('home/step1');    
                        }elseif(($arrRes['audience_id'] == '' || $arrRes['access_token'] == '')){
                            redirect('home/step4');    
                        }
                        else{
                            redirect('home/step1');    
                        }
                        
                    }
                } else {
                    $this->session->set_flashdata('error', 'username or password are invalid.');
                    redirect('login');
                }
            } else {
                $this->load->view('header_new', $data);
                $this->load->view('login');
                $this->load->view('footer_new');
            }
        } else {
            $this->load->view('header_new', $data);
            $this->load->view('login');
            $this->load->view('footer_new');
        }
    }

    /* Register the user... */

    public function register()
    {
        $data['title'] = 'Azon Software | Register  ';
        if ($this->input->post()) {
//	    $this->form_validation->set_rules('full_name', 'Full Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'Password', 'required|matches[password2]');
            $this->form_validation->set_rules('password2', 'Password Confirmation', 'required');
            if ($this->form_validation->run() == TRUE) {
                $this->user->doRegister($this->input->post());
                $this->session->set_flashdata('success', 'Verification email sent to your email address,please check.');
                redirect('register');
            } else {
                $this->load->view('header_new', $data);
                $this->load->view('register');
                $this->load->view('footer_new');
            }
        } else {
            $this->load->view('header_new', $data);
            $this->load->view('register');
            $this->load->view('footer_new');
        }
    }

    /* Activate the user... */

    public function confirm($userid, $token)
    {
        if ($this->session->userdata('logged_in')) {
            $this->session->unset_userdata('logged_in');
        }

            $data['title'] = 'Azon Software | Confirm Account';


            $data = $this->user->getUser(array("id" => $userid, "active" => 0));
            if ($data) {
                if (md5($data['created_at']) == $token) {
                        $this->user->updateUser(array("active" => 1), array("id" => $userid));
                        $this->session->set_flashdata('success', 'Account Activated successfull.');
                        redirect("login");
                } else {
                        $this->session->set_flashdata('error', 'Access denied.');
                        redirect("login");
                }
            } else {
                $this->session->set_flashdata('error', 'Access denied.');
                redirect("login");
            }
    }

    /* Logout the user */

    public function logout()
    {
        $this->session->unset_userdata('logged_in');
        redirect('/');
    }

    /* Forgot password */

    public function forgotPass()
    {
        $data['title'] = 'Azon Software | Forgot Password';
        if ($this->input->post()) {
//	    $this->form_validation->set_rules('full_name', 'Full Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            if ($this->form_validation->run() == TRUE) {
                $query = $this->db->select('*')->from('users')->where(array('email' => $this->input->post('email')))->get();
                if ($query->num_rows() > 0) {
                    $userData = $query->row_array();
                    $user_id = $userData['id'];
                    $password = $userData['password'];
                    $mail = $this->load->view('email_template/email_header', array(), true);
                    $mail .= $this->load->view('email_template/recover_password', array("email_heading" => "Password Reset Email",
                        "content" => '</p>
                 <p style="color:#4b4b4b;margin:0;font-size:16px">Email : ' . $this->input->post('email') . '</p><p >' . base_url("login/updatePassword/" . $user_id . "/" . md5($password)) . '<p>', "btntitle" => "Reset Password", "link" => base_url("login/updatePassword/" . $user_id . "/" . md5($password))), true);
                    $mail .= $this->load->view('email_template/email_footer', array(), true);

                    mymail($this->input->post('email'), "Reset Password Email", $mail);
                    $this->session->set_flashdata('success', 'Reset password email sent please check.');
                } else {
                    $this->session->set_flashdata('error', 'Email does not not exist.');
                }
                redirect('login/forgotPass');
            } else {
                $this->load->view('header_new', $data);
                $this->load->view('recover_password', $data);
                $this->load->view('footer_new');
            }
        } else {
            $this->load->view('header_new', $data);
            $this->load->view('recover_password', $data);
            $this->load->view('footer_new');
        }
    }

    /* Update password */

    public function updatePassword($intUserid = FALSE, $strToken = FALSE)
    {
        $data['title'] = 'Azon Software | Forgot Password';
        $data['userid'] = $intUserid;

        //Validation Rules
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|matches[passconf]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');

        if ($this->input->post()) {
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('header_new', $data);
                $this->load->view('change_password', $data);
                $this->load->view('footer_new');
            } else {
                $this->user->updateUser(array("password" => md5($this->input->post("password"))), array("id" => $this->input->post("userid")));
                $this->session->set_flashdata('success', 'Password changes successfully.');
                redirect("login");
            }
        } else {
            $query = $this->db->select('*')->from('users')->where(array('id' => $intUserid))->get();
            if ($query->num_rows() > 0) {
                $userData = $query->row_array();
                $password = md5($userData['password']);
                if ($password == $strToken) {
                    $this->load->view('header_new', $data);
                    $this->load->view('change_password', $data);
                    $this->load->view('footer_new');
                } else {
                    $this->session->set_flashdata('error', 'Forgot Password link expired please try again.');
                    redirect('login/forgotPass');
                }
            } else {
                $this->session->set_flashdata('error', 'Forgot Password link expired please try again.');
                redirect('login/forgotPass');
            }
        }


    }
}