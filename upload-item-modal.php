<?php
	session_start();
	include("fc/fc_config.php");
?>	
	<div class="modal-header">
		<h4 class="modal-title" id="uploadModalLabel">Upload Foto Item</h4>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">
		
		<form action="fc/fc_add_gambar.php" method="POST" enctype="multipart/form-data">
			<input type="text" name="id" value="<?php echo $_POST["id"];?>" hidden required="required" />
			<input type="file" name="file" />
			<input type="submit" name="upload" value="Upload" />
		</form>
		
	</div>
	<div class="modal-footer">
		<!--
		<button type="submit" class="btn btn-primary btn-sm" formaction="fc/fc_add_gambar.php"><i class="fa fa-paper-plane"></i> Upload</button>
		<button type="button" class="btn btn-dark btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
		-->
	</div>
	
	
