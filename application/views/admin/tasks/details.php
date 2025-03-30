<a  href="<?php echo site_url('admin/tasks/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Tasks'); ?></h5>
<!--Data display of tasks with id--> 
<?php
	$c = $tasks;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Deals</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Deals_model');
									   $dataArr = $this->CI->Deals_model->get_deals($c['deals_id']);
									   echo $dataArr['deal_name'];?>
									</td></tr>

<tr><td>Task Name</td><td><?php echo $c['task_name']; ?></td></tr>

<tr><td>Status</td><td><?php echo $c['status']; ?></td></tr>

<tr><td>Due Date</td><td><?php echo $c['due_date']; ?></td></tr>

<tr><td>Assigned To Users</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Users_model');
									   $dataArr = $this->CI->Users_model->get_users($c['assigned_to_users_id']);
									   echo $dataArr['name'];?>
									</td></tr>

<tr><td>Created At</td><td><?php echo $c['created_at']; ?></td></tr>


</table>
<!--End of Data display of tasks with id//--> 