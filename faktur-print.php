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
	<title>Faktur Penjualan</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.css">
	<style>
		body {
			font-size: normal;
			font-family: "Arial";
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
			min-height: 297mm;
			padding: 0;
			margin: 0 auto;
		}
		page[size="A4"] {  
		  width: 210mm;
		  height: 297mm;
		}
		@media print {
		  body, page {
		    font-size: normal;
			font-family: "Arial";
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
		
		if(!empty($_POST['tipe_outgoing'])){$tipe_outgoing=$_POST['tipe_outgoing'];}else{if(!empty($_GET['tipe_outgoing'])){$tipe_outgoing=$_GET['tipe_outgoing'];}else{$tipe_outgoing="";}}
	
	?>
	<page size="A4">
	<table border="0" align="center" width="100%" cellpadding="5" cellspacing="0">
		<tr>
			<td align="center">
					<table width="100%">
						<tr>
							<td valign="top"><b>PT. SARANA SOLUSINDO PRIMA</b><br>Jl. Drupada II No.14 Komplek Indraprasta II<br>Tegal Gunil,Bogor Utara,Kabupaten Bogor</td>
							<td valign="top" align="right">
							    <table border="1">
							        <tr>
							            <td style="padding:10px;font-size:x-large;font-weight:bold;padding-left:20px; padding-right:20px;">
							                FAKTUR PENJUALAN<br>
							                <small><?php echo $tipe_outgoing;?></small>
							            </td>
							        </tr>
							    </table>
							</td>
						</tr>
					</table>
					<hr>
				<?php
				    
				    
				
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
						    <table width="100%">
						        <tr>
						            <td style="padding:10px;">
						                Kepada Yth. :<br><br><?php echo $customer1."<br>".$address1;?>
						            </td>
						        </tr>
						    </table>
						</td>
						<td width="30%">
						</td>
						<td width="35%" valign="top" style="border:1px solid black;padding-top:5px;padding-bottom:5px;">
						    <table>
						        <tr>
						            <td style="padding-left:10px; padding-right:5px;">No.</td>
						            <td style="padding-right:5px;"> : </td>
						            <td style="padding-right:5px;"><?php echo $faktur;?></td>
						        </tr>
						        <tr>
						            <td style="padding-left:10px; padding-right:5px;">Tanggal</td>
						            <td style="padding-right:5px;"> : </td>
						            <td style="padding-right:5px;"><?php echo date("d M Y",strtotime($tanggal1));?></td>
						        </tr>
						        <tr>
						            <td style="padding-left:10px; padding-right:5px;">Mata Uang</td>
						            <td style="padding-right:5px;"> : </td>
						            <td style="padding-right:5px;">Rupiah</td>
						        </tr>
						        <tr>
						            <td style="padding-left:10px; padding-right:5px;">No. PO</td>
						            <td style="padding-right:5px;"> : </td>
						            <td style="padding-right:5px;"><?php echo $po1;?></td>
						        </tr>
						        <tr>
						            <td style="padding-left:10px; padding-right:5px;">Tgl. PO</td>
						            <td style="padding-right:5px;"> : </td>
						            <td style="padding-right:5px;"><?php echo date("d M Y",strtotime($tglpo1));?></td>
						        </tr>
						        <tr>
						            <td style="padding-left:10px; padding-right:5px;">Tgl. Jatuh Tempo</td>
						            <td style="padding-right:5px;"> : </td>
						            <td style="padding-right:5px;"><?php echo date("d M Y",strtotime($tgltempo1));?></td>
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
						<td align="center" style="padding:5px;" align="right">Harga</td>
						<td align="center" style="padding:5px;" align="right">Total</td>
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
								$subtotal=$harga_jual2*$qty2;
								$grandtotal=$grandtotal+$subtotal;
								
								$satuan2=$row["satuan"];
								$note2=$row["descr"];
								
								echo"
									<tr>												
										<td style='padding:5px;' align='center' valign='top'>$no</td>
										<td style='padding:5px;' valign='top'>$merk</td>
										<td style='padding:5px;' valign='top'>$barang2</td>
										<td style='padding:5px;' valign='top' align='right'>".number_format($qty2)." $satuan2</td>
										<td style='padding:5px;' valign='top' align='right'>".number_format($harga_jual2)."</td>
										<td style='padding:5px;' valign='top' align='right'>".number_format($subtotal)."</td>
									</tr>										
								";												
							}
							echo"
								<tr>												
									<td height='28px;'></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>";
								
							echo"
							    <tr>
							        <td colspan='3' style='padding:5px;' valign='top'>
							        Catatan :<br>		
                                    - Pembayaran yang tidak disertakan kuitansi/faktur dari PT.SARANA SOLUSINDO PRIMA adalah diluar tanggung jawab PT.SARANA SOLUSINDO PRIMA.	<br>	
                                    - Pembayaran dengan giro/cek harus diatas namakan PT.SARANA SOLUSINDO PRIMA, dan bila cek mohon diberi tanda cross.	<br>	
                                    - Pembayaran dengan giro/cek baru dianggap lunas, bila giro/cek tersebut telah kami uangkan.
							        </td>
							        ";
							        
							        if($tipe=="PPN"){
							            echo"
							                <td align='center' style='padding:5px;min-width:120px;' valign='top'>
        							            Hormat Kami,<br><br><br><br>Yeti
        							        </td>
							                <td style='padding:5px;min-width:100px;' valign='top'>
        							            Sub Total<br>
                                                PPN<br>
                                                Ongkir<br>
                                                Lainnya<br>
                                                Total<br>
        							        </td>
							                <td align='right' style='padding:5px;min-width:150px;' valign='top'>
    							            ".number_format($grandtotal)."<br>
                                            ".number_format($grandtotal*0.1)."<br>
                                            ".number_format($ongkir1)."<br>
                                            ".number_format($biaya_lainnya1)."<br>
                                            ".number_format($grandtotal+($grandtotal*0.1)+$ongkir1+$biaya_lainnya1)."
    							        </td>
							            ";
							        }else{
							            echo"
							                <td align='center' style='padding:5px;min-width:120px;' valign='top'>
        							            Hormat Kami,<br><br><br>Yeti
        							        </td>
							                <td style='padding:5px;min-width:100px;' valign='top'>
        							            Sub Total<br>
                                                Ongkir<br>
                                                Lainnya<br>
                                                Total<br>
        							        </td>
							                <td align='right' style='padding:5px;min-width:150px;' valign='top'>
    							            ".number_format($grandtotal)."<br>
                                            ".number_format($ongkir1)."<br>
                                            ".number_format($biaya_lainnya1)."<br>
                                            ".number_format($grandtotal+$ongkir1+$biaya_lainnya1)."
    							        </td>
							            ";
							        }
							        
							 echo"
							    <tr>
							
							";
						}
					?>
					
				</table>
				
				
					
			</td>
		</tr>
		<tr><td style="height:10px"></td></tr>
		
		
	</table>
	
	
	
									
	</page>	
</body>
</html>
<script src="js/jquery-3.2.1.min.js"></script>
<?php
$halaman=$_GET['halaman'];
if($halaman=="outgoing"){
    $tipe_outgoing=$_GET["tipe_outgoing"];
    $tanggal=$_GET["tanggal"];
	$faktur=$_GET["faktur"];
	$kode_customer=$_GET["kode_customer"];
	$po=$_GET["po"];
	$tglpo=$_GET["tglpo"];
	$tgltempo=$_GET["tgltempo"];
	$ongkir=$_GET["ongkir"];
	$biaya_lainnya=$_GET["biaya_lainnya"];
	$halaman="outgoing.php?tanggal=$tanggal&faktur=$faktur&kode_customer=$kode_customer&ongkir=$ongkir&biaya_lainnya=$biaya_lainnya&po=$po&tglpo=$tglpo&tgltempo=$tgltempo&tipe_outgoing=$tipe_outgoing";
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