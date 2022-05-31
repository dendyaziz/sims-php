<?php
session_start();
include("fc/fc_config.php");
if($_SESSION["iss21"]["authentication"]=="VALID"){
	$filenameImages =$_SESSION["iss21"]["img"];
	$filemtimeImages = filemtime("assets/images/users/".$filenameImages);
	$profile_picture=$filenameImages."?".$filemtimeImages;
	$pages="user-registration.php";
	
	if($_SESSION["iss21"]["position"]=="Salesman"){
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
    <title>Items :: <?php echo $app_name;?></title>
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
	<style>
    .modal-dialog {
    	height: 100%;
    	width: 100%;
    	display: flex;
    	align-items: center;
    }
    .modal-content {
    	padding-left:10px;
    	padding-right:10px;
    	margin: 0 auto;
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
                        <h3 class="text-themecolor">Master Barang</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Master Barang</li>
                        </ol>
                    </div>										
                </div>
                <div class="row">
				
				
                    <div class="col-12">
                        <div class="card">							
                            <div class="card-body">
								<div class="row">									
									<div class="col-md-5 align-self-center">
										<h4 class="card-title">Daftar Semua Barang</h4>
										<h6 class="card-subtitle">Items <code>List</code></h6>
									</div>
									<div class="col-md-7 align-self-center text-right">
										<!--<a class='btn btn-success btn-sm' href='add-item.php' title='Tambah Data Barang'> <i class='fa fa-plus-circle'></i> Add New</a> -->
										<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-toggle="modal" data-target="#addModal" data-whatever="@getbootstrap"><i class='fa fa-plus-circle'></i> Add</button>
									</div>
								</div>								
                                <div class="table-responsive">									
                                    <table class="table table-sm table-striped table-hover table-bordered" id="data-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
												<th>Code</th>								
												<th>Group</th>
												<th>Sub Group</th>
												<th>Merk</th>
												<th>Item Description</th>
												<th>Unit</th>
												<th class="text-right">Harga Beli</th>
												<th class="text-right">Harga Jual</th>
												<th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
											$no=0;
											$result = $con->query("Select * from BARANG order By jenis,subgroup,merk,barang");
											$count = mysqli_num_rows($result);
											if($count>0){
												while($row = mysqli_fetch_assoc($result))
												{
													$no++;													
													$kode=$row["kode"];
													$jenis=$row["jenis"];
													$subgroup=$row["subgroup"];
													$merk=$row["merk"];
													$barang=$row["barang"];													
													$satuan=$row["satuan"];
													$harga_beli=$row["harga_beli"];
													$harga_jual=$row["harga_jual"];
													$id=$row["id"];
													
													echo"
														<tr>
															<td>$no</td>
															<td>$kode</td>
															<td>$jenis</td>	
															<td>$subgroup</td>
															<td>$merk</td>															
															<td>$barang</td>
															<td>$satuan</td>
															<td align='right'>".number_format($harga_beli)."</td>
															<td align='right'>".number_format($harga_jual)."</td>
															<td align='center' nowrap>
																<button type='button' class='btn btn-primary btn-sm' title='Edit' data-toggle='modal' data-toggle='modal' data-target='#editModal' data-id=".$id." data-whatever='@getbootstrap'><i class='fa fa-pencil'></i> Edit</button>
																<button type='button' class='btn btn-danger btn-sm' title='Delete' data-toggle='modal' data-toggle='modal' data-target='#deleteModal' data-id=".$id." data-whatever='@getbootstrap'><i class='fa fa-trash'></i> Delete</button>
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
	
	<div class="modal" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="addModalLabel">Add Item</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<form method="POST" action="">
				<div class="modal-body">

					<input type="text" name="username" value="<?php echo $_SESSION["iss21"]["fullname"];?>" hidden required="required">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="kode">Code</label>
								<input type="text" class="form-control" id="kode" name="kode" required="required">
							</div>
						</div>
						<div class="col-md-6">											
							<div class="form-group">
								<label>Group</label>
								<select class="custom-select col-12" id="jenis" name="jenis" required="required">
									<option value="">Pilih...</option>
									<?php
										
										$result = $con->query("Select jenis from JENIS order By jenis");
										$count = mysqli_num_rows($result);
										if($count>0){						
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
						<div class="col-md-6">											
							<div class="form-group">
								<label>Sub Group</label>
								<select class="custom-select col-12" id="subgroup" name="subgroup" required="required">
									<option value="">Pilih...</option>
									<?php
										
										$result = $con->query("Select subgroup from SUBGROUP order By subgroup");
										$count = mysqli_num_rows($result);
										if($count>0){						
											while($row = mysqli_fetch_assoc($result))
											{				
												$subgroup1=$row["subgroup"];
												echo "<option value='$subgroup1'>$subgroup1</option>";
											}
										}												
									?>												
								</select>
							</div>											
						</div>
						<div class="col-md-6">											
							<div class="form-group">
								<label>Merk</label>
								<select class="custom-select col-12" id="merk" name="merk" required="required">
									<option value="">Pilih...</option>
									<?php
										
										$result = $con->query("Select merk from MERK order By merk");
										$count = mysqli_num_rows($result);
										if($count>0){						
											while($row = mysqli_fetch_assoc($result))
											{				
												$merk1=$row["merk"];
												echo "<option value='$merk1'>$merk1</option>";
											}
										}												
									?>												
								</select>
							</div>											
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="barang">Item Description</label>
								<input type="text" class="form-control" id="barang" name="barang" required="required">
							</div>
						</div>						
						<div class="col-md-4">
							<div class="form-group">
								<label for="satuan">Unit</label>
								<input type="text" class="form-control" id="satuan" name="satuan" required="required">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="harga_beli">Harga Beli</label>
								<input type="number" class="form-control" id="harga_beli" name="harga_beli" required="required">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="harga_jual">Harga Jual</label>
								<input type="number" class="form-control" id="harga_jual" name="harga_jual" required="required">
							</div>
						</div>
						<!--
						<div class="col-md-4">
							<div class="form-group">
								<label for="minimal">Min. Stock</label>
								<input type="number" class="form-control" id="minimal" name="minimal" required="required">
							</div>
						</div>
						-->
					</div>
										
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success btn-sm" formaction="fc/fc_add_item_modal.php"><i class="fa fa-paper-plane"></i> Submit</button>
					<button type="button" class="btn btn-dark btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	
	<div class="modal" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">				
				<div class="edit-modal"></div>				
			</div>
		</div>
	</div>
	<div class="modal" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">				
				<div class="delete-modal"></div>				
			</div>
		</div>
	</div>
	<div class="modal" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">				
				<div class="upload-modal"></div>			
			</div>
		</div>
	</div>
	<div class="modal" id="popupImages" tabindex="-1" role="dialog" aria-labelledby="popupImagesLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">				
				<div class="popup-image"></div>			
			</div>
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
		$(document).ready(function() {
			$('#addModal').on('shown.bs.modal', function() {
				$('#kode').trigger('focus');
			});

			$('#editModal').on('show.bs.modal', function (e) {				
				var idx = $(e.relatedTarget).data('id');
				$.ajax({
					type : 'post',
					url : 'edit-item-modal.php',
					data :  'id='+ idx,
					success : function(data){
						$('.edit-modal').html(data);
						/*$('#userid').trigger('focus');*/
					}					
				});
			 });
			 
			 $('#deleteModal').on('show.bs.modal', function (e) {				
				var idx = $(e.relatedTarget).data('id');
				$.ajax({
					type : 'post',
					url : 'delete-item-modal.php',
					data :  'id='+ idx,
					success : function(data){
						$('.delete-modal').html(data);
					}					
				});
			 });			 
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