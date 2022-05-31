<?php
	session_start();
	include("fc/fc_config.php");
?>	
<form method="POST" action="">	
	<div class="modal-header">
		<h4 class="modal-title" id="editModalLabel">Delete Employee</h4>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">		
		<?php
			$id=$_POST['id'];
			$result = $con->query("Select * from KARYAWAN Where id='$id'");
			$count = mysqli_num_rows($result);
			if($count>0){
				while($row = mysqli_fetch_assoc($result))
				{
					$dept=$row["dept"];
					$nik=$row["nik"];
					$fullname=$row["fullname"];
					$position=$row["position"];
					$address=$row["address"];
					$phone=$row["phone"];
				}
			}					
		?>
		
		<input type="text" name="id" value="<?php echo $id;?>" hidden required="required">
		<input type="text" name="username" value="<?php echo $_SESSION["iss21"]["fullname"];?>" hidden required="required">
		
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="nik">Nik</label>
					<input type="text" class="form-control" id="nik" name="nik" value="<?php if(!empty($nik)){echo $nik;}?>" readonly required="required">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="dept">Department</label>
					<input type="text" class="form-control" id="dept" name="dept" value="<?php if(!empty($dept)){echo $dept;}?>" readonly required="required">
				</div>
			</div>			
			<div class="col-md-12">
				<div class="form-group">
					<label for="fullname">Fullname</label>
					<input type="text" class="form-control" id="fullname" name="fullname" value="<?php if(!empty($fullname)){echo $fullname;}?>" readonly required="required">
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="position">Position</label>
					<input type="text" class="form-control" id="position" name="position" value="<?php if(!empty($position)){echo $position;}?>" readonly required="required">
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="address">Location</label>
					<input type="text" class="form-control" id="address" name="address" value="<?php if(!empty($address)){echo $address;}?>" readonly required="required">
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="phone">Phone</label>
					<input type="text" class="form-control" id="phone" name="phone" value="<?php if(!empty($phone)){echo $phone;}?>" readonly required="required">
				</div>
			</div>
		</div>	
		
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-danger btn-sm" formaction="fc/fc_delete_karyawan_modal.php"><i class="fa fa-refresh"></i> Delete</button>
		<button type="button" class="btn btn-dark btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
	</div>
</form>