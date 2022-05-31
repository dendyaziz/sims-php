<?php
session_start();
include("fc/fc_config.php");
if($_SESSION["iss21"]["authentication"]=="VALID"){
	$filenameImages =$_SESSION["iss21"]["img"];
	$filemtimeImages = filemtime("assets/images/users/".$filenameImages);
	$profile_picture=$filenameImages."?".$filemtimeImages;
	$branch=$_SESSION["iss21"]["branch"];
	
	if($_SESSION["iss21"]["position"]=="Gudang"){
		$_SESSION["iss21"]["info"]="Gagal, anda tidak memiliki ijin untuk mengakses halaman ini.";
		header("location: dashboard.php");
	}
	
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
    <title>Purchase Order :: <?php echo $app_name;?></title>
	<style>
		@media screen {			
			div.divHeader{
				display: none;
			}
			div.divFooterKiri {
				display: none;
			}
			div.divFooterTengah {
				display: none;
			}
			div.divFooterKanan {
				display: none;
			}			
		}
		@media print {		  		  
			div.divHeader {			
				position: fixed; top: 2px; right: 8px;
			}
			div.divFooterKiri {			
				position: fixed; bottom: 0;left: 8px;
			}
			div.divFooterTengah{
				position: fixed; bottom: 0;width: 100%; text-align: center;
			}
			div.divFooterKanan{
				position: fixed; bottom: 0;right: 8px;
			}
			body{
				margin: 1em;
				padding-top:1em;
				padding-left:1em;
				padding-right:1em;
				padding-bottom:1em;
				/*font: 14pt Georgia, "Times New Roman", Times, serif;*/
				line-height: 1.3;
				background: #fff !important;
				color: #000;
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
                        <h3 class="text-themecolor">Purchase Order</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Purchase Order</li>
                        </ol>
                    </div>										
                </div>
                <div class="row">
				
				
                    <div class="col-12">
                        <div class="card">							
                            <div class="card-body">
								<div class="row">									
									<div class="col-md-5 align-self-center">
										<h4 class="card-title">Daftar Purchase Order</h4>
										<h6 class="card-subtitle">Purchase Order <code>List</code></h6>
									</div>
									<div class="col-md-7 align-self-center text-right">
										<a class='btn btn-success btn-sm' href='add-po.php' title='Add'> <i class='fa fa-plus-circle'></i> Add</a>								
									</div>
								</div>								
                                <div class="table-responsive">									
                                    <table class="table table-sm table-striped table-hover table-bordered" id="data-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
												<th>PO Number</th>
												<th>Date</th>
                                                <th>Supplier</th>
												<th>Address</th>
												<th>Phone</th>
												<th>Status</th>											
												<th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
											$no=0;
											$result = $con->query("Select po, tanggal, kode_supplier, supplier, address, phone, status 
												from PO 
												where branch='$branch' and status='OPEN'
												group by po, tanggal, kode_supplier, supplier, address, phone, status
												order by po");
											$count = mysqli_num_rows($result);
											if($count>0){
												while($row = mysqli_fetch_assoc($result))
												{
													$no++;													
													$po=$row["po"];
													$tanggal=$row["tanggal"];
													$tanggal1=date('d/m/y',strtotime($tanggal));
													$kode_supplier=$row["kode_supplier"];
													$supplier=$row["supplier"];
													$address=$row["address"];
													$phone=$row["phone"];													
													$status=$row["status"];
													
													echo"
														<tr>
															<td>$no</td>
															<td>$po</td>
															<td>$tanggal1</td>
															<td>$supplier</td>
															<td>$address</td>
															<td>$phone</td>															
															<td>$status</td>
															";
															?>
															
															<td align='center' nowrap>
																<a class='btn btn-primary btn-sm' href='add-po.php?po=<?php echo $po;?>&tanggal=<?php echo $tanggal;?>&kode_supplier=<?php echo $kode_supplier;?>' title='Edit'> <i class='fa fa-pencil'></i> Edit</a>
																<script src="js/jquery.min.js"></script>
																<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
																<a href = 'javascript:
																	swal({
																		  title: "Konfirmasi!",
																		  text: "Apa Anda yakin akan menghapus Po ini?",
																		  icon: "warning",
																		  buttons: true,
																		  dangerMode: "true",
																		})
																		.then((willDelete) => {
																		  if (willDelete) {
																		   swal({ title: "Data dihapus dari sistem...",
																		 icon: "success"}).then(okay => {
																		   if (okay) {
																			window.location.href = "<?php echo "fc/fc_delete_po_by_number.php?po=$po";?>";
																		  }
																		});
																	
																		  } else {
																			swal({
																			title: "Penghapusan dibatalkan...",
																			 icon: "error",
																			
																			});
																		  }
																		});'
																		class='btn btn-danger btn-sm text-xs'><i class='fa fa-trash'></i> Delete 
																</a>
																
																<a href = 'javascript:
																	swal({
																		  title: "Konfirmasi!",
																		  text: "Apa Anda yakin akan Closing PO ini?",
																		  icon: "warning",
																		  buttons: true,
																		  dangerMode: "true",
																		})
																		.then((willDelete) => {
																		  if (willDelete) {
																		   swal({ title: "PO akan diclosing...",
																		 icon: "success"}).then(okay => {
																		   if (okay) {
																			window.location.href = "<?php echo "fc/fc_close_po_by_number.php?po=$po";?>";
																		  }
																		});
																	
																		  } else {
																			swal({
																			title: "Penghapusan dibatalkan...",
																			 icon: "error",
																			
																			});
																		  }
																		});'
																		class='btn btn-dark btn-sm text-xs'><i class='fa fa-close'></i> Close 
																</a>
																<a class='btn btn-info btn-sm text-right' 
																    href='cetak_po.php?po=<?php echo $po; ?>&halaman=po'><i class='fa fa-print'></i> Cetak</a>
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
	<script src="js/datatables/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.responsive.min.js"></script>	
	<script type="text/javascript">
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