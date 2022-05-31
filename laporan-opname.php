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
    <title>Opname :: <?php echo $app_name;?></title>
	
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
                        <h3 class="text-themecolor">Laporan Stock Opname</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Laporan Stock Opname</li>
                        </ol>
                    </div>										
                </div>
				<div class="row">
                    <div class="col-12">
                        <div class="card card-body">
							<div class="col-sm-12 col-xs-12">
								<?php
										
									if(!empty($_POST['branch'])){
										$branch=$_POST["branch"];
									}else{
										
										if(!empty($_GET["branch"])){
											$branch=$_GET["branch"];
										}else{
											
											if($_SESSION["iss21"]["branch"]=="Head Office"){
												$branch="All Branch";
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
									
								?>
								
								<form method="POST" action="">
									
									<div class="row">
									
										<?php if(strtolower($_SESSION["iss21"]["branch"])=="head office"){?>
										<div class="col-md-4">											
											<div class="form-group">
												<label>Branch</label>
												<select class="custom-select col-12" id="branch" name="branch" onchange="this.form.submit()" required="required">
													<option value="<?php if(!empty($branch)){echo $branch;}?>"><?php if(!empty($branch)){echo $branch;}else{echo "Pilih Branch...";}?></option>
													<?php
														$result = $con->query("Select branch from BRANCH where branch<>'Head Office' group by branch order By branch");
														$count = mysqli_num_rows($result);
														if($count>0){
															echo "<option value='All Branch'>All Branch</option>";
															while($row = mysqli_fetch_assoc($result))
															{				
																$branch1=$row["branch"];
																echo "<option value='$branch1'>$branch1</option>";
															}
														}												
													?>												
												</select>
											</div>											
										</div>
										<?php }else{ ?>
										<div class="col-md-4">											
											<div class="form-group">
												<label>Branch</label>
												<select class="custom-select col-12" id="branch" name="branch" onchange="this.form.submit()" required="required">
													<option value="<?php if(!empty($branch)){echo $branch;}?>"><?php if(!empty($branch)){echo $branch;}else{echo "Pilih Branch...";}?></option>
													<?php
														$result = $con->query("Select branch from BRANCH where branch='$branch' group by branch order By branch");
														$count = mysqli_num_rows($result);
														if($count>0){															
															while($row = mysqli_fetch_assoc($result))
															{				
																$branch1=$row["branch"];
																echo "<option value='$branch1'>$branch1</option>";
															}
														}												
													?>												
												</select>
											</div>											
										</div>
										<?php } ?>
									
										<div class="col-md-4">
											<div class="form-group">
												<label for="awal">Awal</label>
												<input class="form-control form-control-line" type="date" name="awal" id="awal" onchange="this.form.submit()" value="<?php echo $awal; ?>" required="required">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="akhir">Akhir</label>
												<input class="form-control form-control-line" type="date" name="akhir" id="akhir" onchange="this.form.submit()" value="<?php echo $akhir; ?>" required="required">
											</div>
										</div>
									</div>
								</form>								
								<button onclick="printContent('cetak')" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
								<div class="table-responsive" id="cetak">
									<div class="Sembunyikan">
										<h5 class="card-title"><b>LAPORAN STOCK OPNAME</b>				
										<br>Periode <?php echo date('d/m/Y',strtotime($awal))." s/d ".date('d/m/Y',strtotime($akhir)); ?>
										<br>Cabang <?php echo $branch; ?>
										</h5>
									</div>
									<table class="table table-sm table-hover table-bordered" id="table">
										<thead>
											<tr>
												<th>#</th>
												<th>Branch</th>
												<th>Tanggal</th>
												<th>Kode</th>
												<th>Jenis</th>
												<th>Nama Barang</th>
												<th>Satuan</th>												
												<th class="text-right">Opname</th>
												<th class="text-right">Stok</th>
												<th class="text-right">Selisih</th>
												<th>Keterangan</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$count=0;
											$no=0;
											$total=0;
											$pAwal=$awal." 00:00:00";
											$pAkhir=$akhir." 23:59:59";
											if($branch=="All Branch"){
												$sql="Select * from OPNAME where tanggal between '$pAwal' and '$pAkhir' order by branch, tanggal, username, jenis, barang, satuan, kode";
											}else{
												$sql="Select * from OPNAME where branch='$branch' and (tanggal between '$pAwal' and '$pAkhir') order by branch, tanggal, username, jenis, barang, satuan, kode";
											}
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
													if(empty($qty2)){$qty2=0;}
													$stok2=$row["stok"];
													if(empty($stok2)){$stok2=0;}
													$selisih2=$stok2-$qty2;
													$id2=$row["id"];
													$keterangan2=$row["keterangan"];
													
													echo"
														<tr>
															<td>$no</td>
															<td>$branch2</td>
															<td>$tanggal2</td>
															<td>$kode2</td>
															<td>$jenis2</td>
															<td>$barang2</td>
															<td>$satuan2</td>
															<td align='right'>".number_format($qty2)."</td>
															<td align='right'>".number_format($stok2)."</td>
															<td align='right'>".number_format($selisih2)."</td>
															<td>$keterangan2</td>															
														</tr>														
													";													
												}
												
											}											
											?>											
										</tbody>
									</table>
									<!--
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
									-->
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
			var a=document.getElementById('branch').value;
			var b=document.getElementById('awal').value;
			var c=document.getElementById('akhir').value;
			
			var restorepage = document.body.innerHTML;
			var printcontent = document.getElementById(el).innerHTML;
			document.body.innerHTML = printcontent;
			window.print();
			document.body.innerHTML = restorepage;
			document.location.href='laporan-opname.php?branch=' + a + '&awal=' + b + '&akhir='+ c;
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