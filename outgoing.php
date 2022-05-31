<?php
session_start();
include("fc/fc_config.php");
if($_SESSION["iss21"]["authentication"]=="VALID"){
	$filenameImages =$_SESSION["iss21"]["img"];
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
    <title>Outgoing Transaction :: <?php echo $app_name;?></title>
	
	<style>
		@media screen {			
			.Sembunyikan{
				display: none;
			}			
		}
		@media print {
		  html, body {
			/*width: 8.5in;*/
			/*height: 5.5in;*/
			display: block;
			/*
			font-family: "Calibri";
			font-size: auto;
			*/
			
			font-family:"Courier New", Courier, monospace;
			font-size:auto;
		  }

		  @page
		   {
			/*size: 5.5in 8.5in;*/
		  }

		}
	</style>	
	<style>            
		.autocomplete-suggestions {
			border: 1px solid #999;
			background: #FFF;
			overflow: auto;
		}
		.autocomplete-suggestion {
			padding: 2px 5px;
			white-space: nowrap;
			overflow: hidden;
		}
		.autocomplete-selected {
			background: #F0F0F0;
		}
		.autocomplete-suggestions strong {
			font-weight: normal;
			color: #3399FF;
		}
		.autocomplete-group {
			padding: 2px 5px;
		}
		.autocomplete-group strong {
			display: block;
			border-bottom: 1px solid #000;
		}
	</style>
	<script>	
		function cek_stok(){
			document.getElementById("btn_save").disabled = true;
			var a=document.getElementById('stok').value;
			var b=document.getElementById('qty').value;
			
			var ceksaldo=(a-b);
			if(ceksaldo<0){
				swal({ 
					position: 'top-end',
					title: 'PERINGATAN',
					text: 'Stok barang tidak mencukupi !!!',
					icon: 'warning',
					dangerMode: true,
					buttons: [false, 'OK']
				})
				document.getElementById("qty").focus();
				document.getElementById("btn_save").disabled = true;
			}else{
				document.getElementById("btn_save").disabled = false;			
			}
			get_disc();
		}
		
		function get_disc(){
			
			document.getElementById("btn_save").disabled = true;
			var x=document.getElementById('qty').value;
			var y=document.getElementById('harga_jual').value;
			
			if(x==""){x=0;}
			if(y==""){y=0;}			
			document.getElementById('total_harga').value=x*y;
			
			var a=document.getElementById('diskon').value;
			
			if(a==""){a=0;}
			
			var cekdisc1=(a-100);
			
			if(cekdisc1>0){
				swal({ 
					position: 'top-end',
					title: 'PERINGATAN',
					text: 'Persentase tidak boleh melebihi 100%',
					icon: 'warning',
					dangerMode: true,
					buttons: [false, 'OK']
				})
				$('#diskon').focus();
				document.getElementById("btn_save").disabled = true;
			}else{
				e=(x*y)-(x*y*a/100);
				document.getElementById('total_hitung').value=e;
				document.getElementById('potongan').value=document.getElementById('total_harga').value-e;
				
				if(e<1){
					swal({ 
						position: 'top-end',
						title: 'PERINGATAN',
						text: 'Total potongan harga melebihi nilai jual barang!',
						icon: 'warning',
						dangerMode: true,
						buttons: [false, 'OK']
					})
					$('#diskon').focus();
					document.getElementById("btn_save").disabled = true;
				}else{					
					document.getElementById("btn_save").disabled = false;
				}
				
				
				
							
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
                        <h3 class="text-themecolor">Outgoing</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Outgoing Transaction</li>
                        </ol>
                    </div>
					<div class="col-md-7 align-self-center text-right d-none d-md-block">
                        <!--<button onclick="printContent('cetak')" class="btn btn-primary text-right"><i class="fa fa-print"></i> Print</button>-->
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-body">
                            <h4 class="card-title">Outgoing Transaction</h4>
                            <h5 class="card-subtitle"> New Outgoing <code>Transaction</code> </h5>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
								
									<?php
										if(!empty($_POST['branch'])){$branch=$_POST["branch"];}else{if(!empty($_GET["branch"])){$branch=$_GET["branch"];}else{$branch=$_SESSION["iss21"]["branch"];}}
										if(!empty($_POST['tanggal'])){
											$tanggal=date('Y-m-d',strtotime($_POST['tanggal']));
										}else{
											if(!empty($_GET['tanggal'])){
												$tanggal=date('Y-m-d',strtotime($_GET['tanggal']));
											}else{
												$tanggal=date("Y-m-d");
											}
										}
										if(!empty($_POST['tglpo'])){
											$tglpo=date('Y-m-d',strtotime($_POST['tglpo']));
										}else{
											if(!empty($_GET['tglpo'])){
												$tglpo=date('Y-m-d',strtotime($_GET['tglpo']));
											}else{
												$tglpo=date("Y-m-d");
											}
										}
										if(!empty($_POST['tgltempo'])){
											$tgltempo=date('Y-m-d',strtotime($_POST['tgltempo']));
										}else{
											if(!empty($_GET['tgltempo'])){
												$tgltempo=date('Y-m-d',strtotime($_GET['tgltempo']));
											}else{
												$tgltempo = date("Y-m-d", time() + (14*86400));
											}
										}
										if(!empty($_POST['tipe_outgoing'])){$tipe_outgoing=$_POST['tipe_outgoing'];}else{if(!empty($_GET['tipe_outgoing'])){$tipe_outgoing=$_GET['tipe_outgoing'];}else{$tipe_outgoing="";}}
										if(!empty($_POST['faktur'])){$faktur=$_POST['faktur'];}else{if(!empty($_GET['faktur'])){$faktur=$_GET['faktur'];}else{$faktur="";}}
										if(!empty($_POST['po'])){$po=$_POST['po'];}else{if(!empty($_GET['po'])){$po=$_GET['po'];}else{$po="";}}
										if(!empty($_POST['kode_customer'])){$kode_customer=$_POST['kode_customer'];}else{if(!empty($_GET['kode_customer'])){$kode_customer=$_GET['kode_customer'];}else{$kode_customer="";}}
										if(!empty($_POST['customer'])){$customer=$_POST['customer'];}else{if(!empty($_GET['customer'])){$customer=$_GET['customer'];}else{$customer="";}}
										if(!empty($_POST['address'])){$address=$_POST['address'];}else{if(!empty($_GET['address'])){$address=$_GET['address'];}else{$address="";}}
										if(!empty($_POST['phone'])){$phone=$_POST['phone'];}else{if(!empty($_GET['phone'])){$phone=$_GET['phone'];}else{$phone="";}}
										if(!empty($_POST['contact'])){$contact=$_POST['contact'];}else{if(!empty($_GET['contact'])){$contact=$_GET['contact'];}else{$contact="";}}
										
										if(!empty($_POST['userid'])){$userid=$_POST['userid'];}else{if(!empty($_GET['userid'])){$userid=$_GET['userid'];}else{$userid="";}}
										if(!empty($_POST['salesman'])){$salesman=$_POST['salesman'];}else{if(!empty($_GET['salesman'])){$salesman=$_GET['salesman'];}else{$salesman="";}}
										if(!empty($_POST['address_salesman'])){$address_salesman=$_POST['address_salesman'];}else{if(!empty($_GET['address_salesman'])){$address_salesman=$_GET['address_salesman'];}else{$address_salesman="";}}
										if(!empty($_POST['phone_salesman'])){$phone_salesman=$_POST['phone_salesman'];}else{if(!empty($_GET['phone_salesman'])){$phone_salesman=$_GET['phone_salesman'];}else{$phone_salesman="";}}
										
										if(!empty($_POST['kode'])){$kode=$_POST['kode'];}else{if(!empty($_GET['kode'])){$kode=$_GET['kode'];}else{$kode="";}}
										if(!empty($_POST['jenis'])){$jenis=$_POST['jenis'];}else{if(!empty($_GET['jenis'])){$jenis=$_GET['jenis'];}else{$jenis="";}}
										if(!empty($_POST['subgroup'])){$subgroup=$_POST['subgroup'];}else{if(!empty($_GET['subgroup'])){$subgroup=$_GET['subgroup'];}else{$subgroup="";}}
										if(!empty($_POST['merk'])){$merk=$_POST['merk'];}else{if(!empty($_GET['merk'])){$merk=$_GET['merk'];}else{$merk="";}}
										if(!empty($_POST['barang'])){$barang=$_POST['barang'];}else{if(!empty($_GET['barang'])){$barang=$_GET['barang'];}else{$barang="";}}
										if(!empty($_POST['satuan'])){$satuan=$_POST['satuan'];}else{if(!empty($_GET['satuan'])){$satuan=$_GET['satuan'];}else{$satuan="";}}										
										if(!empty($_POST['qty'])){$qty=$_POST['qty'];}else{if(!empty($_GET['qty'])){$qty=$_GET['qty'];}else{$qty="";}}
										if(!empty($_POST['descr'])){$descr=$_POST['descr'];}else{if(!empty($_GET['descr'])){$descr=$_GET['descr'];}else{$descr="";}}
										if(!empty($_POST['harga_beli'])){$harga_beli=$_POST['harga_beli'];}else{if(!empty($_GET['harga_beli'])){$harga_beli=$_GET['harga_beli'];}else{$harga_beli="";}}
										if(!empty($_POST['harga_jual'])){$harga_jual=$_POST['harga_jual'];}else{if(!empty($_GET['harga_jual'])){$harga_jual=$_GET['harga_jual'];}else{$harga_jual="";}}
										if(!empty($_POST['ongkir'])){$ongkir=$_POST['ongkir'];}else{if(!empty($_GET['ongkir'])){$ongkir=$_GET['ongkir'];}else{$ongkir=0;}}
										if(!empty($_POST['biaya_lainnya'])){$biaya_lainnya=$_POST['biaya_lainnya'];}else{if(!empty($_GET['biaya_lainnya'])){$biaya_lainnya=$_GET['biaya_lainnya'];}else{$biaya_lainnya=0;}}
										
										if(!empty($kode_customer)){
											$result = $con->query("Select * from CUSTOMER where kode='$kode_customer'");											
											while($row = mysqli_fetch_assoc($result))
											{
												$customer=$row["customer"];
												$address=$row["address"];
												$phone=$row["phone"];
												$contact=$row["contact"];		
											}											
										}
										if(!empty($userid)){
											$result = $con->query("Select * from TBLLOGIN where userid='$userid' and position='Salesman'");											
											while($row = mysqli_fetch_assoc($result))
											{
												$salesman=$row["fullname"];
												$address_salesman=$row["address"];
												$phone_salesman=$row["phone"];
											}											
										}
										
									?>
									
                                    <form method="POST" action="">										
										<input type="text" name="username" value="<?php echo $_SESSION["iss21"]["fullname"];?>" hidden required="required">										
										
										<div class="row">
											
											<div class="col-md-12">
												<div class="row">
													<div class="col-md-4">
														<div class="form-group">
															<label for="tanggal">Tanggal</label>
															<input class="form-control form-control-line" type="date" name="tanggal" id="tanggal" value="<?php echo $tanggal; ?>" <?php if(!empty($faktur)){echo "readonly";} ?> required="required">
														</div>
													</div>
													<div class="col-md-4" hidden>
														<div class="form-group">
															<label for="faktur">Nomor Faktur</label>
															<input type="text" class="form-control" id="faktur" name="faktur" value="<?php  echo $faktur; ?>"  readonly>
														</div>
													</div>
													<div class="col-md-4">
                        								<div class="form-group">
                        									<label>Tipe Outgoing</label>
                        									<select class="custom-select col-12" id="tipe_outgoing" name="tipe_outgoing" required="required">
                        										<option value="" selected disabled>Choose...</option>
                        										<option value="INVOICE">INVOICE</option>
                        										<option value="FOC">FOC</option>																
                        									</select>
                        								</div>
                        							</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="po">No. PO</label>
															<input type="text" class="form-control" id="po" name="po" value="<?php  echo $po; ?>"  required="required"  <?php if(empty($po)){echo "autofocus";} ?> <?php if(!empty($po)){echo "readonly";} ?>>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="tglpo">Tgl PO</label>
															<input class="form-control form-control-line" type="date" name="tglpo" id="tglpo" value="<?php echo $tglpo; ?>" required="required">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="tgltempo">Tgl Jatuh Tempo</label>
															<input class="form-control form-control-line" type="date" name="tgltempo" id="tgltempo" value="<?php echo $tgltempo; ?>" required="required">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="customer">Customer</label>
															<input type="text" class="form-control" id="customer" name="customer" onChange="getCustomer(this.value)" value="<?php  echo $customer; ?>" required="required"  <?php if(empty($customer)){echo "autofocus";} ?> <?php if(!empty($faktur)){echo "readonly";} ?>>
															<small>Isi dengan sebagian nama customer dan pilih</small>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="address">Address</label>
															<input type="text" class="form-control" id="address" name="address" value="<?php  echo $address; ?>"  <?php if(empty($address)){echo "autofocus";} ?> readonly required="required">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="ongkir">Ongkir</label>
															<input type="number" class="form-control" id="ongkir" name="ongkir" value="<?php  echo $ongkir; ?>" required="required"  <?php if(empty($ongkir)){echo "autofocus";} ?>>
													    </div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="biaya_lainnya">Biaya Lainnya</label>
															<input type="int" class="form-control" id="biaya_lainnya" name="biaya_lainnya" value="<?php  echo $biaya_lainnya; ?>" required="required"  <?php if(empty($biaya_lainnya)){echo "autofocus";} ?>>
													    </div>
													</div>
												</div>
												
												<div class="row" hidden>
													<div class="col-md-4">
														<div class="form-group">
															<label for="phone">Phone</label>
															<input type="text" class="form-control" id="phone" name="phone" value="<?php  echo $phone; ?>"  <?php if(empty($phone)){echo "autofocus";} ?> readonly required="required">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="contact">Contact</label>
															<input type="text" class="form-control" id="contact" name="contact" value="<?php  echo $contact; ?>" required="required"  readonly >
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="kode_customer">Customer Code</label>
															<input type="text" class="form-control" id="kode_customer" name="kode_customer" value="<?php  echo $kode_customer; ?>" required="required"  readonly >
														</div>
													</div>
												</div>
												
											</div>
											<div class="col-md-12">
											
												<div class="row">										
													<div class="col-md-8">
														<div class="form-group">
															<label for="barang">Item Description</label>
															<input class="form-control form-control-line" type="text" name="barang" id="barang" onChange="getItem(this.value)" value="<?php echo $barang; ?>" <?php if(empty($barang)){echo "autofocus";} ?> required="required">
															<small>Isi dengan sebagian group, merk atau nama barang dan pilih</small>
														</div>
													</div>
													<div class="col-md-4">
        												<div class="form-group">
        													<label for="kode">Kode</label>
        													<input class="form-control form-control-line" type="text" name="kode" id="kode" value="<?php echo $kode; ?>" readonly>
        												</div>
        											</div>
        											<div class="col-md-4">
        												<div class="form-group">
        													<label for="jenis">Group</label>
        													<input class="form-control form-control-line" type="text" name="jenis" id="jenis" value="<?php echo $jenis; ?>" readonly required="required">
        												</div>
        											</div>
        											<div class="col-md-4">
        												<div class="form-group">
        													<label for="subgroup">Sub Group</label>
        													<input class="form-control form-control-line" type="text" name="subgroup" id="subgroup" value="<?php echo $subgroup; ?>" readonly required="required">
        												</div>
        											</div>
        											<div class="col-md-4">
        												<div class="form-group">
        													<label for="merk">Merk</label>
        													<input class="form-control form-control-line" type="text" name="merk" id="merk" value="<?php echo $merk; ?>" readonly required="required">
        												</div>
        											</div>
        											<div class="col-md-4">
        												<div class="form-group">
        													<label for="satuan">Unit</label>
        													<input class="form-control form-control-line" type="text" name="satuan" id="satuan" value="<?php echo $satuan; ?>" readonly>
        												</div>
        											</div>
        											<div class="col-md-4" hidden>
        												<div class="form-group">
        													<label for="harga_beli">Harga Beli</label>
        													<input type="number" class="form-control" id="harga_beli" name="harga_beli" value="<?php if(!empty($harga_beli)){echo $harga_beli;}?>" onchange="convertToRupiah(this);" required="required">
        												</div>
        											</div>
        											<div class="col-md-4">
														<div class="form-group">
															<label for="stok">Stock</label>
															<input type="number" class="form-control" id="stok" name="stok" value="<?php if(!empty($stok)){echo $stok;}?>" required="required" readonly>
														</div>
													</div>
													<div class="col-md-4" <?php if($_SESSION["iss21"]["position"]=="Gudang"){echo "hidden";}?> >
														<div class="form-group">
															<label for="harga_jual">Price</label>
															<input type="number" class="form-control" id="harga_jual" name="harga_jual" value="<?php if(!empty($harga_jual)){echo $harga_jual;}?>" required="required">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="qty">Qty</label>
															<input type="number" class="form-control" id="qty" name="qty" value="<?php if(!empty($qty)){echo $qty;}?>" oninput="javascript:cek_stok();" required="required">
														</div>
													</div>
													<div class="col-md-4" hidden>
														<div class="form-group">
															<label for="diskon">Discount</label>
															<input type="number" class="form-control" id="diskon" name="diskon" value="<?php if(!empty($diskon)){echo $diskon;}?>" oninput="javascript:get_disc();">
															<small> dalam persentase (%) </small>
														</div>
													</div>
													<div class="col-md-4" <?php if($_SESSION["iss21"]["position"]=="Gudang"){echo "hidden";}?>>
														<div class="form-group">
															<label for="total_harga">Subtotal</label>
															<input type="number" class="form-control" id="total_harga" name="total_harga" value="<?php if(!empty($total_harga)){echo $total_harga;}?>" readonly required="required">
															<small> dalam rupiah (Rp) </small>
														</div>
													</div>
													<div class="col-md-4" hidden>
														<div class="form-group">
															<label for="potongan">Potongan</label>
															<input type="number" class="form-control" id="potongan" name="potongan" value="<?php if(!empty($potongan)){echo $potongan;}?>" readonly required="required">
															<small> dalam rupiah (Rp) </small>
														</div>
													</div>
													<div class="col-md-4" <?php if($_SESSION["iss21"]["position"]=="Gudang"){echo "hidden";}?>>
														<div class="form-group">
															<label for="total_hitung">Total</label>
															<input type="number" class="form-control" id="total_hitung" name="total_hitung" value="<?php if(!empty($total_hitung)){echo $total_hitung;}?>" readonly required="required">
															<small> dalam rupiah (Rp) </small>
														</div>
													</div>
													<div class="col-md-12">
        												<div class="form-group">
        													<label for="descr">Note</label>
        													<input type="text" class="form-control" id="descr" name="descr" value="<?php if(!empty($descr)){echo $descr;}?>" required="required">
        												</div>
        											</div>
													
													
												</div>
												<div class="row">
													<div class="col-md-12">
														<button type="submit" class="btn btn-success mr-2" formaction="fc/fc_add_outgoing.php" id="btn_save"><i class="fa fa-paper-plane"></i> Submit</button>
														<!--<button type="reset" class='btn btn-dark mr2'><i class="fa fa-refresh"></i> Reset</button>-->
														
													</div>
												</div>
											
											</div>
											
										</div>
										
																				
										
										
										
										
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				
				<div class="row">
                    <div class="col-12">
                        <div class="card card-body">
							<div class="text-right">
								<?php
								    if($_SESSION["iss21"]["position"]=="Admin"){
									echo" <a class='btn btn-primary btn-sm text-right' href='faktur-print.php?branch=$branch&tanggal=$tanggal&faktur=$faktur&kode_customer=$kode_customer&po=$po&tglpo=$tglpo&tgltempo=$tgltempo&ongkir=$ongkir&biaya_lainnya=$biaya_lainnya&tipe_outgoing=$tipe_outgoing&halaman=outgoing'><i class='fa fa-print'></i> Faktur</a>";						
									echo" <a class='btn btn-info btn-sm text-right' href='sj-print.php?branch=$branch&tanggal=$tanggal&faktur=$faktur&kode_customer=$kode_customer&po=$po&tglpo=$tglpo&tgltempo=$tgltempo&ongkir=$ongkir&biaya_lainnya=$biaya_lainnya&tipe_outgoing=$tipe_outgoing&halaman=outgoing'><i class='fa fa-print'></i> Surat Jalan</a>";						
								    }else{
								    echo" <a class='btn btn-info btn-sm text-right' href='sj-print.php?branch=$branch&tanggal=$tanggal&faktur=$faktur&kode_customer=$kode_customer&po=$po&tglpo=$tglpo&tgltempo=$tgltempo&ongkir=$ongkir&biaya_lainnya=$biaya_lainnya&tipe_outgoing=$tipe_outgoing&halaman=outgoing'><i class='fa fa-print'></i> Surat Jalan</a>";						    
								    }
								?>
							</div>
							<div class="col-sm-12 col-xs-12">
								<div class="table-responsive">									
									<table class="table table-sm table-striped table-hover table-bordered" id="data-table">
										<thead>
											<tr>
												<th>No</th>		
												<th>Code</th>
												<th>Group</th>
												<th>Sub Group</th>
												<th>Merk</th>
												<th>Item Description</th>
												<th>Unit</th>
												<?php 
												    if($_SESSION["iss21"]["position"]=="Gudang"){
												    }else{
												        ?>
												        <th class='text-right'>Price</th>
        												<th class='text-right'>Qty</th>
        												<th class='text-right'>Disc</th>
        												<th class='text-right'>Total</th>
												        <?php
												    }
												?>
												
												<th class="text-center">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php											
											$count=0;
											$no=0;
											$Qbranch=$_SESSION["iss21"]["branch"];
											$sql="Select * from OUTGOING where branch='$Qbranch' and tanggal='$tanggal' and faktur='$faktur' order By id";
											$result = $con->query($sql);
											$count = mysqli_num_rows($result);
											if($count>0){
												while($row = mysqli_fetch_assoc($result))
												{
													$no++;
													$branch2=$row["branch"];	
													$faktur2=$row["faktur"];
													$tanggal1=$row["tanggal"];
													$tanggal2=date('d/m/Y',strtotime($tanggal1));
													$kode2=$row["kode"];
													$jenis2=$row["jenis"];
													$subgroup2=$row["subgroup"];
													$merk2=$row["merk"];
													$barang2=$row["barang"];
													$satuan2=$row["satuan"];
													$qty2=$row["qty"];
													$diskon2=$row["diskon"];
													$harga_beli2=$row["harga_beli"];
													$harga_jual2=$row["harga_jual"];
													
													$disc=($qty2*$harga_jual2)*($diskon2*0.01);
													
													$id2=$row["id"];
													
													echo"
														<tr>
															<td>$no</td>																													
															<td>$kode2</td>
															<td>$jenis2</td>
															<td>$subgroup2</td>
															<td>$merk2</td>
															<td>$barang2</td>
															<td>$satuan2</td>";
															
															if($_SESSION["iss21"]["position"]=="Gudang"){
												            }else{
    															echo"
    															<td align='right'>".number_format($harga_jual2)."</td>
    															<td align='right'>".number_format($qty2)."</td>	
    															<td align='right' nowrap>$diskon2% (".number_format($disc).")</td>	
    															<td align='right'>".number_format(($harga_jual2*$qty2)-$disc)."</td>
    															";
												            }
												    echo"
															<td align='center' nowrap>
																<a class='btn btn-danger btn-sm' href='fc/fc_delete_outgoing.php?id=$id2&tanggal=$tanggal1&faktur=$faktur&kode_customer=$kode_customer&po=$po&tglpo=$tglpo&tipe_outgoing=$tipe_outgoing' title='Delete'><i class='fa fa-trash'></i> Delete</a>
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
				
							
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>
		
		
		
		
		<!--End Content-->

        <?php include("inc/footer_details.php");?>
        </div>
    </div>
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/jquery.autocomplete.min.js"></script>
	<script src="js/datatables/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.responsive.min.js"></script>	
	<script type="text/javascript">
		$('#data-table').DataTable({
			"responsive": true,
			"autoWidth": false,
			"lengthMenu": [[ 10, 25, 50, 100, -1], [ 10, 25, 50, 100, "All"]],
			"order": [[ 0, 'asc' ],]
		});
	</script>
	
	<script type="text/javascript">
		$("#customer").autocomplete({
			serviceUrl: "autocomplete_customer.php",
			dataType: "JSON",
			onSelect: function (suggestion) {
				$("#customer").val("" + suggestion.customer);
				var s=document.getElementById('customer').value;
				getCustomer(s);
			}
		});
		function getCustomer(val){
			$.post('get_customer.php',{data:val},function(result){
				$('#customer').val(result.customer);
				$('#address').val(result.address);
				$('#phone').val(result.phone);
				$('#contact').val(result.contact);
				$('#kode_customer').val(result.kode);
				document.getElementById("salesman").focus();
			}, "json");				
		}
		
		$("#salesman").autocomplete({
			serviceUrl: "autocomplete_salesman.php",
			dataType: "JSON",
			onSelect: function (suggestion) {
				$("#salesman").val("" + suggestion.salesman);
				var s=document.getElementById('salesman').value;
				getSalesman(s);
			}
		});
		function getSalesman(val){
			$.post('get_salesman.php',{data:val},function(result){
				$('#salesman').val(result.fullname);
				$('#address_salesman').val(result.address);
				$('#phone_salesman').val(result.phone);
				$('#userid').val(result.userid);
				document.getElementById("barang").focus();
			}, "json");				
		}
		
		$("#barang").autocomplete({
			serviceUrl: "autocomplete_barcode.php",
			dataType: "JSON",
			onSelect: function (suggestion) {
				$("#barang").val("" + suggestion.barcode);
				var a=document.getElementById('barang').value;
				getItem(a);
			}
		});
		function getItem(val){
			$.post('get_barcode.php',{data:val},function(result){
				$('#kode').val(result.kode);
				$('#jenis').val(result.jenis);
				$('#subgroup').val(result.subgroup);
				$('#merk').val(result.merk);
				$('#barang').val(result.barang);
				$('#satuan').val(result.satuan);
				$('#harga_beli').val(result.harga_beli);
				$('#harga_jual').val(result.harga_jual);
				$('#stok').val(result.stok);
				document.getElementById("qty").focus();
			}, "json");				
		}
		
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