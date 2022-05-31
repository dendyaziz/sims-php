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
    <title>Stock Card :: <?php echo $app_name;?></title>
	
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
                        <h3 class="text-themecolor">Kartu Persediaan Barang</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Kartu Persediaan Barang</li>
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
								
								<form method="POST" action="">
									
									<div class="row">
									
										<?php if(strtolower($_SESSION["iss21"]["branch"])=="head office"){?>
										<div class="col-md-4">											
											<div class="form-group">
												<label>Gudang</label>
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
												<label>Gudang</label>
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
										<!--
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
										-->
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
										<div class="col-md-2">
											<div class="form-group">
												<label for="satuan">Satuan</label>
												<input class="form-control form-control-line" type="text" name="satuan" id="satuan" value="<?php echo $satuan; ?>" readonly>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label for="kode">Kode</label>
												<input class="form-control form-control-line" type="text" name="kode" id="kode" value="<?php echo $kode; ?>" readonly>
											</div>
										</div>										
									</div>
									<button class="btn btn-info"><i class="fa fa-eye"></i> View</button>
									<button onclick="printContent('cetak')" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>									
								</form>					
								<br>								
								<div class="table-responsive" id="cetak">
									<div class="Sembunyikan">
										<h5 class="card-title"><b>KARTU PERSEDIAAN BARANG</b>			
										<!--<br>Periode <?php echo date('d/m/Y',strtotime($awal))." s/d ".date('d/m/Y',strtotime($akhir)); ?>-->
										<br>Jenis Barang <?php echo $jenis; ?>
										<br>Nama Barang <?php echo $barang; ?>
										</h5>
									</div>
										
									<table class="table table-sm table-hover table-bordered" id="table">
										<thead>
											<tr>
												<th>#</th>
												<th>Tanggal</th>
												<th>Uraian</th>
												<th class="text-right">Masuk</th>
												<th class="text-right">Harga Beli</th>
												<th class="text-right">Keluar</th>
												<th class="text-right">Saldo</th>
												<th class="text-right">Nilai</th>							
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
												$sql="
													Select a.branch, a.tanggal as tanggal, a.suplier as uraian, a.qty, a.harga,
													IFNULL((select sum(d.qty) from PEMBELIAN d where d.tanggal<=a.tanggal and d.kode=a.kode and d.barang=a.barang),0)-
													IFNULL((select sum(e.qty) from PENGELUARAN e where e.entrydate<=a.tanggal and e.kode=a.kode and e.barang=a.barang),0) as saldo,'I' status 
													from PEMBELIAN a Where a.kode='$kode' and a.barang='$barang'
													union
													Select b.branch, b.entrydate as tanggal, b.keterangan as uraian, b.qty, 
														(Select c.harga from PEMBELIAN c Where convert(c.tanggal,date) <= convert(b.entrydate, date) and c.barang=b.barang and c.kode=b.kode order by c.tanggal desc limit 1) as harga,
														IFNULL((select sum(f.qty) from PEMBELIAN f where f.tanggal <= b.entrydate and f.kode=b.kode and f.barang=b.barang),0) - 
														IFNULL((select sum(g.qty) from PENGELUARAN g where g.entrydate<=b.entrydate and g.kode=b.kode and g.barang=b.barang),0) as saldo,'O' status
													from PENGELUARAN b Where b.kode='$kode' and b.barang='$barang'
													order by tanggal";
											}else{
												$sql="Select a.branch, a.tanggal as tanggal, a.suplier as uraian, a.qty, a.harga, 
													IFNULL((select sum(d.qty) from PEMBELIAN d where d.tanggal<=a.tanggal and d.kode=a.kode and d.barang=a.barang and d.branch=a.branch),0)-
													IFNULL((select sum(e.qty) from PENGELUARAN e where e.entrydate<=a.tanggal and e.kode=a.kode and e.barang=a.barang and e.branch=a.branch),0) as saldo,'I' status 
													from PEMBELIAN a Where a.kode='$kode' and a.barang='$barang' and a.branch='$branch'
													union
													Select b.branch, b.entrydate as tanggal, b.keterangan as uraian, b.qty, 
														(Select c.harga from PEMBELIAN c Where convert(c.tanggal,date) <= convert(b.entrydate, date) and c.barang=b.barang and c.kode=b.kode and c.branch=b.branch order by c.tanggal desc limit 1) as harga,
														IFNULL((select sum(f.qty) from PEMBELIAN f where f.tanggal <= b.entrydate and f.kode=b.kode and f.barang=b.barang and f.branch=b.branch),0) - 
														IFNULL((select sum(g.qty) from PENGELUARAN g where g.entrydate<=b.entrydate and g.kode=b.kode and g.barang=b.barang and g.branch=b.branch),0) as saldo,'O' status
													from PENGELUARAN b Where b.kode='$kode' and b.barang='$barang' and b.branch='$branch'
													order by tanggal";
											}
											$result = $con->query($sql);
											$count = mysqli_num_rows($result);
											if($count>0){
												while($row = mysqli_fetch_assoc($result))
												{
													$no++;
													$branch2=$row["branch"];
													$tanggal2=$row["tanggal"];
													$tanggal2=date('Y-m-d H:m',strtotime($tanggal2));
													$uraian2=$row["uraian"];
													$status2=$row["status"];
													if($status2=="I"){
														$masuk2=$row["qty"];
														$keluar2=0;
													}else if ($status2=="O"){
														$masuk2=0;
														$keluar2=$row["qty"];
													}
													$harga2=$row["harga"];
													$saldo2=$row["saldo"];
													$nilai2=$harga2*$saldo2;													
													echo"
														<tr>
															<td>$no</td>
															<td>$tanggal2</td>
															<td>$uraian2</td>
															<td align='right'>".number_format($masuk2)."</td>
															<td align='right'>".number_format($harga2)."</td>
															<td align='right'>".number_format($keluar2)."</td>
															<td align='right'>".number_format($saldo2)."</td>
															<td align='right'>".number_format($nilai2)."</td>
														</tr>														
													";													
												}
												
											}else{
												echo"
													<tr>
														<td colspan='8' class='text-center'>No Data Found</td>
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
	<script src="jquery-3.2.1.min.js"></script>
	<script src="jquery.autocomplete.min.js"></script>
	<script type="text/javascript">
		$("#barang").autocomplete({
			serviceUrl: "search1.php",   // Kode php untuk prosesing data.
			dataType: "JSON",           // Tipe data JSON.
			onSelect: function (suggestion) {
				$("#barang").val("" + suggestion.barang);				
				var a=document.getElementById('barang').value;
				getItem(a);				
			}
		});
		function getItem(val){
			$.post('get_item.php',{data:val},function(result){
				$('#jenis').val(result.jenis);
				$('#satuan').val(result.satuan);
				$('#kode').val(result.kode);
			}, "json");
		}
	</script>
    <?php include("inc/js_bawah.php");?>
	<script language="javascript">
		function printContent(el){
			var a=document.getElementById('branch').value;
			var d=document.getElementById('jenis').value;
			var e=document.getElementById('barang').value;
			var f=document.getElementById('satuan').value;
			var g=document.getElementById('kode').value;
			
			var restorepage = document.body.innerHTML;
			var printcontent = document.getElementById(el).innerHTML;
			document.body.innerHTML = printcontent;
			window.print();
			/*document.body.innerHTML = restorepage;*/
			document.location.href='kartu.php?branch=' + a + '&jenis=' + d + '&barang=' + e+'&satuan='+f+'&kode='+g;
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