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
    <title>Stock Report:: <?php echo $app_name;?></title>
	
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
		.modal-dialog {
			height: 100%;
			width: 100%;
			display: flex;
			align-items: center;
		}
		.modal-content {
			padding-left:10px;
			padding-right:10px;
			margin: 0 auto;
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
                        <h3 class="text-themecolor">Saldo Stok Barang</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Saldo Stok Barang</li>
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
										
									if(!empty($_POST['branch'])){$branch=$_POST["branch"];}else{if(!empty($_GET["branch"])){$branch=$_GET["branch"];}else{if(strtolower($_SESSION["iss21"]["level"])=="admin"){$branch="All Branch";}else{$branch=$_SESSION["iss21"]["branch"];}}}
									if(!empty($_POST['jenis'])){$jenis=$_POST['jenis'];}else{if(!empty($_GET['jenis'])){$jenis=$_GET['jenis'];}else{$jenis="All Group";}}
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
										
										<div class="<?php if($jenis=="All Group"){echo"col-md-6";}else{echo"col-md-6";}?>">											
											<div class="form-group">
												<label>Group</label>
												<select class="custom-select col-12" id="jenis" name="jenis" onchange="this.form.submit()" required="required">
													<option value="<?php if(!empty($jenis)){echo $jenis;}?>"><?php if(!empty($jenis)){echo $jenis;}else{echo "Pilih...";}?></option>
													<?php
														
														if($branch=="All Branch"){
															$result = $con->query("Select jenis from STOK group by jenis order By jenis");
														}else{
															$result = $con->query("Select jenis from STOK where branch='$branch' group by jenis order By jenis");
														}
														$count = mysqli_num_rows($result);
														if($count>0){						
															echo "<option value='All Group'>All Group</option>";
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
										<?php if($jenis=="All Group"){
											
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
															
															if($branch=="All Branch"){
																$result = $con->query("Select kode, barang from STOK where jenis='$jenis' group by kode, barang order By kode");
															}else{
																$result = $con->query("Select kode, barang from STOK where jenis='$jenis' and branch='$branch' group by kode, barang order By kode");
															}
															$count = mysqli_num_rows($result);
															if($count>0){						
																echo "<option value='All Item Code'>All Item Code</option>";
																while($row = mysqli_fetch_assoc($result))
																{				
																	$kode1=$row["kode"];
																	$barang1=$row["barang"];
																	echo "<option value='$kode1'>$kode1 | $barang1</option>";
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
														<label for="satuan">Unit</label>
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
									echo"<a class='btn btn-success btn-sm text-right' href='export_stock.php?branch=$branch&jenis=$jenis&kode=$kode'><i class='fa fa-file-excel-o'></i> Export</a>";
									echo" <a class='btn btn-primary btn-sm text-right' href='cetak_stock.php?branch=$branch&jenis=$jenis&kode=$kode'><i class='fa fa-print'></i> Cetak</a>";						
								?>
							</div>
							<br>
							<div class="col-sm-12 col-xs-12">
								<div class="table-responsive" id="cetak">
									<div class="Sembunyikan">
										<h5 class="card-title"><b>STOCK REPORT</b>					
										<br>Last Date <?php echo date('d/m/Y H:m'); ?>
										<br>Location <?php echo $branch; ?>
										</h5>
									</div>
									<table class="table table-sm table-striped table-hover table-bordered" id="data-table" style="color:black;">
										<thead>
											<tr>
												<th>No</th>
												<th>Code</th>
												<th>Group</th>
												<th>Merk</th>
												<th>Item Description</th>												
												<th class='text-center' align='center'>Saldo</th>
												<th class='text-center' align='center'>Unit</th>
												<?php if($_SESSION["iss21"]["position"]=="Admin"){ ?>
												<th class="text-right">Nilai Beli</th>
												<th class="text-right">Nilai Jual</th>
												<?php } ?>
											</tr>
										</thead>
										<tbody>
											<?php
											$nominal=0;
											$count=0;
											$no=0;
											if($kode=="All Item Code"){
												if($jenis=="All Group"){											
													if($branch=="All Branch"){
														$sql="Select a.kode, a.jenis, a.subgroup, a.merk, a.barang, a.satuan, sum(a.saldo) as saldo, b.harga_beli, b.harga_jual from STOK a inner join BARANG b on a.kode=b.kode group by a.kode, a.jenis, a.subgroup, a.merk, a.barang, a.satuan, b.harga_beli, b.harga_jual order by a.jenis,a.barang,a.satuan";
													}else{
														$sql="Select a.kode, a.jenis, a.subgroup, a.merk, a.barang, a.satuan, sum(a.saldo) as saldo, b.harga_beli, b.harga_jual from STOK a inner join BARANG b on a.kode=b.kode where a.branch='$branch' group by a.kode, a.jenis, a.subgroup, a.merk, a.barang, a.satuan, b.harga_beli, b.harga_jual order by a.jenis,a.barang,a.satuan";
													}												
												}else{
													if($branch=="All Branch"){
														$sql="Select a.kode, a.jenis, a.subgroup, a.merk, a.barang, a.satuan, sum(a.saldo) as saldo, b.harga_beli, b.harga_jual from STOK a inner join BARANG b on a.kode=b.kode where a.jenis='$jenis' group by a.kode, a.jenis, a.subgroup, a.merk, a.barang, a.satuan, b.harga_beli, b.harga_jual order by a.jenis,a.barang,a.satuan";
													}else{
														$sql="Select a.kode, a.jenis, a.subgroup, a.merk, a.barang, a.satuan, sum(a.saldo) as saldo, b.harga_beli, b.harga_jual from STOK a inner join BARANG b on a.kode=b.kode where a.branch='$branch' and a.jenis='$jenis' group by a.kode, a.jenis, a.subgroup, a.merk, a.barang, a.satuan, b.harga_beli, b.harga_jual order by a.jenis,a.barang,a.satuan";
													}
												}
											}else{
												if($branch=="All Branch"){
													$sql="Select a.kode, a.jenis, a.subgroup, a.merk, a.barang, a.satuan, sum(a.saldo) as saldo, b.harga_beli, b.harga_jual from STOK a inner join BARANG b on a.kode=b.kode where a.jenis='$jenis' and a.kode='$kode' group by a.kode, a.jenis, a.subgroup, a.merk, a.barang, a.satuan, b.harga_beli, b.harga_jual order by a.jenis,a.barang,a.satuan";
												}else{
													$sql="Select a.kode, a.jenis, a.subgroup, a.merk, a.barang, a.satuan, sum(a.saldo) as saldo, b.harga_beli, b.harga_jual from STOK a inner join BARANG b on a.kode=b.kode where a.branch='$branch' and a.jenis='$jenis' and a.kode='$kode' group by a.kode, a.jenis, a.subgroup, a.merk, a.barang, a.satuan, b.harga_beli, b.harga_jual order by a.jenis,a.barang,a.satuan";
												}												
											}
											$result = $con->query($sql);
											$count = mysqli_num_rows($result);
											if($count>0){
											    $totalsaldo=0;
												$totalbeli=0;
												$totaljual=0;
												while($row = mysqli_fetch_assoc($result))
												{
													$no++;
													$kode2=$row["kode"];
													$jenis2=$row["jenis"];
													$subgroup2=$row["subgroup"];
													$merk2=$row["merk"];
													$barang2=$row["barang"];
													$satuan2=$row["satuan"];
													$harga_beli2=$row["harga_beli"];
													$harga_jual2=$row["harga_jual"];
													$saldo2=$row["saldo"];
													$totalbeli=$totalbeli+($saldo2*$harga_beli2);
													$totaljual=$totaljual+($saldo2*$harga_jual2);
													$totalsaldo=$totalsaldo+$saldo2;
													echo"
														<tr>
															<td>$no</td>
															<td>$kode2</td>
															<td>$jenis2</td>
															<td>$merk2</td>
															<td>$barang2</td>
															<td class='text-center' align='center'>".number_format($saldo2,0,',','.')."</td>
															<td class='text-center' align='center'>$satuan2</td>
															";
															if($_SESSION["iss21"]["position"]=="Admin"){
															    echo"
															    <td align='right'>".number_format($saldo2*$harga_beli2,0,',','.')."</td>
															    <td align='right'>".number_format($saldo2*$harga_jual2,0,',','.')."</td>
															    ";
															}
													echo"		
														</tr>
													";													
												}
												if($_SESSION["iss21"]["position"]=="Admin"){
												    echo"
														<tr>
															<th colspan='5' class='text-right' align='right'>Grand Total</th>
															<th class='text-center' align='center'>".number_format($totalsaldo,0,',','.')."</th>
															<th></th>
															<th class='text-right'>".number_format($totalbeli,0,',','.')."</th>
															<th class='text-right'>".number_format($totaljual,0,',','.')."</th>
														</tr>
													";
												}else{
												    echo"
														<tr>
															<th colspan='5' class='text-right' align='right'>Grand Total</th>
															<th class='text-center' align='center'>".number_format($totalsaldo,0,',','.')."</th>
															<th></th>
														</tr>
													";
												}
											}else{
                            				    if($_SESSION["iss21"]["position"]=="Admin"){
                            					    echo"<tr><td colspan='9' align='center'>No Data Found</td></tr>";
                            				    }else{
                            				        echo"<tr><td colspan='7' align='center'>No Data Found</td></tr>";
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