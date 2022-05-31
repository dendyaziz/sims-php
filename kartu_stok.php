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
    <title>Kartu Stok Barang :: <?php echo $app_name;?></title>
	
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
                        <h3 class="text-themecolor">Kartu Stok Barang</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Kartu Stok Barang</li>
                        </ol>
                    </div>	
					<div class="col-md-7 align-self-center text-right d-none d-md-block">
                        <button onclick="printContent('cetak')" class="btn btn-primary text-right"><i class="fa fa-print"></i> Print</button>
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
									
									if(!empty($_POST['subgroup'])){
										$subgroup=$_POST["subgroup"];
									}else{										
										if(!empty($_GET["subgroup"])){
											$subgroup=$_GET["subgroup"];
										}else{
											$subgroup="";											
										}
									}
									
									if(!empty($_POST['merk'])){
										$merk=$_POST["merk"];
									}else{										
										if(!empty($_GET["merk"])){
											$merk=$_GET["merk"];
										}else{
											$merk="";											
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
								
								<form method="POST" action="">
									
									<div class="row">
									
										<div class="col-md-4">											
											<div class="form-group">
												<label>Branch</label>
												<select class="custom-select col-12" id="branch" name="branch" onchange="this.form.submit()" required="required">
													<option value="<?php if(!empty($branch)){echo $branch;}?>"><?php if(!empty($branch)){echo $branch;}else{echo "Pilih...";}?></option>
													<?php
														$result = $con->query("Select branch from BRANCH where branch not in ('$branch','All Branch') group by branch order By branch");
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
									</div>
									<div class="row">										
										<div class="col-md-8">
											
											<div class="form-group">
												<label for="barang">Item Description</label>
												<input class="form-control form-control-line" type="text" name="barang" id="barang" onchange="getItem(this.value)" value="<?php echo $barang; ?>" required="required">
											</div>
											
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="kode">Code</label>
												<input class="form-control form-control-line" type="text" name="kode" id="kode" value="<?php echo $kode; ?>" readonly>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="jenis">Group</label>
												<input class="form-control form-control-line" type="text" name="jenis" id="jenis" value="<?php echo $jenis; ?>" readonly required="required">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="subgroup">Sub Group</label>
												<input class="form-control form-control-line" type="text" name="subgroup" id="subgroup" value="<?php echo $subgroup; ?>" readonly required="required">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="merk">Merk</label>
												<input class="form-control form-control-line" type="text" name="merk" id="merk" value="<?php echo $merk; ?>" readonly required="required">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="satuan">Unit</label>
												<input class="form-control form-control-line" type="text" name="satuan" id="satuan" value="<?php echo $satuan; ?>" readonly>
											</div>
										</div>									
									</div>
									<button class="btn btn-info" id="btn-view"><i class="fa fa-refresh"></i> Refresh</button>
									<!--
									<button onclick="printContent('cetak')" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
									-->
								</form>					
							</div>
						</div>
					</div>
					<div class="col-12">
                        <div class="card card-body">
							<div class="col-sm-12 col-xs-12">
								<div class="table-responsive" id="cetak">
									<div class="Sembunyikan">
										<h5 class="card-title"><b>Kartu Stok Barang</b>			
										<br>Periode <?php echo date('d/m/Y',strtotime($awal))." s/d ".date('d/m/Y',strtotime($akhir)); ?>
										</h5>
									</div>
									
									<table class="table table-sm table-hover table-bordered" id="table" style='color:black;'>
										<thead>
											<tr>
												<th>Code</th>
												<th>Group</th>
												<th>Sub Group</th>
												<th>Merk</th>
												<th>Item Description</th>									
												<th>Unit</th>
												<th class="text-right">Saldo Stok</th>										
											</tr>
										</thead>
										<tbody>
											<?php
											$barangQ=str_replace("'","''",$barang);
											if($branch=="All Branch"){
												$sql="Select kode, jenis, subgroup, merk, barang, satuan, sum(saldo) as saldo from STOK where kode='$kode' group by kode, jenis, subgroup, merk, barang, satuan";
											}else{
												$sql="Select kode, jenis, subgroup, merk, barang, satuan, sum(saldo) as saldo from STOK where branch='$branch' and kode='$kode' group by kode, jenis, subgroup, merk, barang, satuan";												
											}
											$result = $con->query($sql);
											$count = mysqli_num_rows($result);
											if($count>0){
												while($row = mysqli_fetch_assoc($result))
												{
													$kode1=$row["kode"];
													$jenis1=$row["jenis"];
													$subgroup1=$row["subgroup"];
													$merk1=$row["merk"];
													$barang1=$row["barang"];
													$satuan1=$row["satuan"];
													$saldo1=$row["saldo"];
													
													echo"
														<tr>
															<td>$kode1</td>
															<td>$jenis1</td>
															<td>$subgroup1</td>
															<td>$merk1</td>
															<td>$barang1</td>															
															<td>$satuan1</td>
															<td align='right'>$saldo1</td>															
														</tr>														
													";													
												}
												
											}else{
												echo"
													<tr>
														<td colspan='7' class='text-center'>No Data Found</td>
													</tr>
												";
											}											
											?>											
										</tbody>
									</table>
										
									<table class="table table-sm table-striped table-hover table-bordered" id="data-table1" style='color:black;'>
										<thead>
											<tr style='font-size:small;'>
												<th>No</th>
												<th>Branch</th>
												<th>Tanggal</th>
												<th>Faktur</th>
												<th>Code</th>
												<th>Group</th>
												<th>Sub Group</th>
												<th>Merk</th>
												<th>Item Description</th>									
												<th>Unit</th>
												<th class="text-right">Qty</th>																							
												<th>Transaction</th>
												<th>Note</th>
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
												$sql="Select * from HISTORY where (tanggal between '$pAwal' and '$pAkhir') and jenis='$jenis' and barang='$barangQ' and kode='$kode' order by branch, entrydate";
											}else{
												$sql="Select * from HISTORY where branch='$branch' and (tanggal between '$pAwal' and '$pAkhir') and jenis='$jenis' and barang='$barangQ' and kode='$kode' order by branch, entrydate";
											}
											$result = $con->query($sql);
											$count = mysqli_num_rows($result);
											if($count>0){
												while($row = mysqli_fetch_assoc($result))
												{
													$no++;
													$branch2=$row["branch"];
													$tanggal2=$row["tanggal"];
													$entrydate2=$row["entrydate"];
													$entrydate2=date("H:m:s",strtotime($entrydate2));
													$username2=$row["username"];
													$faktur2=$row["faktur"];												
													
													$kode2=$row["kode"];
													$jenis2=$row["jenis"];
													$subgroup2=$row["subgroup"];
													$merk2=$row["merk"];
													$barang2=$row["barang"];
													$qty2=$row["qty"];
													$satuan2=$row["satuan"];
													$descr2=$row["descr"];
													$transaksi2=$row["transaksi"];
													
													echo"
														<tr style='font-size:small;'>
															<td>$no</td>
															<td>$branch2</td>
															<td>$tanggal2 $entrydate2</td>
															<td>$faktur2</td>
															<td>$kode2</td>
															<td>$jenis2</td>
															<td>$subgroup2</td>
															<td>$merk2</td>
															<td>$barang2</td>
															<td align='right'>".number_format($qty2)."</td>
															<td>$satuan2</td>
															<td>$transaksi2</td>
															<td>$descr2</td>
														</tr>														
													";													
												}
												
											}else{
												echo"
													<tr>
														<td colspan='13' class='text-center'>No Data Found</td>
													</tr>
												";
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
		$("#barang").autocomplete({
			serviceUrl: "autocomplete_barang.php",
			dataType: "JSON",
			onSelect: function (suggestion) {
				$("#barang").val("" + suggestion.barang);
				var a=document.getElementById('barang').value;
				getItem(a);
			}
		});
		function getItem(val){
			$.post('get_item.php',{data:val},function(result){
				$('#kode').val(result.kode);
				$('#jenis').val(result.jenis);
				$('#subgroup').val(result.subgroup);
				$('#merk').val(result.merk);
				$('#barang').val(result.barang);
				$('#satuan').val(result.satuan);
				$('#harga_beli').val(result.harga_beli);
				document.getElementById("btn-view").click();
			}, "json");	
			
		}
		
	</script>
    <?php include("inc/js_bawah.php");?>
	<script language="javascript">
		function printContent(el){
			var a=document.getElementById('branch').value;
			var b=document.getElementById('awal').value;
			var c=document.getElementById('akhir').value;
			var d=document.getElementById('jenis').value;
			var e=document.getElementById('barang').value;
			var f=document.getElementById('satuan').value;
			var g=document.getElementById('kode').value;
			
			var restorepage = document.body.innerHTML;
			var printcontent = document.getElementById(el).innerHTML;
			document.body.innerHTML = printcontent;
			window.print();
			document.body.innerHTML = restorepage;
			document.location.href='kartu_stok.php?branch=' + a + '&awal=' + b + '&akhir='+ c + '&jenis=' + d + '&barang=' + e+'&satuan='+f+'&kode='+g;
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