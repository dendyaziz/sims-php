<?php
	session_start();
	include("fc/fc_config.php");
?>	
<form method="POST" action="">	
	<div class="modal-header">
		<h4 class="modal-title" id="editModalLabel">Edit User</h4>
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
					$id=$row["id"];
				}
			}					
		?>	
		<input type="text" name="id" value="<?php echo $id;?>" hidden required="required">
		<input type="text" name="username" value="<?php echo $_SESSION["iss21"]["fullname"];?>" hidden required="required">
		<div class="container-fluid">
			<div class="row">
				
				<div class="col-md-6">
					<div class="form-group">
						<label>Branch</label>
						<select class="custom-select col-12" id="branch" name="branch" required="required">
							<option value="<?php if(!empty($branch)){echo $branch;}?>"><?php if(!empty($branch)){echo $branch;}else{echo "Choose...";}?></option>
							<?php													
								$result = $con->query("Select * from BRANCH where branch<>'$branch' order By branch");
								$count = mysqli_num_rows($result);
								if($count>0){
									while($row = mysqli_fetch_assoc($result))
									{				
										$branch=$row["branch"];
										echo "<option value='$branch'>$branch</option>";
									}
								}												
							?>												
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Position</label>
						<select class="custom-select col-12" id="position" name="position" required="required">
							<option value="<?php if(!empty($position)){echo $position;}?>"><?php if(!empty($position)){echo $position;}else{echo "Choose...";}?></option>
							<option value="Admin">Admin</option>
							<option value="Gudang">Gudang</option>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="userid">User ID</label>
						<input type="text" class="form-control" id="userid" name="userid" value="<?php if(!empty($userid)){echo $userid;}?>" required="required">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" id="password" name="password" value="<?php if(!empty($password)){echo $password;}?>" required="required">
					</div>
				</div>				
				<div class="col-md-6">
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" class="form-control" id="email" name="email" value="<?php if(!empty($email)){echo $email;}?>" required="required">
					</div>
				</div>				
				<div class="col-md-6">
					<div class="form-group">
						<label for="fullname">FullName</label>
						<input type="text" class="form-control" id="fullname" name="fullname" value="<?php if(!empty($fullname)){echo $fullname;}?>" required="required">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="address">Address</label>
						<input type="text" class="form-control" id="address" name="address" value="<?php if(!empty($address)){echo $address;}?>" required="required">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="phone">Phone</label>
						<input type="number" class="form-control" id="phone" name="phone" value="<?php if(!empty($phone)){echo $phone;}?>" required="required">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Status</label>
						<select class="custom-select col-12" id="status" name="status" required="required">
							<?php if($status=="Aktif"){$status1="Active User";}else{$status1="Non Active User";}?>
							<option value="<?php if(!empty($status)){echo $status;}?>"><?php if(!empty($status1)){echo $status1;}else{echo "Choose...";}?></option>
							<option value="Aktif">Active User</option>
							<option value="Tidak Aktif">Non Active User</option>
						</select>
					</div>
				</div>				
			</div>
		</div>				
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary btn-sm" formaction="fc/fc_edit_user_modal.php"><i class="fa fa-refresh"></i> Update</button>
		<button type="button" class="btn btn-dark btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
	</div>
</form>