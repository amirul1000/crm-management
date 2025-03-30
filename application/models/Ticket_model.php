<?php

/**
 * Author: Amirul Momenin
 * Desc:Ticket Model
 */
class Ticket_model extends CI_Model
{
	protected $ticket = 'ticket';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get ticket by id
	 *@param $id - primary key to get record
	 *
     */
    function get_ticket($id){
        $result = $this->db->get_where('ticket',array('id'=>$id))->row_array();
		if(!(array)$result){
			$fields = $this->db->list_fields('ticket');
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
	
    /** Get all ticket
	 *
     */
    function get_all_ticket(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('ticket')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit ticket
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_ticket($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('ticket')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count ticket rows
	 *
     */
	function get_count_ticket(){
       $result = $this->db->from("ticket")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	
	 /** Get all users-ticket
	 *
     */
    function get_all_users_ticket(){
        $this->db->order_by('id', 'desc');
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('ticket')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users-ticket
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_ticket($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('ticket')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users-ticket rows
	 *
     */
	function get_count_users_ticket(){
	   $this->db->where('users_id', $this->session->userdata('id'));
       $result = $this->db->from("ticket")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new ticket
	 *@param $params - data set to add record
	 *
     */
    function add_ticket($params){
        $this->db->insert('ticket',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update ticket
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_ticket($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('ticket',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete ticket
	 *@param $id - primary key to delete record
	 *
     */
    function delete_ticket($id){
        $status = $this->db->delete('ticket',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
