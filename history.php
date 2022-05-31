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
    <title>History :: <?php echo $app_name;?></title>
	
	<style>
		@media screen {			
			.Sembunyikan{
				display: none;
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
                        <h3 class="text-themecolor">History Perbarang</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">History Perbarang</li>
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
									if(!empty($_POST['merk'])){
										$merk=$_POST["merk"];
									}else{										
										if(!empty($_GET["merk"])){
											$merk=$_GET["merk"];
										}else{
											$merk="";											
										}
									}
									if(!empty($_POST['ukuran'])){
										$ukuran=$_POST["ukuran"];
									}else{										
										if(!empty($_GET["ukuran"])){
											$ukuran=$_GET["ukuran"];
										}else{
											$ukuran="";											
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
								
								<form method="POST" action="">
									
									<div class="row">
									
										<?php if(strtolower($_SESSION["iss21"]["level"])=="admin"){?>
										<div class="col-md-4">											
											<div class="form-group">
												<label>Gudang</label>
												<select class="custom-select col-12" id="branch" name="branch" onchange="this.form.submit()" required="required">
													<option value="<?php if(!empty($branch)){echo $branch;}?>"><?php if(!empty($branch)){echo $branch;}else{echo "Pilih...";}?></option>
													<?php
														$result = $con->query("Select branch from BRANCH where branch not in ('$branch','Semua Gudang') group by branch order By branch");
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
									<div class="row">										
										<div class="col-md-4">
											
											<div class="form-group">
												<label for="barang">Barang</label>
												<input class="form-control form-control-line" type="text" name="barang" id="barang" onchange="getItem(this.value)" value="<?php echo $barang; ?>" required="required">
											</div>
											
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="jenis">Jenis</label>
												<input class="form-control form-control-line" type="text" name="jenis" id="jenis" value="<?php echo $jenis; ?>" readonly required="required">
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
												<label for="ukuran">Ukuran</label>
												<input class="form-control form-control-line" type="text" name="ukuran" id="ukuran" value="<?php echo $ukuran; ?>" readonly required="required">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="satuan">Satuan</label>
												<input class="form-control form-control-line" type="text" name="satuan" id="satuan" value="<?php echo $satuan; ?>" readonly>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="kode">Kode</label>
												<input class="form-control form-control-line" type="text" name="kode" id="kode" value="<?php echo $kode; ?>" readonly>
											</div>
										</div>										
									</div>
									<!--<button class="btn btn-info" id="btn-view"><i class="fa fa-eye"></i> View</button>
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
										<h5 class="card-title"><b>HISTORY PERBARANG</b>			
										<br>Periode <?php echo date('d/m/Y',strtotime($awal))." s/d ".date('d/m/Y',strtotime($akhir)); ?>
										<br>Jenis Barang <?php echo $jenis; ?>
										<br>Nama Barang <?php echo $barang; ?>
										</h5>
									</div>
									
									<table class="table table-sm table-hover table-bordered" id="table">
										<thead>
											<tr>
												<th>Nama Barang</th>
												<th class="text-right">Saldo</th>						
											</tr>
										</thead>
										<tbody>
											<?php
											
											if($branch=="Semua Gudang"){
												$sql="Select barang, sum(saldo) as saldo from STOK where kode='$kode' and barang='$barang'";
											}else{
												$sql="Select barang, sum(saldo) as saldo from STOK where branch='$branch' and kode='$kode' and barang='$barang'";												
											}
											$result = $con->query($sql);
											$count = mysqli_num_rows($result);
											if($count>0){
												while($row = mysqli_fetch_assoc($result))
												{
													$barang1=$row["barang"];
													$saldo1=$row["saldo"];
													
													echo"
														<tr>
															<td>$barang1</td>
															<td align='right'>$saldo1</td>
														</tr>														
													";													
												}
												
											}else{
												echo"
													<tr>
														<td colspan='2' class='text-center'>No Data Found</td>
													</tr>
												";
											}											
											?>											
										</tbody>
									</table>
										
									<table class="table table-sm table-striped table-hover table-bordered" id="data-table">
										<thead>
											<tr style='font-size:small;'>
												<th>#</th>
												<th>Gudang</th>
												<th>Tanggal</th>
												<th>Username</th>
												<th>Faktur</th>												
												<th>Nama Barang</th>
												<th>Merk</th>
												<th>Ukuran</th>
												<th class="text-right">Qty</th>
												<th>Satuan</th>												
												<th>Transaksi</th>
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
											if($branch=="Semua Gudang"){
												$sql="Select * from HISTORY where (transdate between '$pAwal' and '$pAkhir') and jenis='$jenis' and barang='$barang' and kode='$kode' order by branch, transdate";
											}else{
												$sql="Select * from HISTORY where branch='$branch' and (transdate between '$pAwal' and '$pAkhir') and jenis='$jenis' and barang='$barang' and kode='$kode' order by branch, transdate";
											}
											$result = $con->query($sql);
											$count = mysqli_num_rows($result);
											if($count>0){
												while($row = mysqli_fetch_assoc($result))
												{
													$no++;
													$branch2=$row["branch"];
													$transdate2=$row["entrydate"];
													$transdate2=date('Y-m-d H:m',strtotime($transdate2));
													$username2=$row["username"];
													$faktur2=$row["faktur"];												
													
													$barang2=$row["barang"];
													$merk2=$row["merk"];
													$ukuran2=$row["ukuran"];
													$satuan2=$row["satuan"];
													$qty2=$row["qty"];																							
													if(empty($qty2)){$qty2=0;}
													$transaksi2=$row["transaksi"];
													$descr2=$row["descr"];
													
													echo"
														<tr style='font-size:small;'>
															<td>$no</td>
															<td>$branch2</td>
															<td>$transdate2</td>
															<td>$username2</td>
															<td>$faktur2</td>
															<td>$barang2</td>
															<td>$merk2</td>
															<td>$ukuran2</td>
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
														<td colspan='12' class='text-center'>No Data Found</td>
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
				$('#barang').val(result.barang);
				$('#jenis').val(result.jenis);
				$('#merk').val(result.merk);
				$('#ukuran').val(result.ukuran);
				$('#gambar').val(result.gambar);
				$('#satuan').val(result.satuan);
				$('#kode').val(result.kode);
				
				var a=document.getElementById('kode').value;
				$.ajax({
					type : 'post',
					url : 'view-image.php',
					data :  'kode='+a,
					success : function(data){
						$('#gambar_product').html(data);
					}					
				});
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
			var f=document.getElementById('merk').value;
			var g=document.getElementById('ukuran').value;
			var h=document.getElementById('satuan').value;
			var i=document.getElementById('kode').value;
			
			var restorepage = document.body.innerHTML;
			var printcontent = document.getElementById(el).innerHTML;
			document.body.innerHTML = printcontent;
			window.print();
			/*document.body.innerHTML = restorepage;*/
			document.location.href='history.php?branch=' + a + '&awal=' + b + '&akhir='+ c + '&jenis=' + d + '&barang=' + e+'&merk='+f+'&ukuran='+g+'&satuan='+h+'&kode='+i;
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