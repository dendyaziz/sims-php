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
    <title>Incoming Transaction :: <?php echo $app_name;?></title>
	
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
                        <h3 class="text-themecolor">Transaksi Barang Masuk</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Transaksi Barang Masuk</li>
                        </ol>
                    </div>										
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-body">
                            <h4 class="card-title">Edit Transaksi Barang Masuk</h4>
                            <h5 class="card-subtitle">  Editing <code>Incoming</code> </h5>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
								
									<?php
										
										if(!empty($_GET["username"])){$username=$_GET["username"];}else{$username="";}
										if(!empty($_POST['tanggal'])){$tanggal=date('Y-m-d',strtotime($_POST['tanggal']));}else{if(!empty($_GET['tanggal'])){$tanggal=date('Y-m-d',strtotime($_GET['tanggal']));}else{$tanggal="";}}
										if(!empty($_POST['faktur'])){$faktur=$_POST['faktur'];}else{if(!empty($_GET['faktur'])){$faktur=$_GET['faktur'];}else{$faktur="";}}
										if(!empty($_POST["jenis"])){$jenis=$_POST["jenis"];}else{$jenis="";}
										if(!empty($_POST["barang"])){$barang=$_POST["barang"];}else{$barang="";}
										if(!empty($_POST["satuan"])){$satuan=$_POST["satuan"];}else{$satuan="";}
										if(!empty($_POST["kode"])){$kode=$_POST["kode"];}else{$kode="";}										
										if(!empty($_POST["qty"])){$qty=$_POST["qty"];}else{$qty="";}
										if(!empty($_POST["harga"])){$harga=$_POST["harga"];}else{$harga="";}
										if(!empty($_POST['kode_supplier'])){$kode_supplier=$_POST['kode_supplier'];}else{if(!empty($_GET['kode_supplier'])){$kode_supplier=$_GET['kode_supplier'];}else{$kode_supplier="";}}
										if(!empty($_POST['supplier'])){$supplier=$_POST['supplier'];}else{if(!empty($_GET['supplier'])){$supplier=$_GET['supplier'];}else{$supplier="";}}
										if(!empty($_POST['alamat_supplier'])){$alamat_supplier=$_POST['alamat_supplier'];}else{if(!empty($_GET['alamat_supplier'])){$alamat_supplier=$_GET['alamat_supplier'];}else{$alamat_supplier="";}}
										if(!empty($_POST['telepon_supplier'])){$telepon_supplier=$_POST['telepon_supplier'];}else{if(!empty($_GET['telepon_supplier'])){$telepon_supplier=$_GET['telepon_supplier'];}else{$telepon_supplier="";}}
										if(!empty($_POST['person_supplier'])){$person_supplier=$_POST['person_supplier'];}else{if(!empty($_GET['person_supplier'])){$person_supplier=$_GET['person_supplier'];}else{$person_supplier="";}}
										
										if(!empty($kode_supplier)){
											$result = $con->query("Select * from SUPPLIER where supplier='$supplier'");											
											while($row = mysqli_fetch_assoc($result))
											{
												$supplier=$row["supplier"];
												$alamat_supplier=$row["alamat"];
												$telepon_supplier=$row["telepon"];
												$person_supplier=$row["person"];
												$kode_supplier=$row["kode"];												
											}											
										}
										
										
									?>
									
                                   
										<div class="row">	
											<form method="POST" action="">	
											<div class="col-md-6">												
												<div class="form-group">
													<label for="faktur">Faktur</label>
													<input class="form-control form-control-line" type="text" name="faktur" id="faktur" onChange="getFaktur(this.value)" value="<?php echo $faktur; ?>" <?php if(empty($faktur)){echo "autofocus";} ?> required="required">
												</div>													
											</div>											
											<div class="col-md-6">
												<div class="form-group">
													<label for="tanggal">Tanggal</label>
													<input class="form-control form-control-line" type="text" name="tanggal" id="tanggal" value="<?php echo $tanggal; ?>" required="required" readonly>
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label for="supplier">Supplier</label>
													<input type="text" class="form-control" id="supplier" name="supplier" value="<?php  echo $supplier; ?>" required="required"  readonly >
													<small>Isi dengan sebagian nama supplier dan pilih autocomplete supplier yang tersedia</small>
												</div>
											</div>
										</div>
										<div class="row" hidden>
											
											<div class="col-md-12">
												<div class="form-group">
													<label for="kode_supplier">Kode Supplier</label>
													<input type="text" class="form-control" id="kode_supplier" name="kode_supplier" value="<?php  echo $kode_supplier; ?>" required="required"  readonly >
												</div>
											</div>											
												<button class="btn btn-info" id="btn-view" hidden></button>
											</form>
											 <form method="POST" action="">										
												<input type="text" name="username" value="<?php echo $_SESSION["iss21"]["fullname"];?>" hidden required="required">
												<input type="text" name="tanggal" value="<?php echo $tanggal;?>" hidden required="required">
												<input type="text" name="faktur" value="<?php echo $faktur;?>" hidden required="required">
												<input type="text" name="supplier" value="<?php echo $supplier;?>" hidden required="required">
											
											<div class="col-md-12">
												<div class="form-group">
													<label for="alamat_supplier">Alamat Supplier</label>
													<input type="text" class="form-control" id="alamat_supplier" name="alamat_supplier" value="<?php  echo $alamat_supplier; ?>" required="required" readonly >
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="telepon_supplier">Telepon Supplier</label>
													<input type="text" class="form-control" id="telepon_supplier" name="telepon_supplier" value="<?php  echo $telepon_supplier; ?>"  readonly >
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="person_supplier">Contact Person</label>
													<input type="text" class="form-control" id="person_supplier" name="person_supplier" value="<?php  echo $person_supplier; ?>" readonly >
												</div>
											</div>
											
											
										</div>										
										<div class="row">										
											<div class="col-md-12">
												<div class="form-group">
													<label for="barang">Barang</label>
													<input class="form-control form-control-line" type="text" name="barang" id="barang" onChange="getItem(this.value)" value="<?php echo $barang; ?>" <?php if(empty($barang)){echo "autofocus";} ?> required="required">
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label for="jenis">Jenis</label>
													<input class="form-control form-control-line" type="text" name="jenis" id="jenis" value="<?php echo $jenis; ?>" readonly required="required">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="satuan">Satuan</label>
													<input class="form-control form-control-line" type="text" name="satuan" id="satuan" value="<?php echo $satuan; ?>" readonly>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="kode">Kode</label>
													<input class="form-control form-control-line" type="text" name="kode" id="kode" value="<?php echo $kode; ?>" readonly>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="qty">Jumlah</label>
													<input type="number" class="form-control" id="qty" name="qty" value="<?php if(!empty($qty)){echo $qty;}?>" required="required">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="harga">Harga Beli</label>
													<input type="number" class="form-control" id="harga" name="harga" value="<?php if(!empty($harga)){echo $harga;}?>" required="required">
												</div>
											</div>											
										</div>
										
										<div class="row">
											<div class="col-md-12">												
												<button type="submit" class="btn btn-success mr-2" formaction="fc/fc_add_pembelian_edit.php" ><i class="fa fa-paper-plane"></i> Submit</button>
												<button type="reset" class='btn btn-dark mr2'><i class="fa fa-refresh"></i> Reset</button>
											</div>
										</div>
										
										
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				
				<div class="row">
                    <div class="col-12">
                        <div class="card card-body">
							<div class="col-sm-12 col-xs-12">
								<!--<button onclick="printContent('cetak')" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Print</button>-->
								<div class="table-responsive">									
									<table class="table table-sm table-striped table-hover table-bordered" id="data-table1" style="color:black;">
										<thead>
											<tr>
												<th>#</th>												
												<th>Kode</th>
												<th>Jenis Barang</th>
												<th>Nama Barang</th>
												<th>Satuan</th>
												<th class='text-right'>Qty</th>
												<th class='text-right'>Harga</th>
												<th class="text-center">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php											
											$count=0;
											$no=0;
											$Qbranch=$_SESSION["iss21"]["branch"];
											$sql="Select * from PEMBELIAN where branch='$Qbranch' and CONVERT(tanggal, DATE)='$tanggal' and faktur='$faktur' order By id";
											$result = $con->query($sql);
											$count = mysqli_num_rows($result);
											if($count>0){
												while($row = mysqli_fetch_assoc($result))
												{
													$no++;
													$branch2=$row["branch"];	
													$faktur2=$row["faktur"];
													$tanggal2=$row["tanggal"];
													$tanggal2=date('Y-m-d',strtotime($tanggal2));
													$kode2=$row["kode"];
													$jenis2=$row["jenis"];
													$barang2=$row["barang"];
													$satuan2=$row["satuan"];
													$qty2=$row["qty"];
													$harga2=$row["harga"];
													$id2=$row["id"];
													
													echo"
														<tr>
															<td>$no</td>																													
															<td>$kode2</td>
															<td>$jenis2</td>
															<td>$barang2</td>
															<td>$satuan2</td>
															<td align='right'>".number_format($qty2)."</td>	
															<td align='right'>".number_format($harga2)."</td>														
															<td align='center' nowrap>
																<a class='btn btn-danger btn-sm' href='fc/fc_delete_pembelian_edit.php?id=$id2&tanggal=$tanggal2&faktur=$faktur' title='Hapus Barang Masuk'><i class='fa fa-trash'></i> Delete</a>
															</td>
														</tr>
													";
												}												
											}											
											?>                                      
										</tbody>
									</table>
								</div>
								
								<div class="table-responsive Sembunyikan" id="cetak">
									<h4 class="card-title"><b>TRANSAKSI BARANG MASUK</b>
										<br>Faktur <?php echo $faktur; ?>
										<br>Tanggal <?php echo date('d/m/Y',strtotime($_GET['tanggal'])); ?>
										<br>Gudang <?php echo $_SESSION["iss21"]["branch"]; ?>
									</h4>
									<table class="table table-sm table-hover table-bordered">
										<thead>
											<tr>
												<th>#</th>
												<th>Kode</th>
												<th>Jenis Barang</th>
												<th>Nama Barang</th>
												<th>Satuan</th>
												<th class='text-right'>Qty</th>
											</tr>
										</thead>
										<tbody>
											<?php											
											$count=0;
											$no=0;
											$Qbranch=$_SESSION["iss21"]["branch"];
											$sql="Select * from PEMBELIAN where branch='$Qbranch' and CONVERT(tanggal, DATE)='$tanggal' and faktur='$faktur' order By branch, CONVERT(tanggal, DATE), jenis, barang, kode, satuan";
											$result = $con->query($sql);
											$count = mysqli_num_rows($result);
											if($count>0){
												while($row = mysqli_fetch_assoc($result))
												{
													$no++;
													$branch2=$row["branch"];	
													$faktur2=$row["faktur"];
													$tanggal2=$row["tanggal"];
													$tanggal2=date('Y-m-d',strtotime($tanggal2));
													$kode2=$row["kode"];
													$jenis2=$row["jenis"];
													$barang2=$row["barang"];
													$satuan2=$row["satuan"];
													$qty2=$row["qty"];
													$username2=$row["username"];
													$id2=$row["id"];
													
													echo"
														<tr>
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
									<table class="table table-sm table-bordered" id="table">
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
		$("#faktur").autocomplete({
			serviceUrl: "autocomplete_faktur_pembelian.php",
			dataType: "JSON",
			onSelect: function (suggestion) {
				$("#faktur").val("" + suggestion.faktur);
				var s=document.getElementById('faktur').value;
				getFaktur(s);
			}
		});
		function getFaktur(val){
			$.post('get_faktur_pembelian.php',{data:val},function(result){
				$('#tanggal').val(result.tanggal);
				$('#faktur').val(result.faktur);
				$('#kode_supplier').val(result.kode);
				$('#supplier').val(result.supplier);
				$('#alamat_supplier').val(result.alamat);
				$('#telepon_supplier').val(result.telepon);
				$('#person_supplier').val(result.person);
				document.getElementById("btn-view").click();				
			}, "json");	
			
			
			
		}
		
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
				$('#satuan').val(result.satuan);
				$('#kode').val(result.kode);
				$('#harga').val(result.harga);
				document.getElementById("qty").focus();
			}, "json");	
			
		}
		
	</script>
    <?php include("inc/js_bawah.php");?>
	<script language="javascript">
		function printContent(el){
			var b=document.getElementById('tanggal').value;
			var c=document.getElementById('faktur').value;
			var d=document.getElementById('kode_supplier').value;
			
			var restorepage = document.body.innerHTML;
			var printcontent = document.getElementById(el).innerHTML;
			document.body.innerHTML = printcontent;
			window.print();
			document.body.innerHTML = restorepage;
			document.location.href='incoming-edit.php?tanggal='+b+'&faktur='+c+'&kode_supplier'+d;
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