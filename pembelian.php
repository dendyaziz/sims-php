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
                        <h3 class="text-themecolor">Transaksi Pembelian</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Transaksi Pembelian</li>
                        </ol>
                    </div>										
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-body">
                            <h4 class="card-title">Input Transaksi Pembelian</h4>
                            <h5 class="card-subtitle"> Incoming <code>Transaction</code> </h5>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
								
									<?php
										
										if(!empty($_POST['tanggal'])){
											$tanggal=date('Y-m-d',strtotime($_POST['tanggal']));
										}else{
											if(!empty($_GET['tanggal'])){
												$tanggal=date('Y-m-d',strtotime($_GET['tanggal']));
											}else{
												$tanggal=date("Y-m-d");
											}
										}
										if(!empty($_POST['faktur'])){
											$faktur=$_POST['faktur'];
										}else{
											if(!empty($_GET['faktur'])){
												$faktur=$_GET['faktur'];
											}else{
												$faktur="";
											}
										}
										if(!empty($_POST['suplier'])){
											$suplier=$_POST['suplier'];
										}else{
											if(!empty($_GET['suplier'])){
												$suplier=$_GET['suplier'];
											}else{
												$suplier="";
											}
										}
										
										if(!empty($_GET["username"])){$username=$_GET["username"];}else{$username="";}										
										if(!empty($_POST["jenis"])){$jenis=$_POST["jenis"];}else{$jenis="";}
										if(!empty($_POST["barang"])){$barang=$_POST["barang"];}else{$barang="";}										
										if(!empty($_POST["satuan"])){$satuan=$_POST["satuan"];}else{$satuan="";}
										if(!empty($_POST["kode"])){$kode=$_POST["kode"];}else{$kode="";}
										
										if(!empty($_POST["qty"])){$qty=$_POST["qty"];}else{$qty="";}
										if(!empty($_POST["harga"])){$harga=$_POST["harga"];}else{$harga="";}
										
										
										if(!empty($faktur)){
											$linkba="add-bast.php?faktur=$faktur&tanggal=$tanggal";
										}else{
											$linkba="";
										}
										
									?>
								
                                    <form method="POST" action="">										
										<input type="text" name="username" value="<?php echo $_SESSION["iss21"]["fullname"];?>" hidden required="required">
										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label for="tanggal">Tanggal</label>
													<input class="form-control form-control-line" type="date" name="tanggal" id="tanggal" value="<?php echo $tanggal; ?>" required="required">
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="faktur">Faktur Pembelian</label>
													<input type="text" class="form-control" id="faktur" name="faktur" value="<?php  echo $faktur; ?>" required="required"  <?php if(empty($faktur)){echo "autofocus";} ?> >
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="suplier">Suplier</label>
													<input type="text" class="form-control" id="suplier" name="suplier" value="<?php  echo $suplier; ?>" required="required"  <?php if(empty($suplier)){echo "autofocus";} ?> >
												</div>
											</div>
										</div>
										
										<div class="row">										
											<div class="col-md-4">
												<div class="form-group">
													<label for="barang">Barang</label>
													<input class="form-control form-control-line" type="text" name="barang" id="barang" onChange="getItem(this.value)" value="<?php echo $barang; ?>" <?php if(empty($barang)){echo "autofocus";} ?> required="required">
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
										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label for="qty">Jumlah</label>
													<input type="number" class="form-control" id="qty" name="qty" value="<?php if(!empty($qty)){echo $qty;}?>" required="required">
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="harga">Harga</label>
													<input type="number" class="form-control" id="harga" name="harga" value="<?php if(!empty($harga)){echo $harga;}?>" oninput="addCommas(this.value)" required="required">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<button type="submit" class="btn btn-success mr-2" formaction="fc/fc_add_pembelian.php" >Submit</button>
												<button type="reset" class='btn btn-dark mr2'>Cancel</button>
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
								<button onclick="printContent('cetak')" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Print Pembelian</button>
								<a class='btn btn-success btn-sm' href="<?php echo $linkba; ?>" title='Tambah Data BAST' <?php if(empty($faktur)){ echo"disabled";}?> ><i class='fa fa-plus-circle'></i> Add BAST</a> 
								<div class="table-responsive">									
									<table class="table table-sm table-hover table-bordered" id="table">
										<thead>
											<tr>
												<th>#</th>
												<th>Branch</th>
												<th>Faktur</th>
												<th>Tanggal</th>												
												<th>Kode</th>
												<th>Jenis</th>
												<th>Nama Barang</th>
												<th>Satuan</th>
												<th class='text-right'>Qty</th>
												<th class='text-right'>Harga</th>
												<th class='text-right'>SubTotal</th>
												<?php if(strtolower($_SESSION["iss21"]["level"])=="admin"){?>
												<th class="text-center">Action</th>
												<?php } ?>
											</tr>
										</thead>
										<tbody>
											<?php
											$total=0;
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
													$id2=$row["id"];
													
													$harga2=$row["harga"];
													$subtotal2=($harga2*$qty2);
													$total=$total+$subtotal2;
													
													echo"
														<tr>
															<td>$no</td>
															<td>$branch2</td>
															<td>$faktur2</td>
															<td>$tanggal2</td>
															<td>$kode2</td>
															<td>$jenis2</td>
															<td>$barang2</td>
															<td>$satuan2</td>
															<td align='right'>".number_format($qty2)."</td>
															<td align='right'>".number_format($harga2)."</td>
															<td align='right'>".number_format($subtotal2)."</td>
															";
														if(strtolower($_SESSION["iss21"]["level"])=="admin"){
															echo"
															<td align='center' nowrap>
																<a class='btn btn-danger btn-sm' href='fc/fc_delete_pembelian.php?id=$id2&tanggal=$tanggal2&faktur=$faktur' title='Hapus Pembelian'> <i class='fa fa-trash'></i> Delete</a>
															</td>";
															}
													echo"
														</tr>
													";
												}
												if(strtolower($_SESSION["iss21"]["level"])=="admin"){
													echo"
														<tr>
															<td colspan='10' align='right'><b>GRAND TOTAL</b></td><td>".number_format($total)."</td>
														</tr>
													";
												}else{
													echo"
														<tr>
															<td colspan='9' align='right'><b>GRAND TOTAL</b></td><td>".number_format($total)."</td>
														</tr>
													";
												}
											}
											
											?>                                      
										</tbody>
									</table>
								</div>
								
								
								
                            
								<div class="table-responsive Sembunyikan" id="cetak">	
									<h4 class="card-title"><b>PEMBELIAN</b>
										<br>Faktur <?php echo $faktur; ?>
										<br>Tanggal <?php echo date('d/m/Y',strtotime($_GET['tanggal'])); ?>
										<br>Cabang <?php echo $_SESSION["iss21"]["branch"]; ?>
									</h4>
									<table class="table table-sm table-hover table-bordered" id="table">
										<thead>
											<tr>
												<th>#</th>
												<th>Kode</th>
												<th>Jenis</th>
												<th>Nama Barang</th>
												<th>Satuan</th>
												<th class='text-right'>Qty</th>
												<th class='text-right'>Harga</th>
												<th class='text-right'>SubTotal</th>											
											</tr>
										</thead>
										<tbody>
											<?php
											$count=0;
											$no=0;
											$Qbranch=$_SESSION["iss21"]["branch"];
											$Quser=$_SESSION["iss21"]["fullname"];
											$sql="Select * from PEMBELIAN where branch='$Qbranch' and CONVERT(tanggal, DATE)='$tanggal' and faktur='$faktur' order By branch, CONVERT(tanggal, DATE), jenis, barang, kode, satuan";
											$result = $con->query($sql);
											$count = mysqli_num_rows($result);
																						
											if($count>0){
												while($row = mysqli_fetch_assoc($result))
												{
													$no++;
													$branch2=$row["branch"];													
													$tanggal2=$row["tanggal"];
													$tanggal2=date('Y-m-d',strtotime($tanggal2));
													$kode2=$row["kode"];
													$jenis2=$row["jenis"];
													$barang2=$row["barang"];
													$satuan2=$row["satuan"];
													$qty2=$row["qty"];
													$id2=$row["id"];
													
													$username2=$row["username"];
													
													$harga2=$row["harga"];
													$subtotal2=($harga2*$qty2);
													$total=$total+$subtotal2;
																										
													echo"
														<tr>
															<td>$no</td>
															<td>$kode2</td>
															<td>$jenis2</td>
															<td>$barang2</td>
															<td>$satuan2</td>
															<td align='right'>".number_format($qty2)."</td>
															<td align='right'>".number_format($harga2)."</td>
															<td align='right'>".number_format($subtotal2)."</td>
														</tr>														
													";
													
												}
												echo"
														<tr>
															<td colspan='7' align='right'><b>GRAND TOTAL</b></td><td align='right'>".number_format($total)."</td>
														</tr>
												";
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
				document.getElementById("qty").focus();
			}, "json");			
		}
		function addCommas(nStr)
		{
			nStr += '';
			x = nStr.split('.');
			x1 = x[0];
			x2 = x.length > 1 ? ',' + x[1] : '';
			var rgx = /(\d+)(\d{3})/;
			while (rgx.test(x1)) {
				x1 = x1.replace(rgx, '$1' + ',' + '$2');
			}
			return x1 + x2;
		}
	</script>
    <?php include("inc/js_bawah.php");?>
	<script language="javascript">
		function printContent(el){
			var restorepage = document.body.innerHTML;
			var printcontent = document.getElementById(el).innerHTML;
			document.body.innerHTML = printcontent;
			window.print();
			/*document.body.innerHTML = restorepage;*/
			document.location.href=document.location.href;
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