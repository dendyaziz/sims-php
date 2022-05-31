<?php
	session_start();
	include("fc/fc_config.php");
?>	
<form method="POST" action="">	
	<div class="modal-header">
		<h4 class="modal-title" id="editModalLabel">Delete User</h4>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">		
		<?php
			$id=$_POST['id'];
			$result = $con->query("Select * from TBLLOGIN Where id='$id'");
			$count = mysqli_num_rows($result);
			if($count>0){
				while($row = mysqli_fetch_assoc($result))
				{
					$branch=$row["branch"];
					$position=$row["position"];
					$userid=$row["userid"];
					$password=$row["password"];
					$fullname=$row["fullname"];
					$email=$row["email"];
					$address=$row["address"];
					$phone=$row["phone"];
					$status=$row["status"];
				}
			}					
		?>
		<input type="text" name="id" value="<?php echo $id;?>" hidden required="required">
		<input type="text" name="username" value="<?php echo $_SESSION["iss21"]["fullname"];?>" hidden required="required">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="fullname">Branch</label>
						<input type="text" class="form-control" id="branch" name="branch" value="<?php if(!empty($branch)){echo $branch;}?>" readonly required="required">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="fullname">Position</label>
						<input type="text" class="form-control" id="position" name="position" value="<?php if(!empty($position)){echo $position;}?>" readonly required="required">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="userid">User ID</label>
						<input type="text" class="form-control" id="userid" name="userid" value="<?php if(!empty($userid)){echo $userid;}?>" readonly required="required">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" id="password" name="password" value="<?php if(!empty($password)){echo $password;}?>" readonly required="required">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" class="form-control" id="email" name="email" value="<?php if(!empty($email)){echo $email;}?>" readonly required="required">
					</div>
				</div>				
				<div class="col-md-6">
					<div class="form-group">
						<label for="fullname">FullName</label>
						<input type="text" class="form-control" id="fullname" name="fullname" value="<?php if(!empty($fullname)){echo $fullname;}?>" readonly required="required">
					</div>
				</div>				
				<div class="col-md-6">
					<div class="form-group">
						<label for="address">Address</label>
						<input type="text" class="form-control" id="address" name="address" value="<?php if(!empty($address)){echo $address;}?>" readonly required="required">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="phone">Phone</label>
						<input type="number" class="form-control" id="phone" name="phone" value="<?php if(!empty($phone)){echo $phone;}?>" readonly required="required">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="fullname">Status</label>
						<input type="text" class="form-control" id="status" name="status" value="<?php if(!empty($status)){echo $status;}?>" readonly required="required">
					</div>
				</div>				
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-danger btn-sm" formaction="fc/fc_delete_user_modal.php"><i class="fa fa-refresh"></i> Delete</button>
		<button type="button" class="btn btn-dark btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
	</div>
</form>