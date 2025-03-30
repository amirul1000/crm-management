<a  href="<?php echo site_url('admin/ticket/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Ticket'); ?></h5>
<!--Data display of ticket with id--> 
<?php
	$c = $ticket;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Deals</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Deals_model');
									   $dataArr = $this->CI->Deals_model->get_deals($c['deals_id']);
									   echo $dataArr['deal_name'];?>
									</td></tr>

<tr><td>Ticket No</td><td><?php echo $c['ticket_no']; ?></td></tr>

<tr><td>Site</td><td><?php echo $c['site']; ?></td></tr>

<tr><td>Department</td><td><?php echo $c['department']; ?></td></tr>

<tr><td>Equipment Name</td><td><?php echo $c['equipment_name']; ?></td></tr>

<tr><td>Equipment Type</td><td><?php echo $c['equipment_type']; ?></td></tr>

<tr><td>Status</td><td><?php echo $c['status']; ?></td></tr>

<tr><td>Priority</td><td><?php echo $c['priority']; ?></td></tr>

<tr><td>Summary</td><td><?php echo $c['summary']; ?></td></tr>

<tr><td>Ticket Status</td><td><?php echo $c['ticket_status']; ?></td></tr>

<tr><td>Assigned To Users</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Users_model');
									   $dataArr = $this->CI->Users_model->get_users($c['assigned_to_users_id']);
									   echo $dataArr['name'];?>
									</td></tr>

<tr><td>Assigned By Users</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Users_model');
									   $dataArr = $this->CI->Users_model->get_users($c['assigned_by_users_id']);
									   echo $dataArr['name'];?>
									</td></tr>

<tr><td>Date Open</td><td><?php echo $c['date_open']; ?></td></tr>

<tr><td>Date Closed</td><td><?php echo $c['date_closed']; ?></td></tr>


</table>
<!--End of Data display of ticket with id//--> 