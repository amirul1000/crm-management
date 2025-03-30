<?php

/**
 * Author: Amirul Momenin
 * Desc:Contacts Model
 */
class Contacts_model extends CI_Model
{
	protected $contacts = 'contacts';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get contacts by id
	 *@param $id - primary key to get record
	 *
     */
    function get_contacts($id){
        $result = $this->db->get_where('contacts',array('id'=>$id))->row_array();
		if(!(array)$result){
			$fields = $this->db->list_fields('contacts');
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
	
    /** Get all contacts
	 *
     */
    function get_all_contacts(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('contacts')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit contacts
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_contacts($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('contacts')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count contacts rows
	 *
     */
	function get_count_contacts(){
       $result = $this->db->from("contacts")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	
	 /** Get all users-contacts
	 *
     */
    function get_all_users_contacts(){
        $this->db->order_by('id', 'desc');
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('contacts')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users-contacts
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_contacts($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('contacts')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users-contacts rows
	 *
     */
	function get_count_users_contacts(){
	   $this->db->where('users_id', $this->session->userdata('id'));
       $result = $this->db->from("contacts")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new contacts
	 *@param $params - data set to add record
	 *
     */
    function add_contacts($params){
        $this->db->insert('contacts',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update contacts
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_contacts($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('contacts',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete contacts
	 *@param $id - primary key to delete record
	 *
     */
    function delete_contacts($id){
        $status = $this->db->delete('contacts',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
