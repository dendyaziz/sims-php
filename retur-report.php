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
    <title>Return Transaction Report :: <?php echo $app_name;?></title>
	
	<style>
		@media screen {			
			.Sembunyikan{
				display: none;
			}			
		}
		@media print {
		  html, body {
			display: block;
			font-family:"Courier New", Courier, monospace;
			font-size:auto;
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
                        <h3 class="text-themecolor">Laporan Pengembalian Barang</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Laporan Pengembalian Barang</li>
                        </ol>
                    </div>	
					<div class="col-md-7 align-self-center text-right d-none d-md-block">
                        <!--<button onclick="printContent('cetak')" class="btn btn-primary text-right"><i class="fa fa-print"></i> Print</button>-->
                    </div>
                </div>
				<div class="row">
                    <div class="col-12">
                        <div class="card card-body">
							<div class="col-sm-12 col-xs-12">
								
								<?php
									
									if(!empty($_POST['faktur'])){$faktur=$_POST['faktur'];}else{if(!empty($_GET['faktur'])){$faktur=$_GET['faktur'];}else{$faktur="";}}
									if(!empty($_POST['branch'])){$branch=$_POST["branch"];}else{if(!empty($_GET["branch"])){$branch=$_GET["branch"];}else{if(strtolower($_SESSION["iss21"]["level"])=="admin"){$branch="All Branch";}else{$branch=$_SESSION["iss21"]["branch"];}}}
									if(!empty($_POST['awal'])){$awal=date('Y-m-d',strtotime($_POST['awal']));}else{if(!empty($_GET['awal'])){$awal=date('Y-m-d',strtotime($_GET['awal']));}else{$awal=date("Y-m-d");}}
									if(!empty($_POST['akhir'])){$akhir=date('Y-m-d',strtotime($_POST['akhir']));}else{if(!empty($_GET['akhir'])){$akhir=date('Y-m-d',strtotime($_GET['akhir']));}else{$akhir=date("Y-m-d");}}									
									
									if(!empty($_POST['nik'])){$nik=$_POST['nik'];}else{if(!empty($_GET['nik'])){$nik=$_GET['nik'];}else{$nik="";}}
									if(!empty($nik)){
										$result = $con->query("Select * from KARYAWAN where nik='$nik'");											
										while($row = mysqli_fetch_assoc($result))
										{
											$fullname=$row["fullname"];
											$address=$row["address"];
											$phone=$row["phone"];
											$position=$row["position"];
											$dept=$row["dept"];
										}
									}else{
										$nik="All Employee";
									}
									if(!empty($_POST['jenis'])){$jenis=$_POST['jenis'];}else{if(!empty($_GET['jenis'])){$jenis=$_GET['jenis'];}else{$jenis="All Category";}}									
									if(!empty($_POST['kode'])){$kode=$_POST['kode'];}else{if(!empty($_GET['kode'])){$kode=$_GET['kode'];}else{$kode="";}}
									if(!empty($kode)){
										$result = $con->query("Select * from BARANG where kode='$kode'");											
										while($row = mysqli_fetch_assoc($result))
										{
											$barang=$row["barang"];
											$satuan=$row["satuan"];		
										}
									}else{
										$kode="All Item Code";
									}
									
									
								?>
								
								<form method="POST" action="">
									
									<div class="row" style='font-size:small;'>
									
										<div class="col-md-6">											
											<div class="form-group">
												<label>Branch</label>
												<select class="custom-select col-12" id="branch" name="branch" onchange="this.form.submit()" required="required">
													<option value="<?php if(!empty($branch)){echo $branch;}?>"><?php if(!empty($branch)){echo $branch;}else{echo "Pilih...";}?></option>
													<?php
														$result = $con->query("Select branch from BRANCH where branch not in ('$branch','All Branch') group by branch order By id");
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
										
										
										<div class="col-md-6">											
											<div class="form-group">
												<label>Employee</label>
												<select class="custom-select col-12" id="nik" name="nik" onchange="this.form.submit()" required="required">
													<option value="<?php if(!empty($nik)){echo $nik;}?>"><?php if(!empty($nik)){echo $nik;}else{echo "Pilih...";}?></option>
													<?php
														
														if(!empty($pAwal) && !empty($pAkhir)){
															if($branch=="All Branch"){
																$result = $con->query("Select nik,fullname,position,dept from RETUR Where tanggal between '$pAwal' and '$pAkhir' group by nik,fullname,position,dept order By fullname");
															}else{
																$result = $con->query("Select nik,fullname,position,dept from RETUR where tanggal between '$pAwal' and '$pAkhir' and branch='$branch' group by nik,fullname,position,dept order By fullname");
															}
														}else{
														
															if($branch=="All Branch"){
																$result = $con->query("Select nik,fullname,position,dept from RETUR group by nik,fullname,position,dept order By fullname");
															}else{
																$result = $con->query("Select nik,fullname,position,dept from RETUR where branch='$branch' group by nik,fullname,position,dept order By fullname");
															}
															
														}
														$count = mysqli_num_rows($result);
														if($count>0){						
															echo "<option value='All Employee'>All Employee</option>";
															while($row = mysqli_fetch_assoc($result))
															{				
																$nik1=$row["nik"];
																$fullname1=$row["fullname"];
																$position1=$row["position"];
																$dept1=$row["dept"];
																echo "<option value='$nik1'>$nik1 | $fullname1 | $position1 | $dept1</option>";
															}
														}												
													?>												
												</select>
											</div>											
										</div>
										<?php if($nik == "All Employee"){}else{ ?>
										<div class="col-md-12">
											<div class="form-group">
												<label for="address">Location</label>
												<input type="text" class="form-control" id="address" name="address" value="<?php  echo $address; ?>" readonly required="required">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="phone">Phone</label>
												<input type="text" class="form-control" id="phone" name="phone" value="<?php  echo $phone; ?>"  readonly required="required">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="position">Position</label>
												<input type="text" class="form-control" id="position" name="position" value="<?php  echo $position; ?>" required="required"  readonly >
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="dept">Department</label>
												<input type="text" class="form-control" id="dept" name="dept" value="<?php  echo $dept; ?>" required="required"  readonly >
											</div>
										</div>
										<?php } ?>
										
										
										<div class="<?php if($jenis=="All Category"){echo"col-md-12";}else{echo"col-md-6";}?>">											
											<div class="form-group">
												<label>Category</label>
												<select class="custom-select col-12" id="jenis" name="jenis" onchange="this.form.submit()" required="required">
													<option value="<?php if(!empty($jenis)){echo $jenis;}?>"><?php if(!empty($jenis)){echo $jenis;}else{echo "Pilih...";}?></option>
													<?php
														
														if(!empty($pAwal) && !empty($pAkhir)){
															if($branch=="All Branch"){
																$result = $con->query("Select jenis from RETUR Where tanggal between '$pAwal' and '$pAkhir' group by jenis order By jenis");
															}else{
																$result = $con->query("Select jenis from RETUR where tanggal between '$pAwal' and '$pAkhir' and branch='$branch' group by jenis order By jenis");
															}
														}else{
														
															if($branch=="All Branch"){
																$result = $con->query("Select jenis from RETUR group by jenis order By jenis");
															}else{
																$result = $con->query("Select jenis from RETUR where branch='$branch' group by jenis order By jenis");
															}
															
														}
														$count = mysqli_num_rows($result);
														if($count>0){						
															echo "<option value='All Category'>All Category</option>";
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
										<?php if($jenis=="All Category"){
											?>
												<input type="text" id="kode" value="All Item Code" hidden>
											<?php
											
										}else{?>
											
											<div class="col-md-6">											
												<div class="form-group">
													<label>Item Code</label>
													<select class="custom-select col-12" id="kode" name="kode" onchange="this.form.submit()" required="required">
														<option value="<?php if(!empty($kode)){echo $kode;}?>"><?php if(!empty($kode)){echo $kode;}else{echo "Pilih...";}?></option>
														<?php
															
															if(!empty($pAwal) && !empty($pAkhir)){
																if($branch=="All Branch"){
																	$result = $con->query("Select kode from RETUR Where tanggal between '$pAwal' and '$pAkhir' and jenis='$jenis' group by kode order By kode");
																}else{
																	$result = $con->query("Select kode from RETUR where tanggal between '$pAwal' and '$pAkhir' and jenis='$jenis' and branch='$branch' group by kode order By kode");
																}
															}else{
															
																if($branch=="All Branch"){
																	$result = $con->query("Select kode from RETUR where jenis='$jenis' group by kode order By kode");
																}else{
																	$result = $con->query("Select kode from RETUR where jenis='$jenis' and branch='$branch' group by kode order By kode");
																}
																
															}
															$count = mysqli_num_rows($result);
															if($count>0){						
																echo "<option value='All Item Code'>All Item Code</option>";
																while($row = mysqli_fetch_assoc($result))
																{				
																	$kode1=$row["kode"];
																	echo "<option value='$kode1'>$kode1</option>";
																}
															}												
														?>													
													</select>
												</div>											
											</div>
											<?php if($kode=="All Item Code"){}else{?>
												<div class="col-md-6">
													<div class="form-group">
														<label for="barang">Item Description</label>
														<input class="form-control form-control-line" type="text" name="barang" id="barang" value="<?php echo $barang; ?>" readonly>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="satuan">Uom</label>
														<input class="form-control form-control-line" type="text" name="satuan" id="satuan" value="<?php echo $satuan; ?>" readonly>
													</div>
												</div>
											<?php } ?>
											
										<?php } ?>
										
										
										
										
										
										
										
										<div class="col-md-6">
											<div class="form-group">
												<label for="awal">Start</label>
												<input class="form-control form-control-line" type="date" name="awal" id="awal" onchange="this.form.submit()" value="<?php echo $awal; ?>" required="required">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="akhir">End</label>
												<input class="form-control form-control-line" type="date" name="akhir" id="akhir" onchange="this.form.submit()" value="<?php echo $akhir; ?>" required="required">
											</div>
										</div>
										
									</div>									
								</form>								
							</div>
						</div>
					</div>
					<div class="col-12">						
                        <div class="card card-body">
							<div class="text-right">
								<?php
									echo"<a class='btn btn-success btn-sm text-right' href='export_retur.php?branch=$branch&awal=$awal&akhir=$akhir&nik=$nik&jenis=$jenis&kode=$kode'><i class='fa fa-file-excel-o'></i> Export</a>";
									echo" <a class='btn btn-primary btn-sm text-right' href='cetak_retur.php?branch=$branch&awal=$awal&akhir=$akhir&nik=$nik&jenis=$jenis&kode=$kode'><i class='fa fa-print'></i> Cetak</a>";						
								?>
							</div>
							<br>
							<div class="col-sm-12 col-xs-12">
								<div class="table-responsive" id="cetak">
									<div class="Sembunyikan">
										<h5 class="card-title"><b>RETURN TRANSACTION REPORT</b>				
										<br>Period <?php echo date('d/m/Y',strtotime($awal))." s/d ".date('d/m/Y',strtotime($akhir)); ?>
										<br>Location <?php echo $branch; ?>
										</h5>
									</div>
									<table class="table table-sm table-striped table-hover table-bordered text-sm" id="data-table1" style='color:black;'>
										<thead>
											<tr>
												<th>No</th>
												<th>Faktur</th>
												<th>Tanggal</th>
												<th>Employee</th>
												<th>Code</th>
												<th>Item Description</th>
												<th>Category</th>	
												<th>Uom</th>
												<th class="text-right">Qty</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$count=0;
											$no=0;									
											$pAwal=$awal." 00:00:00";
											$pAkhir=$akhir." 23:59:59";
											if($kode=="All Item Code"){
												if($jenis=="All Category"){
													if($nik=="All Employee"){
														if($branch=="All Branch"){												
															$sql="Select * from RETUR where tanggal between '$pAwal' and '$pAkhir' order by tanggal, fullname, faktur, jenis, barang, satuan, kode";
														}else{
															$sql="Select * from RETUR where branch='$branch' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, fullname, faktur, jenis, barang, satuan, kode";
														}
													}else{
														if($branch=="All Branch"){												
															$sql="Select * from RETUR where nik='$nik' and tanggal between '$pAwal' and '$pAkhir' order by tanggal, fullname, faktur, jenis, barang, satuan, kode";
														}else{
															$sql="Select * from RETUR where nik='$nik' and branch='$branch' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, fullname, faktur, jenis, barang, satuan, kode";
														}
													}
												}else{
													if($nik=="All Employee"){
														if($branch=="All Branch"){												
															$sql="Select * from RETUR where jenis='$jenis' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, fullname, faktur, jenis, barang, satuan, kode";
														}else{
															$sql="Select * from RETUR where branch='$branch' and jenis='$jenis' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, fullname, faktur, jenis, barang, satuan, kode";
														}
													}else{
														if($branch=="All Branch"){												
															$sql="Select * from RETUR where nik='$nik' and jenis='$jenis' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, fullname, faktur, jenis, barang, satuan, kode";
														}else{
															$sql="Select * from RETUR where nik='$nik' and branch='$branch' and jenis='$jenis' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, fullname, faktur, jenis, barang, satuan, kode";
														}
													}
												}
											}else{
												
												if($nik=="All Employee"){
													if($branch=="All Branch"){												
														$sql="Select * from RETUR where jenis='$jenis' and kode='$kode' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, fullname, faktur, jenis, barang, satuan, kode";
													}else{
														$sql="Select * from RETUR where branch='$branch' and jenis='$jenis' and kode='$kode' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, fullname, faktur, jenis, barang, satuan, kode";
													}
												}else{
													if($branch=="All Branch"){												
														$sql="Select * from RETUR where nik='$nik' and jenis='$jenis' and kode='$kode' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, fullname, faktur, jenis, barang, satuan, kode";
													}else{
														$sql="Select * from RETUR where branch='$branch' and nik='$nik' and jenis='$jenis' and kode='$kode' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, fullname, faktur, jenis, barang, satuan, kode";
													}
												}

											}
											$result = $con->query($sql);
											$count = mysqli_num_rows($result);
											if($count>0){
												while($row = mysqli_fetch_assoc($result))
												{
													$no++;
													$tanggal2=$row["tanggal"];
													$tanggal2=date('Y-m-d',strtotime($tanggal2));
													$fullname2=$row["fullname"];
													$faktur2=$row["faktur"];
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
															<td>$faktur2</td>
															<td>$tanggal2</td>
															<td>$fullname2</td>
															<td>$kode2</td>
															<td>$barang2</td>
															<td>$jenis2</td>
															<td>$satuan2</td>
															<td align='right'>".number_format($qty2)."</td>															
														</tr>													
													";													
												}
												
											}else{
												echo"
													<tr><td colspan='9' align='center'>No Data Found</td></tr>
												";
											}											
											?>											
										</tbody>
									</table>
									
									<table class="table table-sm table-bordered Sembunyikan" id="table" style='color:black;'>
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
			var b=document.getElementById('awal').value;
			var c=document.getElementById('akhir').value;
			var d=document.getElementById('nik').value;
			var e=document.getElementById('jenis').value;
			if(e!="All Category"){
				var f=document.getElementById('kode').value;
			}
			
			var restorepage = document.body.innerHTML;
			var printcontent = document.getElementById(el).innerHTML;
			document.body.innerHTML = printcontent;
			window.print();
			document.body.innerHTML = restorepage;
			if(e!="All Category"){
				document.location.href='retur-report.php?branch=' + a + '&awal=' + b + '&akhir='+ c+'&nik='+d+'&jenis='+e+'&kode='+f;
			}else{
				document.location.href='retur-report.php?branch=' + a + '&awal=' + b + '&akhir='+ c+'&nik='+d+'&jenis='+e;
			}
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