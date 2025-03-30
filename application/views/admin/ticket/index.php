<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Ticket'); ?></h5>
<?php
  	echo $this->session->flashdata('msg');
?>
<!--Action-->
<div>
	<div class="float_left padding_10">
		<a href="<?php echo site_url('admin/ticket/save'); ?>"
			class="btn btn-success">Add</a>
	</div>
	<div class="float_left padding_10">
		<i class="fa fa-download"></i> Export <select name="xeport_type" class="select"
			onChange="window.location='<?php echo site_url('admin/ticket/export'); ?>/'+this.value">
			<option>Select..</option>
			<option>Pdf</option>
			<option>CSV</option>
		</select>
	</div>
	<div  class="float_right padding_10">
		<ul class="left-side-navbar d-flex align-items-center">
			<li class="hide-phone app-search mr-15">
                <?php echo form_open_multipart('admin/ticket/search/',array("class"=>"form-horizontal")); ?>
                    <input name="key" type="text"
				value="<?php echo isset($key)?$key:'';?>" placeholder="Search..."
				class="form-control">
				<button type="submit" class="mr-0">
					<i class="fa fa-search"></i>
				</button>
                <?php echo form_close(); ?>
            </li>
		</ul>
	</div>
</div>
<!--End of Action//--> 
   
<!--Data display of ticket-->     
<div style="overflow-x:auto;width:100%;">      
<table class="table table-striped table-bordered">
    <tr>
		<th>Deals</th>
<th>Ticket No</th>
<th>Site</th>
<th>Department</th>
<th>Equipment Name</th>
<th>Equipment Type</th>
<th>Status</th>
<th>Priority</th>
<th>Summary</th>
<th>Ticket Status</th>
<th>Assigned To Users</th>
<th>Assigned By Users</th>
<th>Date Open</th>
<th>Date Closed</th>

		<th>Actions</th>
    </tr>
	<?php foreach($ticket as $c){ ?>
    <tr>
		<td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Deals_model');
									   $dataArr = $this->CI->Deals_model->get_deals($c['deals_id']);
									   echo $dataArr['deal_name'];?>
									</td>
<td><?php echo $c['ticket_no']; ?></td>
<td><?php echo $c['site']; ?></td>
<td><?php echo $c['department']; ?></td>
<td><?php echo $c['equipment_name']; ?></td>
<td><?php echo $c['equipment_type']; ?></td>
<td><?php echo $c['status']; ?></td>
<td><?php echo $c['priority']; ?></td>
<td><?php echo $c['summary']; ?></td>
<td><?php echo $c['ticket_status']; ?></td>
<td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Users_model');
									   $dataArr = $this->CI->Users_model->get_users($c['assigned_to_users_id']);
									   echo $dataArr['name'];?>
									</td>
<td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Users_model');
									   $dataArr = $this->CI->Users_model->get_users($c['assigned_by_users_id']);
									   echo $dataArr['name'];?>
									</td>
<td><?php echo $c['date_open']; ?></td>
<td><?php echo $c['date_closed']; ?></td>

		<td>
            <a href="<?php echo site_url('admin/ticket/details/'.$c['id']); ?>"  class="action-icon"> <i class="zmdi zmdi-eye"></i></a>
            <a href="<?php echo site_url('admin/ticket/save/'.$c['id']); ?>" class="action-icon"> <i class="zmdi zmdi-edit"></i></a>
            <a href="<?php echo site_url('admin/ticket/remove/'.$c['id']); ?>" onClick="return confirm('Are you sure to delete this item?');" class="action-icon"> <i class="zmdi zmdi-delete"></i></a>
        </td>
    </tr>
	<?php } ?>
</table>
</div>
<!--End of Data display of ticket//--> 

<!--No data-->
<?php
	if(count($ticket)==0){
?>
 <div align="center"><h3>Data does not exists</h3></div>
<?php
	}
?>
<!--End of No data//-->

<!--Pagination-->
<?php
	echo $link;
?>
<!--End of Pagination//-->
