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
	<script>
		function cek_po(){
			document.getElementById("btn_save").disabled = true;
			var a=document.getElementById('po_qty').value;
			var b=document.getElementById('qty').value;
			var c=document.getElementById('validasi').value;
			
			var ceksaldo=(a-b);
			if(ceksaldo<0){
				swal({ 
					position: 'top-end',
					title: 'PERINGATAN',
					text: 'Incoming tidak boleh melebihi PO !!!',
					icon: 'warning',
					dangerMode: true,
					buttons: [false, 'OK']
				})
				document.getElementById('qty').value=c;
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
                        <h3 class="text-themecolor">Incoming</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                            <li class="breadcrumb-item active">Incoming By PO</li>
                        </ol>
                    </div>										
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-body">
                            <h4 class="card-title">Incoming</h4>
                            <h5 class="card-subtitle"> Incoming <code>By PO</code> </h5>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
								
									<?php
										
										if(!empty($_POST['tanggal1'])){$tanggal=date('Y-m-d',strtotime($_POST['tanggal1']));}else{if(!empty($_GET['tanggal1'])){$tanggal=date('Y-m-d',strtotime($_GET['tanggal1']));}else{$tanggal=date("Y-m-d");}}
										if(!empty($_POST['faktur1'])){$faktur=$_POST['faktur1'];}else{if(!empty($_GET['faktur1'])){$faktur=$_GET['faktur1'];}else{$faktur="";}}
										if(!empty($_POST['po1'])){$po=$_POST['po1'];}else{if(!empty($_GET['po1'])){$po=$_GET['po1'];}else{$po="";}}
										if(!empty($_POST['do1'])){$do=$_POST['do1'];}else{if(!empty($_GET['do1'])){$do=$_GET['do1'];}else{$do="";}}
										
										if(!empty($_POST['id1'])){$id=$_POST['id1'];}else{if(!empty($_GET['id1'])){$id=$_GET['id1'];}else{$id="";}}
										if(!empty($po) && !empty($id)){
											$result = $con->query("Select * from PO where po='$po' and id='$id'");											
											while($row = mysqli_fetch_assoc($result))
											{
												$tanggal_po=$row["tanggal"];
												$kode_supplier=$row["kode_supplier"];
												$supplier=$row["supplier"];
												$address=$row["address"];
												$phone=$row["phone"];
												$contact=$row["contact"];
												$kode=$row["kode"];												
												$barang=$row["barang"];
												$jenis=$row["jenis"];
												$satuan=$row["satuan"];
												$qty3=$row["qty3"];
												$qty=$row["qty2"]-$qty3;
												$po_qty=$qty;
												$descr=$row["descr"];
											}											
										}
																				
									?>
									
                                    <form method="POST" action="">
										
										<input type="text" name="username" value="<?php echo $_SESSION["iss21"]["fullname"];?>" hidden required="required">
										<input type="text" name="validasi" id="validasi" value="<?php echo $qty;?>" hidden>
										<div class="row">
											
											<div class="col-md-3" hidden>
												<div class="form-group">
													<label for="tanggal">TransDate</label>
													<input class="form-control form-control-line" type="date" name="tanggal" id="tanggal" value="<?php echo $tanggal; ?>" readonly required="required">
												</div>
											</div>
											<div class="col-md-3" hidden>
												<div class="form-group">
													<label for="faktur">TransNo</label>
													<input type="text" class="form-control" id="faktur" name="faktur" value="<?php  echo $faktur; ?>"  readonly>
												</div>
											</div>
											<div class="col-md-3" hidden>
												<div class="form-group">
													<label for="do">DO</label>
													<input type="text" class="form-control" id="do" name="do" value="<?php  echo $do; ?>"  readonly required="required">
												</div>
											</div>
											<div class="col-md-3" hidden>
												<div class="form-group">
													<label for="po">PO Number</label>
													<input type="text" class="form-control" id="po" name="po" value="<?php  echo $po; ?>"  readonly required="required">
												</div>
											</div>
											<div class="col-md-3" hidden>
												<div class="form-group">
													<label for="tanggal_po">PO Date</label>
													<input type="date" class="form-control" id="tanggal_po" name="tanggal_po" value="<?php  echo $tanggal_po; ?>"  readonly required="required">
												</div>
											</div>
											<div class="col-md-3" hidden>
												<div class="form-group">
													<label for="kode_supplier">Supplier Code</label>
													<input type="text" class="form-control" id="kode_supplier" name="kode_supplier" value="<?php  echo $kode_supplier; ?>"  readonly required="required">
												</div>
											</div>
											<div class="col-md-6" hidden>
												<div class="form-group">
													<label for="supplier">Supplier</label>
													<input type="text" class="form-control" id="supplier" name="supplier" value="<?php  echo $supplier; ?>"  readonly required="required">
												</div>
											</div>
											<div class="col-md-12" hidden>
												<div class="form-group">
													<label for="address">Address</label>
													<input type="text" class="form-control" id="address" name="address" value="<?php  echo $address; ?>"  readonly>
												</div>
											</div>
											<div class="col-md-6" hidden>
												<div class="form-group">
													<label for="phone">Phone</label>
													<input type="text" class="form-control" id="phone" name="phone" value="<?php  echo $phone; ?>"  readonly>
												</div>
											</div>
											<div class="col-md-6" hidden>
												<div class="form-group">
													<label for="contact">Contact</label>
													<input type="text" class="form-control" id="contact" name="contact" value="<?php  echo $contact; ?>"  readonly>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-3" hidden>
												<div class="form-group">
													<label for="kode">Code</label>
													<input class="form-control form-control-line" type="text" name="kode" id="kode" value="<?php echo $kode; ?>" readonly>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="barang">Barang</label>
													<input class="form-control form-control-line" type="text" name="barang" id="barang" value="<?php echo $barang; ?>" readonly>
												</div>
											</div>
											<div class="col-md-3" hidden>
												<div class="form-group">
													<label for="jenis">Category</label>
													<input class="form-control form-control-line" type="text" name="jenis" id="jenis" value="<?php echo $jenis; ?>" readonly>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="satuan">Uom</label>
													<input class="form-control form-control-line" type="text" name="satuan" id="satuan" value="<?php echo $satuan; ?>" readonly>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="po_qty">Purchace Order</label>
													<input type="text" class="form-control" id="po_qty" name="po_qty"  value="<?php echo $po_qty;?>" readonly required="required">
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="qty">Incoming</label>
													<input type="text" class="form-control" id="qty" name="qty" onKeyPress="return filter_char(event,'0123456789.',this)" oninput="javascript:cek_po();" value="<?php if(!empty($qty)){echo $qty;}?>" autofocus required="required">
												</div>
											</div>
											
											
										
										
										
											
											
										</div>
										
										
										<div class="row">
											<div class="col-md-12">
												<button type="submit" name="btn_save" id="btn_save" class="btn btn-success mr-2" formaction="fc/fc_add_incoming_by_po.php" ><i class="fa fa-paper-plane"></i> Save</button>
												<a class='btn btn-dark mr2' href="<?php echo "incoming_by_po.php?tanggal=$tanggal&faktur=$faktur&po=$po&do=$do";?>"><i class="fa fa-refresh"></i> Back To Incoming </a>
											</div>
										</div>
										
										
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				
				<div class="row">
                    
				
							
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
				getItemStock(a);
			}
		});
		function getItemStock(val){
			$.post('get_item.php',{data:val},function(result){
				$('#kode').val(result.kode);
				$('#barang').val(result.barang);
				$('#jenis').val(result.jenis);
				$('#satuan').val(result.satuan);
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