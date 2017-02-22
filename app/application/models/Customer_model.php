<?php

/**
 * Created by PhpStorm.
 * User: ankit
 * Date: 1/7/2017
 * Time: 6:15 PM
 */
class Customer_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getCustomerByUserId($intUserId)
    {
        $query = $this->db->select('buyer_first_name as FN,buyer_last_name as LN,buyer_email as EMAIL,country_code as COUNTRY,city as CT,postal_code as ZIP,state_or_region as ST')
            ->from('customers')
            ->where(array('user_id' => $intUserId, 'audience_id' => ''))
            ->get();
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
            $returnArr = array();
            foreach ($data as $item) {
                $returnArr[] = array_values($item);
            }
            return $returnArr;
        } else {
            return FALSE;
        }
    }

    public function updateCustomerByUserId($intUserId, $arrData)
    {
        $query = $this->db->where(array('user_id' => $intUserId, 'audience_id' => ''))->update('customers', $arrData);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}