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
    <title>Return Transaction :: <?php echo $app_name;?></title>
	
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
                        <h3 class="text-themecolor">Return Transaction</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Return Transaction</li>
                        </ol>
                    </div>
					<div class="col-md-7 align-self-center text-right d-none d-md-block">
                        <button onclick="printContent('cetak')" class="btn btn-primary text-right"><i class="fa fa-print"></i> Print</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-body">
                            <h4 class="card-title">Input Transaksi Retur Barang</h4>
                            <h5 class="card-subtitle"> Return <code>Transaction</code> </h5>
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
										if(!empty($_POST['faktur'])){$faktur=$_POST['faktur'];}else{if(!empty($_GET['faktur'])){$faktur=$_GET['faktur'];}else{$faktur="";}}
										
										if(!empty($_POST['nik'])){$nik=$_POST['nik'];}else{if(!empty($_GET['nik'])){$nik=$_GET['nik'];}else{$nik="";}}
										if(!empty($_POST['fullname'])){$fullname=$_POST['fullname'];}else{if(!empty($_GET['fullname'])){$fullname=$_GET['fullname'];}else{$fullname="";}}
										if(!empty($_POST['address'])){$address=$_POST['address'];}else{if(!empty($_GET['address'])){$address=$_GET['address'];}else{$address="";}}
										if(!empty($_POST['phone'])){$phone=$_POST['phone'];}else{if(!empty($_GET['phone'])){$phone=$_GET['phone'];}else{$phone="";}}
										if(!empty($_POST['position'])){$position=$_POST['position'];}else{if(!empty($_GET['position'])){$position=$_GET['position'];}else{$position="";}}
										if(!empty($_POST['dept'])){$dept=$_POST['dept'];}else{if(!empty($_GET['dept'])){$dept=$_GET['dept'];}else{$dept="";}}
										
										if(!empty($_POST['kode'])){$kode=$_POST['kode'];}else{if(!empty($_GET['kode'])){$kode=$_GET['kode'];}else{$kode="";}}
										if(!empty($_POST['barang'])){$barang=$_POST['barang'];}else{if(!empty($_GET['barang'])){$barang=$_GET['barang'];}else{$barang="";}}
										if(!empty($_POST['jenis'])){$jenis=$_POST['jenis'];}else{if(!empty($_GET['jenis'])){$jenis=$_GET['jenis'];}else{$jenis="";}}
										if(!empty($_POST['satuan'])){$satuan=$_POST['satuan'];}else{if(!empty($_GET['satuan'])){$satuan=$_GET['satuan'];}else{$satuan="";}}
										if(!empty($_POST['qty'])){$qty=$_POST['qty'];}else{if(!empty($_GET['qty'])){$qty=$_GET['qty'];}else{$qty="";}}
																				
										if(!empty($nik)){
											$result = $con->query("Select * from KARYAWAN where nik='$nik'");											
											while($row = mysqli_fetch_assoc($result))
											{
												$fullname=$row["fullname"];
												$address=$row["address"];
												$phone=$row["phone"];
												$position=$row["position"];
												$dept=$row["dept"];									
											}											
										}
										
									?>
									
                                    <form method="POST" action="">										
										<input type="text" name="username" value="<?php echo $_SESSION["iss21"]["fullname"];?>" hidden required="required">										
										
										<div class="row">
											
											<div class="col-md-12">
												<div class="row">
													<div class="col-md-4">
														<div class="form-group">
															<label for="tanggal">Tanggal</label>
															<input class="form-control form-control-line" type="date" name="tanggal" id="tanggal" value="<?php echo $tanggal; ?>" <?php if(!empty($faktur)){echo "readonly";} ?> required="required">
														</div>
													</div>
													<div class="col-md-8">
														<div class="form-group">
															<label for="faktur">Nomor Faktur</label>
															<input type="text" class="form-control" id="faktur" name="faktur" value="<?php  echo $faktur; ?>"  readonly>
														</div>
													</div>
													<div class="col-md-12">
														<div class="form-group">
															<label for="fullname">Penerima</label>
															<input type="text" class="form-control" id="fullname" name="fullname" onChange="getKaryawan(this.value)" value="<?php  echo $fullname; ?>" required="required"  <?php if(empty($fullname)){echo "autofocus";}else{echo "readonly";} ?> >
															<small>Isi dengan sebagian nama karyawan dan pilih karyawan yang tersedia</small>
														</div>
													</div>
												</div>
												<div class="row" hidden>
													<div class="col-md-4">
														<div class="form-group">
															<label for="nik">Nik</label>
															<input type="text" class="form-control" id="nik" name="nik" value="<?php  echo $nik; ?>"  readonly required="required">
														</div>
													</div>
													<div class="col-md-12">
														<div class="form-group">
															<label for="address">Location</label>
															<input type="text" class="form-control" id="address" name="address" value="<?php  echo $address; ?>" readonly required="required">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="phone">Phone</label>
															<input type="text" class="form-control" id="phone" name="phone" value="<?php  echo $phone; ?>"  readonly required="required">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="position">Position</label>
															<input type="text" class="form-control" id="position" name="position" value="<?php  echo $position; ?>" required="required"  readonly >
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="dept">Department</label>
															<input type="text" class="form-control" id="dept" name="dept" value="<?php  echo $dept; ?>" required="required"  readonly >
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-12">
											
												<div class="row">										
													<div class="col-md-8">
														<div class="form-group">
															<label for="barang">Item Description</label>
															<input class="form-control form-control-line" type="text" name="barang" id="barang" onChange="getItem(this.value)" value="<?php echo $barang; ?>" <?php if(empty($barang)){echo "autofocus";} ?> required="required">
															<small>Isi dengan sebagian jenis atau nama barang dan pilih jenis atau nama barang yang tersedia</small>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="jenis">Category</label>
															<input class="form-control form-control-line" type="text" name="jenis" id="jenis" value="<?php echo $jenis; ?>" readonly required="required">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="satuan">Uom</label>
															<input class="form-control form-control-line" type="text" name="satuan" id="satuan" value="<?php echo $satuan; ?>" readonly required="required">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="kode">Item Code</label>
															<input class="form-control form-control-line" type="text" name="kode" id="kode" value="<?php echo $kode; ?>" readonly required="required">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="qty">Qty</label>
															<input type="number" class="form-control" id="qty" name="qty" value="<?php if(!empty($qty)){echo $qty;}?>" oninput="javascript:cek_stok();" required="required">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<button type="submit" class="btn btn-success mr-2" formaction="fc/fc_add_retur.php" id="btn_save"><i class="fa fa-paper-plane"></i> Submit</button>
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
												<th>No</th>												
												<th>Code</th>
												<th>Item Description</th>
												<th>Category</th>
												<th>Uom</th>
												<th class='text-right'>Qty</th>
												<th class='text-center'>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php											
											$count=0;
											$no=0;
											$Qbranch=$_SESSION["iss21"]["branch"];
											$sql="Select * from RETUR where branch='$Qbranch' and CONVERT(tanggal, DATE)='$tanggal' and faktur='$faktur' order By id";
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
													
													echo"
														<tr>
															<td>$no</td>																													
															<td>$kode2</td>															
															<td>$barang2</td>
															<td>$jenis2</td>
															<td>$satuan2</td>
															<td align='right'>".number_format($qty2)."</td>																
															<td align='center' nowrap>
																<a class='btn btn-danger btn-sm' href='fc/fc_delete_retur.php?id=$id2&tanggal=$tanggal2&faktur=$faktur&nik=$nik'><i class='fa fa-trash'></i> Delete</a>
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
		$("#fullname").autocomplete({
			serviceUrl: "autocomplete_karyawan.php",
			dataType: "JSON",
			onSelect: function (suggestion) {
				$("#fullname").val("" + suggestion.karyawan);
				var s=document.getElementById('fullname').value;
				getKaryawan(s);
			}
		});
		function getKaryawan(val){
			$.post('get_karyawan.php',{data:val},function(result){
				$('#nik').val(result.nik);
				$('#fullname').val(result.fullname);
				$('#address_karyawan').val(result.address);
				$('#phone_karyawan').val(result.phone);
				$('#position').val(result.position);
				$('#dept').val(result.dept);
				document.getElementById("barang").focus();
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
				document.getElementById("qty").focus();
			}, "json");	
			
		}
		
	</script>
    <?php include("inc/js_bawah.php");?>
	<script language="javascript">
		function printContent(el){
			var b=document.getElementById('tanggal').value;
			var c=document.getElementById('faktur').value;
			var d=document.getElementById('nik').value;
			
			var restorepage = document.body.innerHTML;
			var printcontent = document.getElementById(el).innerHTML;
			document.body.innerHTML = printcontent;
			window.print();
			document.body.innerHTML = restorepage;
			document.location.href='retur.php?tanggal='+b+'&faktur='+c+'&nik='+d;
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