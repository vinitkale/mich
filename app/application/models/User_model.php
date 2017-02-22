<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User_model extends CI_Model {

    public function __construct() {
	parent::__construct();
    }

    public function checkUser($email, $password) {
	$this->db->where(array('email' => $email, 'password' => md5($password)));
	$query = $this->db->get('users');
	if ($query->num_rows() > 0) {
	    return $query->row_array();
	} else {
	    return FALSE;
	}
    }

    public function saveMwsdata($arrMwsData, $user_id) {
	if ($this->db->where('user_id', $user_id)->get('mwsdetails')->num_rows() > 0) {
	    $this->db->where('user_id', $user_id)->update('mwsdetails', array('seller_id' => $arrMwsData['seller_id'], 'marketplace_id' => $arrMwsData['marketplace_id'], 'aws_auth_token' => $arrMwsData['aws_auth_token'], 'user_id' => $user_id, 'initial_sync' => 1));
	    return TRUE;
	} else {
	    $this->db->insert('mwsdetails', array('seller_id' => $arrMwsData['seller_id'], 'marketplace_id' => $arrMwsData['marketplace_id'], 'aws_auth_token' => $arrMwsData['aws_auth_token'], 'user_id' => $user_id, 'initial_sync' => 1));
	    if ($this->db->affected_rows() > 0) {
		return TRUE;
	    } else {
		return FALSE;
	    }
	}
    }

    public function saveFbdata($arrFbData, $user_id) {
	if ($this->db->where('user_id', $user_id)->get('fb_details')->num_rows() > 0) {
	    $this->db->where('user_id', $user_id)->update('fb_details', array('app_id' => $arrFbData['app_id'], 'app_secret' => $arrFbData['app_secret'], 'user_id' => $user_id));
	    return TRUE;
	} else {
	    $this->db->insert('fb_details', array('app_id' => $arrFbData['app_id'], 'app_secret' => $arrFbData['app_secret'], 'user_id' => $user_id));
	    if ($this->db->affected_rows() > 0) {
		return TRUE;
	    } else {
		return FALSE;
	    }
	}
    }

    public function doRegister($arrUserData) {
	$created_at = date('Y-m-d h:i:s');
	$this->db->insert('users', array('email' => $arrUserData['email'], 'password' => md5($arrUserData['password']), 'created_at' => $created_at));
	if ($this->db->affected_rows() > 0) {
	    $user_id = $this->db->insert_id();
	    $mail = $this->load->view('email_template/email_header', array(), true);
	    $mail .= $this->load->view('email_template/email_view', array("email_heading" => "Email confirmation required", "content" => '
                 <h2 style="color:#black;margin:0;font-weight:normal;text-align:center;margin-bottom:8px;font-size:22px">Your profile is almost ready</h2>
                 <p style="color:#4b4b4b;margin:0;text-align:center;font-size:16px"><span class="il">Confirm</span> your <span class="il">email</span> to continue</p>
                 <p >' . base_url("login/confirm/" . $user_id . "/" . md5($created_at)) . '<p>', "btntitle" => "OK, Confirm", "link" => base_url("login/confirm/" . $user_id . "/" . md5($created_at))), true);
	    $mail .= $this->load->view('email_template/email_footer', array(), true);

	    mymail($arrUserData['email'], "Email confirmation required", $mail);
	    return TRUE;
	} else {
	    return FALSE;
	}
    }

    public function getUser($where) {
	$query = $this->db->where($where)->get('users');
	if ($query->num_rows() > 0) {
	    return $query->row_array();
	} else {
	    return FALSE;
	}
    }

    public function updateUser($arrData, $where) {
	$query = $this->db->where($where)->update('users', $arrData);
	if ($this->db->affected_rows() > 0) {
	    return TRUE;
	} else {
	    return FALSE;
	}
    }

    public function getMwsData() {

	$query = $this->db->get('mwsdetails');
	if ($query->num_rows() > 0) {
	    return $query->result_array();
	} else {
	    return FALSE;
	}
    }

    public function getFacebookData() {

	$query = $this->db->get_where('users', array('expiry_date > ' => date("Y-m-d")));
	if ($query->num_rows() > 0) {
	    return $query->result_array();
	} else {
	    return FALSE;
	}
    }

    public function getMwsInfo($intUser) {
	$query = $this->db->where('user_id', $intUser)->get('mwsdetails');
	if ($query->num_rows() > 0) {
	    return $query->row_array();
	} else {
	    return FALSE;
	}
    }

    public function getFbInfo($intUser) {
	$query = $this->db->where('user_id', $intUser)->get('fb_details');
	if ($query->num_rows() > 0) {
	    return $query->row_array();
	} else {
	    return FALSE;
	}
    }

    public function getUserInfo($intUser) {
	$query = $this->db->where('id', $intUser)->get('users');
	if ($query->num_rows() > 0) {
	    return $query->row_array();
	} else {
	    return FALSE;
	}
    }

    public function saveProfileData($arrProfileData = array(), $intUserId) {
	$this->db->where('id', $intUserId)->update('users', $arrProfileData);
	return TRUE;
    }

    public function changePassword($newPassword, $intUserId) {
	$this->db->where('id', $intUserId)->update('users', array('password' => $newPassword));
	return TRUE;
    }

    public function getOrderCount($country_code = false,$user_id = false){
    	
    	return $this->db->where(array('country_code'=>$country_code,'user_id'=>$user_id))->get('mws_orders')->num_rows();

    }

}
