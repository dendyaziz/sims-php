<?php
	session_start();
	include("fc/fc_config.php");
?>	
<form method="POST" action="">	
	<div class="modal-header">
		<h4 class="modal-title" id="editModalLabel">Edit Gudang</h4>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">		
		<?php
			$id=$_POST['id'];
			$result = $con->query("Select * from BRANCH Where id='$id'");
			$count = mysqli_num_rows($result);
			if($count>0){
				while($row = mysqli_fetch_assoc($result))
				{
					$branch1=$row["branch"];
					$location1=$row["location"];
				}
			}		
		?>	
		<input type="text" name="id" value="<?php echo $id;?>" hidden required="required">
		<input type="text" name="username" value="<?php echo $_SESSION["iss21"]["fullname"];?>" hidden required="required">
		<div class="form-group">
			<label for="branch1">Nama Gudang</label>
			<input type="text" class="form-control" id="branch1" name="branch" value="<?php if(!empty($branch1)){echo $branch1;}?>" <?php if(empty($branch1)){echo "autofocus";}?> required="required">
		</div>
		<div class="form-group">
			<label for="location">Lokasi Gudang</label>
			<input type="location" class="form-control" id="location" name="location" value="<?php if(!empty($location1)){echo $location1;}?>" <?php if(empty($location1)){echo "autofocus";}?> required="required">
		</div>		
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary btn-sm" formaction="fc/fc_edit_branch_modal.php"><i class="fa fa-refresh"></i> Update</button>
		<button type="button" class="btn btn-dark btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
	</div>
</form>