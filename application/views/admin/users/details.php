<a  href="<?php echo site_url('admin/users/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Users'); ?></h5>
<!--Data display of users with id--> 
<?php
	$c = $users;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Name</td><td><?php echo $c['name']; ?></td></tr>

<tr><td>Email</td><td><?php echo $c['email']; ?></td></tr>

<tr><td>Password</td><td><?php echo $c['password']; ?></td></tr>

<tr><td>Role</td><td><?php echo $c['role']; ?></td></tr>

<tr><td>Created At</td><td><?php echo $c['created_at']; ?></td></tr>


</table>
<!--End of Data display of users with id//--> 