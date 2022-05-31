<?php
session_start();
include("fc/fc_config.php");
if($_SESSION["iss21"]["authentication"]=="VALID"){
	$filenameImages =$_SESSION["iss21"]["img"];
	$filemtimeImages = filemtime("assets/images/users/".$filenameImages);
	$profile_picture=$filenameImages."?".$filemtimeImages;
	$pages="user-registration.php";
	
	if(!empty($_GET["faktur"])){
		if(strtolower($_GET["faktur"])=="new"){
			if(!empty($_SESSION["iss21"]["faktur"])){
				unset($_SESSION["iss21"]["faktur"]);
			}
		}
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
    <title>Outgoing Transaction :: <?php echo $app_name;?></title>
	<script>
	
	function cek_stok(){
		document.getElementById("btn_save").disabled = true;
		var a=document.getElementById('jual_panjang').value;
		var b=document.getElementById('jual_lebar').value;
		var c=document.getElementById('saldo').value;
		var jenis=document.getElementById('jenis').value;
		
		
		
		
		if (jenis=="Cleated"){
			var penjualan=a;
		}else if (jenis=="Profile"){
			var penjualan=a;
		}else{
			var penjualan=(a/100)*(b/100);
		}
		$('#jumlah').val(penjualan);
		var ceksaldo=(c-penjualan);
		if(ceksaldo<0){
			swal({ 
				position: 'top-end',
				title: 'PERINGATAN',
				text: 'Stok barang tidak mencukupi !!!',
				icon: 'warning',
				dangerMode: true,
				buttons: [false, 'OK']
			})
			$('#jual_panjang').focus();
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
                        <h3 class="text-themecolor">Transaksi Penjualan</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Transaksi Penjualan</li>
                        </ol>
                    </div>										
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-body">
                            <h4 class="card-title">Input Data Penjualan Barang</h4>
                            <h5 class="card-subtitle"> Outgoing <code>Transaction</code> </h5>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <form method="POST" action="">
										<input type="text" name="username" value="<?php echo $_SESSION["iss21"]["fullname"];?>" hidden required="required">
										<input type="text" name="branch" value="<?php echo $_SESSION["iss21"]["branch"];?>" hidden required="required">
                                        
										<div class="row">
											<div class="col-md-2">
												<div class="form-group">
													<label for="tanggal">Tanggal Faktur</label>
													<input class="form-control form-control-line" type="date" name="tanggal" id="tanggal" value="<?php if(!empty($_POST['tanggal'])){echo date('Y-m-d',strtotime($_POST['tanggal']));}else{if(!empty($_GET['tanggal'])){echo date('Y-m-d',strtotime($_GET['tanggal']));}else{echo date("Y-m-d");}}?>" <?php if(!empty($_SESSION["iss21"]["faktur"])){echo "readonly";}?> required="required">
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label for="faktur">Nomor Faktur</label>
													<input type="text" class="form-control" id="faktur" name="faktur" placeholder="Automatic" value="<?php if(!empty($_SESSION["iss21"]["faktur"])){echo $_SESSION["iss21"]["faktur"];}?>" readonly>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-3">
												<div class="form-group">
													<label for="customer">Customer</label>
													<input type="text" class="form-control" id="customer" name="customer" value="<?php if(!empty($_POST['customer'])){echo $_POST['customer'];}else{if(!empty($_GET['customer'])){echo $_GET['customer'];}}?>" <?php if(!empty($_SESSION["iss21"]["faktur"])){echo "readonly";}?> required="required" <?php if(empty($_POST['customer'])){echo "autofocus";} ?>>
												</div>
											</div>
											<div class="col-md-7">
												<div class="form-group">
													<label for="alamat">Alamat Customer</label>
													<input type="text" class="form-control" id="alamat" name="alamat" value="<?php if(!empty($_POST['alamat'])){echo $_POST['alamat'];}else{if(!empty($_GET['alamat'])){echo $_GET['alamat'];}}?>" <?php if(!empty($_SESSION["iss21"]["faktur"])){echo "readonly";}?> required="required" <?php if(empty($_POST['alamat'])){echo "autofocus";} ?>>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label for="telepon">Telepon</label>
													<input type="text" class="form-control" id="telepon" name="telepon" value="<?php if(!empty($_POST['telepon'])){echo $_POST['telepon'];}else{if(!empty($_GET['telepon'])){echo $_GET['telepon'];}}?>" <?php if(!empty($_SESSION["iss21"]["faktur"])){echo "readonly";}?> required="required" <?php if(empty($_POST['telepon'])){echo "autofocus";} ?>>
												</div>
											</div>
										</div>
										
										
										<div class="row">
											<div class="col-md-3">
												<div class="form-group">
													<label>Jenis Barang</label>
													<select class="custom-select col-12" id="jenis" name="jenis" required="required" onchange="this.form.submit()" <?php if(empty($_POST['jenis'])){echo "autofocus";}?>>
														<option value="<?php if(!empty($_POST['jenis'])){echo $_POST['jenis'];}?>"><?php if(!empty($_POST['jenis'])){echo $_POST['jenis'];}else{echo "Pilih...";}?></option>
														<?php
															
															$result = $con->query("Select jenis from BARANG group by jenis order By jenis");
															$count = mysqli_num_rows($result);
															if($count>0){
																while($row = mysqli_fetch_assoc($result))
																{				
																	$jenis=$row["jenis"];
																	echo "<option value='$jenis'>$jenis</option>";
																}
															}												
														?>												
													</select>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Nama Barang</label>
													<select class="custom-select col-12" id="barang" name="barang" required="required" onchange="this.form.submit()" <?php if(empty($_POST['barang'])){echo "autofocus";}?>>
														<option value="<?php if(!empty($_POST['barang'])){echo $_POST['barang'];}?>"><?php if(!empty($_POST['barang'])){echo $_POST['barang'];}else{echo "Pilih...";}?></option>
														<?php						
															if(!empty($_POST["jenis"])){
																$jenis=$_POST["jenis"];
															}else{
																$jenis="";
															}
															$result = $con->query("Select barang from BARANG where jenis='$jenis' group by barang order By barang");
															$count = mysqli_num_rows($result);
															if($count>0){
																while($row = mysqli_fetch_assoc($result))
																{				
																	$barang=$row["barang"];
																	echo "<option value='$barang'>$barang</option>";
																}
															}												
														?>												
													</select>
												</div>
											</div>
										
										
										<?php
										
										
											if(!empty($_POST["jenis"]) and !empty($_POST["barang"])){
												$jenis=$_POST["jenis"];
												$barang=$_POST["barang"];
												$branch=$_SESSION["iss21"]["branch"];
												$result = $con->query("Select a.panjang, a.lebar, b.saldo from BARANG a inner join STOK b on a.jenis=b.jenis and a.barang=b.barang Where b.branch='$branch' and a.jenis='$jenis' and a.barang='$barang'");
												$count = mysqli_num_rows($result);
												if($count>0){
													while($row = mysqli_fetch_assoc($result))
													{
														$panjang=$row["panjang"];
														$lebar=$row["lebar"];
														$lebar=$row["lebar"];
														$saldo=$row["saldo"];
														if(empty($saldo)){$saldo=0;}
														
														if(($saldo-1)<0){
															$_SESSION["iss21"]["info"]="Saldo barang sudah habis !!! ";
														}else{
														
														?>
														
															<div class="col-md-2">
																<div class="form-group">
																	<label for="panjang">Panjang</label>
																	<input type="number" class="form-control" id="panjang" name="panjang" value="<?php if(!empty($panjang)){echo ($panjang/100);}?>" readonly required="required">
																	<small>meter (M)</small>
																</div>
															</div>
															<div class="col-md-2">
																<div class="form-group">
																	<label for="lebar">Lebar</label>
																	<input type="number" class="form-control" id="lebar" name="lebar" value="<?php if(!empty($lebar)){echo ($lebar/100);}?>" readonly required="required">
																	<small>meter (M)</small>
																</div>
															</div>
															<div class="col-md-2">
																<div class="form-group">
																	<label for="saldo">Stok</label>
																	<input type="number" class="form-control" id="saldo" name="saldo" value="<?php if(!empty($saldo)){echo $saldo;}?>" readonly required="required">
																	<?php 
																		if($jenis=="Cleated" or $jenis=="Profile"){
																			echo"<small>dalam Meter</small>";																			
																		}else{
																			echo"<small>dalam M<sup>2</sup></small>";
																		}
																	?>
																	
																</div>
															</div>
																												
														<?
														
														}
													}
												}												
											}
										?>
										</div>
										
										
										<div class="row">
											
											
											<div class="col-md-3">
												<div class="row">
													<div class="col-md-6">	
														<div class="form-group">
															<label for="jual_panjang">Panjang</label>
															<input type="text" class="form-control" id="jual_panjang" name="jual_panjang" oninput="javascript:cek_stok();" onKeyPress="return filter_char(event,'0123456789.',this)" required="required" autofocus>
															<?php 
																if($jenis=="Cleated" or $jenis=="Profile"){
																	echo"<small>input dalam meter (M)</small>";
																}else{
																	echo"<small>input dalam centi meter (CM)</small>";																	
																}
															?>
															
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="jual_lebar">Lebar</label>
															<input type="text" class="form-control" id="jual_lebar" name="jual_lebar" oninput="javascript:cek_stok();" onKeyPress="return filter_char(event,'0123456789.',this)"  value="<?php if($jenis=="Cleated" or $jenis=="Profile"){if(!empty($lebar)){echo ($lebar/100);}}?>"  <?php if($jenis=="Cleated" or $jenis=="Profile"){ echo "readonly";}?>  required="required" autofocus>
															<?php 
																if($jenis=="Cleated" or $jenis=="Profile"){
																	echo"<small>input dalam meter (M)</small>";
																}else{
																	echo"<small>input dalam centi meter (CM)</small>";																	
																}
															?>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-3">										
												<div class="form-group">
													<label for="jumlah">Ukuran Barang Penjualan</label>
													<input type="number" class="form-control" id="jumlah" name="jumlah" required="required" readonly>
													<?php 
														if($jenis=="Cleated" or $jenis=="Profile"){
															echo"<small>dalam Meter</small>";																			
														}else{
															echo"<small>dalam M<sup>2</sup></small>";
														}
													?>
												</div>
											</div>
											<div class="col-md-6">										
												<div class="form-group">
													<label for="harga">Harga</label>
													<input type="number" class="form-control" id="harga" name="harga" required="required" oninput="javascript:cek_stok();" <?php if(empty($_POST['harga'])){echo "autofocus";}?>>
													<small>input dengan harga total</small>
												</div>
											</div>
											<div class="col-md-12">										
												<div class="form-group">
													<button type='submit' class='btn btn-success mr-2' id="btn_save" formaction="fc/fc_add_penjualan.php">Submit</button>
													<button type='reset' class='btn btn-dark mr2'>Cancel</button>
												</div>
											</div>
                                    </form>
										</div>
                                </div>
                            </div>
                        </div>
                    </div>
					
					
					
					
					<?php if(!empty($_POST['faktur']) or !empty($_GET['faktur']) ){?>
						
						
						
						
					<div class="col-md-12">
                        <div class="card card-body">
							<div class="table-responsive">									
								<table class="table table-bordered" id="table">
									<thead>
										<tr>
											<th>#</th>
											<th>Jenis Barang</th>
											<th>Nama Barang</th>
											<th>Ukuran (P x L)</th>
											<th class="text-right">M<sup>2</sup>/ Meter</th>
											<th class="text-right">Roll/Lonjor</th>
											<th class="text-right">Harga</th>
											<th class="text-center">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										
										if(!empty($_SESSION["iss21"]["faktur"])){
											$faktur=$_SESSION["iss21"]["faktur"];
										}else if(!empty($_GET["faktur"])){
											$faktur=$_GET["faktur"];
										}else{
											$faktur="";
										}
										
										if(!empty($_GET['tanggal'])){
											$tanggal=$_GET['tanggal'];
											$tgl=date('Y-m-d',strtotime($tanggal));
										}else if(!empty($_POST['tanggal'])){
											$tanggal=$_POST['tanggal'];
											$tgl=date('Y-m-d',strtotime($tanggal));
										}else{
											$tanggal="";
											$tgl="";
										}
										
										
										$no=0;
										$total1=0;
										$total2=0;
										$total3=0;
										$result = $con->query("Select * from PENJUALAN where DATE(tanggal) = '$tgl' and faktur='$faktur' order By entrydate");
										$count = mysqli_num_rows($result);
										if($count>0){
											while($row = mysqli_fetch_assoc($result))
											{
												$no++;
												$branch=$row["branch"];
												$faktur=$row["faktur"];
												$tanggal=$row["tanggal"];
												$suplier=$row["customer"];												
												$jenis=$row["jenis"];	
												$barang=$row["barang"];
												$panjang=($row["panjang"]);
												$lebar=($row["lebar"]);
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
												$harga=$row["harga"];
												$total3=$total3+$harga;
												$id=$row["id"];
												
												echo"
													<tr>
														<td>$no</td>
														<td>$jenis</td>
														<td>$barang</td>
														<td>$ukuran</td>
														<td class='text-right'>".number_format($jumlah,2)."</td>
														<td class='text-right'>".number_format($roll,2)."</td>
														<td class='text-right'>".number_format($harga)."</td>
														<td align='center' nowrap>
															<a class='btn btn-danger btn-sm' href='fc/fc_delete_penjualan.php?id=$id' title='Hapus Data Penjualan Barang ini'> <i class='fa fa-trash'></i> Delete</a>
														</td>
													</tr>
												";
												
											}
										}
										
										?> 
										<tr>
											<td colspan="4" align="right">Total</td>
											<td class='text-right'><?php echo number_format($total1,2);?></td>
											<td class='text-right'><?php echo number_format($total2,2);?></td>
											<td class='text-right'><?php echo number_format($total3);?></td>
										</tr>	
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
	<!--Function Filter Character-->
	
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