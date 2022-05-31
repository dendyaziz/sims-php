<?php
session_start();
include("fc/fc_config.php");
if($_SESSION["iss21"]["authentication"]=="VALID"){
	$filenameImages =$_SESSION["iss21"]["img"];
	$filemtimeImages = filemtime("assets/images/users/".$filenameImages);
	$profile_picture=$filenameImages."?".$filemtimeImages;
?>
<!--
Author: Susatyo Widodo Pratama
Author URL: https://softkita.id
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("inc/meta_tag.php");?>
    <title>Kartu Stok Barang</title>	
</head>

<body class="fix-header card-no-border fix-sidebar">
	<div class="row">
		<div class="col-12">
			<div class="card card-body">
				<?php
										
					if(!empty($_POST['branch'])){
						$branch=$_POST["branch"];
					}else{
						
						if(!empty($_GET["branch"])){
							$branch=$_GET["branch"];
						}else{
							
							if(strtolower($_SESSION["iss21"]["level"])=="admin"){
								$branch="Semua Gudang";
							}else{
								$branch=$_SESSION["iss21"]["branch"];
							}
							
						}
					}
					
					if(!empty($_POST['awal'])){
						$awal=date('Y-m-d',strtotime($_POST['awal']));
					}else{
						if(!empty($_GET['awal'])){
							$awal=date('Y-m-d',strtotime($_GET['awal']));
						}else{
							$awal=date("Y-m-d");
						}
					}
					
					if(!empty($_POST['akhir'])){
						$akhir=date('Y-m-d',strtotime($_POST['akhir']));
					}else{
						if(!empty($_GET['akhir'])){
							$akhir=date('Y-m-d',strtotime($_GET['akhir']));
						}else{
							$akhir=date("Y-m-d");
						}
					}

					if(!empty($_POST['jenis'])){
						$jenis=$_POST["jenis"];
					}else{										
						if(!empty($_GET["jenis"])){
							$jenis=$_GET["jenis"];
						}else{
							$jenis="";											
						}
					}
					
					if(!empty($_POST['barang'])){
						$barang=$_POST["barang"];
					}else{										
						if(!empty($_GET["barang"])){
							$barang=$_GET["barang"];
						}else{
							$barang="";											
						}
					}
					
					if(!empty($_POST['satuan'])){
						$satuan=$_POST["satuan"];
					}else{										
						if(!empty($_GET["satuan"])){
							$satuan=$_GET["satuan"];
						}else{
							$satuan="";											
						}
					}
					
					if(!empty($_POST['kode'])){
						$kode=$_POST["kode"];
					}else{										
						if(!empty($_GET["kode"])){
							$kode=$_GET["kode"];
						}else{
							$kode="";											
						}
					}
				?>
				<div class="col-sm-12 col-xs-12">
					<div class="table-responsive" id="cetak">
						<table class="table table-sm table-striped table-hover table-bordered" id="data-table" style='color:black;'>
							<thead>
								<tr style='font-size:small;'>
									<th>#</th>
									<th>Gudang</th>
									<th>Tanggal</th>
									<th>Username</th>
									<th>Faktur</th>												
									<th>Nama Barang</th>
									<th class="text-right">Qty</th>
									<th>Satuan</th>												
									<th>Transaksi</th>										
								</tr>
							</thead>
							<tbody>
								<?php
								$count=0;
								$no=0;
								$total=0;
								$pAwal=$awal." 00:00:00";
								$pAkhir=$akhir." 23:59:59";
								if($branch=="Semua Gudang"){
									$sql="Select * from HISTORY where (transdate between '$pAwal' and '$pAkhir') and jenis='$jenis' and kode='$kode' order by branch, transdate";
								}else{
									$sql="Select * from HISTORY where branch='$branch' and (transdate between '$pAwal' and '$pAkhir') and jenis='$jenis' and kode='$kode' order by branch, transdate";
								}
								$result = $con->query($sql);
								$count = mysqli_num_rows($result);
								if($count>0){
									while($row = mysqli_fetch_assoc($result))
									{
										$no++;
										$branch2=$row["branch"];
										$transdate2=$row["transdate"];
										$transdate2=date('Y-m-d H:m',strtotime($transdate2));
										$username2=$row["username"];
										$faktur2=$row["faktur"];												
										
										$barang2=$row["barang"];
										$satuan2=$row["satuan"];
										$qty2=$row["qty"];																							
										if(empty($qty2)){$qty2=0;}
										$transaksi2=$row["transaksi"];
										
										echo"
											<tr style='font-size:small;'>
												<td>$no</td>
												<td>$branch2</td>
												<td>$transdate2</td>
												<td>$username2</td>
												<td>$faktur2</td>
												<td>$barang2</td>
												<td align='right'>".number_format($qty2)."</td>
												<td>$satuan2</td>
												<td>$transaksi2</td>
											</tr>														
										";													
									}									
								}											
								?>											
							</tbody>
						</table>									
						
					</div>								
					
					
					
					
				</div>
			</div>
		</div>
	
				
	<!-- ============================================================== -->
	<!-- End PAge Content -->
	<!-- ============================================================== -->
</div>
		
	
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/datatables/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.responsive.min.js"></script>
	<script src="js/dataTables.buttons.min.js"></script>
	<script src="js/buttons.flash.min.js"></script>
	<script src="js/jszip.min.js"></script>
	<script src="js/pdfmake.min.js"></script>
	<script src="js/vfs_fonts.js"></script>
	<script src="js/buttons.html5.min.js"></script>
	<script src="js/buttons.print.min.js"></script>

	<script type="text/javascript">
		$('#data-table').DataTable({
			dom: 'Bfrtip',
			buttons: [
				'copy','excel','pdf'
			],
			"lengthMenu": [[ -1], [ "All"]],
		});
		$('.data-table').DataTable({
			"responsive": true,
			"autoWidth": false,
			"lengthMenu": [[-1], ["All"]],
			"order": [[ 0, 'asc' ],]
		});
	</script>
	
</body>
</html>

<?php

}else{
	session_destroy();
	session_start();
	$_SESSION["iss21"]["info"]="Gagal, anda tidak memiliki ijin untuk mengakses halaman tersebut atau session anda sudah habis, silahkan login ulang.";
	header("location: index.php");
}

?>