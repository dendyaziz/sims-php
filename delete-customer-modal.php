<?php
	session_start();
	include("fc/fc_config.php");
?>	
<form method="POST" action="">	
	<div class="modal-header">
		<h4 class="modal-title" id="editModalLabel">Delete Customer</h4>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">		
		<?php
			$id=$_POST['id'];
			$result = $con->query("Select * from CUSTOMER Where id='$id'");
			$count = mysqli_num_rows($result);
			if($count>0){
				while($row = mysqli_fetch_assoc($result))
				{
					$kode=$row["kode"];
					$customer=$row["customer"];
					$address=$row["address"];
					$phone=$row["phone"];
					$contact=$row["contact"];
					$tipe=$row["tipe"];
				}
			}					
		?>
		
		<input type="text" name="id" value="<?php echo $id;?>" hidden required="required">
		<input type="text" name="username" value="<?php echo $_SESSION["iss21"]["fullname"];?>" hidden required="required">
		
		<div class="form-group">
			<label for="kode">Code</label>
			<input type="text" class="form-control" id="kode" name="kode" value="<?php if(!empty($kode)){echo $kode;}?>" readonly required="required">
		</div>
		<div class="form-group">
			<label for="customer">Customer</label>
			<input type="text" class="form-control" id="customer" name="customer" value="<?php if(!empty($customer)){echo $customer;}?>" readonly required="required">
		</div>
		<div class="form-group">
			<label for="address">Address</label>
			<input type="text" class="form-control" id="address" name="address" value="<?php if(!empty($address)){echo $address;}?>" readonly required="required">
		</div>
		<div class="form-group">
			<label for="phone">Phone</label>
			<input type="text" class="form-control" id="phone" name="phone" value="<?php if(!empty($phone)){echo $phone;}?>" readonly required="required">
		</div>
		<div class="form-group">
			<label for="contact">Contact</label>
			<input type="text" class="form-control" id="contact" name="contact" value="<?php if(!empty($contact)){echo $contact;}?>" readonly required="required">
		</div>	
		<div class="form-group">
			<label for="tipe">Tipe</label>
			<input type="text" class="form-control" id="tipe" name="tipe" value="<?php if(!empty($tipe)){echo $tipe;}?>" readonly required="required">
		</div>
		
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-danger btn-sm" formaction="fc/fc_delete_customer_modal.php"><i class="fa fa-refresh"></i> Delete</button>
		<button type="button" class="btn btn-dark btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
	</div>
</form>