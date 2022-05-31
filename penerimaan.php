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
    <title>Laporan Penerimaan :: <?php echo $app_name;?></title>
	
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
	<style>            
		.autocomplete-suggestions {
			border: 1px solid #999;
			background: #FFF;
			overflow: auto;
		}
		.autocomplete-suggestion {
			padding: 2px 5px;
			white-space: nowrap;
			overflow: hidden;
		}
		.autocomplete-selected {
			background: #F0F0F0;
		}
		.autocomplete-suggestions strong {
			font-weight: normal;
			color: #3399FF;
		}
		.autocomplete-group {
			padding: 2px 5px;
		}
		.autocomplete-group strong {
			display: block;
			border-bottom: 1px solid #000;
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
                        <h3 class="text-themecolor">Laporan Penerimaan Barang</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Laporan Penerimaan Barang oleh karyawan</li>
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
										$fullname="";		
										$address="";
										$phone="";
										$position="";		
										$dept="";	
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
								
								<form id="theForm" method="POST" action="">
									
									<div class="row">
										
										<div class="col-md-8">
											<div class="form-group">
												<label for="fullname">Penerima</label>
												<input type="text" class="form-control" id="fullname" name="fullname" onChange="getKaryawan(this.value)" value="<?php  echo $fullname; ?>" required="required"  <?php if(empty($fullname)){echo "autofocus";}else{echo "readonly";} ?> >
												<small>Isi dengan sebagian nama karyawan dan pilih karyawan yang tersedia</small>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="nik">Nik</label>
												<input type="text" class="form-control" id="nik" name="nik" value="<?php  echo $nik; ?>"  <?php if(empty($nik)){echo "autofocus";} ?> readonly required="required">
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="address">Address</label>
												<input type="text" class="form-control" id="address" name="address" value="<?php  echo $address; ?>"  <?php if(empty($address)){echo "autofocus";} ?> readonly required="required">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="phone">Phone</label>
												<input type="text" class="form-control" id="phone" name="phone" value="<?php  echo $phone; ?>"  <?php if(empty($phone)){echo "autofocus";} ?> readonly required="required">
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
										
										<div class="col-md-4">
											<div class="form-group">
												<label for="awal">Start</label>
												<input class="form-control form-control-line" type="date" name="awal" id="awal" onchange="this.form.submit()" value="<?php echo $awal; ?>" required="required">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="akhir">End</label>
												<input class="form-control form-control-line" type="date" name="akhir" id="akhir" onchange="this.form.submit()" value="<?php echo $akhir; ?>" required="required">
											</div>
										</div>
										
										
										
										<div class="<?php if($jenis=="All Category"){echo"col-md-4";}else{echo"col-md-4";}?>">											
											<div class="form-group">
												<label>Category</label>
												<select class="custom-select col-12" id="jenis" name="jenis" onchange="this.form.submit()" required="required">
													<option value="<?php if(!empty($jenis)){echo $jenis;}?>"><?php if(!empty($jenis)){echo $jenis;}else{echo "Pilih...";}?></option>
													<?php
														
														if(!empty($pAwal) && !empty($pAkhir)){
															$result = $con->query("Select jenis from OUTGOING Where tanggal between '$pAwal' and '$pAkhir' group by jenis order By jenis");
														}else{														
															$result = $con->query("Select jenis from OUTGOING group by jenis order By jenis");															
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
											
											<div class="col-md-4">											
												<div class="form-group">
													<label>Item Code</label>
													<select class="custom-select col-12" id="kode" name="kode" onchange="this.form.submit()" required="required">
														<option value="<?php if(!empty($kode)){echo $kode;}?>"><?php if(!empty($kode)){echo $kode;}else{echo "Pilih...";}?></option>
														<?php
															
															if(!empty($pAwal) && !empty($pAkhir)){
																$result = $con->query("Select kode from OUTGOING Where tanggal between '$pAwal' and '$pAkhir' and jenis='$jenis' group by kode order By kode");
															}else{
																$result = $con->query("Select kode from OUTGOING where jenis='$jenis' group by kode order By kode");
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
												<div class="col-md-4">
													<div class="form-group">
														<label for="barang">Item Description</label>
														<input class="form-control form-control-line" type="text" name="barang" id="barang" value="<?php echo $barang; ?>" readonly>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label for="satuan">Uom</label>
														<input class="form-control form-control-line" type="text" name="satuan" id="satuan" value="<?php echo $satuan; ?>" readonly>
													</div>
												</div>
											<?php } ?>
											
										<?php } ?>
										
										

									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-12">
                        <div class="card card-body">
							<div class="text-right">
								<?php
									echo"<a class='btn btn-success btn-sm text-right' href='export_penerimaan.php?awal=$awal&akhir=$akhir&nik=$nik&jenis=$jenis&kode=$kode'><i class='fa fa-file-excel-o'></i> Export</a>";
									echo" <a class='btn btn-primary btn-sm text-right' href='cetak_penerimaan.php?awal=$awal&akhir=$akhir&nik=$nik&jenis=$jenis&kode=$kode'><i class='fa fa-print'></i> Cetak</a>";						
								?>
							</div>
							<br>
							<div class="col-sm-12 col-xs-12">
								<div class="table-responsive" id="cetak">
									<div class="Sembunyikan">
										<h5 class="card-title"><b>LAPORAN PENERIMAAN BARANG</b>				
										<br>Periode : <?php echo date('d/m/Y',strtotime($awal))." s/d ".date('d/m/Y',strtotime($akhir)); ?>
										<br>Penerima : <?php echo $nik." | ".$fullname." | ".$position." | ".$dept; ?>
										</h5>
									</div>
									<table class="table table-sm table-striped table-hover table-bordered" id="data-table1" style='color:black;'>
										<thead>
											<tr>
												<th>No</th>
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
													$sql="Select kode, barang, jenis, satuan, sum(qty) as terima 
													from OUTGOING 
													where (tanggal between '$pAwal' and '$pAkhir') and fullname='$fullname'
													group by kode, barang, jenis, satuan
													order by barang";
												}else{
													$sql="Select kode, barang, jenis, satuan, sum(qty) as terima 
													from OUTGOING 
													where (tanggal between '$pAwal' and '$pAkhir') and fullname='$fullname' and jenis='$jenis'
													group by kode, barang, jenis, satuan
													order by barang";
												}
											}else{
												if($jenis=="All Category"){
													$sql="Select kode, barang, jenis, satuan, sum(qty) as terima 
													from OUTGOING 
													where (tanggal between '$pAwal' and '$pAkhir') and fullname='$fullname' and kode='$kode'
													group by kode, barang, jenis, satuan
													order by barang";
												}else{
													$sql="Select kode, barang, jenis, satuan, sum(qty) as terima 
													from OUTGOING 
													where (tanggal between '$pAwal' and '$pAkhir') and fullname='$fullname' and jenis='$jenis' and kode='$kode'
													group by kode, barang, jenis, satuan
													order by barang";
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
													$terima2=$row["terima"];
													
													echo"
														<tr style='font-size:small;'>
															<td>$no</td>
															<td>$kode2</td>
															<td>$barang2</td>
															<td>$jenis2</td>
															<td>$satuan2</td>
															<td align='right'>".number_format($terima2)."</td>
														</tr>
														
													";													
												}												
											}else{
												echo"
													<tr><td colspan='6' align='center'>No Data Found</td></tr>
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
											<td align="center" height="30px"></td>
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
	<script src="js/jquery.autocomplete.min.js"></script>
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
	
	<script type="text/javascript">

		$("#fullname").autocomplete({
			serviceUrl: "autocomplete_karyawan.php",
			dataType: "JSON",
			onSelect: function (suggestion) {
				$("#fullname").val("" + suggestion.karyawan);
				var s=document.getElementById('fullname').value;
				getKaryawan(s);
			}
		});
		function getKaryawan(val){
			$.post('get_karyawan.php',{data:val},function(result){
				$('#nik').val(result.nik);
				$('#fullname').val(result.fullname);
				$('#address').val(result.address);
				$('#phone').val(result.phone);
				$('#position').val(result.position);
				$('#dept').val(result.dept);
				document.getElementById('theForm').submit();
			}, "json");				
		}
	
		
	</script>
    <?php include("inc/js_bawah.php");?>
	<script language="javascript">
		function printContent(el){
			var a=document.getElementById('nik').value;
			var b=document.getElementById('awal').value;
			var c=document.getElementById('akhir').value;
			var d=document.getElementById('jenis').value;						
			if(d!="All Category"){
				var e=document.getElementById('kode').value;
			}
			
			var restorepage = document.body.innerHTML;
			var printcontent = document.getElementById(el).innerHTML;
			document.body.innerHTML = printcontent;
			window.print();
			document.body.innerHTML = restorepage;
			if(d!="All Category"){
				document.location.href='penerimaan.php?nik='+a+'&awal=' + b + '&akhir=' + c + '&jenis='+ d+'&kode='+e;
			}else{
				document.location.href='penerimaan.php?nik='+a+'&awal=' + b + '&akhir=' + c + '&jenis='+ d;
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