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
    <title>List Items :: <?php echo $app_name;?></title>
	
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
                        <h3 class="text-themecolor">Daftar Barang</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Daftar Barang</li>
                        </ol>
                    </div>	
					<div class="col-md-7 align-self-center text-right d-none d-md-block">
                        <!--<button onclick="printContent('cetak')" class="btn btn-primary text-right"><i class="fa fa-print"></i> Print</button>-->
                    </div>
                </div>
				<?php
					if(!empty($_POST['jenis'])){$jenis=$_POST['jenis'];}else{if(!empty($_GET['jenis'])){$jenis=$_GET['jenis'];}else{$jenis="All Group";}}
				?>
				<div class="row" style='font-size:small;'>
					<div class="col-12">
                        <div class="card card-body">								
							<form method="POST" action="">
							<div class="col-md-12">											
								<div class="form-group">
									<label>Group</label>
									<select class="custom-select col-12" id="jenis" name="jenis" onchange="this.form.submit()" required="required">
										<option value="<?php if(!empty($jenis)){echo $jenis;}?>"><?php if(!empty($jenis)){echo $jenis;}else{echo "Pilih...";}?></option>
										<?php
											
											$result = $con->query("Select jenis from BARANG group by jenis order By jenis");
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
							</form>
						</div>
					</div>
                    <div class="col-12">
                        <div class="card card-body">
							<div class="text-right">
								<?php
									echo"<a class='btn btn-success btn-sm text-right' href='export_item.php?jenis=$jenis'><i class='fa fa-file-excel-o'></i> Export</a>";
									echo" <a class='btn btn-primary btn-sm text-right' href='cetak_item.php?jenis=$jenis'><i class='fa fa-print'></i> Cetak</a>";						
								?>
							</div>
							<div class="col-sm-12 col-xs-12">
								<div class="table-responsive" id="cetak">
									<div class="Sembunyikan">
										<h5 class="card-title"><b>LIST ITEMS</b>			
										<br>Last Date <?php echo date('d/m/Y H:m:s'); ?>									
										</h5>
									</div>
									<table class="table table-sm table-striped table-hover table-bordered" id="data-table" style="color:black;">
										<thead>
											<tr>
												<th>No</th>
												<th>Code</th>
												<th>Group</th>
												<th>Sub Group</th>
												<th>Merk</th>
												<th>Item Description</th>												
												<th>Unit</th>
												<th class="text-right">Harga Beli</th>
												<th class="text-right">Harga Jual</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$count=0;
											$no=0;
											if($jenis=="All Group"){
												$sql="Select * from BARANG order by barang";
											}else{
												$sql="Select * from BARANG where jenis='$jenis' order by barang";
											}
											$result = $con->query($sql);
											$count = mysqli_num_rows($result);
											if($count>0){
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
													echo"
														<tr>
															<td>$no</td>
															<td>$kode2</td>
															<td>$jenis2</td>
															<td>$subgroup2</td>
															<td>$merk2</td>
															<td>$barang2</td>
															<td>$satuan2</td>
															<td align='right'>".number_format($harga_beli2,0,",",".")."</td>
															<td align='right'>".number_format($harga_jual2,0,",",".")."</td>
														</tr>
													";													
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
	<script language="javascript">
		function printContent(el){
			var a=document.getElementById('jenis').value;
			var restorepage = document.body.innerHTML;
			var printcontent = document.getElementById(el).innerHTML;			
			document.body.innerHTML = printcontent;
			window.print();
			document.body.innerHTML = restorepage;
			document.location.href='all-item.php?jenis='+a;
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