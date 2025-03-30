<?php

/**
 * Author: Amirul Momenin
 * Desc:Deals Model
 */
class Deals_model extends CI_Model
{
	protected $deals = 'deals';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get deals by id
	 *@param $id - primary key to get record
	 *
     */
    function get_deals($id){
        $result = $this->db->get_where('deals',array('id'=>$id))->row_array();
		if(!(array)$result){
			$fields = $this->db->list_fields('deals');
			foreach ($fields as $field)
			{
			   $result[$field] = ''; 	  
			}
		}
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all deals
	 *
     */
    function get_all_deals(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('deals')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit deals
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_deals($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('deals')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count deals rows
	 *
     */
	function get_count_deals(){
       $result = $this->db->from("deals")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	
	 /** Get all users-deals
	 *
     */
    function get_all_users_deals(){
        $this->db->order_by('id', 'desc');
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('deals')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users-deals
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_deals($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('deals')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users-deals rows
	 *
     */
	function get_count_users_deals(){
	   $this->db->where('users_id', $this->session->userdata('id'));
       $result = $this->db->from("deals")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new deals
	 *@param $params - data set to add record
	 *
     */
    function add_deals($params){
        $this->db->insert('deals',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update deals
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_deals($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('deals',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete deals
	 *@param $id - primary key to delete record
	 *
     */
    function delete_deals($id){
        $status = $this->db->delete('deals',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
