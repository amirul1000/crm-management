<a  href="<?php echo site_url('admin/contacts/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Contacts'); ?></h5>
<!--Data display of contacts with id--> 
<?php
	$c = $contacts;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Customers</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Customers_model');
									   $dataArr = $this->CI->Customers_model->get_customers($c['customers_id']);
									   echo $dataArr['name'];?>
									</td></tr>

<tr><td>Contact Person</td><td><?php echo $c['contact_person']; ?></td></tr>

<tr><td>Email</td><td><?php echo $c['email']; ?></td></tr>

<tr><td>Phone</td><td><?php echo $c['phone']; ?></td></tr>

<tr><td>Position</td><td><?php echo $c['position']; ?></td></tr>

<tr><td>Created At</td><td><?php echo $c['created_at']; ?></td></tr>


</table>
<!--End of Data display of contacts with id//--> 