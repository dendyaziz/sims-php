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
    <title>Group :: <?php echo $app_name;?></title>
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
                        <h3 class="text-themecolor">Group</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Group</li>
                        </ol>
                    </div>										
                </div>
                <div class="row">
				
				
                    <div class="col-12">
                        <div class="card">							
                            <div class="card-body">
								<div class="row">									
									<div class="col-md-5 align-self-center">
										<h4 class="card-title">Daftar Semua Group</h4>
										<h6 class="card-subtitle">Group <code>List</code></h6>
									</div>
									<div class="col-md-7 align-self-center text-right">
										<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-toggle="modal" data-target="#addModal" data-whatever="@getbootstrap"><i class='fa fa-plus-circle'></i> Add</button>
									</div>
								</div>								
                                <div class="table-responsive">									
                                    <table class="table table-sm table-striped table-hover table-bordered" id="data-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
												<th>Group</th>
												<th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
											$no=0;
											$result = $con->query("Select * from JENIS order By jenis");
											$count = mysqli_num_rows($result);
											if($count>0){
												while($row = mysqli_fetch_assoc($result))
												{
													$no++;													
													$jenis=$row["jenis"];
													$id=$row["id"];
													
													echo"
														<tr>
															<td>$no</td>
															<td>$jenis</td>
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
					<h4 class="modal-title" id="addModalLabel">Add Group</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<form method="POST" action="">
				<div class="modal-body">

					<input type="text" name="username" value="<?php echo $_SESSION["iss21"]["fullname"];?>" hidden required="required">
					<div class="row">						
						<div class="col-md-12">
							<div class="form-group">
								<label for="jenis">Group</label>
								<input type="text" class="form-control" id="jenis" name="jenis" required="required">
							</div>
						</div>						
					</div>
										
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success btn-sm" formaction="fc/fc_add_category_modal.php"><i class="fa fa-paper-plane"></i> Submit</button>
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
			"lengthMenu": [[ 15, 25, -1], [ 15, 25, "All"]],
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
					url : 'edit-category-modal.php',
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
					url : 'delete-category-modal.php',
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