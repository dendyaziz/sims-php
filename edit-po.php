<?php
ob_start();session_start();
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
    <title>Editing Purchase Orders :: <?php echo $app_name;?></title>
	
	<style>
		@media screen {			
			.Sembunyikan{
				display: none;
			}			
		}
		@media print {
		  html, body {
			display: block;
			font-family:"Arial";
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
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	
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
                        <h3 class="text-themecolor">Purchase Order</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="po_pembelian.php">Home</a></li>
                            <li class="breadcrumb-item active">Editing Purchase Order</li>
                        </ol>
                    </div>
					<div class="col-md-7 align-self-center text-right d-none d-md-block">
                        <button onclick="printContent('cetak')" class="btn btn-primary text-right"><i class="fa fa-print"></i> Print</button>
						<a class='btn btn-dark mr2' href='po.php' title='Back'> <i class='fa fa-close'></i> Close</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-body">
                            <h4 class="card-title">Purchase Order</h4>
                            <h5 class="card-subtitle"> Editing <code>Purchase Order</code> </h5>
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
										
										if(!empty($_POST['po'])){$po=$_POST['po'];}else{if(!empty($_GET['po'])){$po=$_GET['po'];}else{$po="";}}
										if(!empty($_POST['kode_supplier'])){$kode_supplier=$_POST['kode_supplier'];}else{if(!empty($_GET['kode_supplier'])){$kode_supplier=$_GET['kode_supplier'];}else{$kode_supplier="";}}
										if(!empty($_POST['supplier'])){$supplier=$_POST['supplier'];}else{if(!empty($_GET['supplier'])){$supplier=$_GET['supplier'];}else{$supplier="";}}
										if(!empty($_POST['address'])){$address=$_POST['address'];}else{if(!empty($_GET['address'])){$address=$_GET['address'];}else{$address="";}}
										if(!empty($_POST['contact'])){$contact=$_POST['contact'];}else{if(!empty($_GET['contact'])){$contact=$_GET['contact'];}else{$contact="";}}
										if(!empty($_POST['phone'])){$phone=$_POST['phone'];}else{if(!empty($_GET['phone'])){$phone=$_GET['phone'];}else{$phone="";}}
										
										if(!empty($_POST['jenis'])){$jenis=$_POST['jenis'];}else{if(!empty($_GET['jenis'])){$jenis=$_GET['jenis'];}else{$jenis="";}}
										if(!empty($_POST['kode'])){$kode=$_POST['kode'];}else{if(!empty($_GET['kode'])){$kode=$_GET['kode'];}else{$kode="";}}
										if(!empty($_POST['barang'])){$barang=$_POST['barang'];}else{if(!empty($_GET['barang'])){$barang=$_GET['barang'];}else{$barang="";}}
										if(!empty($_POST['satuan'])){$satuan=$_POST['satuan'];}else{if(!empty($_GET['satuan'])){$satuan=$_GET['satuan'];}else{$satuan="";}}										
										if(!empty($_POST['qty'])){$qty=$_POST['qty'];}else{if(!empty($_GET['qty'])){$qty=$_GET['qty'];}else{$qty="";}}
										
										if(empty($supplier)){
											$sql="Select * from SUPPLIER where kode='$kode_supplier'";
											$result = $con->query($sql);
											$count = mysqli_num_rows($result);
											if($count>0){
												while($row = mysqli_fetch_assoc($result))
												{
													$supplier=$row["supplier"];
													$address=$row["address"];
													$contact=$row["contact"];
													$phone=$row["phone"];
												}
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
															<label for="tanggal">Tanggal</label>
															<input class="form-control" type="date" name="tanggal" id="tanggal" value="<?php echo $tanggal; ?>" <?php if(!empty($po)){echo "readonly";} ?> required="required">														
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="po">Nomor PO</label>
															<input type="text" class="form-control" id="po" name="po" value="<?php  echo $po; ?>"  readonly>
														</div>
													</div>
													<div class="col-md-12">
														<div class="form-group">
															<label for="supplier">Supplier</label>
															<input type="text" class="form-control" id="supplier" name="supplier" onChange="getSupplier(this.value)" value="<?php  echo $supplier; ?>" required="required"  <?php if(empty($supplier)){echo "autofocus";}else{echo "readonly";} ?> >
															<small>Isi dengan sebagian nama suplier dan pilih suplier yang tersedia</small>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-4">
														<div class="form-group">
															<label for="kode_supplier">Code</label>
															<input type="text" class="form-control" id="kode_supplier" name="kode_supplier" value="<?php  echo $kode_supplier; ?>" required="required"  readonly >
														</div>
													</div>
													<div class="col-md-8">
														<div class="form-group">
															<label for="contact">Contact</label>
															<input type="text" class="form-control" id="contact" name="contact" value="<?php  echo $contact; ?>" required="required"  readonly >
														</div>
													</div>
													<div class="col-md-8">
														<div class="form-group">
															<label for="address">Address</label>
															<input type="text" class="form-control" id="address" name="address" value="<?php  echo $address; ?>"  <?php if(empty($address)){echo "autofocus";} ?> readonly required="required">
														</div>
													</div>													
													<div class="col-md-4">
														<div class="form-group">
															<label for="phone">Phone</label>
															<input type="text" class="form-control" id="phone" name="phone" value="<?php  echo $phone; ?>"  <?php if(empty($phone)){echo "autofocus";} ?> readonly required="required">
														</div>
													</div>													
													
												</div>
											</div>
											<div class="col-md-12">
											
												<div class="row">										
													<div class="col-md-12">
														<div class="form-group">
															<label for="barang">Item Description</label>
															<input class="form-control form-control-line" type="text" name="barang" id="barang" onChange="getItem(this.value)" value="<?php echo $barang; ?>" <?php if(empty($barang)){echo "autofocus";} ?> required="required">
															<small>Isi dengan sebagian jenis atau nama barang dan pilih jenis atau nama barang yang tersedia</small>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="kode">Kode</label>
															<input class="form-control form-control-line" type="text" name="kode" id="kode" value="<?php echo $kode; ?>" readonly>
														</div>
													</div>
													<div class="col-md-8">
														<div class="form-group">
															<label for="jenis">Jenis</label>
															<input class="form-control form-control-line" type="text" name="jenis" id="jenis" value="<?php echo $jenis; ?>" readonly required="required">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="satuan">Satuan</label>
															<input class="form-control form-control-line" type="text" name="satuan" id="satuan" value="<?php echo $satuan; ?>" readonly>
														</div>
													</div>													
													<div class="col-md-8">
														<div class="form-group">
															<label for="qty">Jumlah</label>
															<input type="number" class="form-control" id="qty" name="qty" value="<?php if(!empty($qty)){echo $qty;}?>" required="required">
														</div>
													</div>
												
													<div class="col-md-12">
														<button type="submit" class="btn btn-success mr-2" formaction="fc/fc_add_po.php" id="btn_save"><i class="fa fa-paper-plane"></i> Save</button>
																												
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
												<th>Code</th>
												<th>Item Description</th>
												<th>Category</th>
												<th class="text-right">Qty</th>
												<th>Uom</th>
												<th class="text-center">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php											
											$count=0;
											$no=0;
											$sql="Select * from PO where po='$po' order By id";
											$result = $con->query($sql);
											$count = mysqli_num_rows($result);
											if($count>0){
												while($row = mysqli_fetch_assoc($result))
												{
													$no++;
													$po2=$row["po"];
													$tanggal2=$row["tanggal"];
													$kode_supplier2=$row["kode_supplier"];
													
													$jenis2=$row["jenis"];
													$kode2=$row["kode"];
													$barang2=$row["barang"];
													$qty2=$row["qty"];
													$satuan2=$row["satuan"];													
													$id2=$row["id"];
													
													echo"
														<tr>
															<td>$no</td>																													
															<td>$kode2</td>
															<td>$barang2</td>
															<td>$jenis2</td>															
															<td align='right'>".number_format($qty2)."</td>
															<td>$satuan2</td>
															<td align='center' nowrap>
															";
																?>
															
																	<script src="js/jquery.min.js"></script>
																	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
																	<a href = 'javascript:
																		swal({
																			  title: "Konfirmasi!",
																			  text: "Apa Anda yakin akan menghapus barang ini?",
																			  icon: "warning",
																			  buttons: true,
																			  dangerMode: "true",
																			})
																			.then((willDelete) => {
																			  if (willDelete) {
																			   swal({ title: "Data dihapus dari sistem...",
																			 icon: "success"}).then(okay => {
																			   if (okay) {
																				window.location.href = "<?php echo "fc/fc_delete_po_by_item.php?id=$id2&po=$po2&tanggal=$tanggal2&kode_supplier=$kode_supplier2";?>";
																			  }
																			});																		
																			  } else {
																				swal({
																				title: "Penghapusan dibatalkan...",
																				 icon: "error",
																				
																				});
																			  }
																			});'
																			class='btn btn-danger btn-sm text-xs'><i class='fa fa-trash'></i> </a>
																
															<?php
													echo"		
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
													$sql1="Select supplier,address,phone,contact from PO
														where po='$po' 
														group by supplier,address,phone,contact";
													$result1 = $con1->query($sql1);
													$count1 = mysqli_num_rows($result1);
													if($count1>0){
														while($row1 = mysqli_fetch_assoc($result1))
														{
															$supplierX=$row1["supplier"];
															$addressX=$row1["address"];
															$phoneX=$row1["phone"];
															$contactX=$row1["contact"];
														}
													}
													
													if(empty($supplierX)){$supplierX="";}
													if(empty($addressX)){$addressX="";}
													if(empty($phoneX)){$phoneX="";}
													if(empty($contactX)){$contactX="";}
												?>
												<tr><td colspan="3"><b>PURCHASE ORDER (<?php echo $po; ?>)</b></td></tr>
												<tr style='font-size:small;'><th>Date		</th><th class="text-center"> : </th><th><?php echo date('Y-m-d',strtotime($tanggal)); ?></th></tr>
												<tr style='font-size:small;'><th>Supplier	</th><th class="text-center"> : </th><th><?php echo $supplierX; ?></th></tr>
												<tr style='font-size:small;'><th>Address	</th><th class="text-center"> : </th><th><?php echo $addressX; ?></th></tr>
												<tr style='font-size:small;'><th>Phone	    </th><th class="text-center"> : </th><th><?php echo $phoneX." ".$contactX; ?></th></tr>
												<tr><td colspan="3"></td></tr>
											</thead>
										</table>
										
										<table class="table table-sm table-striped table-hover table-bordered" id="data-table1" style='color:black;'>
											<thead>
												<tr>
													<th>#</th>												
													<th>Code</th>
													<th>Item Description</th>
													<th>Category</th>
													<th class="text-right">Qty</th>
													<th>Uom</th>
													
												</tr>
											</thead>
											<tbody>
												<?php												
												$sql="Select * from PO where po='$po' order by barang";
												$result = $con->query($sql);
												$count = mysqli_num_rows($result);
												if($count>0){
													while($row = mysqli_fetch_assoc($result))
													{
														$no++;													
														$jenis2=$row["jenis"];
														$kode2=$row["kode"];
														$barang2=$row["barang"];
														$qty2=$row["qty"];
														$satuan2=$row["satuan"];
														$username2=$row["username"];
														
														echo"
															<tr style='font-size:small;'>
																<td>$no</td>															
																<td>$kode2</td>
																<td>$barang2</td>
																<td>$jenis2</td>
																<td align='right'>".number_format($qty2)."</td>
																<td>$satuan2</td>
															</tr>
															
														";													
													}													
												}											
												?>											
											</tbody>
										</table>
										
										<table class="table table-sm table-bordered Sembunyikan" id="table" style='color:black;'>
											<tr>
												<td width="50%" align="center">Dibuat Oleh,</td>
												<td width="50%" align="center">Disetujui Oleh,</td>
											</tr>
											<tr>
												<td height="80px"></td>
												<td></td>
											</tr>
											<tr>
												<td align="center"><?php if(!empty($username2)){echo $username2;} ?></td>
												<td align="center"></td>
											</tr>
											<tr>
												<td align="center">User</td>
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
			"stateSave": true,"responsive": true,
			"autoWidth": false,
			"lengthMenu": [[ 10, 25, 50, 100, -1], [ 10, 25, 50, 100, "All"]],
			"order": [[ 0, 'asc' ],]
		});
	</script>
	
	<script type="text/javascript">
		$("#supplier").autocomplete({
			serviceUrl: "autocomplete_supplier.php",
			dataType: "JSON",
			onSelect: function (suggestion) {
				$("#supplier").val("" + suggestion.supplier);
				var s=document.getElementById('supplier').value;
				getSupplier(s);
			}
		});
		function getSupplier(val){
			$.post('get_supplier.php',{data:val},function(result){
				$('#supplier').val(result.supplier);
				$('#address').val(result.address);
				$('#phone').val(result.phone);
				$('#contact').val(result.contact);
				$('#kode_supplier').val(result.kode);
				document.getElementById("barang").focus();
			}, "json");			}
		
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
				document.getElementById("qty").focus();
			}, "json");	
			
		}
		
	</script>
    <?php include("inc/js_bawah.php");?>
	<script language="javascript">
		function printContent(el){
			var a=document.getElementById('tanggal1').value;
			var b=document.getElementById('po').value;
			var c=document.getElementById('kode_supplier').value;
			
			var restorepage = document.body.innerHTML;
			var printcontent = document.getElementById(el).innerHTML;
			document.body.innerHTML = printcontent;
			window.print();
			document.body.innerHTML = restorepage;
			document.location.href='edit-po.php?tanggal='+a+'&po='+b+'&kode_supplier='+c;
		}		
	</script>
	
</body>
</html>

<?php

}else{
	session_destroy();
	ob_start();session_start();
	$_SESSION["iss21"]["info"]="Gagal, anda tidak memiliki ijin untuk mengakses halaman tersebut atau session anda sudah habis, silahkan login ulang.";
	header("location: index.php");
}

?>