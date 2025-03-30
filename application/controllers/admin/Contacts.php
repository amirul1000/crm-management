<?php

 /**
 * Author: Amirul Momenin
 * Desc:Contacts Controller
 *
 */
class Contacts extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Contacts_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of contacts table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['contacts'] = $this->Contacts_model->get_limit_contacts($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/contacts/index');
		$config['total_rows'] = $this->Contacts_model->get_count_contacts();
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
		
        $data['_view'] = 'admin/contacts/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save contacts
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
'contact_person' => html_escape($this->input->post('contact_person')),
'email' => html_escape($this->input->post('email')),
'phone' => html_escape($this->input->post('phone')),
'position' => html_escape($this->input->post('position')),
'created_at' =>$created_at,

				);
		 
		if($id>0){
							                        unset($params['created_at']);
						                          } 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['contacts'] = $this->Contacts_model->get_contacts($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Contacts_model->update_contacts($id,$params);
				$this->session->set_flashdata('msg','Contacts has been updated successfully');
                redirect('admin/contacts/index');
            }else{
                $data['_view'] = 'admin/contacts/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $contacts_id = $this->Contacts_model->add_contacts($params);
				$this->session->set_flashdata('msg','Contacts has been saved successfully');
                redirect('admin/contacts/index');
            }else{  
			    $data['contacts'] = $this->Contacts_model->get_contacts(0);
                $data['_view'] = 'admin/contacts/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details contacts
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['contacts'] = $this->Contacts_model->get_contacts($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/contacts/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting contacts
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $contacts = $this->Contacts_model->get_contacts($id);

        // check if the contacts exists before trying to delete it
        if(isset($contacts['id'])){
            $this->Contacts_model->delete_contacts($id);
			$this->session->set_flashdata('msg','Contacts has been deleted successfully');
            redirect('admin/contacts/index');
        }
        else
            show_error('The contacts you are trying to delete does not exist.');
    }
	
	/**
     * Search contacts
	 * @param $start - Starting of contacts table's index to get query
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
$this->db->or_like('contact_person', $key, 'both');
$this->db->or_like('email', $key, 'both');
$this->db->or_like('phone', $key, 'both');
$this->db->or_like('position', $key, 'both');
$this->db->or_like('created_at', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['contacts'] = $this->db->get('contacts')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/contacts/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('customers_id', $key, 'both');
$this->db->or_like('contact_person', $key, 'both');
$this->db->or_like('email', $key, 'both');
$this->db->or_like('phone', $key, 'both');
$this->db->or_like('position', $key, 'both');
$this->db->or_like('created_at', $key, 'both');

		$config['total_rows'] = $this->db->from("contacts")->count_all_results();
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
		$data['_view'] = 'admin/contacts/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export contacts
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'contacts_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $contactsData = $this->Contacts_model->get_all_contacts();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Customers Id","Contact Person","Email","Phone","Position","Created At"); 
		   fputcsv($file, $header);
		   foreach ($contactsData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $contacts = $this->db->get('contacts')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/contacts/print_template.php');
			$html = ob_get_clean();
			require_once FCPATH.'vendor/autoload.php';			
			$mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
	  }
	   
	}
}
//End of Contacts controller