<a  href="<?php echo site_url('admin/deals/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Deals'); ?></h5>
<!--Data display of deals with id--> 
<?php
	$c = $deals;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Customers</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Customers_model');
									   $dataArr = $this->CI->Customers_model->get_customers($c['customers_id']);
									   echo $dataArr['name'];?>
									</td></tr>

<tr><td>Deal Name</td><td><?php echo $c['deal_name']; ?></td></tr>

<tr><td>Value</td><td><?php echo $c['value']; ?></td></tr>

<tr><td>Stage</td><td><?php echo $c['stage']; ?></td></tr>

<tr><td>Expected Close Date</td><td><?php echo $c['expected_close_date']; ?></td></tr>

<tr><td>Assigned To Users</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Users_model');
									   $dataArr = $this->CI->Users_model->get_users($c['assigned_to_users_id']);
									   echo $dataArr['name'];?>
									</td></tr>

<tr><td>Created At</td><td><?php echo $c['created_at']; ?></td></tr>


</table>
<!--End of Data display of deals with id//--> 