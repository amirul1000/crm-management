<?php

 /**
 * Author: Amirul Momenin
 * Desc:Deals Controller
 *
 */
class Deals extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Deals_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of deals table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['deals'] = $this->Deals_model->get_limit_deals($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/deals/index');
		$config['total_rows'] = $this->Deals_model->get_count_deals();
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
		
        $data['_view'] = 'admin/deals/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save deals
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		$created_at = "";

		if($id<=0){
															 $created_at = date("Y-m-d H:i:s");
														 }

		$params = array(
					 'customers_id' => html_escape($this->input->post('customers_id')),
'deal_name' => html_escape($this->input->post('deal_name')),
'value' => html_escape($this->input->post('value')),
'stage' => html_escape($this->input->post('stage')),
'expected_close_date' => html_escape($this->input->post('expected_close_date')),
'assigned_to_users_id' => html_escape($this->input->post('assigned_to_users_id')),
'created_at' =>$created_at,

				);
		 
		if($id>0){
							                        unset($params['created_at']);
						                          } 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['deals'] = $this->Deals_model->get_deals($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Deals_model->update_deals($id,$params);
				$this->session->set_flashdata('msg','Deals has been updated successfully');
                redirect('admin/deals/index');
            }else{
                $data['_view'] = 'admin/deals/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $deals_id = $this->Deals_model->add_deals($params);
				$this->session->set_flashdata('msg','Deals has been saved successfully');
                redirect('admin/deals/index');
            }else{  
			    $data['deals'] = $this->Deals_model->get_deals(0);
                $data['_view'] = 'admin/deals/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details deals
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['deals'] = $this->Deals_model->get_deals($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/deals/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting deals
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $deals = $this->Deals_model->get_deals($id);

        // check if the deals exists before trying to delete it
        if(isset($deals['id'])){
            $this->Deals_model->delete_deals($id);
			$this->session->set_flashdata('msg','Deals has been deleted successfully');
            redirect('admin/deals/index');
        }
        else
            show_error('The deals you are trying to delete does not exist.');
    }
	
	/**
     * Search deals
	 * @param $start - Starting of deals table's index to get query
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
$this->db->or_like('customers_id', $key, 'both');
$this->db->or_like('deal_name', $key, 'both');
$this->db->or_like('value', $key, 'both');
$this->db->or_like('stage', $key, 'both');
$this->db->or_like('expected_close_date', $key, 'both');
$this->db->or_like('assigned_to_users_id', $key, 'both');
$this->db->or_like('created_at', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['deals'] = $this->db->get('deals')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/deals/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('customers_id', $key, 'both');
$this->db->or_like('deal_name', $key, 'both');
$this->db->or_like('value', $key, 'both');
$this->db->or_like('stage', $key, 'both');
$this->db->or_like('expected_close_date', $key, 'both');
$this->db->or_like('assigned_to_users_id', $key, 'both');
$this->db->or_like('created_at', $key, 'both');

		$config['total_rows'] = $this->db->from("deals")->count_all_results();
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
		$data['_view'] = 'admin/deals/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export deals
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'deals_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $dealsData = $this->Deals_model->get_all_deals();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Customers Id","Deal Name","Value","Stage","Expected Close Date","Assigned To Users Id","Created At"); 
		   fputcsv($file, $header);
		   foreach ($dealsData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $deals = $this->db->get('deals')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/deals/print_template.php');
			$html = ob_get_clean();
			require_once FCPATH.'vendor/autoload.php';			
			$mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
	  }
	   
	}
}
//End of Deals controller