<?php
session_start();
include("fc/fc_config.php");
if($_SESSION["iss21"]["authentication"]=="VALID"){
	$filenameImages =$_SESSION["iss21"]["img"];
	$filemtimeImages = filemtime("assets/images/users/".$filenameImages);
	$profile_picture=$filenameImages."?".$filemtimeImages;
	$pages="user-registration.php";
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
    <title>Master :: <?php echo $app_name;?></title>
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
                        <h3 class="text-themecolor">Master</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Master</li>
                        </ol>
                    </div>										
                </div>
                <div class="row">
				
				
                    <div class="col-12">
                        <div class="card">							
                            <div class="card-body">
								<div class="row">									
									<div class="col-md-5 align-self-center">
										<h4 class="card-title">Daftar Semua Cabang</h4>
										<h6 class="card-subtitle">Branch <code>List</code></h6>
									</div>
									<div class="col-md-7 align-self-center text-right">
										<a class='btn btn-success btn-sm' href='add-branch.php' title='Tambah Data Cabang'> <i class='fa fa-plus-circle'></i> Add New</a> 
									</div>
								</div>								
                                <div class="table-responsive">									
                                    <table class="table table-bordered" id="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama cabang</th>
												<th>Lokasi Cabang</th>                                               
												<th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
											$no=0;
											$result = $con->query("Select * from BRANCH order By branch");
											$count = mysqli_num_rows($result);
											if($count>0){
												while($row = mysqli_fetch_assoc($result))
												{				
													$no++;
													$branch=$row["branch"];	
													$location=$row["location"];
													$id=$row["id"];
													
													echo"
														<tr>
															<td>$no</td>
															<td>$branch</td>
															<td>$location</td>
															<td align='center' nowrap>
																<a class='btn btn-primary btn-sm' href='edit-branch.php?id=$id' title='Edit Data Cabang'> <i class='fa fa-edit'></i> Edit</a>
																<a class='btn btn-danger btn-sm' href='delete-branch.php?id=$id' title='Hapus Data Cabang'> <i class='fa fa-trash'></i> Delete</a>
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
					
					
					
					<div class="col-12">
                        <div class="card">							
                            <div class="card-body">
								<div class="row">									
									<div class="col-md-5 align-self-center">
										<h4 class="card-title">Daftar Semua User</h4>
										<h6 class="card-subtitle">Users <code>List</code></h6>
									</div>
									<div class="col-md-7 align-self-center text-right">
										<a class='btn btn-success btn-sm' href='add-user.php' title='Tambah Data User'> <i class='fa fa-plus-circle'></i> Add New</a> 
									</div>
								</div>								
                                <div class="table-responsive">									
                                    <table class="table table-bordered" id="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Cabang</th>
												<th>Nama Lengkap</th>
                                                <th>Jabatan</th>
                                                <th>Email</th>
												<th>Status</th>
												<th>Level</th>
												<th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
											$no=0;
											$result = $con->query("Select * from TBLLOGIN order By branch, fullname");
											$count = mysqli_num_rows($result);
											if($count>0){
												while($row = mysqli_fetch_assoc($result))
												{				
													$no++;
													$branch=$row["branch"];	
													$fullname=$row["fullname"];													
													$position=$row["position"];
													$email=$row["email"];
													$status=$row["status"];
													$level=$row["level"];
													$id=$row["id"];
													
													echo"
														<tr>
															<td>$no</td>
															<td>$branch</td>
															<td>$fullname</td>
															<td>$position</td>
															<td>$email</td>
															<td>$status</td>
															<td>$level</td>
															<td align='center' nowrap>
																<a class='btn btn-primary btn-sm' href='edit-user.php?id=$id' title='Edit Data User'> <i class='fa fa-edit'></i> Edit</a>
																<a class='btn btn-danger btn-sm 
																";
																
																if($_SESSION["iss21"]["id"]==$id){echo "disabled";}
																
													echo		"' href='delete-user.php?id=$id' title='Hapus Data User'> <i class='fa fa-trash'></i> Delete</a>
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
					
					
					
					<div class="col-12">
                        <div class="card">							
                            <div class="card-body">
								<div class="row">									
									<div class="col-md-5 align-self-center">
										<h4 class="card-title">Daftar Semua Barang</h4>
										<h6 class="card-subtitle">Items <code>List</code></h6>
									</div>
									<div class="col-md-7 align-self-center text-right">
										<a class='btn btn-success btn-sm' href='add-item.php' title='Tambah Data Barang'> <i class='fa fa-plus-circle'></i> Add New</a> 
									</div>
								</div>								
                                <div class="table-responsive">									
                                    <table class="table table-bordered" id="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Jenis Barang</th>
												<th>Nama Barang</th>
												<th>Ukuran (P x L)</th>
												<th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
											$no=0;
											$result = $con->query("Select * from BARANG order By jenis,barang");
											$count = mysqli_num_rows($result);
											if($count>0){
												while($row = mysqli_fetch_assoc($result))
												{
													/*
													
													$cm = 234459891345;
													echo sprintf('km: %02d m: %02d cm: %02d', ($cm/100000),($cm/100%100), $cm%100);
													
													*/
													$no++;
													$jenis=$row["jenis"];	
													$barang=$row["barang"];
													$panjang=($row["panjang"]/100);
													$lebar=($row["lebar"]/100);
													$ukuran=$panjang."M x ".$lebar."M";									
													$id=$row["id"];
													
													echo"
														<tr>
															<td>$no</td>
															<td>$jenis</td>
															<td>$barang</td>
															<td>$ukuran</td>
															<td align='center' nowrap>
																<a class='btn btn-primary btn-sm' href='edit-barang.php?id=$id' title='Edit Data Barang'> <i class='fa fa-edit'></i> Edit</a>
																<a class='btn btn-danger btn-sm' href='delete-barang.php?id=$id' title='Hapus Data Barang'> <i class='fa fa-trash'></i> Delete</a>
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
					
					
					
                </div>
				
							
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>
		
		
		
		
		<!--End Content-->

        <?php include("inc/footer_details.php");?>
        </div>
    </div>
    <?php include("inc/js_bawah.php");?>
	<script>
		function printContent(el){
			var restorepage = document.body.innerHTML;
			var printcontent = document.getElementById(el).innerHTML;
			document.body.innerHTML = printcontent;
			window.print();
			document.body.innerHTML = restorepage;
		}
		function exportF(elem) {
		  var table = document.getElementById("table");
		  var html = table.outerHTML;
		  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
		  elem.setAttribute("href", url);
		  elem.setAttribute("download", "export.xls"); // Choose the file name
		  return false;
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