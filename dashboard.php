<?php
session_start();
include("fc/fc_config.php");
if($_SESSION["iss21"]["authentication"]=="VALID"){	
	$filenameImages = $_SESSION["iss21"]["img"];
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
	<title>Dashboard :: <?php echo $app_name;?></title>	
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
<body class="fix-header fix-sidebar card-no-border">
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
		
		<?php
		
			$bln=date("m");
			$thn=date("Y");
			
			if($bln==1){
				$bulan="Januari";
			}else if($bln==2){
				$bulan="Februari";
			}else if($bln==3){
				$bulan="Maret";
			}else if($bln==4){
				$bulan="April";
			}else if($bln==5){
				$bulan="Mei";
			}else if($bln==6){
				$bulan="Juni";
			}else if($bln==7){
				$bulan="Juli";
			}else if($bln==8){
				$bulan="Agustus";
			}else if($bln==9){
				$bulan="September";
			}else if($bln==10){
				$bulan="Oktober";
			}else if($bln==11){
				$bulan="November";
			}else if($bln==12){
				$bulan="Desember";
			}	
			
			if(empty($bln)){
				$judul_Laporan1="Sales of <code>The Month</code>";
			}else{
				$judul_Laporan1=" <code>".$bulan." ".$thn."</code>";
			}
				
			
		?>

        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-themecolor">Dashboard</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>		
                </div>				
				
				<?php
				
					$result1 = mysqli_query($con, "Select count(id) jmlbrg from BARANG");
					while($row1 = mysqli_fetch_assoc($result1)){
						$jmlbrg=$row1["jmlbrg"];
						$jmlbrg=number_format($jmlbrg);
					}
					$result1 = mysqli_query($con, "Select count(id) jmlgudang from BRANCH");
					while($row1 = mysqli_fetch_assoc($result1)){
						$jmlgudang=$row1["jmlgudang"];
						$jmlgudang=number_format($jmlgudang);
					}
					$result1 = mysqli_query($con, "Select count(id) jmlsupplier from SUPPLIER");
					while($row1 = mysqli_fetch_assoc($result1)){
						$jmlsupplier=$row1["jmlsupplier"];
						$jmlsupplier=number_format($jmlsupplier);
					}
					$result1 = mysqli_query($con, "Select count(id) jmlcustomer from CUSTOMER");
					while($row1 = mysqli_fetch_assoc($result1)){
						$jmlcustomer=$row1["jmlcustomer"];
						$jmlcustomer=number_format($jmlcustomer);
					}
					
				
				?>
				
				<div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex p-10 no-block">
                                    <div class="align-slef-center">
                                        <h2 class="m-b-0"><?php echo $jmlgudang; ?></h2>
                                        <h6 class="text-muted m-b-0">Jumlah Gudang</h6>
                                    </div>
                                    <div class="align-self-center display-6 ml-auto"><i class="text-success fa fa-building"></i></div>
                                </div>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:100%; height:3px;"> <span class="sr-only">50% Complete</span></div>
                            </div>
                        </div>
                    </div>                    
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex p-10 no-block">
                                    <div class="align-slef-center">
                                        <h2 class="m-b-0"><?php echo $jmlbrg; ?></h2>
                                        <h6 class="text-muted m-b-0">Jumlah Barang</h6>
                                    </div>
                                    <div class="align-self-center display-6 ml-auto"><i class="text-primary fa fa-hdd-o"></i></div>
                                </div>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:100%; height:3px;"> <span class="sr-only">50% Complete</span></div>
                            </div>
                        </div>
                    </div> 
					<div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex p-10 no-block">
                                    <div class="align-slef-center">
                                        <h2 class="m-b-0"><?php echo $jmlsupplier; ?></h2>
                                        <h6 class="text-muted m-b-0">Jumlah Supplier</h6>
                                    </div>
                                    <div class="align-self-center display-6 ml-auto"><i class="text-info fa fa-industry"></i></div>
                                </div>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:100%; height:3px;"> <span class="sr-only">50% Complete</span></div>
                            </div>
                        </div>
                    </div>
					<div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex p-10 no-block">
                                    <div class="align-slef-center">
                                        <h2 class="m-b-0"><?php echo $jmlcustomer; ?></h2>
                                        <h6 class="text-muted m-b-0">Jumlah Customer</h6>
                                    </div>
                                    <div class="align-self-center display-6 ml-auto"><i class="text-warning fa fa-user"></i></div>
                                </div>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:100%; height:3px;"> <span class="sr-only">50% Complete</span></div>
                            </div>
                        </div>
                    </div>
                </div>
				
				
				<div class="row">
					
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Latest History</h5>
                                <ul class="feeds">
									
									<?php
										$branchX=$_SESSION["iss21"]["branch"];
										$result1 = mysqli_query($con, "Select * from HISTORY where branch='$branchX' order by id desc limit 10");
										while($row1 = mysqli_fetch_assoc($result1)){
											$branch2=$row1["branch"];
											$tanggal=$row1["tanggal"];
											$tanggal=date('d/m/Y',strtotime($tanggal));											
											$username2=$row1["username"];
											$faktur2=$row1["faktur"];
											$kode2=$row1["kode"];
											$jenis2=$row1["jenis"];
											$barang2=$row1["barang"];
											$satuan2=$row1["satuan"];
											$qty2=$row1["qty"];																							
											if(empty($qty2)){$qty2=0;}
											$qty2=number_format($qty2);
											$transaksi2=$row1["transaksi"];
											
											echo"
												<li>
													<div class='bg-light-"	;												
													if($transaksi2=="INCOMING"){
														echo"success";
													}else if($transaksi2=="OUTGOING"){
														echo"info";
													}else if($transaksi2=="RETUR" or $transaksi2=="OPNAME"){
														echo"danger";
													}else{
														echo"secondary";
													}			
											echo"'><i class='fa fa-bell'></i></div> Transaksi $transaksi2<br>
													$kode2 $jenis2 $barang2<br>$qty2 $satuan2<span class='text-muted'>$tanggal</span>
												</li>
											";
											
										}
									
									?>
                                </ul>
                            </div>
                        </div>
                    </div>
					<div class="col-lg-6">
						<div class="card">
							<div class="card-body">
								<h5 class="card-title">Stock Warning</h5>
																	
										<?php 
											$no=0;
											$Qbranch=$_SESSION["iss21"]["branch"];
											$sql1="SELECT a.jenis, a.kode, a.barang, a.satuan, a.saldo, a.satuan 
												FROM STOK a inner join BARANG b on a.kode=b.kode 
												Where a.branch='$Qbranch' and b.minimal>0 and a.saldo<b.minimal 
												order by a.saldo limit 10";
											$result1 = $con1->query($sql1);
											$count1 = mysqli_num_rows($result1);
											if($count1>0){
												echo"
												<table class='table browser m-t-30 no-border'>
													<tbody>";
														while($row1 = mysqli_fetch_assoc($result1)){
															$no++;
															$jenis=$row1["jenis"];
															$kode=$row1["kode"];
															$barang=$row1["barang"];
															$satuan=$row1["satuan"];
															$saldo=$row1["saldo"];															
															$saldo=number_format($saldo);
															echo"
																<tr>
																	<td>$jenis<br>$barang</td>
																	<td align='right'><span class='label label-light-danger'>$saldo $satuan</span></td>
																</tr>													
															";
														}
												echo"
													</tbody>
												</table>";
											}
										?>										
									
							</div>
						</div>
					</div>
                </div>
				
				

<iframe id="txtArea1" style="display:none"></iframe>
                </div>
                <!-- ============================================================== -->
                <!-- End Notification And Feeds -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- End Page Content -->
                <!-- ============================================================== -->
				
				
				

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
	header("location: index.php");
}

?>