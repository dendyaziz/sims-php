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
    <title>Laporan Barang Keluar</title>	
</head>

<body class="fix-header card-no-border fix-sidebar">
	<div class="row">
		<div class="col-12">
			<div class="card card-body">
				<?php
					if(!empty($_POST['faktur'])){$faktur=$_POST['faktur'];}else{if(!empty($_GET['faktur'])){$faktur=$_GET['faktur'];}else{$faktur="";}}			
					if(!empty($_POST['branch'])){$branch=$_POST["branch"];}else{if(!empty($_GET["branch"])){$branch=$_GET["branch"];}else{if(strtolower($_SESSION["iss21"]["level"])=="admin"){$branch="Semua Gudang";}else{$branch=$_SESSION["iss21"]["branch"];}}}
					if(!empty($_POST['awal'])){$awal=date('Y-m-d',strtotime($_POST['awal']));}else{if(!empty($_GET['awal'])){$awal=date('Y-m-d',strtotime($_GET['awal']));}else{$awal=date("Y-m-d");}}
					if(!empty($_POST['akhir'])){$akhir=date('Y-m-d',strtotime($_POST['akhir']));}else{if(!empty($_GET['akhir'])){$akhir=date('Y-m-d',strtotime($_GET['akhir']));}else{$akhir=date("Y-m-d");}}									
					if(!empty($_POST['kode_customer'])){$kode_customer=$_POST['kode_customer'];}else{if(!empty($_GET['kode_customer'])){$kode_customer=$_GET['kode_customer'];}else{$kode_customer="";}}
					if(!empty($kode_customer)){
						$result = $con->query("Select * from CUSTOMER where kode='$kode_customer'");											
						while($row = mysqli_fetch_assoc($result))
						{
							$customer=$row["customer"];
							$alamat=$row["alamat"];
							$telepon=$row["telepon"];
							$person=$row["person"];		
						}
					}else{
						$kode_customer="Semua Customer";
					}
					if(!empty($_POST['jenis'])){$jenis=$_POST['jenis'];}else{if(!empty($_GET['jenis'])){$jenis=$_GET['jenis'];}else{$jenis="Semua Jenis Barang";}}
					
					if(!empty($_POST['kode'])){$kode=$_POST['kode'];}else{if(!empty($_GET['kode'])){$kode=$_GET['kode'];}else{$kode="";}}
					if(!empty($kode)){
						$result = $con->query("Select * from BARANG where kode='$kode'");											
						while($row = mysqli_fetch_assoc($result))
						{
							$barang=$row["barang"];
							$satuan=$row["satuan"];		
						}
					}else{
						$kode="Semua Kode Barang";
					}						
					
				?>
				<div class="col-sm-12 col-xs-12">
					<div class="table-responsive" id="cetak">									
						<table class="table table-sm table-striped table-hover table-bordered" id="data-table" style='color:black;'>
							<thead>
								<tr>
									<th>#</th>
									<th>Tanggal</th>
									<th>Faktur</th>
									<th>Customer</th>
									<th>Kode</th>
									<th>Jenis</th>
									<th>Barang</th>
									<th class="text-right">Qty</th>
									<th>Satuan</th>
									<th class="text-right">Harga</th>
									<th class="text-right">Subtotal</th>
								</tr>
							</thead>
							<tbody>
								<?php
								
								$count=0;
								$no=0;											
								$pAwal=$awal." 00:00:00";
								$pAkhir=$akhir." 23:59:59";
								if($kode=="Semua Kode Barang"){
									if($jenis=="Semua Jenis Barang"){
										if($kode_customer=="Semua Customer"){
											if($branch=="Semua Gudang"){												
												$sql="Select * from OUTGOING where faktur like '%$faktur%' and tanggal between '$pAwal' and '$pAkhir' order by tanggal, customer, faktur, jenis, barang, satuan, kode";
											}else{
												$sql="Select * from OUTGOING where faktur like '%$faktur%' and branch='$branch' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
											}
										}else{
											if($branch=="Semua Gudang"){												
												$sql="Select * from OUTGOING where faktur like '%$faktur%' and kode_customer='$kode_customer' and tanggal between '$pAwal' and '$pAkhir' order by tanggal, customer, faktur, jenis, barang, satuan, kode";
											}else{
												$sql="Select * from OUTGOING where faktur like '%$faktur%' and kode_customer='$kode_customer' and branch='$branch' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
											}
										}
									}else{
										if($kode_customer=="Semua Customer"){
											if($branch=="Semua Gudang"){												
												$sql="Select * from OUTGOING where faktur like '%$faktur%' and jenis='$jenis' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
											}else{
												$sql="Select * from OUTGOING where faktur like '%$faktur%' and branch='$branch' and jenis='$jenis' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
											}
										}else{
											if($branch=="Semua Gudang"){												
												$sql="Select * from OUTGOING where faktur like '%$faktur%' and kode_customer='$kode_customer' and jenis='$jenis' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
											}else{
												$sql="Select * from OUTGOING where faktur like '%$faktur%' and kode_customer='$kode_customer' and branch='$branch' and jenis='$jenis' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
											}
										}
									}
								}else{
									
									if($kode_customer=="Semua Customer"){
										if($branch=="Semua Gudang"){												
											$sql="Select * from OUTGOING where faktur like '%$faktur%' and jenis='$jenis' and kode='$kode' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
										}else{
											$sql="Select * from OUTGOING where faktur like '%$faktur%' and branch='$branch' and jenis='$jenis' and kode='$kode' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
										}
									}else{
										if($branch=="Semua Gudang"){												
											$sql="Select * from OUTGOING where faktur like '%$faktur%' and kode_customer='$kode_customer' and jenis='$jenis' and kode='$kode' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
										}else{
											$sql="Select * from OUTGOING where faktur like '%$faktur%' and branch='$branch' and kode_customer='$kode_customer' and jenis='$jenis' and kode='$kode' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
										}
									}

								}
								$grandtotal=0;
								$result = $con->query($sql);
								$count = mysqli_num_rows($result);
								if($count>0){
									while($row = mysqli_fetch_assoc($result))
									{
										$no++;
										$tanggal2=$row["tanggal"];
										$tanggal2=date('Y-m-d',strtotime($tanggal2));
										
										$faktur2=$row["faktur"];
										$customer2=$row["customer"];
										$alamat2=$row["alamat"];
										$telepon2=$row["telepon"];													
										
										$kode2=$row["kode"];
										$jenis2=$row["jenis"];
										$barang2=$row["barang"];
										$satuan2=$row["satuan"];
										$qty2=$row["qty"];
										$harga2=$row["harga"];													
										if(empty($qty2)){$qty2=0;}
										if(empty($harga2)){$harga2=0;}
										$subtotal=$qty2*$harga2;
										$grandtotal=$grandtotal+$subtotal;
										
										$username2=$row["username"];
										
										echo"
											<tr style='font-size:small;'>
												<td>$no</td>
												<td>$tanggal2</td>
												<td>$faktur2</td>
												<td>$customer2</td>
												<td>$kode2</td>
												<td>$jenis2</td>
												<td>$barang2</td>
												<td align='right'>".number_format($qty2)."</td>
												<td>$satuan2</td>
												<td align='right'>".number_format($harga2)."</td>
												<td align='right'>".number_format($subtotal)."</td>
											</tr>
											
										";													
									}
									
								}else{
									
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