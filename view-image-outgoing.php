<?php
	session_start();
	include("fc/fc_config.php");
	$kode=$_POST['kode'];
	$result = $con->query("Select gambar from BARANG Where kode='$kode'");
	$count = mysqli_num_rows($result);
	if($count>0){
		while($row = mysqli_fetch_assoc($result))
		{
			$gambar2=$row["gambar"];											
			$filenameImages2 = $gambar2;
			$filemtimeImages2 = filemtime("barang/".$filenameImages2);
			$profile_picture2=$filenameImages2."?".$filemtimeImages2;
			if(empty($gambar2)){
				$url2="<img src='barang/no.png' width='150' height='auto' />";
			}else{
				$url2="<img src='barang/$profile_picture2' width='150' height='auto' data-toggle='modal' data-toggle='modal' data-target='#popupImages' data-whatever='@getbootstrap' />";
			
				?>
				
				<style>
					.modal-dialog {
						height: 100%;
						width: 100%;
						display: flex;
						align-items: center;
					}
					.modal-content {
						padding-left:10px;
						padding-right:10px;
						margin: 0 auto;
					}
				</style>
				<div class="modal" id="popupImages" tabindex="-1" role="dialog" aria-labelledby="popupImagesLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
						
							<div class="modal-header">
								<h4 class="modal-title" id="popupImagesLabel">Preview Produk</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							</div>
							<div class="modal-body text-center">

								<?php echo "<img src='barang/$profile_picture2' width='300' height='auto' />";?>
													
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-dark btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
							</div>
							
						</div>
					</div>
				</div>
				
				<?php
			}
		}
	}
	echo $url2;	
?>

	
	
