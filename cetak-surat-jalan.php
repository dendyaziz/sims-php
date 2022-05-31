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
    <title>Outgoing :: <?php echo $app_name;?></title>
	
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
                            <img src="title.png" width="32" height="32" alt="homepage" class="dark-logo" />
	                    </b>
						<span>
							<?php echo $app_name;?>														
						</span>						
					</a>					
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
                        <h3 class="text-themecolor">Cetak Surat Jalan</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Cetak Surat Jalan</li>
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
											
											if(strtolower($_SESSION["iss21"]["level"])=="admin"){
												$branch="Semua Gudang";
											}else{
												$branch=$_SESSION["iss21"]["branch"];
											}
											
										}
									}
									
									if(!empty($_POST['tanggal'])){
										$tanggal=date('Y-m-d',strtotime($_POST['tanggal']));
									}else{
										if(!empty($_GET['tanggal'])){
											$tanggal=date('Y-m-d',strtotime($_GET['tanggal']));
										}else{
											$tanggal=date("Y-m-d");
										}
									}
									
									if(!empty($_POST['faktur'])){
										$faktur=$_POST['faktur'];
									}else{
										if(!empty($_GET['faktur'])){
											$faktur=$_GET['faktur'];
										}else{
											$faktur="";
										}
									}									
									
								?>
								
								<form method="POST" action="">
									
									<div class="row">
									
										<?php if(strtolower($_SESSION["iss21"]["level"])=="admin"){?>
										<div class="col-md-4">											
											<div class="form-group">
												<label>Gudang</label>
												<select class="custom-select col-12" id="branch" name="branch" onchange="this.form.submit()" required="required">
													<option value="<?php if(!empty($branch)){echo $branch;}?>"><?php if(!empty($branch)){echo $branch;}else{echo "Pilih...";}?></option>
													<?php
														$result = $con->query("Select branch from BRANCH where branch not in ('$branch','Semua Gudang') group by branch order By id");
														$count = mysqli_num_rows($result);
														if($count>0){
															echo "<option value='Semua Gudang'>Semua Gudang</option>";
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
												<label>Gudang</label>
												<select class="custom-select col-12" id="branch" name="branch" onchange="this.form.submit()" required="required">
													<option value="<?php if(!empty($branch)){echo $branch;}?>"><?php if(!empty($branch)){echo $branch;}else{echo "Pilih...";}?></option>
													<?php
														$result = $con->query("Select branch from BRANCH where branch='$branch' group by branch order By id");
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
												<label for="tanggal">Tanggal</label>
												<input class="form-control form-control-line" type="date" name="tanggal" id="tanggal" onchange="this.form.submit()" value="<?php echo $tanggal; ?>" required="required">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Faktur</label>
												<select class="custom-select col-12" id="faktur" name="faktur" onchange="this.form.submit()" required="required">
													<option value="<?php if(!empty($faktur)){echo $faktur;}?>"><?php if(!empty($faktur)){echo $faktur;}else{echo "Pilih...";}?></option>
													<?php
														$result = $con->query("Select faktur from OUTGOING where convert(tanggal, DATE)='$tanggal' group by faktur order By faktur");
														$count = mysqli_num_rows($result);
														if($count>0){															
															while($row = mysqli_fetch_assoc($result))
															{				
																$faktur1=$row["faktur"];
																echo "<option value='$faktur1'>$faktur1</option>";
															}
														}												
													?>												
												</select>
											</div>
										</div>
									</div>
								</form>								
								<button onclick="printContent('cetak')" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
								<div class="table-responsive" id="cetak">
									<div class="Sembunyikan">
										<h5 class="card-title"><b>SURAT JALAN</b><h5>
										<table cellpadding="2px">
											<thead>
												<?php
													
													$sql1="Select customer,alamat,phone from OUTGOING where faktur='$faktur' group by customer,alamat,phone";
													$result1 = $con1->query($sql1);
													$count1 = mysqli_num_rows($result1);
													if($count1>0){
														while($row1 = mysqli_fetch_assoc($result1))
														{
															$customerX=$row1["customer"];
															$alamatX=$row1["alamat"];
															$phoneX=$row1["phone"];
														}
													}
												
												?>
												<tr style='font-size:small;'><th>No Faktur</th><th style="width:40px;" class="text-center"> : </th><th><?php echo $faktur; ?></th></tr>
												<tr style='font-size:small;'><th>Tanggal</th><th class="text-center"> : </th><th><?php echo date('d/m/Y',strtotime($tanggal)); ?></th></tr>
												<tr style='font-size:small;'><th>Customer</th><th class="text-center"> : </th><th><?php echo $customerX; ?></th></tr>
												<tr style='font-size:small;'><th>Phone</th><th class="text-center"> : </th><th><?php echo $phoneX; ?></th></tr>
												<tr style='font-size:small;'><th>Alamat</th><th class="text-center"> : </th><th><?php echo $alamatX; ?></th></tr>												
											</thead>
										</table>
										
									</div>
									<table class="table table-sm table-striped table-hover table-bordered" id="">
										<thead>
											<tr>
												<th>No</th>												
												<th>Kode</th>
												<th>Jenis</th>
												<th>Barang</th>
												<th>Satuan</th>
												<th class="text-right">Qty</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$count=0;
											$no=0;
											$sql="Select * from OUTGOING where convert(tanggal,DATE)='$tanggal' and faktur='$faktur' order by jenis, barang, satuan, kode";
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
													$qty2=$row["qty"];																							
													if(empty($qty2)){$qty2=0;}
													
													$username2=$row["username"];
													
													echo"
														<tr style='font-size:small;'>
															<td>$no</td>															
															<td>$kode2</td>
															<td>$jenis2</td>
															<td>$barang2</td>
															<td>$satuan2</td>
															<td align='right'>".number_format($qty2)."</td>
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
											<td width="50%" align="center">Diterima Oleh,</td>
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
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/datatables/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.responsive.min.js"></script>	
	<script type="text/javascript">
		$('#data-table').DataTable({
			"responsive": true,
			"autoWidth": false,
			"lengthMenu": [[ 10, 25, 50, 100, -1], [ 10, 25, 50, 100, "All"]],
			"order": [[ 0, 'asc' ],]
		});
	</script>
    <?php include("inc/js_bawah.php");?>
	<script language="javascript">
		function printContent(el){
			var a=document.getElementById('branch').value;
			var b=document.getElementById('tanggal').value;
			var c=document.getElementById('faktur').value;
			
			var restorepage = document.body.innerHTML;
			var printcontent = document.getElementById(el).innerHTML;
			document.body.innerHTML = printcontent;
			window.print();
			document.body.innerHTML = restorepage;
			document.location.href='cetak-surat-jalan.php?branch=' + a + '&tanggal=' + b + '&faktur='+ c;
		}
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