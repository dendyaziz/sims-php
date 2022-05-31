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
    <title>Inventory Report :: <?php echo $app_name;?></title>
	
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
                        <h3 class="text-themecolor">Inventory Report</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Inventory Report</li>
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
									if(!empty($_POST['branch'])){$branch=$_POST["branch"];}else{if(!empty($_GET["branch"])){$branch=$_GET["branch"];}else{$branch=$_SESSION["iss21"]["branch"];}}
									if(!empty($_POST['awal'])){$awal=date('Y-m-d',strtotime($_POST['awal']));}else{if(!empty($_GET['awal'])){$awal=date('Y-m-d',strtotime($_GET['awal']));}else{$awal=date("Y-m-d");}}
									if(!empty($_POST['akhir'])){$akhir=date('Y-m-d',strtotime($_POST['akhir']));}else{if(!empty($_GET['akhir'])){$akhir=date('Y-m-d',strtotime($_GET['akhir']));}else{$akhir=date("Y-m-d");}}									
									
								?>
								
								<form id="theForm" method="POST" action="">
									
									<div class="row">
										
										<div class="col-md-4">											
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
								</form>
							</div>
						</div>
					</div>
					<div class="col-12">
                        <div class="card card-body">
							<div class="col-sm-12 col-xs-12">
								<div class="text-right">
									<?php
										echo"<a class='btn btn-success btn-sm text-right' href='export_inventory.php?awal=$awal&akhir=$akhir&branch=$branch'><i class='fa fa-file-excel-o'></i> Export</a>";
										echo" <a class='btn btn-primary btn-sm text-right' href='cetak_inventory.php?awal=$awal&akhir=$akhir&branch=$branch'><i class='fa fa-print'></i> Cetak</a>";						
									?>
								</div>
								<br>
								<div class="table-responsive" id="cetak">
									<!--
									<div class="Sembunyika">
										<h5 class="card-title"><b>PT. PRATAMA WIDYA</b>				
										<br>Period <?php echo date('d/m/Y',strtotime($awal))." s/d ".date('d/m/Y',strtotime($akhir)); ?>
										<br>Project <?php echo $branch; ?>
										</h5>
									</div>
									-->
									<h5 class="card-title"><b><?php echo $branch; ?></b><br>Period <?php echo date('d/m/Y',strtotime($awal))." s/d ".date('d/m/Y',strtotime($akhir)); ?></h5>
									<table border="1" cellpadding="5" style='color:black;font-size:small;'>
										<thead>
											<tr>
												<th>Code</th>
                            					<th>Group</th>
                            					<th>Merk</th>
                            					<th>Item Description</th>
                            					<th>Opening Balance</th>
                            					<th>Received Items</th>
                            					<th>Outgoing Items</th>
                            					<th>Adjustment Stock</th>
                            					<th>Destruction</th>
                            					<th>Ending Balance</th>
                            					<th>Unit</th>											
											</tr>
										</thead>
										<tbody>
											<?php
											
											$total_last=0;
											$total_incoming=0;
											$total_outgoing=0;
											$total_opname=0;
											$total_ending=0;
											$total_destroy=0;
											
											$count=0;
											$no=0;											
											$pAwal=$awal." 00:00:00";
											$pAkhir=$akhir." 23:59:59";
											
												$sql="
													Select a.kode, a.barang, a.jenis, a.subgroup, a.merk, a.satuan,
														ifnull((Select sum(b.qty) from PEMBELIAN b where b.branch='$branch' and a.kode=b.kode and b.tanggal<'$pAwal'),0)
														-											
														ifnull((Select sum(c.qty) from OUTGOING c where c.branch='$branch' and a.kode=c.kode and c.tanggal<'$pAwal'),0)
														-											
														ifnull((Select sum(c.qty) from PEMUSNAHAN c where c.branch='$branch' and a.kode=c.kode and c.tanggal<'$pAwal'),0)
														+											
														ifnull((Select sum(c.qty-c.stok) from OPNAME c where c.branch='$branch' and a.kode=c.kode and c.tanggal<'$pAwal'),0)
														
														as last,
														ifnull((Select sum(d.qty) from PEMBELIAN d where d.branch='$branch' and a.kode=d.kode and (d.tanggal between '$pAwal' and '$pAkhir')),0)as incoming,
														ifnull((Select sum(e.qty) from OUTGOING e where e.branch='$branch' and a.kode=e.kode and (e.tanggal between '$pAwal' and '$pAkhir')),0) as outgoing,
														ifnull((Select sum(g.qty-g.stok) from OPNAME g where  g.branch='$branch' and a.kode=g.kode and (g.tanggal between '$pAwal' and '$pAkhir')),0) as opname,
														ifnull((Select sum(h.qty) from PEMUSNAHAN h where  h.branch='$branch' and a.kode=h.kode and (h.tanggal between '$pAwal' and '$pAkhir')),0) as destroy
													from BARANG a
													group by a.kode, a.barang, a.jenis, a.subgroup, a.merk, a.satuan
													order by a.jenis, a.subgroup, a.merk, a.barang
												";
												
												$result = $con->query($sql);
												$count = mysqli_num_rows($result);
												if($count>0){
													while($row = mysqli_fetch_assoc($result))
													{
														$kode2=$row["kode"];
														$jenis2=$row["jenis"];
														$subgroup2=$row["subgroup"];
														$merk2=$row["merk"];
														$barang2=$row["barang"];
														$satuan2=$row["satuan"];														
														$last=$row["last"];														
														$incoming=$row["incoming"];														
														$outgoing=$row["outgoing"];
														$opname=$row["opname"];
														$destroy=$row["destroy"];
														
														echo"
															<tr style='font-size:small;'>
																<td>$kode2</td>
                            									<td>$jenis2</td>
                            									<td>$merk2</td>
                            									<td>$barang2</td>
                            									<td align='center'>".number_format($last,0,",",".")."</td>
                            									<td align='center'>".number_format($incoming,0,",",".")."</td>
                            									<td align='center'>".number_format($outgoing,0,",",".")."</td>
                            									<td align='center'>".number_format($opname,0,",",".")."</td>
                            									<td align='center'>".number_format($destroy,0,",",".")."</td>
                            									<td align='center'>".number_format($last+$incoming-$outgoing+$opname-$destroy,0,",",".")."</td>
                            									<td>$satuan2</td>																
															</tr>
															
														";

														$total_last=$total_last+$last;
														$total_incoming=$total_incoming+$incoming;
														$total_outgoing=$total_outgoing+$outgoing;
														$total_opname=$total_opname+$opname;
														$total_destroy=$total_destroy+$destroy;
														
													}
													echo"
                            							<tr>
                            								<td align='center' colspan='4'><b>GRAND TOTAL</b></td>
                            								<td align='center'>".number_format($total_last,0,",",".")."</td>
                            								<td align='center'>".number_format($total_incoming,0,",",".")."</td>
                            								<td align='center'>".number_format($total_outgoing,0,",",".")."</td>
                            								<td align='center'>".number_format($total_opname,0,",",".")."</td>
                            								<td align='center'>".number_format($total_destroy,0,",",".")."</td>
                            								<td align='center'>".number_format($total_last+$total_incoming-$total_outgoing+$total_opname-$total_destroy,0,",",".")."</td>
                            								<td></td>
                            							</tr>	
                            						";
												}else{
                                				    echo"
                                						<tr><td colspan='12' align='center'>No Data Found</td></tr>
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