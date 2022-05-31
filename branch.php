<?php
session_start();
include("fc/fc_config.php");
if($_SESSION["iss21"]["authentication"]=="VALID"){
	$filenameImages =$_SESSION["iss21"]["img"];
	$filemtimeImages = filemtime("assets/images/users/".$filenameImages);
	$profile_picture=$filenameImages."?".$filemtimeImages;
	
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
    <title>Warehouse :: <?php echo $app_name;?></title>
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
                        <h3 class="text-themecolor">Gudang</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Gudang</li>
                        </ol>
                    </div>										
                </div>
                <div class="row">
				
				
                    <div class="col-12">
                        <div class="card">							
                            <div class="card-body">
								<div class="row">									
									<div class="col-md-5 align-self-center">
										<h4 class="card-title">Daftar Semua Gudang</h4>
										<h6 class="card-subtitle">Warehouse <code>List</code></h6>
									</div>
									<div class="col-md-7 align-self-center text-right">
										<!--<a class='btn btn-success btn-sm' href='add-branch.php' title='Tambah Data Gudang'> <i class='fa fa-plus-circle'></i> Add New</a> -->
										<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-toggle="modal" data-target="#addModal" data-whatever="@getbootstrap"><i class='fa fa-plus-circle'></i> Add</button>
									</div>
								</div>								
                                <div class="table-responsive">									
                                    <table class="table table-sm table-striped table-hover table-bordered" id="data-table">
                                        <thead>
                                            <tr>
                                                <th style="width:40px">#</th>
                                                <th>Nama Gudang</th>
												<th>Lokasi Gudang</th>                                               
												<th class="text-center" style="width:150px">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
											$no=0;
											$result = $con->query("Select * from BRANCH order By id");
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
																<button type='button' class='btn btn-primary btn-sm' title='Edit' data-toggle='modal' data-toggle='modal' data-target='#editModal' data-id=".$id." data-whatever='@getbootstrap'><i class='fa fa-pencil'></i> Edit</button>
																<button type='button' class='btn btn-danger btn-sm' title='Delete' data-toggle='modal' data-toggle='modal' data-target='#deleteModal' data-id=".$id." data-whatever='@getbootstrap'><i class='fa fa-trash'></i> Delete</button>
																
																<!--
																<a class='btn btn-primary btn-sm' href='edit-branch.php?id=$id' title='Edit Data Gudang'> <i class='fa fa-edit'></i> Edit</a>
																<a class='btn btn-danger btn-sm' href='delete-branch.php?id=$id' title='Hapus Data Gudang'> <i class='fa fa-trash'></i> Delete</a>
																-->
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
					<h4 class="modal-title" id="addModalLabel">Add Gudang</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<form method="POST" action="">
				<div class="modal-body">

					<input type="text" name="username" value="<?php echo $_SESSION["iss21"]["fullname"];?>" hidden required="required">
					<div class="form-group">
						<label for="branch">Nama Gudang</label>
						<input type="text" class="form-control" id="branch" name="branch" required="required">
					</div>
					<div class="form-group">
						<label for="location">Lokasi Gudang</label>
						<input type="location" class="form-control" id="location" name="location" required="required">
					</div>
										
										
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success btn-sm" formaction="fc/fc_add_branch_modal.php"><i class="fa fa-paper-plane"></i> Submit</button>
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
				$('#branch').trigger('focus');
			});

			$('#editModal').on('show.bs.modal', function (e) {				
				var idx = $(e.relatedTarget).data('id');
				$.ajax({
					type : 'post',
					url : 'edit-branch-modal.php',
					data :  'id='+ idx,
					success : function(data){
						$('.edit-modal').html(data);
						$('#branch1').trigger('focus');
					}					
				});
			 });
			 
			 $('#deleteModal').on('show.bs.modal', function (e) {				
				var idx = $(e.relatedTarget).data('id');
				$.ajax({
					type : 'post',
					url : 'delete-branch-modal.php',
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