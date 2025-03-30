<?php

 /**
 * Author: Amirul Momenin
 * Desc:Ticket Controller
 *
 */
class Ticket extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Ticket_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of ticket table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['ticket'] = $this->Ticket_model->get_limit_ticket($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/ticket/index');
		$config['total_rows'] = $this->Ticket_model->get_count_ticket();
		$config['per_page'] = 10;
		//Bootstrap 4 Pagination fix
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close']   = '<span aria-hidden="true"></span></span></li>';
		$config['next_tag_close']   = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close']   = '</span></li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close']  = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close']   = '</span></li>';		
		$this->pagination->initialize($config);
        $data['link'] =$this->pagination->create_links();
		
        $data['_view'] = 'admin/ticket/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save ticket
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		
		
		$params = array(
					 'deals_id' => html_escape($this->input->post('deals_id')),
'ticket_no' => html_escape($this->input->post('ticket_no')),
'site' => html_escape($this->input->post('site')),
'department' => html_escape($this->input->post('department')),
'equipment_name' => html_escape($this->input->post('equipment_name')),
'equipment_type' => html_escape($this->input->post('equipment_type')),
'status' => html_escape($this->input->post('status')),
'priority' => html_escape($this->input->post('priority')),
'summary' => html_escape($this->input->post('summary')),
'ticket_status' => html_escape($this->input->post('ticket_status')),
'assigned_to_users_id' => html_escape($this->input->post('assigned_to_users_id')),
'assigned_by_users_id' => html_escape($this->input->post('assigned_by_users_id')),
'date_open' => html_escape($this->input->post('date_open')),
'date_closed' => html_escape($this->input->post('date_closed')),

				);
		 
		 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['ticket'] = $this->Ticket_model->get_ticket($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Ticket_model->update_ticket($id,$params);
				$this->session->set_flashdata('msg','Ticket has been updated successfully');
                redirect('admin/ticket/index');
            }else{
                $data['_view'] = 'admin/ticket/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $ticket_id = $this->Ticket_model->add_ticket($params);
				$this->session->set_flashdata('msg','Ticket has been saved successfully');
                redirect('admin/ticket/index');
            }else{  
			    $data['ticket'] = $this->Ticket_model->get_ticket(0);
                $data['_view'] = 'admin/ticket/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details ticket
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['ticket'] = $this->Ticket_model->get_ticket($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/ticket/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting ticket
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $ticket = $this->Ticket_model->get_ticket($id);

        // check if the ticket exists before trying to delete it
        if(isset($ticket['id'])){
            $this->Ticket_model->delete_ticket($id);
			$this->session->set_flashdata('msg','Ticket has been deleted successfully');
            redirect('admin/ticket/index');
        }
        else
            show_error('The ticket you are trying to delete does not exist.');
    }
	
	/**
     * Search ticket
	 * @param $start - Starting of ticket table's index to get query
     */
	function search($start=0){
		if(!empty($this->input->post('key'))){
			$key =$this->input->post('key');
			$_SESSION['key'] = $key;
		}else{
			$key = $_SESSION['key'];
		}
		
		$limit = 10;		
		$this->db->like('id', $key, 'both');
$this->db->or_like('deals_id', $key, 'both');
$this->db->or_like('ticket_no', $key, 'both');
$this->db->or_like('site', $key, 'both');
$this->db->or_like('department', $key, 'both');
$this->db->or_like('equipment_name', $key, 'both');
$this->db->or_like('equipment_type', $key, 'both');
$this->db->or_like('status', $key, 'both');
$this->db->or_like('priority', $key, 'both');
$this->db->or_like('summary', $key, 'both');
$this->db->or_like('ticket_status', $key, 'both');
$this->db->or_like('assigned_to_users_id', $key, 'both');
$this->db->or_like('assigned_by_users_id', $key, 'both');
$this->db->or_like('date_open', $key, 'both');
$this->db->or_like('date_closed', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['ticket'] = $this->db->get('ticket')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/ticket/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('deals_id', $key, 'both');
$this->db->or_like('ticket_no', $key, 'both');
$this->db->or_like('site', $key, 'both');
$this->db->or_like('department', $key, 'both');
$this->db->or_like('equipment_name', $key, 'both');
$this->db->or_like('equipment_type', $key, 'both');
$this->db->or_like('status', $key, 'both');
$this->db->or_like('priority', $key, 'both');
$this->db->or_like('summary', $key, 'both');
$this->db->or_like('ticket_status', $key, 'both');
$this->db->or_like('assigned_to_users_id', $key, 'both');
$this->db->or_like('assigned_by_users_id', $key, 'both');
$this->db->or_like('date_open', $key, 'both');
$this->db->or_like('date_closed', $key, 'both');

		$config['total_rows'] = $this->db->from("ticket")->count_all_results();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		$config['per_page'] = 10;
		// Bootstrap 4 Pagination fix
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close']   = '<span aria-hidden="true"></span></span></li>';
		$config['next_tag_close']   = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close']   = '</span></li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close']  = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close']   = '</span></li>';
		$this->pagination->initialize($config);
        $data['link'] =$this->pagination->create_links();
		
		$data['key'] = $key;
		$data['_view'] = 'admin/ticket/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export ticket
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'ticket_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $ticketData = $this->Ticket_model->get_all_ticket();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Deals Id","Ticket No","Site","Department","Equipment Name","Equipment Type","Status","Priority","Summary","Ticket Status","Assigned To Users Id","Assigned By Users Id","Date Open","Date Closed"); 
		   fputcsv($file, $header);
		   foreach ($ticketData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $ticket = $this->db->get('ticket')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/ticket/print_template.php');
			$html = ob_get_clean();
			require_once FCPATH.'vendor/autoload.php';			
			$mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
	  }
	   
	}
}
//End of Ticket controller