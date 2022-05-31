<?php
	session_start();
	include("fc/fc_config.php");
?>	
<form method="POST" action="">	
	<div class="modal-header">
		<h4 class="modal-title" id="editModalLabel">Edit Item</h4>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">
		<?php
			$id=$_POST['id'];
			$result = $con->query("Select * from BARANG Where id='$id'");
			$count = mysqli_num_rows($result);
			if($count>0){
				while($row = mysqli_fetch_assoc($result))
				{
					$kode=$row["kode"];
					$jenis=$row["jenis"];
					$subgroup=$row["subgroup"];
					$merk=$row["merk"];
					$barang=$row["barang"];													
					$satuan=$row["satuan"];
					$harga_beli=$row["harga_beli"];
					$harga_jual=$row["harga_jual"];
				}
			}					
		?>	
		<input type="text" name="id" value="<?php echo $id;?>" hidden required="required">
		<input type="text" name="username" value="<?php echo $_SESSION["iss21"]["fullname"];?>" hidden required="required">
		<div class="row">
		    <div class="col-md-6">
				<div class="form-group">
					<label for="kode">Code</label>
					<input type="text" class="form-control" id="kode" name="kode" value="<?php if(!empty($kode)){echo $kode;}?>" readonly required="required">
				</div>
			</div>
			<div class="col-md-6">											
				<div class="form-group">
					<label>Group</label>
					<select class="custom-select col-12" id="jenis" name="jenis" required="required">
						<option value="<?php if(!empty($jenis)){echo $jenis;}?>"><?php if(!empty($jenis)){echo $jenis;}else{echo "Pilih...";}?></option>
						<?php
							$result = $con->query("Select jenis from JENIS order By jenis");
							$count = mysqli_num_rows($result);
							if($count>0){						
								while($row = mysqli_fetch_assoc($result))
								{				
									$jenis1=$row["jenis"];
									echo "<option value='$jenis1'>$jenis1</option>";
								}
							}												
						?>												
					</select>
				</div>											
			</div>
			<div class="col-md-6">											
				<div class="form-group">
					<label>Sub Group</label>
					<select class="custom-select col-12" id="subgroup" name="subgroup" required="required">
						<option value="<?php if(!empty($subgroup)){echo $subgroup;}?>"><?php if(!empty($subgroup)){echo $subgroup;}else{echo "Pilih...";}?></option>
						<?php
							$result = $con->query("Select subgroup from SUBGROUP order By subgroup");
							$count = mysqli_num_rows($result);
							if($count>0){						
								while($row = mysqli_fetch_assoc($result))
								{				
									$subgroup1=$row["subgroup"];
									echo "<option value='$subgroup1'>$subgroup1</option>";
								}
							}												
						?>												
					</select>
				</div>											
			</div>
			<div class="col-md-6">											
				<div class="form-group">
					<label>Merk</label>
					<select class="custom-select col-12" id="merk" name="merk" required="required">
						<option value="<?php if(!empty($merk)){echo $merk;}?>"><?php if(!empty($merk)){echo $merk;}else{echo "Pilih...";}?></option>
						<?php
							$result = $con->query("Select merk from MERK order By merk");
							$count = mysqli_num_rows($result);
							if($count>0){						
								while($row = mysqli_fetch_assoc($result))
								{				
									$merk1=$row["merk"];
									echo "<option value='$merk1'>$merk1</option>";
								}
							}												
						?>												
					</select>
				</div>											
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="barang">Item Description</label>
					<input type="text" class="form-control" id="barang" name="barang" value="<?php if(!empty($barang)){echo $barang;}?>" required="required">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="satuan">Unit</label>
					<input type="text" class="form-control" id="satuan" name="satuan" value="<?php if(!empty($satuan)){echo $satuan;}?>" required="required">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="harga_beli">Harga Beli</label>
					<input type="number" class="form-control" id="harga_beli" name="harga_beli" value="<?php if(!empty($harga_beli)){echo $harga_beli;}?>" required="required">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="harga_jual">Harga Jual</label>
					<input type="number" class="form-control" id="harga_jual" name="harga_jual" value="<?php if(!empty($harga_jual)){echo $harga_jual;}?>" required="required">
				</div>
			</div>
		</div>			
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary btn-sm" formaction="fc/fc_edit_item_modal.php"><i class="fa fa-refresh"></i> Update</button>
		<button type="button" class="btn btn-dark btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
	</div>
</form>