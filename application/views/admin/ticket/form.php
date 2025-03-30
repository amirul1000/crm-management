<a  href="<?php echo site_url('admin/ticket/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Ticket'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('admin/ticket/save/'.$ticket['id'],array("class"=>"form-horizontal")); ?>
<div class="card">
   <div class="card-body">    
        <div class="form-group"> 
                                    <label for="Deals" class="col-md-4 control-label">Deals</label> 
         <div class="col-md-8"> 
          <?php 
             $this->CI =& get_instance(); 
             $this->CI->load->database();  
             $this->CI->load->model('Deals_model'); 
             $dataArr = $this->CI->Deals_model->get_all_deals(); 
          ?> 
          <select name="deals_id"  id="deals_id"  class="form-control"/> 
            <option value="">--Select--</option> 
            <?php 
             for($i=0;$i<count($dataArr);$i++) 
             {  
            ?> 
            <option value="<?=$dataArr[$i]['id']?>" <?php if($ticket['deals_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['deal_name']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
<div class="form-group"> 
          <label for="Ticket No" class="col-md-4 control-label">Ticket No</label> 
          <div class="col-md-8"> 
           <input type="text" name="ticket_no" value="<?php echo ($this->input->post('ticket_no') ? $this->input->post('ticket_no') : $ticket['ticket_no']); ?>" class="form-control" id="ticket_no" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Site" class="col-md-4 control-label">Site</label> 
          <div class="col-md-8"> 
           <input type="text" name="site" value="<?php echo ($this->input->post('site') ? $this->input->post('site') : $ticket['site']); ?>" class="form-control" id="site" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Department" class="col-md-4 control-label">Department</label> 
          <div class="col-md-8"> 
           <input type="text" name="department" value="<?php echo ($this->input->post('department') ? $this->input->post('department') : $ticket['department']); ?>" class="form-control" id="department" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Equipment Name" class="col-md-4 control-label">Equipment Name</label> 
          <div class="col-md-8"> 
           <input type="text" name="equipment_name" value="<?php echo ($this->input->post('equipment_name') ? $this->input->post('equipment_name') : $ticket['equipment_name']); ?>" class="form-control" id="equipment_name" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Equipment Type" class="col-md-4 control-label">Equipment Type</label> 
          <div class="col-md-8"> 
           <input type="text" name="equipment_type" value="<?php echo ($this->input->post('equipment_type') ? $this->input->post('equipment_type') : $ticket['equipment_type']); ?>" class="form-control" id="equipment_type" /> 
          </div> 
           </div>
<div class="form-group"> 
                                        <label for="Status" class="col-md-4 control-label">Status</label> 
          <div class="col-md-8"> 
           <?php 
             $enumArr = $this->customlib->getEnumFieldValues('ticket','status'); 
           ?> 
           <select name="status"  id="status"  class="form-control"/> 
             <option value="">--Select--</option> 
             <?php 
              for($i=0;$i<count($enumArr);$i++) 
              { 
             ?> 
             <option value="<?=$enumArr[$i]?>" <?php if($ticket['status']==$enumArr[$i]){ echo "selected";} ?>><?=ucwords($enumArr[$i])?></option> 
             <?php 
              } 
             ?> 
           </select> 
          </div> 
            </div>
<div class="form-group"> 
                                        <label for="Priority" class="col-md-4 control-label">Priority</label> 
          <div class="col-md-8"> 
           <?php 
             $enumArr = $this->customlib->getEnumFieldValues('ticket','priority'); 
           ?> 
           <select name="priority"  id="priority"  class="form-control"/> 
             <option value="">--Select--</option> 
             <?php 
              for($i=0;$i<count($enumArr);$i++) 
              { 
             ?> 
             <option value="<?=$enumArr[$i]?>" <?php if($ticket['priority']==$enumArr[$i]){ echo "selected";} ?>><?=ucwords($enumArr[$i])?></option> 
             <?php 
              } 
             ?> 
           </select> 
          </div> 
            </div>
<div class="form-group"> 
                                        <label for="Summary" class="col-md-4 control-label">Summary</label> 
          <div class="col-md-8"> 
           <textarea  name="summary"  id="summary"  class="form-control" rows="4"/><?php echo ($this->input->post('summary') ? $this->input->post('summary') : $ticket['summary']); ?></textarea> 
          </div> 
           </div>
<div class="form-group"> 
                                        <label for="Ticket Status" class="col-md-4 control-label">Ticket Status</label> 
          <div class="col-md-8"> 
           <?php 
             $enumArr = $this->customlib->getEnumFieldValues('ticket','ticket_status'); 
           ?> 
           <select name="ticket_status"  id="ticket_status"  class="form-control"/> 
             <option value="">--Select--</option> 
             <?php 
              for($i=0;$i<count($enumArr);$i++) 
              { 
             ?> 
             <option value="<?=$enumArr[$i]?>" <?php if($ticket['ticket_status']==$enumArr[$i]){ echo "selected";} ?>><?=ucwords($enumArr[$i])?></option> 
             <?php 
              } 
             ?> 
           </select> 
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
            <option value="<?=$dataArr[$i]['id']?>" <?php if($ticket['assigned_to_users_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['name']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
<div class="form-group"> 
                                    <label for="Assigned By Users" class="col-md-4 control-label">Assigned By Users</label> 
         <div class="col-md-8"> 
          <?php 
             $this->CI =& get_instance(); 
             $this->CI->load->database();  
             $this->CI->load->model('Users_model'); 
             $dataArr = $this->CI->Users_model->get_all_users(); 
          ?> 
          <select name="assigned_by_users_id"  id="assigned_by_users_id"  class="form-control"/> 
            <option value="">--Select--</option> 
            <?php 
             for($i=0;$i<count($dataArr);$i++) 
             {  
            ?> 
            <option value="<?=$dataArr[$i]['id']?>" <?php if($ticket['assigned_by_users_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['name']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
<div class="form-group"> 
                                       <label for="Date Open" class="col-md-4 control-label">Date Open</label> 
            <div class="col-md-8"> 
           <input type="text" name="date_open"  id="date_open"  value="<?php echo ($this->input->post('date_open') ? $this->input->post('date_open') : $ticket['date_open']); ?>" class="form-control-static datepicker"/> 
            </div> 
           </div>
<div class="form-group"> 
                                       <label for="Date Closed" class="col-md-4 control-label">Date Closed</label> 
            <div class="col-md-8"> 
           <input type="text" name="date_closed"  id="date_closed"  value="<?php echo ($this->input->post('date_closed') ? $this->input->post('date_closed') : $ticket['date_closed']); ?>" class="form-control-static datepicker"/> 
            </div> 
           </div>

   </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <button type="submit" class="btn btn-success"><?php if(empty($ticket['id'])){?>Save<?php }else{?>Update<?php } ?></button>
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