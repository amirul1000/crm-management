<a  href="<?php echo site_url('admin/customers/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Customers'); ?></h5>
<!--Data display of customers with id--> 
<?php
	$c = $customers;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Name</td><td><?php echo $c['name']; ?></td></tr>

<tr><td>Email</td><td><?php echo $c['email']; ?></td></tr>

<tr><td>Phone</td><td><?php echo $c['phone']; ?></td></tr>

<tr><td>Address</td><td><?php echo $c['address']; ?></td></tr>

<tr><td>Company</td><td><?php echo $c['company']; ?></td></tr>

<tr><td>Website</td><td><?php echo $c['website']; ?></td></tr>

<tr><td>Created By</td><td><?php echo $c['created_by']; ?></td></tr>

<tr><td>Created At</td><td><?php echo $c['created_at']; ?></td></tr>


</table>
<!--End of Data display of customers with id//--> 