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
    <title>Cetak Ulang Faktur :: <?php echo $app_name;?></title>
	
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
                        <h3 class="text-themecolor">Tanda Terima</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Cetak Tanda Terima</li>
                        </ol>
                    </div>	
					<div class="col-md-7 align-self-center text-right d-none d-md-block">
                        <!--<button onclick="printContent('cetak')" class="btn btn-primary text-right"><i class="fa fa-print"></i> Print</button>-->
                    </div>
                </div>
				<div class="row">
                    <div class="col-12">
                        <div class="card card-body">
							<div class="col-sm-12 col-xs-12">
								<?php
										
									if(!empty($_POST['branch'])){
										$branch=$_POST["branch"];
									}else{
										
										if(!empty($_GET["branch"])){
											$branch=$_GET["branch"];
										}else{
											
											if(strtolower($_SESSION["iss21"]["level"])=="admin"){
												$branch="All Branch";
											}else{
												$branch=$_SESSION["iss21"]["branch"];
											}
											
										}
									}
									
									if(!empty($_POST['tanggal'])){
										$tanggal=date('Y-m-d',strtotime($_POST['tanggal']));
									}else{
										if(!empty($_GET['tanggal'])){
											$tanggal=date('Y-m-d',strtotime($_GET['tanggal']));
										}else{
											$tanggal=date("Y-m-d");
										}
									}
									
									if(!empty($_POST['transaksi'])){
										$transaksi=$_POST['transaksi'];
									}else{
										if(!empty($_GET['transaksi'])){
											$transaksi=$_GET['transaksi'];
										}else{
											$transaksi="";
										}
									}
									
									if(!empty($_POST['faktur'])){
										$faktur=$_POST['faktur'];
									}else{
										if(!empty($_GET['faktur'])){
											$faktur=$_GET['faktur'];
										}else{
											$faktur="";
										}
									}									
									
								?>
								
								<form method="POST" action="">
									
									<div class="row" style='font-size:small;'>
									
										<div class="col-md-6">											
											<div class="form-group">
												<label>Branch</label>
												<select class="custom-select col-12" id="branch" name="branch" onchange="this.form.submit()" required="required">
													<option value="<?php if(!empty($branch)){echo $branch;}?>"><?php if(!empty($branch)){echo $branch;}else{echo "Pilih...";}?></option>
													<?php
														$result = $con->query("Select branch from BRANCH where branch not in ('$branch','All Branch') group by branch order By id");
														$count = mysqli_num_rows($result);
														if($count>0){
															echo "<option value='All Branch'>All Branch</option>";
															while($row = mysqli_fetch_assoc($result))
															{				
																$branch1=$row["branch"];
																echo "<option value='$branch1'>$branch1</option>";
															}
														}												
													?>												
												</select>
											</div>											
										</div>
										
										<div class="col-md-6">
											<div class="form-group">
												<label>Transaksi</label>
												<select class="custom-select col-12" id="transaksi" name="transaksi" onchange="this.form.submit()" required="required">
													<option value="<?php if(!empty($transaksi)){echo $transaksi;}?>"><?php if(!empty($transaksi)){echo $transaksi;}else{echo "Pilih...";}?></option>
													<option value="Outgoing Transaction">Outgoing Transaction</option>
													<!--<option value="Return Transaction">Return Transaction</option>-->
												</select>
											</div>
										</div>
										
										<div class="col-md-6">
											<div class="form-group">
												<label for="tanggal">Tanggal</label>
												<input class="form-control form-control-line" type="date" name="tanggal" id="tanggal" onchange="this.form.submit()" value="<?php echo $tanggal; ?>" required="required">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Faktur</label>
												<select class="custom-select col-12" id="faktur" name="faktur" onchange="this.form.submit()" required="required">
													<option value="<?php if(!empty($faktur)){echo $faktur;}?>"><?php if(!empty($faktur)){echo $faktur;}else{echo "Pilih...";}?></option>
													<?php
														if($branch=="All Branch"){
															if($transaksi=="Outgoing Transaction"){
																$result = $con->query("Select faktur from OUTGOING where tanggal='$tanggal' group by faktur order By faktur");
															}else{
																$result = $con->query("Select faktur from RETUR where tanggal='$tanggal' group by faktur order By faktur");
															}
														}else{
															if($transaksi=="Outgoing Transaction"){
																$result = $con->query("Select faktur from OUTGOING where branch='$branch' and tanggal='$tanggal' group by faktur order By faktur");
															}else{
																$result = $con->query("Select faktur from RETUR where branch='$branch' and tanggal='$tanggal' group by faktur order By faktur");
															}
														}															
														$count = mysqli_num_rows($result);
														if($count>0){															
															while($row = mysqli_fetch_assoc($result))
															{				
																$faktur1=$row["faktur"];
																echo "<option value='$faktur1'>$faktur1</option>";
															}
														}												
													?>												
												</select>
											</div>
										</div>
									</div>
								</form>								
							
							
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
                    <div class="col-12">
                        <div class="card card-body">
							<div class="text-right">
								<?php
								    if($transaksi=="Outgoing Transaction"){
									    echo" <a class='btn btn-primary btn-sm text-right' href='faktur-print.php?branch=$branch&tanggal=$tanggal&faktur=$faktur&halaman=cetak-ulang&transaksi=$transaksi'><i class='fa fa-print'></i> Faktur</a>";						
									    echo" <a class='btn btn-info btn-sm text-right' href='sj-print.php?branch=$branch&tanggal=$tanggal&faktur=$faktur&halaman=cetak-ulang&transaksi=$transaksi'><i class='fa fa-print'></i> Surat Jalan</a>";						
								    }else{
								        echo" <a class='btn btn-primary btn-sm text-right' href='return-print.php?branch=$branch&tanggal=$tanggal&faktur=$faktur&halaman=cetak-ulang&transaksi=$transaksi'><i class='fa fa-print'></i> Return</a>";						
								    }
								?>
							</div>
							<div class="col-sm-12 col-xs-12">
								<div class="table-responsive">
                                    <br>
                                    <br>
									<?php if($transaksi=="Outgoing Transaction" && $faktur!=""){?>
										<table border="0" align="center" width="100%" cellpadding="5" cellspacing="0">
                                    		<tr>
                                    			<td align="center">
                                    					<table width="100%">
                                    						<tr>
                                    							<td valign="top"><b>PT. Sarana Solusindo Prima</b><br>Jl. Drupada II No.14 Komplek Indraprasta II<br>Tegal Gunil,Bogor Utara,Kabupaten Bogor</td>
                                    							<td valign="top" align="right">
                                    							    <table border="1">
                                    							        <tr>
                                    							            <td style="padding:10px;font-size:x-large;font-weight:bold;padding-left:20px; padding-right:20px;">
                                    							                SURAT JALAN<br>
                                    							                <small><?php echo $tipe_outgoing;?>
                                    							            </td>
                                    							        </tr>
                                    							    </table>
                                    							</td>
                                    						</tr>
                                    					</table>
                                    					<hr>
                                    				<?php
                                    				    
                                    				    $tipe="";
                                    				    $sql="Select tipe from CUSTOMER where kode='$kode_customer'";
                                    					$result = $con->query($sql);
                                    					$count = mysqli_num_rows($result);
                                    					if($count>0){
                                    						while($row = mysqli_fetch_assoc($result))
                                    						{
                                    							$tipe=$row["tipe"];
                                    						}
                                    					}
                                    				
                                    					$po1="";
                                    					$tanggal1="";
                                    					$tgltempo1="";
                                    					$tglpo1="";
                                    					$customer1="";							
                                    					$address1="";
                                    					$phone1="";
                                    					$contact1="";
                                    					$ongkir1="";
                                    					$biaya_lainnya1="";
                                    					
                                    					$sql="Select po, tglpo, tgltempo, tanggal, kode_customer, customer, address, phone, contact, ongkir, biaya_lainnya
                                    						from OUTGOING where faktur='$faktur' 
                                    						group by po, tglpo, tgltempo, tanggal, kode_customer, customer, address, phone, contact, ongkir, biaya_lainnya";
                                    					$result = $con->query($sql);
                                    					$count = mysqli_num_rows($result);
                                    					if($count>0){
                                    						while($row = mysqli_fetch_assoc($result))
                                    						{
                                    							$po1=$row["po"];
                                    							$tanggal1=$row["tanggal"];
                                    							$tgltempo1=$row["tgltempo"];
                                    							$tglpo1=$row["tglpo"];
                                    							$kode_customer1=$row["kode_customer"];
                                    							$customer1=$row["customer"];							
                                    							$address1=$row["address"];
                                    							$phone1=$row["phone"];
                                    							$contact1=$row["contact"];
                                    							$ongkir1=$row["ongkir"];
                                    							$biaya_lainnya1=$row["biaya_lainnya"];
                                    						}
                                    					}
                                    					
                                    					$tipe="";
                                    				    $sql="Select tipe from CUSTOMER where kode='$kode_customer1'";
                                    					$result = $con->query($sql);
                                    					$count = mysqli_num_rows($result);
                                    					if($count>0){
                                    						while($row = mysqli_fetch_assoc($result))
                                    						{
                                    							$tipe=$row["tipe"];
                                    						}
                                    					}
                                    					
                                    				?>
                                    				<table width="100%" align="center">
                                    					<tr>						
                                    						<td width="35%" valign="top" style="border:1px solid black;padding-top:5px;padding-bottom:5px;">
                                    						   <table>
                                    						        <tr>
                                    						            <td style="padding-left:10px; padding-right:5px;">Nomor</td>
                                    						            <td style="padding-right:5px;"> : </td>
                                    						            <td style="padding-right:5px;"><?php echo $faktur;?></td>
                                    						        </tr>
                                    						        <tr>
                                    						            <td style="padding-left:10px; padding-right:5px;">Nama</td>
                                    						            <td style="padding-right:5px;"> : </td>
                                    						            <td style="padding-right:5px;"><?php echo $customer1;?></td>
                                    						        </tr>
                                    						    </table>
                                    						</td>
                                    						<td width="30%">
                                    						</td>
                                    						<td width="35%" valign="top" style="border:1px solid black;padding-top:5px;padding-bottom:5px;">
                                    						    <table>
                                    						        <tr>
                                    						            <td style="padding-left:10px; padding-right:5px;">Alamat</td>
                                    						            <td style="padding-right:5px;"> : </td>
                                    						            <td style="padding-right:5px;"><?php echo $address1;?></td>
                                    						        </tr>
                                    						        <tr>
                                    						            <td style="padding-left:10px; padding-right:5px;">No. PO</td>
                                    						            <td style="padding-right:5px;"> : </td>
                                    						            <td style="padding-right:5px;"><?php echo $po1;?></td>
                                    						        </tr>
                                    						    </table>
                                    						</td>
                                    					</tr>
                                    				</table>	
                                    				
                                    			</td>
                                    		</tr>
                                    		<tr><td style="height:10px"></td></tr>
                                    		<tr>
                                    			<td>
                                    				<table border="1" width="100%" cellpadding="5" cellspacing="0" width="100%">
                                    					<tr>						
                                    						<td align="center" >No.</td>
                                    						<td align="center" style="padding:5px;">Merk</td>
                                    						<td align="center" style="padding:5px;" nowrap>Nama Barang</td>
                                    						<td align="center" style="padding:5px;" align="right">Jumlah</td>
                                    						
                                    						<!--
                                    						<td align="center" style="padding:5px;" align="right">Harga</td>
                                    						<td align="center" style="padding:5px;" align="right">Disc</td>
                                    						<td align="center" style="padding:5px;" align="right">Total</td>
                                    						-->
                                    						
                                    						<td align="center" style="padding:5px;">Note</td>
                                    					</tr>
                                    					<?php
                                    						$no=0;
                                    						$sql="Select * from OUTGOING where faktur='$faktur' order by jenis,subgroup,merk,barang";
                                    						$result = $con->query($sql);
                                    						$count = mysqli_num_rows($result);
                                    						if($count>0){
                                    						    $grandtotal=0;
                                    							while($row = mysqli_fetch_assoc($result))
                                    							{
                                    								$no++;			
                                    								
                                    								$merk=$row["merk"];
                                    								$barang2=$row["barang"];
                                    								$harga_jual2=$row["harga_jual"];
                                    								
                                    								if($tipe=="PPN"){
                                    								    $harga_jual2=($harga_jual2*0.909090909);    
                                    								}
                                    								
                                    								$qty2=$row["qty"];
                                    								$diskon=$row["diskon"];
                                    								$disc=(($harga_jual2*$qty2)*($diskon*0.01));
                                    								$subtotal=($harga_jual2*$qty2)-$disc;
                                    								$grandtotal=$grandtotal+$subtotal;
                                    								
                                    								$satuan2=$row["satuan"];
                                    								$note2=$row["descr"];
                                    								
                                    								echo"
                                    									<tr>												
                                    										<td style='padding:5px;' align='center' valign='top'>$no</td>
                                    										<td style='padding:5px;' valign='top'>$merk</td>
                                    										<td style='padding:5px;' valign='top'>$barang2</td>
                                    										<td style='padding:5px;' valign='top' align='right'>".number_format($qty2)." $satuan2</td>";
                                    										
                                    										/*
                                    										<td style='padding:5px;' valign='top' align='right'>".number_format($harga_jual2)."</td>
                                    										<td style='padding:5px;' valign='top' align='right'>$diskon% | ".number_format($disc)."</td>
                                    										<td style='padding:5px;' valign='top' align='right'>".number_format($subtotal)."</td>
                                    										*/
                                    										
                                    								echo"		
                                    										<td style='padding:5px;' valign='top'>$note2</td>
                                    									</tr>										
                                    								";													
                                    							}
                                    							
                                    						}
                                    					?>
                                    					
                                    				</table>
                                    				
                                    				
                                    					
                                    			</td>
                                    		</tr>
                                    		<tr><td style="height:10px"></td></tr>
                                    		<tr>
                                    		    <td>
                                    		        <table width="100%">
                                    		            <tr>
                                    		                <td valign='top'>
                                    		                    <table>
                                    		                        <tr>
                                    		                            <td>Note : 
                                    		                            </td>
                                    		                        </tr>
                                    		                        <tr>
                                    		                            <td><br>Yang Menerima</td>
                                    		                        </tr>
                                    		                        <tr>
                                    		                            <td height='80px'></td>
                                    		                        </tr>
                                    		                    </table>
                                    		                </td>
                                    		                <td valign='top'>
                                    		                    <table>
                                    		                        <tr>
                                    		                            <td>
                                    		                                <?php
                                    		                                    $tanggalX=date('d-m-Y');
                                            									function getDayIndonesia($date)    {
                                                                                    if($date != '0000-00-00'){
                                                                                        $data = hari(date('D', strtotime($date)));
                                                                                    }else{
                                                                                        $data = '-';
                                                                                    }
                                                                                    return $data;
                                                                                }
                                                                              
                                                                                function hari($day) {
                                                                                    $hari = $day;
                                                                              
                                                                                    switch ($hari) {
                                                                                        case "Sun":
                                                                                            $hari = "Minggu";
                                                                                            break;
                                                                                        case "Mon":
                                                                                            $hari = "Senin";
                                                                                            break;
                                                                                        case "Tue":
                                                                                            $hari = "Selasa";
                                                                                            break;
                                                                                        case "Wed":
                                                                                            $hari = "Rabu";
                                                                                            break;
                                                                                        case "Thu":
                                                                                            $hari = "Kamis";
                                                                                            break;
                                                                                        case "Fri":
                                                                                            $hari = "Jum'at";
                                                                                            break;
                                                                                        case "Sat":
                                                                                            $hari = "Sabtu";
                                                                                            break;
                                                                                    }
                                                                                    return $hari;
                                                                                }
                                            								?>
                                    		                                Bogor, <?php echo getDayIndonesia($tanggal1)." ".$tanggalX;?>
                                    		                            </td>
                                    		                        </tr>
                                    		                        <tr>
                                    		                            <td>
                                    		                                <br>
                                    		                                Hormat Kami
                                    		                            </td>
                                    		                        </tr>
                                    		                    </table>
                                    		                </td>
                                    		            </tr>
                                    		        </table>
                                    		    </td>
                                    		</tr>
                                    		<tr><td>
                                                <table border="1" width="100%">
                                                    <tr>
                                                        <td style="padding:10px;">
                                                            Catatan Serah Terima Barang :
                                                            <br>
                                                            <br>
                                                            <br>
                                                            <br>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td></tr>
                                    		
                                    		
                                    	</table>
									<?php } ?>
									
									
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
    <?php include("inc/js_bawah.php");?>
	<script language="javascript">
		function printContent(el){
			var a=document.getElementById('branch').value;
			var b=document.getElementById('tanggal').value;
			var c=document.getElementById('transaksi').value;
			var d=document.getElementById('faktur').value;
			
			var restorepage = document.body.innerHTML;
			var printcontent = document.getElementById(el).innerHTML;
			document.body.innerHTML = printcontent;
			window.print();
			document.body.innerHTML = restorepage;
			document.location.href='cetak-ulang.php?branch=' + a + '&tanggal=' + b + '&transaksi='+ c+'&faktur='+d;
		}
	</script>
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