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
    <title>Saldo Stok Barang</title>	
</head>

<body class="fix-header card-no-border fix-sidebar">
	<div class="row">
		<div class="col-12">
			<div class="card card-body">
				<?php
										
					if(!empty($_POST['branch'])){$branch=$_POST["branch"];}else{if(!empty($_GET["branch"])){$branch=$_GET["branch"];}else{if(strtolower($_SESSION["iss21"]["level"])=="admin"){$branch="Semua Gudang";}else{$branch=$_SESSION["iss21"]["branch"];}}}
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
						<table class="table table-sm table-striped table-hover table-bordered" id="data-table" style="color:black;">
							<thead>
								<tr>
									<th>#</th>
									<th>Kode</th>
									<th>Jenis</th>
									<th>Nama Barang</th>
									<th class="text-right">Stok</th>
									<th>Satuan</th>												
									<th class="text-right">Harga Beli</th>
									<th class="text-right">Nilai Barang</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$nominal2=0;
								$count=0;
								$no=0;
								if($kode=="Semua Kode Barang"){
									if($jenis=="Semua Jenis Barang"){											
										if($branch=="Semua Gudang"){
											$sql="Select a.kode, a.jenis, a.barang, a.satuan, sum(a.saldo) as saldo, b.harga_beli from STOK a inner join BARANG b on a.kode=b.kode and a.jenis=b.jenis and a.barang=b.barang group by a.kode, a.jenis, a.barang, a.satuan, b.harga_beli order by a.jenis,a.barang,a.satuan";
										}else{
											$sql="Select a.kode, a.jenis, a.barang, a.satuan, sum(a.saldo) as saldo, b.harga_beli from STOK a inner join BARANG b on a.kode=b.kode and a.jenis=b.jenis and a.barang=b.barang where a.branch='$branch' group by a.kode, a.jenis, a.barang, a.satuan, b.harga_beli order by a.jenis,a.barang,a.satuan";
										}												
									}else{
										if($branch=="Semua Gudang"){
											$sql="Select a.kode, a.jenis, a.barang, a.satuan, sum(a.saldo) as saldo, b.harga_beli from STOK a inner join BARANG b on a.kode=b.kode and a.jenis=b.jenis and a.barang=b.barang where a.jenis='$jenis' group by a.kode, a.jenis, a.barang, a.satuan, b.harga_beli order by a.jenis,a.barang,a.satuan";
										}else{
											$sql="Select a.kode, a.jenis, a.barang, a.satuan, sum(a.saldo) as saldo, b.harga_beli from STOK a inner join BARANG b on a.kode=b.kode and a.jenis=b.jenis and a.barang=b.barang where a.branch='$branch' and a.jenis='$jenis' group by a.kode, a.jenis, a.barang, a.satuan, b.harga_beli order by a.jenis,a.barang,a.satuan";
										}
									}
								}else{
									if($branch=="Semua Gudang"){
										$sql="Select a.kode, a.jenis, a.barang, a.satuan, sum(a.saldo) as saldo, b.harga_beli from STOK a inner join BARANG b on a.kode=b.kode and a.jenis=b.jenis and a.barang=b.barang where a.jenis='$jenis' and a.kode='$kode' group by a.kode, a.jenis, a.barang, a.satuan, b.harga_beli order by a.jenis,a.barang,a.satuan";
									}else{
										$sql="Select a.kode, a.jenis, a.barang, a.satuan, sum(a.saldo) as saldo, b.harga_beli from STOK a inner join BARANG b on a.kode=b.kode and a.jenis=b.jenis and a.barang=b.barang where a.branch='$branch' and a.jenis='$jenis' and a.kode='$kode' group by a.kode, a.jenis, a.barang, a.satuan, b.harga_beli order by a.jenis,a.barang,a.satuan";
									}												
								}
								$result = $con->query($sql);
								$count = mysqli_num_rows($result);
								if($count>0){
									while($row = mysqli_fetch_assoc($result))
									{
										$no++;
										$kode2=$row["kode"];
										$jenis2=$row["jenis"];
										$barang2=$row["barang"];
										$satuan2=$row["satuan"];
										$saldo2=$row["saldo"];
										$harga_beli2=$row["harga_beli"];
										
										if(empty($saldo2)){$saldo=0;}
										if(empty($harga_beli2)){$harga_beli2=0;}													
										$nilai_barang=$saldo2*$harga_beli2;													
										$nominal=$nominal+$nilai_barang;
										
										echo"
											<tr>
												<td>$no</td>															
												<td>$kode2</td>
												<td>$jenis2</td>
												<td>$barang2</td>
												<td align='right'>".number_format($saldo2)."</td>
												<td>$satuan2</td>
												<td align='right'>".number_format($harga_beli2)."</td>
												<td align='right'>".number_format($nilai_barang)."</td>
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