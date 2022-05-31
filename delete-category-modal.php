<?php
	session_start();
	include("fc/fc_config.php");
?>	
<form method="POST" action="">	
	<div class="modal-header">
		<h4 class="modal-title" id="editModalLabel">Delete Group</h4>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">		
		<?php
			$id=$_POST['id'];
			$result = $con->query("Select * from JENIS Where id='$id'");
			$count = mysqli_num_rows($result);
			if($count>0){
				while($row = mysqli_fetch_assoc($result))
				{
					$jenis=$row["jenis"];
				}
			}					
		?>
		
		<input type="text" name="id" value="<?php echo $id;?>" hidden required="required">
		<input type="text" name="username" value="<?php echo $_SESSION["iss21"]["fullname"];?>" hidden required="required">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="jenis">Group</label>
					<input type="text" class="form-control" id="jenis" name="jenis" value="<?php if(!empty($jenis)){echo $jenis;}?>" readonly required="required">
				</div>
			</div>
		</div>
		
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-danger btn-sm" formaction="fc/fc_delete_category_modal.php"><i class="fa fa-refresh"></i> Delete</button>
		<button type="button" class="btn btn-dark btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
	</div>
</form>