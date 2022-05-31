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
    <title>Outgoing Transaction :: <?php echo $app_name;?></title>
	
	<style>
		@media screen {			
			.Sembunyikan{
				display: none;
			}			
		}
		@media print {
		  html, body {
			/*width: 8.5in;*/
			/*height: 5.5in;*/
			display: block;
			/*
			font-family: "Calibri";
			font-size: auto;
			*/
			
			font-family:"Courier New", Courier, monospace;
			font-size:auto;
		  }

		  @page
		   {
			/*size: 5.5in 8.5in;*/
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
	<script>	
		function cek_stok(){
			document.getElementById("btn_save").disabled = true;
			var a=document.getElementById('stok').value;
			var b=document.getElementById('qty').value;
			
			var ceksaldo=(a-b);
			if(ceksaldo<0){
				swal({ 
					position: 'top-end',
					title: 'PERINGATAN',
					text: 'Stok barang tidak mencukupi !!!',
					icon: 'warning',
					dangerMode: true,
					buttons: [false, 'OK']
				})
				$('#qty').focus();
				document.getElementById("btn_save").disabled = true;
			}else{
				document.getElementById("btn_save").disabled = false;			
			}
		}
	</script>
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
                        <h3 class="text-themecolor">Transaksi Barang Keluar</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Transaksi Barang Keluar</li>
                        </ol>
                    </div>
					<div class="col-md-7 align-self-center text-right d-none d-md-block">
                        <button onclick="printContent('cetak')" class="btn btn-primary text-right"><i class="fa fa-print"></i> Print</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-body">
                            <h4 class="card-title">Input Transaksi Barang Keluar</h4>
                            <h5 class="card-subtitle"> Outgoing <code>Transaction</code> </h5>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
								
									<?php
										
										if(!empty($_POST['kode_customer'])){$kode_customer=$_POST['kode_customer'];}else{if(!empty($_GET['kode_customer'])){$kode_customer=$_GET['kode_customer'];}else{$kode_customer="";}}
										if(!empty($_POST['customer'])){$customer=$_POST['customer'];}else{if(!empty($_GET['customer'])){$customer=$_GET['customer'];}else{$customer="";}}
										if(!empty($_POST['alamat'])){$alamat=$_POST['alamat'];}else{if(!empty($_GET['alamat'])){$alamat=$_GET['alamat'];}else{$alamat="";}}
										if(!empty($_POST['telepon'])){$telepon=$_POST['telepon'];}else{if(!empty($_GET['telepon'])){$telepon=$_GET['telepon'];}else{$telepon="";}}
										if(!empty($_POST['person'])){$person=$_POST['person'];}else{if(!empty($_GET['person'])){$person=$_GET['person'];}else{$person="";}}
										if(!empty($_POST['jenis'])){$jenis=$_POST['jenis'];}else{if(!empty($_GET['jenis'])){$jenis=$_GET['jenis'];}else{$jenis="";}}
										if(!empty($_POST['barang'])){$barang=$_POST['barang'];}else{if(!empty($_GET['barang'])){$barang=$_GET['barang'];}else{$barang="";}}
										if(!empty($_POST['satuan'])){$satuan=$_POST['satuan'];}else{if(!empty($_GET['satuan'])){$satuan=$_GET['satuan'];}else{$satuan="";}}
										if(!empty($_POST['kode'])){$kode=$_POST['kode'];}else{if(!empty($_GET['kode'])){$kode=$_GET['kode'];}else{$kode="";}}
										if(!empty($_POST['qty'])){$qty=$_POST['qty'];}else{if(!empty($_GET['qty'])){$qty=$_GET['qty'];}else{$qty="";}}
										if(!empty($_POST['harga'])){$harga=$_POST['harga'];}else{if(!empty($_GET['harga'])){$harga=$_GET['harga'];}else{$harga="";}}
										

										if(!empty($_POST['tanggal'])){$tanggal=date('Y-m-d',strtotime($_POST['tanggal']));}else{if(!empty($_GET['tanggal'])){$tanggal=date('Y-m-d',strtotime($_GET['tanggal']));}else{$tanggal="";}}
										if(!empty($_POST['faktur'])){$faktur=$_POST['faktur'];}else{if(!empty($_GET['faktur'])){$faktur=$_GET['faktur'];}else{$faktur="";}}
										
										if(!empty($kode_customer)){
											$result = $con->query("Select * from CUSTOMER where kode='$kode_customer'");											
											while($row = mysqli_fetch_assoc($result))
											{
												$customer=$row["customer"];
												$alamat=$row["alamat"];
												$telepon=$row["telepon"];
												$person=$row["person"];		
											}											
										}
										
									?>
									
                                   		<form method="POST" action="">							
										<input type="text" name="username" value="<?php echo $_SESSION["iss21"]["fullname"];?>" hidden required="required">										
										 	
										<div class="row">
											<div class="col-md-12">
												<div class="row">													
													<div class="col-md-6">												
														<div class="form-group">
															<label for="faktur">Faktur</label>
															<input class="form-control form-control-line" type="text" name="faktur" id="faktur" onChange="getFaktur(this.value);" value="<?php echo $faktur; ?>" <?php if(empty($faktur)){echo "autofocus";} ?> required="required">
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
															<label for="customer">Customer</label>
															<input type="text" class="form-control" id="customer" name="customer" onChange="getCustomer(this.value)" value="<?php  echo $customer; ?>" required="required"  <?php if(empty($customer)){echo "autofocus";}else{echo "readonly";} ?> >
															<small>Isi dengan sebagian nama customer dan pilih autocomplete customer yang tersedia</small>
														</div>
													</div>
												</div>
												<div class="row" hidden>
													<div class="col-md-12">
														<div class="form-group">
															<label for="alamat">Alamat Customer</label>
															<input type="text" class="form-control" id="alamat" name="alamat" value="<?php  echo $alamat; ?>"  <?php if(empty($alamat)){echo "autofocus";} ?> readonly required="required">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="telepon">Telepon Customer</label>
															<input type="text" class="form-control" id="telepon" name="telepon" value="<?php  echo $telepon; ?>"  <?php if(empty($telepon)){echo "autofocus";} ?> readonly required="required">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="person">Contact Person</label>
															<input type="text" class="form-control" id="person" name="person" value="<?php  echo $person; ?>" required="required"  readonly >
														</div>
													</div>
													<div class="col-md-12">
														<div class="form-group">
															<label for="kode_customer">Kode Customer</label>
															<input type="text" class="form-control" id="kode_customer" name="kode_customer" value="<?php  echo $kode_customer; ?>" required="required"  readonly >
														</div>
													</div>
													
													
												</div>
											</div>
											 
											<div class="col-md-12">
											
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
															<label for="stok">Stok</label>
															<input class="form-control form-control-line" type="text" name="stok" id="stok" value="<?php echo $stok; ?>" readonly required="required">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label for="qty">Jumlah</label>
															<input type="number" class="form-control" id="qty" name="qty" value="<?php if(!empty($qty)){echo $qty;}?>" oninput="javascript:cek_stok();" required="required">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="harga">Harga Jual</label>
															<input type="number" class="form-control" id="harga" name="harga" value="<?php if(!empty($harga)){echo $harga;}?>" required="required">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<button type="submit" class="btn btn-success mr-2" formaction="fc/fc_add_outgoing_edit.php" id="btn_save"><i class="fa fa-paper-plane"></i> Submit</button>
														<button type="reset" class='btn btn-dark mr2'><i class="fa fa-refresh"></i> Reset</button>
														
													</div>
												</div>
											
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
								<div class="table-responsive">									
									<table class="table table-sm table-striped table-hover table-bordered" id="data-table">
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
											$sql="Select * from OUTGOING where branch='$Qbranch' and CONVERT(tanggal, DATE)='$tanggal' and faktur='$faktur' order By id";
											echo $sql;
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
																<a class='btn btn-danger btn-sm' href='fc/fc_delete_outgoing_edit.php?id=$id2&tanggal=$tanggal2&faktur=$faktur' title='Hapus Barang Masuk'><i class='fa fa-trash'></i> Delete</a>
															</td>
														</tr>
													";
												}												
											}											
											?>                                      
										</tbody>
									</table>
								</div>
								
								<div class="table-responsive" id="cetak">
									<div class="Sembunyikan">
										
										<table cellpadding="2px" style='color:black;'>
											<thead>
												<?php
													
													$sql1="Select customer,alamat,telepon,person,kode from OUTGOING where faktur='$faktur' group by customer,alamat,telepon,person,kode";
													$result1 = $con1->query($sql1);
													$count1 = mysqli_num_rows($result1);
													if($count1>0){
														while($row1 = mysqli_fetch_assoc($result1))
														{
															$customerX=$row1["customer"];
															$alamatX=$row1["alamat"];
															$teleponX=$row1["telepon"];
															$personX=$row1["person"];
															$kodeX=$row1["kode"];
														}
													}
												
												?>
												<tr><td colspan="3"><h5 class="card-title"><b>TANDA TERIMA FAKTUR <?php echo $faktur; ?></b><h5></td></tr>
												<tr style='font-size:small;'><th>Tanggal</th><th class="text-center"> : </th><th><?php echo date('d/m/Y',strtotime($tanggal)); ?></th></tr>
												<tr style='font-size:small;'><th>Customer</th><th class="text-center"> : </th><th><?php echo $kodeX." / ".$customerX; ?></th></tr>
												<tr style='font-size:small;'><th>Alamat / Contact Person</th><th class="text-center"> : </th><th><?php echo $alamatX." / ".$personX." / ".$teleponX; ?></th></tr>
												<tr><td colspan="3"></td></tr>
											</thead>
										</table>
										
										<table class="table table-sm table-striped table-hover table-bordered" id="data-table1" style='color:black;'>
											<thead>
												<tr>
													<th>#</th>												
													<th>Kode</th>
													<th>Jenis</th>
													<th>Barang</th>
													<th class="text-right">Qty</th>
													<th>Satuan</th>
													<th class="text-center">Cek Gudang</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$count=0;
												$no=0;
												$sql="Select * from OUTGOING where convert(tanggal,DATE)='$tanggal' and faktur='$faktur' order by jenis, barang, satuan, kode";
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
														$qty2=$row["qty"];																							
														if(empty($qty2)){$qty2=0;}
														
														$username2=$row["username"];
														
														echo"
															<tr style='font-size:small;'>
																<td>$no</td>															
																<td>$kode2</td>
																<td>$jenis2</td>
																<td>$barang2</td>
																<td align='right'>".number_format($qty2)."</td>
																<td>$satuan2</td>															
																<td></td>
															</tr>
															
														";													
													}												
												}											
												?>											
											</tbody>
										</table>
										
										<table class="table table-sm table-bordered Sembunyikan" id="table" style='color:black;'>
											<tr>
												<td colspan="3"><?php echo $_SESSION["iss21"]["branch"].", ".date('d M Y');?></td>
											</tr>
											<tr>
												<td width="33%" align="center">Dibuat Oleh,</td>
												<td width="33%" align="center">Dikeluarkan Oleh,</td>
												<td width="34%" align="center">Diterima Oleh,</td>
											</tr>
											<tr>
												<td height="80px"></td>
												<td></td>
												<td></td>
											</tr>
											<tr>
												<td align="center"><?php echo $username2; ?></td>
												<td align="center"></td>
												<td align="center"></td>
											</tr>
											<tr>
												<td align="center">Admin</td>
												<td align="left">Date :../../....  ..:..</td>
												<td align="left">Date :../../....  ..:..</td>
											</tr>
										</table>
										
									</div>
									
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
			serviceUrl: "autocomplete_faktur_penjualan.php",
			dataType: "JSON",
			onSelect: function (suggestion) {
				$("#faktur").val("" + suggestion.faktur);
				var s=document.getElementById('faktur').value;
				getFaktur(s);
			}
		});
		function getFaktur(val){
			$.post('get_faktur_penjualan.php',{data:val},function(result){
				$('#kode_customer').val(result.kode);
				$('#tanggal').val(result.tanggal);
				$('#faktur').val(result.faktur);
				$('#customer').val(result.customer);
				$('#alamat').val(result.alamat);
				$('#telepon').val(result.telepon);
				$('#person').val(result.person);
				
				var b=document.getElementById('tanggal').value;
				var c=document.getElementById('faktur').value;
				var d=document.getElementById('kode_customer').value;
				document.location.href ='outgoing-edit.php?tanggal='+b+'&faktur='+c+'&kode_customer='+d;				
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
			$.post('get_item_stok.php',{data:val},function(result){
				$('#barang').val(result.barang);
				$('#jenis').val(result.jenis);
				$('#satuan').val(result.satuan);
				$('#kode').val(result.kode);
				$('#harga').val(result.harga);
				$('#stok').val(result.stok);
				document.getElementById("qty").focus();
			}, "json");				
		}
		
	</script>
    <?php include("inc/js_bawah.php");?>
	<script language="javascript">
		function printContent(el){
			var b=document.getElementById('tanggal').value;
			var c=document.getElementById('faktur').value;
			var d=document.getElementById('kode_customer').value;
			
			var restorepage = document.body.innerHTML;
			var printcontent = document.getElementById(el).innerHTML;
			document.body.innerHTML = printcontent;
			window.print();
			document.body.innerHTML = restorepage;
			document.location.href='outgoing-edit.php?tanggal='+b+'&faktur='+c+'&kode_customer='+d;
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