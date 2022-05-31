<?php
session_start();
include("fc/fc_config.php");
if($_SESSION["iss21"]["authentication"]=="VALID"){
	$filenameImages =$_SESSION["iss21"]["img"];
	$filemtimeImages = filemtime("assets/images/users/".$filenameImages);
	$profile_picture=$filenameImages."?".$filemtimeImages;
	
	if($_SESSION["iss21"]["position"]=="Salesman"){
		$_SESSION["iss21"]["info"]="Gagal, anda tidak memiliki ijin untuk mengakses halaman ini.";
		header("location: dashboard.php");
	}
	
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
    <title>Laporan Laba / Rugi :: <?php echo $app_name;?></title>
	
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
                        <h3 class="text-themecolor">Laba / Rugi</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Laporan Laba / Rugi</li>
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
										
									if(!empty($_POST['branch'])){$branch=$_POST["branch"];}else{if(!empty($_GET["branch"])){$branch=$_GET["branch"];}else{if(strtolower($_SESSION["iss21"]["level"])=="admin"){$branch="All Branch";}else{$branch=$_SESSION["iss21"]["branch"];}}}
									if(!empty($_POST['awal'])){$awal=date('Y-m-d',strtotime($_POST['awal']));}else{if(!empty($_GET['awal'])){$awal=date('Y-m-d',strtotime($_GET['awal']));}else{$awal=date("Y-m-d");}}
									if(!empty($_POST['akhir'])){$akhir=date('Y-m-d',strtotime($_POST['akhir']));}else{if(!empty($_GET['akhir'])){$akhir=date('Y-m-d',strtotime($_GET['akhir']));}else{$akhir=date("Y-m-d");}}									
									
								?>
								
								<form method="POST" action="">
									
									<div class="row">
									
										<div class="col-md-12">											
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
												<label for="awal">Awal</label>
												<input class="form-control form-control-line" type="date" name="awal" id="awal" onchange="this.form.submit()" value="<?php echo $awal; ?>" required="required">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="akhir">Akhir</label>
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
							<div class="col-sm-12 col-xs-12">
								<div class="table-responsive" id="cetak">
									<div class="Sembunyikan">
										<h5 class="card-title"><b>LAPORAN LABA/RUGI (<?php echo $branch;?>)</b>			
										<br>Periode <?php echo date('d/m/Y',strtotime($awal))." s/d ".date('d/m/Y',strtotime($akhir)); ?>								
										</h5>
									</div>
									
									<table class="table table-sm table-striped table-hover table-bordered" id="data-table1" style="color:black;">
										<thead>
											<tr>
												<th>#</th>
												<th>Branch</th>
												<th class="text-right">Outgoing</th>
												<th class="text-right">Hpp Outgoing</th>
												<th class="text-right">Return</th>
												<th class="text-right">Hpp Return</th>
												<th class="text-right">Opname</th>
												<th class="text-right">Destruction</th>
												<th class="text-right">Laba/Rugi</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no=0;			
											$totallaba=0;
											$pAwal=$awal." 00:00:00";
											$pAkhir=$akhir." 23:59:59";
											if($branch=="All Branch"){
												$sql="Select 
														a.branch,
														(Select sum(b.qty*b.harga_beli) as outcome from OUTGOING b where b.branch=a.branch and (tanggal between '$pAwal' and '$pAkhir')) as income,
														(Select sum(b.qty*b.harga_jual) as outcome from OUTGOING b where b.branch=a.branch and (tanggal between '$pAwal' and '$pAkhir')) as outcome,
														(Select sum(b.qty*b.harga_jual) as outcome from RETUR b where b.branch=a.branch and (tanggal between '$pAwal' and '$pAkhir')) as retur,
														(Select sum(b.qty*b.harga_beli) as outcome from RETUR b where b.branch=a.branch and (tanggal between '$pAwal' and '$pAkhir')) as hpp_retur,
														(Select sum((b.qty-b.stok)*b.harga) as outcome from OPNAME b where b.branch=a.branch and (tanggal between '$pAwal' and '$pAkhir')) as opname,
														(Select sum(b.qty*b.harga) as outcome from PEMUSNAHAN b where b.branch=a.branch and (tanggal between '$pAwal' and '$pAkhir')) as destroy
													from BRANCH a													
													";
											}else{
												$sql="Select 
													a.branch,
													(Select sum(b.qty*b.harga_beli) as outcome from OUTGOING b where b.branch=a.branch and (tanggal between '$pAwal' and '$pAkhir')) as income,
													(Select sum(b.qty*b.harga_jual) as outcome from OUTGOING b where b.branch=a.branch and (tanggal between '$pAwal' and '$pAkhir')) as outcome,
													(Select sum(b.qty*b.harga_jual) as outcome from RETUR b where b.branch=a.branch and (tanggal between '$pAwal' and '$pAkhir')) as retur,
													(Select sum(b.qty*b.harga_beli) as outcome from RETUR b where b.branch=a.branch and (tanggal between '$pAwal' and '$pAkhir')) as hpp_retur,
													(Select sum((b.qty-b.stok)*b.harga) as outcome from OPNAME b where b.branch=a.branch and (tanggal between '$pAwal' and '$pAkhir')) as opname,
													(Select sum(b.qty*b.harga) as outcome from PEMUSNAHAN b where b.branch=a.branch and (tanggal between '$pAwal' and '$pAkhir')) as destroy
												from BRANCH a	
												where a.branch='$branch'
												";
											}
											
											$result = $con->query($sql);
											$count = mysqli_num_rows($result);
											if($count>0){
												while($row = mysqli_fetch_assoc($result))
												{
													$no++;
													$branch2=$row["branch"];
													$in=$row["income"];
													$out=$row["outcome"];
													$retur=$row["retur"];
													$hpp_retur=$row["hpp_retur"];
													$opname=$row["opname"];
													$destroy=$row["destroy"];
													$laba=($out-$retur+$hpp_retur)-$in+$opname-$destroy;
													$totallaba=$totallaba+$laba;
													echo"
														<tr>
															<td>$no</td>															
															<td>$branch2</td>
															<td align='right'>".number_format($out)."</td>
															<td align='right'>".number_format($in)."</td>
															<td align='right'>".number_format($retur)."</td>
															<td align='right'>".number_format($hpp_retur)."</td>
															<td align='right'>".number_format($opname)."</td>
															<td align='right'>".number_format($destroy)."</td>
															<td align='right'>".number_format($laba)."</td>
														</tr>
													";													
												}
												echo"
													<tr>
														<th colspan='8' class='text-right'>Total</th>
														<th class='text-right'>".number_format($totallaba)."</th>
													</tr>
												";
											}else{
												echo"
													<tr><td colspan='9' align='center'>No Data Found</td></tr>
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
	<script src="js/datatables/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.responsive.min.js"></script>	
	<script language="javascript">
		$('#data-table').DataTable({
			"responsive": true,
			"autoWidth": false,
			"lengthMenu": [[ 10, 25, -1], [ 10, 25, "All"]],
			"order": [[ 0, 'asc' ],]
		});
	</script>
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
			document.location.href='laba_rugi.php?branch=' + a + '&awal=' + b + '&akhir='+ c;
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