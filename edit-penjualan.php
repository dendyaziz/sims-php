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
			if(!empty($faktur)){
				unset($faktur);
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
    <title>Editing :: <?php echo $app_name;?></title>
	<script>
	
	function cek_stok(){
		document.getElementById("btn_save").disabled = true;
		var a=document.getElementById('jual_panjang').value;
		var b=document.getElementById('jual_lebar').value;
		var d=document.getElementById('awal').value;
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
		penjualan=penjualan-d;
		
		var ceksaldo=(c-penjualan);
		if(ceksaldo<0){
			swal({ 
				position: 'top-end',
				title: 'PERINGATAN',
				text: 'Stok barang tidak mencukupi !!!'+c+','+penjualan+','+d,
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
                        <h3 class="text-themecolor">Edit Transaksi Penjualan</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Edit Transaksi Penjualan</li>
                        </ol>
                    </div>										
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-body">
							<?php
								$branch=$_SESSION["iss21"]["branch"];
								if(!empty($_POST["faktur"])){
									$faktur=$_POST["faktur"];
									$result = $con->query("Select customer, alamat, telepon, date(tanggal) as tanggal from PENJUALAN where faktur='$faktur' group by customer, alamat, telepon, date(tanggal)");
									$count = mysqli_num_rows($result);
									if($count>0){
										while($row = mysqli_fetch_assoc($result))
										{				
											$customer=$row["customer"];
											$alamat=$row["alamat"];
											$telepon=$row["telepon"];
											$tanggal=$row["tanggal"];
											$tgl=date('Y-m-d',strtotime($tanggal));
										}
									}
								}
								if(!empty($_GET["id"])){
									$id=$_GET["id"];
									$result = $con->query("Select a.faktur, a.tanggal, a.customer, a.alamat, a.telepon, a.jenis, a.barang, a.panjang, a.lebar, a.jual_panjang, a.jual_lebar, a.harga, a.jumlah, b.saldo from PENJUALAN a inner join STOK b on a.jenis=b.jenis and a.barang=b.barang and a.branch=b.branch where a.id='$id'");
									$count = mysqli_num_rows($result);
									if($count>0){
										while($row = mysqli_fetch_assoc($result))
										{				
											$faktur=$row["faktur"];
											$customer=$row["customer"];
											$alamat=$row["alamat"];
											$telepon=$row["telepon"];
											$tanggal=$row["tanggal"];
											$tgl=date('Y-m-d',strtotime($tanggal));
											$jenis=$row["jenis"];
											$barang=$row["barang"];
											$panjang=$row["panjang"];
											$lebar=$row["lebar"];
											$jual_panjang=$row["jual_panjang"];
											$jual_lebar=$row["jual_lebar"];
											$jumlah=$row["jumlah"];
											
											$saldo=$row["saldo"];
											if(empty($saldo)){$saldo=0;}
											
										}
									}
								}
															
							?>
                            <h4 class="card-title">Edit Transaksi Penjualan Barang</h4>
                            <h5 class="card-subtitle"> Edit <code>Outgoing Transaction</code> </h5>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <form method="POST" action="">
										<input type="text" name="username" value="<?php echo $_SESSION["iss21"]["fullname"];?>" hidden required="required">
										<input type="text" name="branch" value="<?php echo $_SESSION["iss21"]["branch"];?>" hidden required="required">
										<input type="text" name="id" value="<?php echo $id;?>" hidden required="required">
										<input type="text" name="awal" id="awal" value="<?php echo $jumlah;?>" hidden required="required">
                                        
										<div class="row">
											<div class="col-md-3">
												<div class="form-group">
													<label for="faktur">Nomor Faktur</label>
													<input type="text" class="form-control" id="faktur" name="faktur" onchange="this.form.submit()" value="<?php if(!empty($faktur)){echo $faktur;}?>" <?php if(!empty($faktur)){echo "readonly";}?> <?php if(empty($faktur)){echo "autofocus";}?>>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="tanggal">Tanggal Faktur</label>
													<input class="form-control form-control-line" type="date" name="tanggal" id="tanggal" value="<?php if(!empty($tgl)){echo $tgl;}?>" readonly required="required">
												</div>
											</div>
											
										</div>
										
										<div class="row">
											<div class="col-md-3">
												<div class="form-group">
													<label for="customer">Customer</label>
													<input type="text" class="form-control" id="customer" name="customer" value="<?php if(!empty($customer)){echo $customer;}?>" required="required" readonly>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="alamat">Alamat</label>
													<input type="text" class="form-control" id="alamat" name="alamat" value="<?php if(!empty($alamat)){echo $alamat;}?>" required="required" readonly>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="telepon">Telepon</label>
													<input type="text" class="form-control" id="telepon" name="telepon" value="<?php if(!empty($telepon)){echo $telepon;}?>" required="required" readonly>
												</div>
											</div>
										</div>
										
										
										<div class="row">
											<div class="col-md-3">
												<div class="form-group">
													<label for="jenis">Jenis Barang</label>
													<input type="text" class="form-control" id="jenis" name="jenis" value="<?php if(!empty($jenis)){echo $jenis;}?>" required="required" readonly>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="barang">Nama Barang</label>
													<input type="text" class="form-control" id="barang" name="barang" value="<?php if(!empty($barang)){echo $barang;}?>" required="required" readonly>
												</div>
											</div>
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
													<small>dalam M<sup>2</sup></small>
												</div>
											</div>
										
										</div>
										
										
										<div class="row">
											
											
											<div class="col-md-3">
												<div class="row">
													<div class="col-md-6">	
														<div class="form-group">
															<label for="jual_panjang">Panjang</label>
															<input type="text" class="form-control" id="jual_panjang" name="jual_panjang" oninput="javascript:cek_stok();" onKeyPress="return filter_char(event,'0123456789.',this)" value="<?php if(!empty($jual_panjang)){echo $jual_panjang;}?>"  <?php if(empty($id)){echo "readonly";}?> required="required" autofocus>
															<small>input dalam centi meter (CM)</small>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="jual_lebar">Lebar</label>
															<input type="text" class="form-control" id="jual_lebar" name="jual_lebar" oninput="javascript:cek_stok();" onKeyPress="return filter_char(event,'0123456789.',this)" value="<?php if($jenis=="Cleated" or $jenis=="Profile"){if(!empty($jual_lebar)){echo jual_lebar;}}?>"  <?php if($jenis=="Cleated" or $jenis=="Profile"){ echo "readonly";}?> <?php if(empty($id)){echo "readonly";}?> required="required" autofocus>
															<small>input dalam centi meter (CM)</small>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-3">										
												<div class="form-group">
													<label for="jumlah">Ukuran Barang Penjualan</label>
													<input type="number" class="form-control" id="jumlah" name="jumlah" required="required" value="<?php if(!empty($jumlah)){echo $jumlah;}?>" readonly>
													<small>dalam M<sup>2</sup></small>
												</div>
											</div>
											<div class="col-md-6">										
												<div class="form-group">
													<label for="harga">Harga</label>
													<input type="number" class="form-control" id="harga" name="harga" required="required" oninput="javascript:cek_stok();" value="<?php if(!empty($harga)){echo $harga;}?>" <?php if(empty($id)){echo "readonly";}?> <?php if(empty($_POST['harga'])){echo "autofocus";}?>>
													<small>input dengan harga total</small>
												</div>
											</div>
											<div class="col-md-12">										
												<div class="form-group">
													<button type='submit' class='btn btn-success mr-2' id="btn_save" formaction="fc/fc_edit_penjualan.php">Submit</button>
													<button type='reset' class='btn btn-dark mr2'>Cancel</button>
												</div>
											</div>
										
                                    </form>
										</div>
                                </div>
                            </div>
                        </div>
                    </div>
					
					
					
					
					<?php if($faktur){?>
						
						
						
						
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
										
										$no=0;
										$total1=0;
										$total2=0;
										$total3=0;
										$result = $con->query("Select * from PENJUALAN where jenis not in ('Cleated','Profile') and DATE(tanggal) = '$tgl' and faktur='$faktur' order By entrydate");
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
															<a class='btn btn-primary btn-sm' href='edit-penjualan.php?id=$id' title='Hapus Data Penjualan Barang ini'> <i class='fa fa-edit'></i> Edit</a>
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
										
										$no=0;
										$total1=0;
										$total2=0;
										$total3=0;
										$result = $con->query("Select * from PENJUALAN where jenis in ('Cleated','Profile') and DATE(tanggal) = '$tgl' and faktur='$faktur' order By entrydate");
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
														<td class='text-right'>".number_format($jumlah)."</td>
														<td class='text-right'>".number_format($roll,2)."</td>
														<td class='text-right'>".number_format($harga)."</td>
														<td align='center' nowrap>
															<a class='btn btn-primary btn-sm' href='edit-penjualan.php?id=$id' title='Hapus Data Penjualan Barang ini'> <i class='fa fa-edit'></i> Edit</a>
															<a class='btn btn-danger btn-sm' href='fc/fc_delete_penjualan.php?id=$id' title='Hapus Data Penjualan Barang ini'> <i class='fa fa-trash'></i> Delete</a>
														</td>
													</tr>
												";
												
											}
										}
										
										?> 
										<tr>
											<td colspan="4" align="right">Total</td>
											<td class='text-right'><?php echo number_format($total1);?></td>
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