<?php
	session_start();
	include("fc/fc_config.php");
	$id=$_POST['id'];
	$result = $con->query("Select gambar from BARANG Where id='$id'");
	$count = mysqli_num_rows($result);
	if($count>0){
		while($row = mysqli_fetch_assoc($result))
		{
			$gambar2=$row["gambar"];											
			$filenameImages2 = $gambar2;
			$filemtimeImages2 = filemtime("barang/".$filenameImages2);
			$profile_picture2=$filenameImages2."?".$filemtimeImages2;
			if(empty($gambar2)){
				$url2="<img src='barang/no.png' id='myid' width='300' height='auto' style='border:1px solid #999;' />";
			}else{
				$url2="<img src='barang/$profile_picture2' id='myid' width='300' height='auto' style='border:1px solid #999;' />";			
			}
		}
	}
	?>
	
	<div class="modal-header">
		<h4 class="modal-title" id="popupImagesLabel">Ganti Gambar Produk</h4>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body text-center">

		<?php echo $url2;?><br><br>
		<script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<!--<img id = "myid" src = "#" alt = "new image" />-->
				   
		   
							
	</div>
	<div class="modal-footer">
		<form id = "form1" runat = "server" action="fc/fc_add_gambar.php" method="POST" enctype="multipart/form-data" class="btn btn-primary btn-sm">
		   <input type="text" name="id" value="<?php echo $_POST["id"];?>" hidden required="required" />	
		   <input type ='file' name='file' id = "demo" />
		   <input type="submit" name="upload" value="Change"  />
		</form>
	</div>
	
	<script src="js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript">
		function display(input) {
		   if (input.files && input.files[0]) {
			  var reader = new FileReader();
			  reader.onload = function(event) {
				 $('#myid').attr('src', event.target.result);
			  }
			  reader.readAsDataURL(input.files[0]);
		   }
		}
		$("#demo").change(function() {
		   display(this);
		});
	</script>
	
	
	
