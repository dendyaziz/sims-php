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
    <title>Incoming :: <?php echo $app_name;?></title>
	
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
	<script language="javascript">
		function getDO(el){
			var a=document.getElementById('do').value;
			document.getElementById('do1').value=a;
		}		
	</script>
	
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
                        <h3 class="text-themecolor">Incoming</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                            <li class="breadcrumb-item active">New Incoming Transaction</li>
                        </ol>
                    </div>										
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-body">
                            <h4 class="card-title">Incoming</h4>
                            <h5 class="card-subtitle"> New Incoming <code>Transaction</code> </h5>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
								
									<?php
										
										if(!empty($_GET["username"])){$username=$_GET["username"];}else{$username=$_SESSION["iss21"]["fullname"];}
										if(!empty($_POST['tanggal'])){
											$tanggal=date('Y-m-d',strtotime($_POST['tanggal']));
										}else{
											if(!empty($_GET['tanggal'])){
												$tanggal=date('Y-m-d',strtotime($_GET['tanggal']));
											}else{
												$tanggal=date("Y-m-d");
											}
										}
										if(!empty($_POST['faktur'])){$faktur=$_POST['faktur'];}else{if(!empty($_GET['faktur'])){$faktur=$_GET['faktur'];}else{$faktur="";}}
										if(!empty($_POST['do'])){$do=$_POST['do'];}else{if(!empty($_GET['do'])){$do=$_GET['do'];}else{$do="";}}
										if(!empty($_POST['po'])){$po=$_POST['po'];}else{if(!empty($_GET['po'])){$po=$_GET['po'];}else{
											$po="";
											$result = $con->query("Select * from TMPOUT where username='$username'");											
											while($row = mysqli_fetch_assoc($result))
											{
												$poX=$row["po"];
												$kodeX=$row["kode"];
												$result2 = $con2->query("update PO set qty3=qty2-qty where status='OPEN' and po='$poX' and kode='$kodeX'");
												$result2 = $con2->query("delete from TMPOUT where po='$poX' and kode='$kodeX' and username='$username'");
											}
										}}
										
										$kode_supplier="";
										$supplier="";
										$address="";
										$phone="";
										$contact="";
										if(!empty($po)){
											$result = $con->query("Select tanggal, kode_supplier, supplier, address, contact, phone 
												from PO where po='$po' 
												group by tanggal, kode_supplier, supplier, address, contact, phone 
												order by kode_supplier limit 1");											
											while($row = mysqli_fetch_assoc($result))
											{
												$tanggal_po=$row["tanggal"];
												$kode_supplier=$row["kode_supplier"];
												$supplier=$row["supplier"];
												$address=$row["address"];
												$phone=$row["phone"];
												$contact=$row["contact"];
											}											
										}
										
										
									?>
									
                                    <form method="POST" action="">										
										<input type="text" name="username" value="<?php echo $_SESSION["iss21"]["fullname"];?>" hidden required="required">
										<div class="row">											
											<div class="col-md-6">
												<div class="form-group">
													<label for="tanggal">Transaction Date</label>
													<input class="form-control" type="date" name="tanggal" id="tanggal" value="<?php echo $tanggal; ?>" <?php if(!empty($faktur)){echo "readonly";} ?> required="required">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="faktur">TransNo</label>
													<input type="text" class="form-control" id="faktur" name="faktur" value="<?php  echo $faktur; ?>"  readonly>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="do">DO</label>
													<input type="text" class="form-control" id="do" name="do" value="<?php  echo $do; ?>" oninput="javascript:getDO();" <?php if(!empty($do)){echo "readonly";} ?> required="required">
												</div>
											</div>
											<div class="col-md-6">											
												<div class="form-group">
													<label>PO Number</label>
													<select class="custom-select col-12" id="po" name="po" onchange="this.form.submit()" <?php if(!empty($faktur)){echo "disabled";}?> required="required">
														<option value="<?php if(!empty($po)){echo $po;}?>"><?php if(!empty($po)){echo $po;}else{echo "Pilih...";}?></option>
														<?php
															
															$result = $con->query("Select po from PO where status='OPEN' group by po order By po");
															$count = mysqli_num_rows($result);
															if($count>0){						
																while($row = mysqli_fetch_assoc($result))
																{				
																	$po1=$row["po"];
																	echo "<option value='$po1'>$po1</option>";
																}
															}												
														?>												
													</select>
												</div>											
											</div>
											<div class="col-md-3" hidden>
												<div class="form-group">
													<label for="kode_supplier">Supplier Code</label>
													<input type="text" class="form-control" id="kode_supplier" name="kode_supplier" value="<?php  echo $kode_supplier; ?>"  readonly required="required">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="supplier">Supplier</label>
													<input type="text" class="form-control" id="supplier" name="supplier" value="<?php  echo $supplier; ?>"  readonly required="required">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="phone">Phone</label>
													<input type="text" class="form-control" id="phone" name="phone" value="<?php  echo $phone; ?>"  readonly>
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label for="contact">Contact</label>
													<input type="text" class="form-control" id="contact" name="contact" value="<?php  echo $contact; ?>"  readonly required="required">
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label for="address">Address</label>
													<input type="text" class="form-control" id="address" name="address" value="<?php  echo $address; ?>"  readonly>
												</div>
											</div>
											
											
											<div class="col-md-12">
												
												
												<div class="table-responsive">									
													<table class="table table-sm table-striped table-hover table-bordered" id="data-table1" style="color:black;">
														<thead>
															<tr>
																<th>No</th>
																<th>Code</th>
																<th>Item Description</th>
																<th>Category</th>																
																<th class='text-right'>Qty</th>
																<th>Uom</th>
																<th class="text-center">Action</th>
															</tr>
														</thead>
														<tbody>
															<?php											
															$count=0;
															$no=0;
															$sql="Select * from PO where po='$po' and status='OPEN' order By id";
															$result = $con->query($sql);
															$count = mysqli_num_rows($result);
															if($count>0){
																while($row = mysqli_fetch_assoc($result))
																{
																	$no++;
																	$tanggal2=$row["tanggal"];
																	$po2=$row["po"];
																	$kode2=$row["kode"];
																	$barang2=$row["barang"];
																	$jenis2=$row["jenis"];
																	$satuan2=$row["satuan"];
																	$qty2=$row["qty2"]-$row["qty3"];
																	$descr2=$row["descr"];
																	$id2=$row["id"];
																	
																	echo"
																		<tr>
																			<td>$no</td>
																			<td>$kode2</td>
																			<td>$barang2</td>
																			<td>$jenis2</td>
																			<td align='right'>".number_format($qty2)."</td>
																			<td>$satuan2</td>
																			<td align='center' nowrap>";
																	?>
																				
																				<form method="POST" action="">
																					<input type="date" name="tanggal1" value="<?php echo $tanggal;?>" hidden/>
																					<input type="text" name="faktur1" value="<?php echo $faktur;?>" hidden/>
																					<input type="text" name="po1" value="<?php echo $po;?>" hidden/>
																					<input type="text" name="do1" id="do1" value="<?php echo $do;?>" hidden/>	
																					<input type="text" name="id1" value="<?php echo $id2;?>" hidden/>	
																					<button class='btn btn-info btn-sm' formaction='add-incoming_by_po.php' <?php if($qty2>0){}else{echo " disabled ";}?>><i class='fa fa-paper-plane'></i> Validation</button>
																				</form>
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
												
												
												
											
											</div>
											
											
										</div>
										
										
										<div class="row" hidden>
											<div class="col-md-12">
												<button type="submit" name="btn_save" id="btn_save" class="btn btn-success mr-2" formaction="fc/fc_add_incoming_by_po.php" ><i class="fa fa-paper-plane"></i> Submit</button>
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
								<div class="text-right">
									<!--<button onclick="printContent('cetak')" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Print</button>-->
									<?php
										//echo "<a class='btn btn-info btn-sm' href='nota_penjualan.php?tanggal=$tanggal&faktur=$faktur&po=$po&ppn=$ppn' target='_BLANK'><i class='fa fa-print'></i> Print</a>";
										?>
								</div>
								<br>
								<div class="table-responsive">									
									<table class="table table-sm table-striped table-hover table-bordered" id="data-table1" style="color:black;">
										<thead>
											<tr style='color:black;'>
												<th>No</th>												
												<th>Code</th>
												<th>Item Description</th>
												<th>Category</th>
												<th class='text-right'>Qty</th>
												<th>Uom</th>
												<th class="text-center">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php											
											$count=0;
											$no=0;
											$sql="Select * from TMPOUT where tanggal='$tanggal' and po='$po' and faktur='$faktur' order By id desc";
											$result = $con->query($sql);
											$count = mysqli_num_rows($result);
											if($count>0){
												while($row = mysqli_fetch_assoc($result))
												{
													$no++;
													$po2=$row["po"];
													$faktur2=$row["faktur"];
													$tanggal2=$row["tanggal"];
													$kode2=$row["kode"];
													$barang2=$row["barang"];
													$jenis2=$row["jenis"];
													$qty2=$row["qty"];
													$satuan2=$row["satuan"];
													
													$id2=$row["id"];
													
													$kode_supplier2=$row["kode_supplier"];
													$supplier2=$row["supplier"];
													$address2=$row["address"];
													$phone2=$row["phone"];
													$contact2=$row["contact"];
													
													echo"
														<tr style='color:black;'>
															<td>$no</td>																													
															<td>$kode2</td>
															<td>$barang2</td>
															<td>$jenis2</td>
															<td align='right'>".number_format($qty2)."</td>
															<td>$satuan2</td>
															";
															?>
															<td align='center' nowrap>
																<script src="js/jquery.min.js"></script>
																<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
																<a href = 'javascript:
																	swal({
																		  title: "Konfirmasi!",
																		  text: "Apa Anda yakin akan menghapus Barang ini?",
																		  icon: "warning",
																		  buttons: true,
																		  dangerMode: "true",
																		})
																		.then((willDelete) => {
																		  if (willDelete) {
																		   swal({ title: "Data dihapus dari sistem...",
																		 icon: "success"}).then(okay => {
																		   if (okay) {
																			window.location.href = "<?php echo "fc/fc_delete_tmpout.php?id=$id2&tanggal=$tanggal2&faktur=$faktur2&po=$po2&do=$do";?>";
																		  }
																		});
																	
																		  } else {
																			swal({
																			title: "Penghapusan dibatalkan...",
																			 icon: "error",
																			
																			});
																		  }
																		});'
																		class='btn btn-danger btn-sm text-xs'><i class='fa fa-trash'></i> 
																</a>
															</td>
															<?php 
															
													echo"
														</tr>
													";
												}												
											}											
											?>                                      
										</tbody>
									</table>
									
									<?php if(!empty($faktur2)){?>
									<script src="js/jquery.min.js"></script>
									<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
									<a href = 'javascript:
										swal({
											  title: "Konfirmasi!",
											  text: "Apa Anda yakin akan menyimpan Semua Data ini?",
											  icon: "warning",
											  buttons: true,
											})
											.then((willDelete) => {
											  if (willDelete) {
											   swal({ title: "Data disimpan...",
											 icon: "success"}).then(okay => {
											   if (okay) {
												window.location.href = "<?php echo "fc/fc_submit_incoming.php?faktur=$faktur2&tanggal=$tanggal2&po=$po2&kode_supplier=$kode_supplier2&do=$do";?>";
											  }
											});
										
											  } else {
												swal({
												title: "Penyimpanan data dibatalkan...",
												 icon: "error",
												
												});
											  }
											});'
											class='btn btn-success'><i class='fa fa-save'></i> Save Incoming
									</a>
									<?php } ?>
								
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
			var a=document.getElementById('tanggal').value;
			var b=document.getElementById('faktur').value;
			var c=document.getElementById('po').value;
			
			var restorepage = document.body.innerHTML;
			var printcontent = document.getElementById(el).innerHTML;
			document.body.innerHTML = printcontent;
			window.print();
			document.body.innerHTML = restorepage;
			document.location.href='incoming_by_po.php?tanggal='+a+'&faktur='+b+'&po='+c;
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