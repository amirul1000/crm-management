<link rel="stylesheet"
	href="<?php echo base_url(); ?>public/css/custom.css"> 
<h3 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Ticket'); ?></h3>
Date: <?php echo date("Y-m-d");?>
<hr>
<!--*************************************************
*********mpdf header footer page no******************
****************************************************-->
<htmlpageheader name="firstpage" class="hide">
</htmlpageheader>

<htmlpageheader name="otherpages" class="hide">
    <span class="float_left"></span>
    <span  class="padding_5"> &nbsp; &nbsp; &nbsp;
     &nbsp; &nbsp; &nbsp;</span>
    <span class="float_right"></span>         
</htmlpageheader>      
<sethtmlpageheader name="firstpage" value="on" show-this-page="1" />
<sethtmlpageheader name="otherpages" value="on" /> 
   
<htmlpagefooter name="myfooter"  class="hide">                          
     <div align="center">
               <br><span class="padding_10">Page {PAGENO} of {nbpg}</span> 
     </div>
</htmlpagefooter>    

<sethtmlpagefooter name="myfooter" value="on" />
<!--*************************************************
*********#////mpdf header footer page no******************
****************************************************-->
<!--Data display of ticket-->    
<table   cellspacing="3" cellpadding="3" class="table" align="center">
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

    </tr>
	<?php } ?>
</table>
<!--End of Data display of ticket//--> 