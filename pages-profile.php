<?php
session_start();
include("fc/fc_config.php");
if($_SESSION["iss21"]["authentication"]=="VALID"){
	$filenameImages = $_SESSION["iss21"]["img"];
	$filemtimeImages = filemtime("assets/images/users/".$filenameImages);
	$profile_picture=$filenameImages."?".$filemtimeImages;
	$pages="pages-profile.php";
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
    <title>Profile :: <?php echo $app_name;?></title>
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
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-themecolor">Profile</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>
                    <div class="col-md-7 align-self-center">
                        
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body">						
							
								
                                <center class="m-t-30"> <img src="assets/images/users/<?php echo $profile_picture;?>" class="img-circle" width="150" height="150" />
								<form role="form" method="POST" action="fc/fc_change_profile_picture.php" enctype="multipart/form-data">
									<div class="card-body">
										<label class="btn btn-default" style="width:100%">
											Browse...
											<span id="uploaded-file-name" style="font-style: italic; color:orange"></span>
											<input id="file-upload" type="file" name="img" id="img" onchange="$('#uploaded-file-name').text($('#file-upload')[0].value);" hidden>
											<input type="text" name="id" class="form-control" id="id" value="<?php echo $_SESSION["iss21"]["id"];?>" required="required" hidden>											
										</label>
										<button type="submit" class="btn btn-primary">Change Picture</button>										
										
									</div>
								</form>
								
									<!--
                                    <h4 class="card-title m-t-10"><?php echo $_SESSION["iss21"]["fullname"];?></h4>
                                    <h6 class="card-subtitle"><?php echo $_SESSION["iss21"]["position"];?></h6>
                                    
									<div class="row text-center justify-content-md-center">
                                        <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-people"></i> <font class="font-medium">254</font></a></div>
                                        <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-picture"></i> <font class="font-medium">54</font></a></div>
                                    </div>
									-->
                                </center>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card">
                            <!-- Tab panes -->
                            <div class="card-body">
                                <form class="form-horizontal form-material" action="fc/fc_update_profile.php" method="post">
									<div class="form-group">
                                        <label for="example-email" class="col-md-12">Email</label>
                                        <div class="col-md-12">
                                            <input type="email" name="email" value="<?php echo $_SESSION["iss21"]["email"];?>" class="form-control form-control-line" name="example-email" id="example-email" required="required" >
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label class="col-md-12">Password</label>
                                        <div class="col-md-12">
                                            <input type="password" name="password" value="<?php echo $_SESSION["iss21"]["password"];?>" class="form-control form-control-line" required="required">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Nama Lengkap</label>
                                        <div class="col-md-12">
                                            <input type="text" name="fullname" value="<?php echo $_SESSION["iss21"]["fullname"];?>" class="form-control form-control-line" required="required">
                                        </div>
                                    </div>	
									<div class="form-group">
                                        <label class="col-md-12">Kantor Cabang</label>
                                        <div class="col-md-12">
											<input type="text" name="branch" value="<?php echo $_SESSION["iss21"]["branch"];?>" class="form-control form-control-line" readonly required="required">
                                        </div>
                                    </div>									
									<div class="form-group">
                                        <label class="col-md-12">Jabatan</label>
                                        <div class="col-md-12">
											<input type="text" name="position" value="<?php echo $_SESSION["iss21"]["position"];?>" class="form-control form-control-line" readonly required="required">
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label class="col-md-12">Level</label>
                                        <div class="col-md-12">
                                            <input type="text" name="level" value="<?php echo $_SESSION["iss21"]["level"];?>" class="form-control form-control-line" readonly required="required">
											<input type="text" name="id" value="<?php echo $_SESSION["iss21"]["id"];?>" class="form-control form-control-line" hidden required="required">
											<input type="text" name="img" value="<?php echo $_SESSION["iss21"]["img"];?>" class="form-control form-control-line" hidden required="required">
											<input type="text" name="status" value="<?php echo $_SESSION["iss21"]["status"];?>" class="form-control form-control-line" hidden required="required">
                                            
										</div>
                                    </div>
																		
									<!--
                                    <div class="form-group">
                                        <label class="col-md-12">Message</label>
                                        <div class="col-md-12">
                                            <textarea rows="5" class="form-control form-control-line"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-12">Select Country</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>London</option>
                                                <option>India</option>
                                                <option>Usa</option>
                                                <option>Canada</option>
                                                <option>Thailand</option>
                                            </select>
                                        </div>
                                    </div>
									-->
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button class="btn btn-success">Update Profile</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->

            <?php include("inc/footer_details.php");?>

        </div>

    </div>
    
	<?php include("inc/js_bawah.php");?>
	
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