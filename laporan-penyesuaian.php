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
    <title>Reporting :: <?php echo $app_name;?></title>
	<link href="css/dataTables.bootstrap4.css" rel="stylesheet">
	<link href="css/responsive.dataTables.min" rel="stylesheet">
	<link href="css/table-pages.css" rel="stylesheet">
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
                        <h3 class="text-themecolor">Laporan Penyesuaian Stok</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Laporan Penyesuaian Stok</li>
                        </ol>
                    </div>
					<?php
						/*if(strtolower($_SESSION["iss21"]["branch"])=="head office"){*/
							if(!empty($_POST["branch"])){
								if(strtolower($_POST["branch"])=="semua kantor cabang"){
									$judul_laporan="Laporan Penyesuaian Keseluruhan";
									$branchL="Semua Kantor Cabang";
								}else{
									$branchL=$_POST["branch"];
									$judul_laporan="Laporan Penyesuaian Kantor Cabang ".$_POST["branch"];
								}
							}else{
								$branchL="Semua Kantor Cabang";
								$judul_laporan="Laporan Penyesuaian Keseluruhan";
							}
						/*}else{
							$branchL=$_SESSION["iss21"]["branch"];
							$judul_laporan="Laporan Penyesuaian Kantor Cabang ".$_SESSION["iss21"]["branch"];
						}*/
						
						
						if(!empty($_POST["awal"]) && !empty($_POST["akhir"])){													
							$awal=$_POST["awal"];
							$akhir=$_POST["akhir"];
							$tAwal=date('d/m/Y', strtotime($awal));
							$tAkhir=date('d/m/Y', strtotime($akhir));
							if($awal==$akhir){
								$judul_laporan1="Periode : <code> $tAwal </code>";
							}else{
								$judul_laporan1="Periode : <code> $tAwal s/d $tAkhir </code>";
							}
							$awal=date('Y-m-d 00:00:00', strtotime($awal));													
							$akhir=date('Y-m-d 23:59:59', strtotime($akhir));
						}else{
							$awal=date("Y-m-d 00:00:00");
							$akhir=date("Y-m-d 23:59:59");
							$tAwal=date('d/m/Y', strtotime($awal));
							$judul_laporan1="Periode : <code> $tAwal </code>";
						}
						
					?>
					<div class="col-md-7 align-self-center text-right">
					</div>
                </div>
				
				
                <div class="row" id="cetak">
				
					
					
					<div class="col-md-12">
                        <div class="card card-body">
						
                            <h4 class="card-title">Pilih Kriteria Pelaporan</h4>
                            <h5 class="card-subtitle"> Choose <code> Report Criteria</code> </h5>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
									
									
									
									
										<form method="POST" action="">
											<div class="row">
												<?php /*if(strtolower($_SESSION["iss21"]["branch"])=="head office"){*/ ?>
												<div class="col-md-4">
													<div class="form-group">
														<label>Kantor Cabang</label>
														<select class="custom-select col-12" id="branch" name="branch" required="required" onchange="this.form.submit()">
															<option value="<?php if(!empty($branchL)){echo $branchL;}?>"><?php if(!empty($branchL)){echo $branchL;}else{echo "Pilih...";}?></option>
															<?php
																
																$result = $con->query("Select branch from BRANCH group by branch order By branch");
																$count = mysqli_num_rows($result);
																if($count>0){
																	
																	if(strtolower($branchL)=="semua kantor cabang"){
																		echo "<option value='$branchL'>$branchL</option>";
																	}else{
																		echo "<option value='Semua Kantor Cabang'>Semua Kantor Cabang</option>";
																	}
																	while($row = mysqli_fetch_assoc($result))
																	{				
																		$branch=$row["branch"];
																		echo "<option value='$branch'>$branch</option>";
																	}
																}												
															?>												
														</select>
													</div>
												</div>
												<?php /*}*/ ?>
											
												<div class="col-md-4">
													<div class="form-group">
														<label for="awal">Periode Awal</label>
														<input class="form-control form-control-line" type="date" name="awal" id="awal" value="<?php if(!empty($_POST['awal'])){echo $_POST['awal'];}else{echo date("Y-m-d");} ?>" required="required">
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label for="akhir">Periode Akhir</label>
														<input class="form-control form-control-line" type="date" name="akhir" id="akhir" value="<?php if(!empty($_POST['akhir'])){echo $_POST['akhir'];}else{echo date("Y-m-d");} ?>" required="required">
													</div>
												</div>
												<div class="col-md-12">										
													<div class="form-group">
														<button type="submit" class="btn btn-primary mr-2"><i class="fa fa-bar-chart-o"></i> Tampilkan </button>
													</div>
												</div>
											
											</div>
										</form>
									
                                </div>
                            </div>
						</div>
					</div>
					<div class="col-md-12">
                        <div class="card card-body">
					
					
					
					
					<?php if(!empty($branchL)){?>
						
							<div class="row">
								<div class="col-md-5">
									<h4 class="card-title"><?php echo $judul_laporan;?></h4>
									<h5 class="card-subtitle"> <?php echo $judul_laporan1;?> </h5>
								</div>
								<div class="col-md-7 text-right">
									<a class="btn btn-success" href="<?php echo 'cetak_penyesuaian.php?branch='.$branchL.'&awal='.$awal.'&akhir='.$akhir;?>" target="_BLANK"><i class="fa fa-print"></i> Cetak</a>
								</div>
							</div>
							<div class="table-responsive">	
								
								<table class="table table-sm table-hover table-bordered" id="table">
									
										<?php
										if(strtolower($branchL)=="semua kantor cabang"){
											?>
											<thead>
												<tr>
													<th>#</th>
													<th>Tanggal</th>
													<th>Faktur</th>
													<th>Penyesuaian</th>
													<th>Alasan</th>													
													<th>Jenis Barang</th>
													<th>Nama Barang</th>
													<th>Ukuran (P x L)</th>
													<th>Panjang</th>
													<th>Lebar</th>
													<th class="text-right">M<sup>2</sup>/Meter</th>
													<th class="text-right">Roll/Lonjor</th>
													<th>Username</th>
												</tr>												
											</thead>
											<tbody>
											<?php
											$result = $con->query("Select date(tanggal) as tanggal, faktur, alasan, penyesuaian, jenis, barang, panjang, lebar, sesuai_panjang, sesuai_lebar, sum(jumlah) as jumlah, username from PENYESUAIAN where (tanggal between '$awal' and '$akhir') group by date(tanggal), faktur, alasan, penyesuaian, jenis, barang, panjang, lebar, sesuai_panjang, sesuai_lebar, username order By date(tanggal), jenis, barang");
											$count = mysqli_num_rows($result);
											if($count>0){
												$no=0;
												$total1=0;
												$total2=0;
												while($row = mysqli_fetch_assoc($result))
												{
													$no++;
													$tanggal=$row["tanggal"];
													$tanggal=date('d/m/Y', strtotime($tanggal));
													$faktur=$row["faktur"];
													$penyesuaian=$row["penyesuaian"];
													$alasan=$row["alasan"];
													$jenis=$row["jenis"];	
													$barang=$row["barang"];
													$panjang=($row["panjang"]);
													$lebar=($row["lebar"]);
													$sesuai_panjang=($row["sesuai_panjang"]);
													$sesuai_lebar=($row["sesuai_lebar"]);
													$jumlah=$row["jumlah"];
													$total1=$total1+$jumlah;
													if($jenis=="Cleated" or $jenis=="Profile"){
														$ukuran=$panjang."M";
														$roll=$jumlah/($panjang);
													}else{
														$ukuran=$panjang."M x ".$lebar."M";
														$roll=$jumlah/($panjang*$lebar);
													}	
													$total2=$total2+$roll;
													$username=$row["username"];													
													echo"
														<tr>
															<td>$no</td>
															<td>$tanggal</td>
															<td>$faktur</td>
															<td>$penyesuaian</td>
															<td>$alasan</td>
															<td>$jenis</td>
															<td>$barang</td>
															<td>$ukuran</td>
															<td>$sesuai_panjang</td>
															<td>$sesuai_lebar</td>
															<td class='text-right'>".number_format($jumlah,2)."</td>
															<td class='text-right'>".number_format($roll,2)."</td>
															<td>$username</td>															
														</tr>
													";													
												}
												echo"
														<tr>
															<th colspan='10' class='text-right'> Total</th>
															<th class='text-right'>".number_format($total1,2)."</th>
															<th class='text-right'>".number_format($total2,2)."</th>
															
														</tr>
												";
											}
										}else{
											
											?>
											<thead>
												<tr>
													<th>#</th>
													<th>Kantor Cabang</th>
													<th>Tanggal</th>
													<th>Faktur</th>
													<th>Penyesuaian</th>
													<th>Alasan</th>
													<th>Jenis Barang</th>
													<th>Nama Barang</th>
													<th>Ukuran (P x L)</th>
													<th>Panjang</th>
													<th>Lebar</th>
													<th class="text-right">M<sup>2</sup>/Meter</th>
													<th class="text-right">Roll/Lonjor</th>
													<th>Username</th>
												</tr>												
											</thead>
											<tbody>
											<?php
											$result = $con->query("Select branch, date(tanggal) as tanggal, faktur, alasan, penyesuaian, jenis, barang, panjang, lebar, sesuai_panjang, sesuai_lebar, sum(jumlah) as jumlah, username from PENYESUAIAN where branch='$branchL' and (tanggal between '$awal' and '$akhir') group by branch, date(tanggal), faktur, alasan, penyesuaian, jenis, barang, panjang, lebar, sesuai_panjang, sesuai_lebar, username order By date(tanggal), jenis, barang");
											$count = mysqli_num_rows($result);
											if($count>0){
												$no=0;
												$total1=0;
												$total2=0;
												while($row = mysqli_fetch_assoc($result))
												{
													$no++;
													$branch=$row["branch"];
													$tanggal=$row["tanggal"];
													$tanggal=date('d/m/Y', strtotime($tanggal));
													$faktur=$row["faktur"];
													$penyesuaian=$row["penyesuaian"];
													$alasan=$row["alasan"];
													$jenis=$row["jenis"];	
													$barang=$row["barang"];
													$panjang=($row["panjang"]);
													$lebar=($row["lebar"]);
													$sesuai_panjang=($row["sesuai_panjang"]);
													$sesuai_lebar=($row["sesuai_lebar"]);
													$jumlah=$row["jumlah"];
													$total1=$total1+$jumlah;
													if($jenis=="Cleated" or $jenis=="Profile"){
														$ukuran=$panjang."M";
														$roll=$jumlah/($panjang);
													}else{
														$ukuran=$panjang."M x ".$lebar."M";
														$roll=$jumlah/($panjang*$lebar);
													}
													$total2=$total2+$roll;
													$username=$row["username"];													
													echo"
														<tr>
															<td>$no</td>
															<td>$branch</td>
															<td>$tanggal</td>
															<td>$faktur</td>
															<td>$penyesuaian</td>
															<td>$alasan</td>
															<td>$jenis</td>
															<td>$barang</td>
															<td>$ukuran</td>
															<td>$sesuai_panjang</td>
															<td>$sesuai_lebar</td>
															<td class='text-right'>".number_format($jumlah,2)."</td>
															<td class='text-right'>".number_format($roll,2)."</td>
															<td>$username</td>															
														</tr>
													";													
												}
												echo"
														<tr>
															<th colspan='11' class='text-right'> Total</th>
															<th class='text-right'>".number_format($total1,2)."</th>
															<th class='text-right'>".number_format($total2,2)."</th>															
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
						
						
						
						
						
						
					<?php } ?>
					
					
					
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