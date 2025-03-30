<a  href="<?php echo site_url('admin/deals/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Deals'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('admin/deals/save/'.$deals['id'],array("class"=>"form-horizontal")); ?>
<div class="card">
   <div class="card-body">    
        <div class="form-group"> 
                                    <label for="Customers" class="col-md-4 control-label">Customers</label> 
         <div class="col-md-8"> 
          <?php 
             $this->CI =& get_instance(); 
             $this->CI->load->database();  
             $this->CI->load->model('Customers_model'); 
             $dataArr = $this->CI->Customers_model->get_all_customers(); 
          ?> 
          <select name="customers_id"  id="customers_id"  class="form-control"/> 
            <option value="">--Select--</option> 
            <?php 
             for($i=0;$i<count($dataArr);$i++) 
             {  
            ?> 
            <option value="<?=$dataArr[$i]['id']?>" <?php if($deals['customers_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['name']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
<div class="form-group"> 
          <label for="Deal Name" class="col-md-4 control-label">Deal Name</label> 
          <div class="col-md-8"> 
           <input type="text" name="deal_name" value="<?php echo ($this->input->post('deal_name') ? $this->input->post('deal_name') : $deals['deal_name']); ?>" class="form-control" id="deal_name" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Value" class="col-md-4 control-label">Value</label> 
          <div class="col-md-8"> 
           <input type="text" name="value" value="<?php echo ($this->input->post('value') ? $this->input->post('value') : $deals['value']); ?>" class="form-control" id="value" /> 
          </div> 
           </div>
<div class="form-group"> 
                                        <label for="Stage" class="col-md-4 control-label">Stage</label> 
          <div class="col-md-8"> 
           <?php 
             $enumArr = $this->customlib->getEnumFieldValues('deals','stage'); 
           ?> 
           <select name="stage"  id="stage"  class="form-control"/> 
             <option value="">--Select--</option> 
             <?php 
              for($i=0;$i<count($enumArr);$i++) 
              { 
             ?> 
             <option value="<?=$enumArr[$i]?>" <?php if($deals['stage']==$enumArr[$i]){ echo "selected";} ?>><?=ucwords($enumArr[$i])?></option> 
             <?php 
              } 
             ?> 
           </select> 
          </div> 
            </div>
<div class="form-group"> 
                                       <label for="Expected Close Date" class="col-md-4 control-label">Expected Close Date</label> 
            <div class="col-md-8"> 
           <input type="text" name="expected_close_date"  id="expected_close_date"  value="<?php echo ($this->input->post('expected_close_date') ? $this->input->post('expected_close_date') : $deals['expected_close_date']); ?>" class="form-control-static datepicker"/> 
            </div> 
           </div>
<div class="form-group"> 
                                    <label for="Assigned To Users" class="col-md-4 control-label">Assigned To Users</label> 
         <div class="col-md-8"> 
          <?php 
             $this->CI =& get_instance(); 
             $this->CI->load->database();  
             $this->CI->load->model('Users_model'); 
             $dataArr = $this->CI->Users_model->get_all_users(); 
          ?> 
          <select name="assigned_to_users_id"  id="assigned_to_users_id"  class="form-control"/> 
            <option value="">--Select--</option> 
            <?php 
             for($i=0;$i<count($dataArr);$i++) 
             {  
            ?> 
            <option value="<?=$dataArr[$i]['id']?>" <?php if($deals['assigned_to_users_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['name']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>

   </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <button type="submit" class="btn btn-success"><?php if(empty($deals['id'])){?>Save<?php }else{?>Update<?php } ?></button>
    </div>
</div>
<?php echo form_close(); ?>
<!--End of Form to save data//-->	
<!--JQuery-->
<script>
	$( ".datepicker" ).datepicker({
		dateFormat: "yy-mm-dd", 
		changeYear: true,
		changeMonth: true,
		showOn: 'button',
		buttonText: 'Show Date',
		buttonImageOnly: true,
		buttonImage: '<?php echo base_url(); ?>public/datepicker/images/calendar.gif',
	});
</script>  			