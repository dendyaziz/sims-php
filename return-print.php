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
	<meta charset="utf-8">
	<title>Retur Penjualan</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.css">
	<style>
		body {
			font-size: normal;
			font-family: "Calibri";
			width: 100%;
			height: 100%;
			margin: 0;
			padding: 0;
		}
		* {
			box-sizing: border-box;
			-moz-box-sizing: border-box;
		}
		page {
			width: 210mm;
			min-height: 139.7mm;
			padding: 0;
			margin: 0 auto;
		}
		page[size="A5"] {  
		  width: 21cm;
		  height: 13.97cm;
		}
		@media print {
		  body, page {
		    font-size: normal;
			font-family: "Calibri";
			margin: 0;
			box-shadow: 0;
		  }
		}	
	</style>
	
</head>
<body>
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
		
		if(!empty($_POST['kode_customer'])){
			$kode_customer=$_POST['kode_customer'];
		}else{
			if(!empty($_GET['kode_customer'])){
				$kode_customer=$_GET['kode_customer'];
			}else{
				$kode_customer="";
			}
		}
		
		if(!empty($_POST['userid'])){
			$userid=$_POST['userid'];
		}else{
			if(!empty($_GET['userid'])){
				$userid=$_GET['userid'];
			}else{
				$userid="";
			}
		}
	
	?>
	<page size="A5">
	<table border="0" align="center" width="100%" cellpadding="0" cellspacing="0">
		<!--
		<tr>
			<td align="left">
				<table border="0" cellspacing="0" cellpadding="5">
					<tr>
						<td><img src="logo_pt.png" width="auto" height="60"></img></td>
					</tr>
				</table>			
			</td>
		</tr>
		-->
		<tr><td style="height:10px"></td></tr>
		<tr>
			<td align="center">
				
					<table width="100%">
						<tr style="border-top:1px solid black; border-bottom:1px solid black;">
							<td style="padding:5px;"><b>RETUR PENJUALAN</b></td>
							<td style="padding:5px;" align="right"><b></b></td>
						</tr>
					</table>
				<?php
					$faktur1="";
					$tanggal1="";
					$customer1="";							
					$alamat1="";
					
					$sql="Select salesman, faktur, tanggal, customer, address, phone, contact
						from RETUR where tanggal='$tanggal' and faktur='$faktur' 
						group by salesman, faktur, tanggal, customer, address, phone, contact";
					$result = $con->query($sql);
					$count = mysqli_num_rows($result);
					if($count>0){
						while($row = mysqli_fetch_assoc($result))
						{
							$salesman1=$row["salesman"];
							$faktur1=$row["faktur"];
							$tanggal1=$row["tanggal"];
							$customer1=$row["customer"];							
							$alamat1=$row["address"];
							$phone1=$row["phone"];
							$contact1=$row["contact"];
						}
					}
					
				?>
				<table width="100%">
					<tr>						
						<td width="70%">
							<table>								
								<tr><td style="padding-left:5px;">Customer</td><td style="padding-left:5px;">:</td><td style="padding-left:5px;"><?php echo $customer1;?></td></tr>
								<tr><td style="padding-left:5px;">Address</td><td style="padding-left:5px;">:</td><td style="padding-left:5px;"><?php echo $alamat1;?></td></tr>
								<tr><td style="padding-left:5px;">Phone</td><td style="padding-left:5px;">:</td><td style="padding-left:5px;"><?php echo $phone1;?></td></tr>
							</table>
						</td>
						<td width="30%">
							<table>
								<?php
									$tanggalX=date('M d, Y',strtotime($tanggal1));
									$hari = array ( 1 =>    'Senin',
										'Selasa, ',
										'Rabu, ',
										'Kamis, ',
										'Jumat, ',
										'Sabtu, ',
										'Minggu, '
									);
									$num = date('N', strtotime('$tanggal1'));
								?>
								<tr><td style="padding-left:5px;">Date</td><td style="padding-left:5px;">:</td><td style="padding-left:5px;"><?php echo $hari[$num]." ".$tanggalX;?></td></tr>
								<tr><td style="padding-left:5px;">Nomor</td>  <td style="padding-left:5px;">:</td><td style="padding-left:5px;"><?php echo $faktur1;?></td></tr>
								<tr><td style="padding-left:5px;">Salesman</td>  <td style="padding-left:5px;">:</td><td style="padding-left:5px;"><?php echo $salesman1;?></td></tr>
							</table>
						</td>
					</tr>
				</table>
				
			</td>
		</tr>
		<tr><td style="height:20px"></td></tr>
		<tr>
			<td>
				<table border="0" width="100%" cellpadding="0" cellspacing="0" width="100%">
					<tr style='border-top:1px solid black;border-bottom:1px solid black;'>						
						<td style="padding:5px;">Category</td>
						<td style="padding:5px;">Item Code</td>
						<td style="padding:5px;">Item Description</td>
						<td style="padding:5px;">Unit</td>
						<td align="right" style="padding:5px;" nowrap>Qty</td>
						<td align="right" style="padding:5px;" nowrap>Price</td>
						<td align="right" style="padding:5px;" nowrap>Subtotal</td>
					</tr>
					<?php
						$no=0;
						$subtotal=0;
						$grandtotal=0;
						$total_potongan=0;
						$sql="Select * from RETUR where tanggal='$tanggal' and faktur='$faktur' order by jenis, barang";
						$result = $con->query($sql);
						$count = mysqli_num_rows($result);
						if($count>0){
							while($row = mysqli_fetch_assoc($result))
							{
								$no++;			
								$branch2=$row["branch"];
								$kode2=$row["kode"];						
								$jenis2=$row["jenis"];
								$barang2=$row["barang"];
								$satuan2=$row["satuan"];
								$harga_jual2=$row["harga_jual"];
								$qty2=$row["qty"];
								$subtotal=$qty2*$harga_jual2;
								$grandtotal=$grandtotal+$subtotal;
								$username2=$row["username"];
								
								echo"
									<tr>												
										<td style='padding:5px;'>$jenis2</td>
										<td style='padding:5px;'>$kode2</td>
										<td style='padding:5px;'>$barang2</td>
										<td style='padding:5px;'>$satuan2</td>
										<td style='padding:5px;' align='right'>".number_format($qty2)."</td>
										<td style='padding:5px;' align='right'>".number_format($harga_jual2)."</td>
										<td style='padding:5px;' align='right'>".number_format($subtotal)."</td>
									</tr>										
								";													
							}							
						}
					?>
					
				</table>
				<table border="0" width="100%" cellpadding="0" cellspacing="0" width="100%">
					<tr style='border-top:1px solid black;'>						
						<td style="padding:5px; font-size:small;" width="50%" valign="top" style="padding-right:10px;">
																					
						</td>
						<td style="padding:5px;" width="50%" valign="top">
							<table width="100%">								
								<tr style='border-bottom:1px solid black;'>
									<td>Grand Total</td>
									<td align="right"><b>Rp. <?php echo number_format($grandtotal);?></b></td>
								</tr>
								<tr>
									<td colspan="2">
										<table width="100%" align="center">
											<tr><td align="center"></td></tr>
										</table>
									</td>
							</table>
						</td>
					</tr>
				</table>
				
					
			</td>
		</tr>
		<tr><td style="height:10px"></td></tr>
		<tr><td>
			<br>
			<table border="1" cellpadding="0" cellspacing="0" width="100%">
				<tr>						
					<td width="30%" align="center" style="padding:5px;">Created By,</td>
					<td width="40%" align="center" style="padding:5px;">Delivered By,</td>
					<td width="30%" align="center" style="padding:5px;">Received By,</td>
				</tr>
				<tr>						
					<td height="80"></td>
					<td></td>
					<td></td>
				</tr>
				<tr>						
					<td style="padding:5px;">Name :</td>
					<td style="padding:5px;">Name :</td>
					<td style="padding:5px;">Name :</td>
				</tr>
				<tr>						
					<td style="padding:5px;">Date :</td>
					<td style="padding:5px;">Date :</td>
					<td style="padding:5px;">Date :</td>
				</tr>
			</table>
		</td></tr>
		
	</table>
	
	
	
									
	</page>	
</body>
</html>
<script src="js/jquery-3.2.1.min.js"></script>
<?php
$halaman=$_GET['halaman'];
if($halaman=="return"){
	$halaman="return.php?tanggal=$tanggal&faktur=$faktur&kode_customer=$kode_customer&userid=$userid";
}else{
	$halaman="cetak-ulang.php?branch=$branch&tanggal=$tanggal&faktur=$faktur&transaksi=$transaksi";
}

?>
<script type="text/javascript">
	$(document).ready(function () {
        window.print();
        setTimeout("closePrintView()", 5);
    });
    function closePrintView() {
        document.location.href = '<?php echo $halaman; ?>';
    }
</script>
<?php

}else{
	session_destroy();
	session_start();
	$_SESSION["iss21"]["info"]="Gagal, anda tidak memiliki ijin untuk mengakses halaman tersebut atau session anda sudah habis, silahkan login ulang.";
	header("location: index.php");
}


?>