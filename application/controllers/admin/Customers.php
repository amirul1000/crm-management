<?php

 /**
 * Author: Amirul Momenin
 * Desc:Customers Controller
 *
 */
class Customers extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Customers_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of customers table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['customers'] = $this->Customers_model->get_limit_customers($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/customers/index');
		$config['total_rows'] = $this->Customers_model->get_count_customers();
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
		
        $data['_view'] = 'admin/customers/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save customers
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		$created_at = "";

		if($id<=0){
															 $created_at = date("Y-m-d H:i:s");
														 }

		$params = array(
					 'name' => html_escape($this->input->post('name')),
'email' => html_escape($this->input->post('email')),
'phone' => html_escape($this->input->post('phone')),
'address' => html_escape($this->input->post('address')),
'company' => html_escape($this->input->post('company')),
'website' => html_escape($this->input->post('website')),
'created_by' => html_escape($this->input->post('created_by')),
'created_at' =>$created_at,

				);
		 
		if($id>0){
							                        unset($params['created_at']);
						                          } 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['customers'] = $this->Customers_model->get_customers($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Customers_model->update_customers($id,$params);
				$this->session->set_flashdata('msg','Customers has been updated successfully');
                redirect('admin/customers/index');
            }else{
                $data['_view'] = 'admin/customers/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $customers_id = $this->Customers_model->add_customers($params);
				$this->session->set_flashdata('msg','Customers has been saved successfully');
                redirect('admin/customers/index');
            }else{  
			    $data['customers'] = $this->Customers_model->get_customers(0);
                $data['_view'] = 'admin/customers/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details customers
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['customers'] = $this->Customers_model->get_customers($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/customers/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting customers
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $customers = $this->Customers_model->get_customers($id);

        // check if the customers exists before trying to delete it
        if(isset($customers['id'])){
            $this->Customers_model->delete_customers($id);
			$this->session->set_flashdata('msg','Customers has been deleted successfully');
            redirect('admin/customers/index');
        }
        else
            show_error('The customers you are trying to delete does not exist.');
    }
	
	/**
     * Search customers
	 * @param $start - Starting of customers table's index to get query
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
$this->db->or_like('name', $key, 'both');
$this->db->or_like('email', $key, 'both');
$this->db->or_like('phone', $key, 'both');
$this->db->or_like('address', $key, 'both');
$this->db->or_like('company', $key, 'both');
$this->db->or_like('website', $key, 'both');
$this->db->or_like('created_by', $key, 'both');
$this->db->or_like('created_at', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['customers'] = $this->db->get('customers')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/customers/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('name', $key, 'both');
$this->db->or_like('email', $key, 'both');
$this->db->or_like('phone', $key, 'both');
$this->db->or_like('address', $key, 'both');
$this->db->or_like('company', $key, 'both');
$this->db->or_like('website', $key, 'both');
$this->db->or_like('created_by', $key, 'both');
$this->db->or_like('created_at', $key, 'both');

		$config['total_rows'] = $this->db->from("customers")->count_all_results();
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
		$data['_view'] = 'admin/customers/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export customers
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'customers_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $customersData = $this->Customers_model->get_all_customers();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Name","Email","Phone","Address","Company","Website","Created By","Created At"); 
		   fputcsv($file, $header);
		   foreach ($customersData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $customers = $this->db->get('customers')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/customers/print_template.php');
			$html = ob_get_clean();
			require_once FCPATH.'vendor/autoload.php';			
			$mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
	  }
	   
	}
}
//End of Customers controller