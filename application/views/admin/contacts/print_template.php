<link rel="stylesheet"
	href="<?php echo base_url(); ?>public/css/custom.css"> 
<h3 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Contacts'); ?></h3>
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
<!--Data display of contacts-->    
<table   cellspacing="3" cellpadding="3" class="table" align="center">
    <tr>
		<th>Customers</th>
<th>Contact Person</th>
<th>Email</th>
<th>Phone</th>
<th>Position</th>

    </tr>
	<?php foreach($contacts as $c){ ?>
    <tr>
		<td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Customers_model');
									   $dataArr = $this->CI->Customers_model->get_customers($c['customers_id']);
									   echo $dataArr['name'];?>
									</td>
<td><?php echo $c['contact_person']; ?></td>
<td><?php echo $c['email']; ?></td>
<td><?php echo $c['phone']; ?></td>
<td><?php echo $c['position']; ?></td>

    </tr>
	<?php } ?>
</table>
<!--End of Data display of contacts//--> 