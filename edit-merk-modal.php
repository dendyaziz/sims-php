<?php
	session_start();
	include("fc/fc_config.php");
?>	
<form method="POST" action="">	
	<div class="modal-header">
		<h4 class="modal-title" id="editModalLabel">Edit Sub Group</h4>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">
		<?php
			$id=$_POST['id'];
			$result = $con->query("Select group2 from GROUP2 Where id='$id'");
			$count = mysqli_num_rows($result);
			if($count>0){
				while($row = mysqli_fetch_assoc($result))
				{
					$group2=$row["group2"];
				}
			}					
		?>	
		<input type="text" name="id" value="<?php echo $id;?>" hidden required="required">
		<input type="text" name="username" value="<?php echo $_SESSION["iss21"]["fullname"];?>" hidden required="required">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="group2">Sub Group</label>
					<input type="text" class="form-control" id="group2" name="group2" value="<?php if(!empty($group2)){echo $group2;}?>" required="required">
				</div>
			</div>
		</div>
					
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary btn-sm" formaction="fc/fc_edit_group2_modal.php"><i class="fa fa-refresh"></i> Update</button>
		<button type="button" class="btn btn-dark btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
	</div>
</form>