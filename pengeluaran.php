<?php
session_start();
include("fc/fc_config.php");
if($_SESSION["iss21"]["authentication"]=="VALID"){
	$filenameImages =$_SESSION["iss21"]["img"];
	$filemtimeImages = filemtime("assets/images/users/".$filenameImages);
	$profile_picture=$filenameImages."?".$filemtimeImages;
	$pages="add-item.php";
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
    <title>View Outgoing :: <?php echo $app_name;?></title>
	
	<style>
		@media screen {			
			.Sembunyikan{
				display: none;
			}			
		}
	</style>	
</head>

<body class="fix-header card-no-border fix-sidebar">
    <?php include("inc/pre_loader.php");?>
    <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">					
                    <a class="navbar-brand" href="dashboard.php">
                        <b>
                            <img src="favicon.png" width="150" height="48" alt="homepage" class="dark-logo" />
							<!--
                            <img src="assets/images/logo-icon.png" alt="homepage" class="dark-logo" />
                            <img src="assets/images/logo-light-icon.png" alt="homepage" class="light-logo" />	
							-->							 
                        </b><span>
						
                </div>
                <div class="navbar-collapse">
					<?php include("inc/profile_right.php");?>
                </div>
            </nav>
        </header>        
		<?php include("inc/sidebar.php");?>		
        <div class="page-wrapper">
		
		
		<!--Content-->
		
		
		<div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-themecolor">Permintaan Keluar</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Permintaan Keluar</li>
                        </ol>
                    </div>										
                </div>
				<div class="row">
                    <div class="col-12">
                        <div class="card card-body">
							<div class="col-sm-12 col-xs-12">
								<?php
										
									if(!empty($_GET['tanggal'])){
										$tanggal=date('Y-m-d',strtotime($_GET['tanggal']));
									}else{
										$tanggal=date("Y-m-d");
									}
									if(!empty($_GET["username"])){
										$username=$_GET["username"];
									}else{
										$username="";
									}
									if(!empty($_GET["faktur"])){
										$faktur=$_GET["faktur"];
									}else{
										$faktur="";
									}
									
									$position2="";
									$Qbranch=$_SESSION["iss21"]["branch"];
									$Quser=$username;
									$sql="Select b.position from OUTGOING a inner join TBLLOGIN b on a.username=b.fullname 
									where a.branch='$Qbranch' and a.username='$Quser' and CONVERT(a.tanggal, DATE)='$tanggal' 
									Group By b.position";
									$result = $con->query($sql);
									$count = mysqli_num_rows($result);																				
									if($count>0){
										while($row = mysqli_fetch_assoc($result))
										{	
											$positionX="Subdit/Bagian ".$row["position"];
										}
									}
									
									
									
									
								?>															
								<div class="table-responsive">
									<div>
										<h5 class="card-title"><b>PERMINTAAN KELUAR</b>								
										<br>Tanggal <?php echo date('d/m/Y',strtotime($_GET['tanggal'])); ?>
										<br>Gudang <?php echo $_SESSION["iss21"]["branch"]; ?>
										<br><?php echo $positionX;?>
										</h5>
									</div>
									<table class="table table-sm table-hover table-bordered" id="table">
										<thead>
											<tr>
												<th>#</th>
												<th>Kode</th>
												<th>Jenis</th>
												<th>Nama Barang</th>
												<th>Satuan</th>
												<th>Jumlah</th>
												<th>Keterangan</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$count=0;
											$no=0;
											$Qbranch=$_SESSION["iss21"]["branch"];
											$Quser=$username;
											$sql="Select a.*, b.position from OUTGOING a inner join TBLLOGIN b on a.username=b.fullname 
											where a.branch='$Qbranch' and a.username='$Quser' and CONVERT(a.tanggal, DATE)='$tanggal' 
											order By a.branch, CONVERT(a.tanggal, DATE), a.jenis, a.barang, a.kode, a.satuan";
											$result = $con->query($sql);
											$count = mysqli_num_rows($result);
																						
											if($count>0){
												while($row = mysqli_fetch_assoc($result))
												{
													$no++;
													$branch2=$row["branch"];	
													$tanggal2=$row["tanggal"];
													$tanggal2=date('Y-m-d',strtotime($tanggal2));
													$kode2=$row["kode"];
													$jenis2=$row["jenis"];
													$barang2=$row["barang"];
													$satuan2=$row["satuan"];
													$qty2=$row["qty"];
													$username2=$row["username"];
													$position2=$row["position"];
													$id2=$row["id"];													
													
													$keterangan2=$row["keterangan"];
													$status2=$row["status"];
													if($status2=="OPEN"){$status2="Waiting Approval";}
													echo"
														<tr>
															<td>$no</td>
															<td>$kode2</td>
															<td>$jenis2</td>
															<td>$barang2</td>
															<td>$satuan2</td>
															<td>$qty2</td>
															<td>$keterangan2</td>
															<td align='center' nowrap>
																<a class='btn btn-danger btn-sm' href='fc/fc_reject_pengeluaran.php?tanggal=$tanggal&username=$username&id=$id2' title='Reject Pengeluaran'> <i class='fa fa-trash'></i> Reject</a>
																<a class='btn btn-success btn-sm' href='fc/fc_approve_pengeluaran.php?tanggal=$tanggal&username=$username&id=$id2' title='Approve Pengeluaran'> <i class='fa fa-check'></i> Approve</a>
															</td>
														</tr>
													";
													
												}
											}
											
											?>											
										</tbody>
									</table>
									<table class="table table-sm table-bordered Sembunyikan" id="table">
										<tr>
											<td colspan="2"><?php echo $_SESSION["iss21"]["branch"].", ".date('d M Y');?></td>
										</tr>
										<tr>
											<td width="50%" align="center">Dibuat Oleh,</td>
											<td width="50%" align="center">Disetujui Oleh,</td>
										</tr>
										<tr>
											<td height="80px"></td>
											<td></td>
										</tr>
										<tr>
											<td align="center"><?php echo $username2; ?></td>
											<td align="center"></td>
										</tr>
									</table>
								</div>								
								
								
								
								
								
								<br>
								<button onclick="printContent('cetak')" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>								
								<div class="table-responsive" id="cetak">
										<h6 class="card-title"><b>TRANSAKSI PENGELUARAN</b>
										<br>Tanggal <?php echo date('d/m/Y',strtotime($_GET['tanggal'])); ?>
										<br>Request By <?php echo $username; ?>
										<br>Gudang <?php echo $_SESSION["iss21"]["branch"]; ?>
										<br><?php echo $positionX;?>										
										</h6>
									<table class="table table-sm table-hover table-bordered" id="table">
										<thead>
											<tr>
												<th>#</th>
												<th>Kode</th>
												<th>Jenis</th>
												<th>Nama Barang</th>
												<th>Satuan</th>
												<th>Jumlah</th>
												<th>Keterangan</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$count=0;
											$no=0;
											$Qbranch=$_SESSION["iss21"]["branch"];
											$Quser=$username;
											$sql="Select * from PENGELUARAN where branch='$Qbranch' and requestby='$Quser' and CONVERT(requestdate, DATE)='$tanggal' order By branch, CONVERT(requestdate, DATE), jenis, barang, kode, satuan";
											$result = $con->query($sql);
											$count = mysqli_num_rows($result);																						
											if($count>0){
												while($row = mysqli_fetch_assoc($result))
												{
													$no++;
													$branch2=$row["branch"];	
													$tanggal2=$row["tanggal"];
													$tanggal2=date('Y-m-d',strtotime($tanggal2));
													$kode2=$row["kode"];
													$jenis2=$row["jenis"];
													$barang2=$row["barang"];
													$satuan2=$row["satuan"];
													$qty2=$row["qty"];
													$username2=$row["username"];
													$keterangan2=$row["keterangan"];
													$id2=$row["id"];													
													echo"
														<tr>
															<td>$no</td>
															<td>$kode2</td>
															<td>$jenis2</td>
															<td>$barang2</td>
															<td>$satuan2</td>
															<td>$qty2</td>
															<td>$keterangan2</td>
														</tr>
													";
													
												}
											}
											
											?>											
										</tbody>
									</table>
									<table class="table table-sm table-bordered Sembunyikan" id="table">
										<tr>
											<td colspan="2"><?php echo $_SESSION["iss21"]["branch"].", ".date('d M Y');?></td>
										</tr>
										<tr>
											<td width="50%" align="center">Dikeluarkan Oleh,</td>
											<td width="50%" align="center">Disetujui Oleh,</td>
										</tr>
										<tr>
											<td height="80px"></td>
											<td></td>
										</tr>
										<tr>
											<td align="center"><?php echo $username2; ?></td>
											<td align="center"></td>
										</tr>
									</table>
								</div>
								
								
								
							</div>
						</div>
					</div>
				
							
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>
		
		
		
		
		<!--End Content-->

        <?php include("inc/footer_details.php");?>
        </div>
    </div>
    <?php include("inc/js_bawah.php");?>
	<script language="javascript">
		function printContent(el){
			var restorepage = document.body.innerHTML;
			var printcontent = document.getElementById(el).innerHTML;
			document.body.innerHTML = printcontent;
			window.print();
			/*document.body.innerHTML = restorepage;*/
			document.location.href=document.location.href;
		}
	</script>
</body>
</html>

<?php

}else{
	session_destroy();
	session_start();
	$_SESSION["iss21"]["info"]="Gagal, anda tidak memiliki ijin untuk mengakses halaman tersebut atau session anda sudah habis, silahkan login ulang.";
	header("location: ../index.php");
}

?>