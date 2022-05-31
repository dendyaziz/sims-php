<?php
ob_start();session_start();
include("fc/fc_config.php");
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

    <title>Sales Performance Report :: <?php echo $app_name;?></title>	
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
		page[size="A4"] {  
		  width: 21cm;
		  height: 29.7cm; 
		}
		page[size="A4"][layout="landscape"] {
		  width: 29.7cm;
		  height: 21cm; 
		}
		@media print {
		  body, page {
			margin: 0;
			box-shadow: 0;
		  }
		}

		
	</style>	
</head>

<body>
    <page size="A4" layout="landscape">
		<?php			
			$branch="All Branch";
			if(!empty($_POST['awal'])){$awal=date('Y-m-d',strtotime($_POST['awal']));}else{if(!empty($_GET['awal'])){$awal=date('Y-m-d',strtotime($_GET['awal']));}else{$awal=date("Y-m-d");}}
			if(!empty($_POST['akhir'])){$akhir=date('Y-m-d',strtotime($_POST['akhir']));}else{if(!empty($_GET['akhir'])){$akhir=date('Y-m-d',strtotime($_GET['akhir']));}else{$akhir=date("Y-m-d");}}									
			if(!empty($_POST['kode_customer'])){$kode_customer=$_POST['kode_customer'];}else{if(!empty($_GET['kode_customer'])){$kode_customer=$_GET['kode_customer'];}else{$kode_customer="";}}
			if(!empty($kode_customer)){
				$result = $con->query("Select * from CUSTOMER where kode='$kode_customer'");											
				while($row = mysqli_fetch_assoc($result))
				{
					$customer=$row["customer"];
					$address=$row["address"];
					$phone=$row["phone"];
					$contact=$row["contact"];		
				}
			}else{
				$kode_customer="All Customer";
			}
			
			if(!empty($_POST['salesman'])){$salesman=$_POST['salesman'];}else{if(!empty($_GET['salesman'])){$salesman=$_GET['salesman'];}else{$salesman="All Salesman";}}
			if(!empty($_POST['jenis'])){$jenis=$_POST['jenis'];}else{if(!empty($_GET['jenis'])){$jenis=$_GET['jenis'];}else{$jenis="All Category";}}
			
			if(!empty($_POST['kode'])){$kode=$_POST['kode'];}else{if(!empty($_GET['kode'])){$kode=$_GET['kode'];}else{$kode="";}}
			if(!empty($kode)){
				$result = $con->query("Select * from BARANG where kode='$kode'");											
				while($row = mysqli_fetch_assoc($result))
				{
					$barang=$row["barang"];
					$satuan=$row["satuan"];		
				}
			}else{
				$kode="All Item Code";
			}
		?>
	
		<table width="100%" cellspacing="0" cellpadding="5">
			<tr>
				<td><b>SALES PERFORMANCE REPORT</b><br><?php echo "Period ".date('d/m/Y',strtotime($awal))." s/d ".date('d/m/Y',strtotime($akhir));?><br><?php echo "Location ".$branch;?></td>
			</tr>
		</table>
		<table border="1" width="100%" cellspacing="0" cellpadding="5">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Salesman</th>
					<th>Customer</th>												
					<th>Category</th>
					<th>Item Description</th>
					<th>Unit</th>
					<th class="text-right">Qty</th>
					<?php if($_SESSION["iss21"]["position"]=="Admin"){ ?>
					<th class="text-right">Harga Jual</th>
					<th class="text-right">Nilai Jual</th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php
				$count=0;
				$no=0;									
				$pAwal=$awal." 00:00:00";
				$pAkhir=$akhir." 23:59:59";
				if($kode=="All Item Code"){
					
					if($salesman=="All Salesman"){
						if($jenis=="All Category"){
							if($kode_customer=="All Customer"){
								$sql="Select tanggal, salesman, customer, jenis, barang, satuan, harga_jual, sum(qty) as qty from OUTGOING where tanggal between '$pAwal' and '$pAkhir' group by tanggal, salesman, customer, jenis, barang, satuan, harga_jual order by tanggal, salesman, customer, jenis, barang";
							}else{
								$sql="Select tanggal, salesman, customer, jenis, barang, satuan, harga_jual, sum(qty) as qty from OUTGOING where kode_customer='$kode_customer' and tanggal between '$pAwal' and '$pAkhir' group by tanggal, salesman, customer, jenis, barang, satuan, harga_jual order by tanggal, salesman, customer, jenis, barang";
							}
						}else{
							if($kode_customer=="All Customer"){
								$sql="Select tanggal, salesman, customer, jenis, barang, satuan, harga_jual, sum(qty) as qty from OUTGOING where jenis='$jenis' and (tanggal between '$pAwal' and '$pAkhir') group by tanggal, salesman, customer, jenis, barang, satuan, harga_jual order by tanggal, salesman, customer, jenis, barang";
							}else{
								$sql="Select tanggal, salesman, customer, jenis, barang, satuan, harga_jual, sum(qty) as qty from OUTGOING where kode_customer='$kode_customer' and jenis='$jenis' and (tanggal between '$pAwal' and '$pAkhir') group by tanggal, salesman, customer, jenis, barang, satuan, harga_jual order by tanggal, salesman, customer, jenis, barang";
							}
						}
					}else{
						if($jenis=="All Category"){
							if($kode_customer=="All Customer"){
								$sql="Select tanggal, salesman, customer, jenis, barang, satuan, harga_jual, sum(qty) as qty from OUTGOING where salesman='$salesman' and tanggal between '$pAwal' and '$pAkhir' group by tanggal, salesman, customer, jenis, barang, satuan, harga_jual order by tanggal, salesman, customer, jenis, barang";
							}else{
								$sql="Select tanggal, salesman, customer, jenis, barang, satuan, harga_jual, sum(qty) as qty from OUTGOING where salesman='$salesman' and kode_customer='$kode_customer' and tanggal between '$pAwal' and '$pAkhir' group by tanggal, salesman, customer, jenis, barang, satuan, harga_jual order by tanggal, salesman, customer, jenis, barang";
							}
						}else{
							if($kode_customer=="All Customer"){
								$sql="Select tanggal, salesman, customer, jenis, barang, satuan, harga_jual, sum(qty) as qty from OUTGOING where salesman='$salesman' and jenis='$jenis' and (tanggal between '$pAwal' and '$pAkhir') group by tanggal, salesman, customer, jenis, barang, satuan, harga_jual order by tanggal, salesman, customer, jenis, barang";
							}else{
								$sql="Select tanggal, salesman, customer, jenis, barang, satuan, harga_jual, sum(qty) as qty from OUTGOING where salesman='$salesman' and kode_customer='$kode_customer' and jenis='$jenis' and (tanggal between '$pAwal' and '$pAkhir') group by tanggal, salesman, customer, jenis, barang, satuan, harga_jual order by tanggal, salesman, customer, jenis, barang";
							}
						}

					}												
					
				}else{
					
					if($salesman=="All Salesman"){
						if($kode_customer=="All Customer"){
							$sql="Select tanggal, salesman, customer, jenis, barang, satuan, harga_jual, sum(qty) as qty from OUTGOING where jenis='$jenis' and kode='$kode' and (tanggal between '$pAwal' and '$pAkhir') group by tanggal, salesman, customer, jenis, barang, satuan, harga_jual order by tanggal, salesman, customer, jenis, barang";
						}else{
							$sql="Select tanggal, salesman, customer, jenis, barang, satuan, harga_jual, sum(qty) as qty from OUTGOING where kode_customer='$kode_customer' and jenis='$jenis' and kode='$kode' and (tanggal between '$pAwal' and '$pAkhir') group by tanggal, salesman, customer, jenis, barang, satuan, harga_jual order by tanggal, salesman, customer, jenis, barang";
						}
					}else{
						if($kode_customer=="All Customer"){
							$sql="Select tanggal, salesman, customer, jenis, barang, satuan, harga_jual, sum(qty) as qty from OUTGOING where salesman='$salesman' and jenis='$jenis' and kode='$kode' and (tanggal between '$pAwal' and '$pAkhir') group by tanggal, salesman, customer, jenis, barang, satuan, harga_jual order by tanggal, salesman, customer, jenis, barang";
						}else{
							$sql="Select tanggal, salesman, customer, jenis, barang, satuan, harga_jual, sum(qty) as qty from OUTGOING where salesman='$salesman' and kode_customer='$kode_customer' and jenis='$jenis' and kode='$kode' and (tanggal between '$pAwal' and '$pAkhir') group by tanggal, salesman, customer, jenis, barang, satuan, harga_jual order by tanggal, salesman, customer, jenis, barang";
						}
					}
					
					

				}
				
				$result = $con->query($sql);
				$count = mysqli_num_rows($result);
				if($count>0){
					$grandtotal=0;
					while($row = mysqli_fetch_assoc($result))
					{
						$no++;
						$tanggal1=$row["tanggal"];
						$tanggal2=date('d/m/Y',strtotime($tanggal1));
						$customer2=$row["customer"];
						$salesman2=$row["salesman"];
						$jenis2=$row["jenis"];
						$barang2=$row["barang"];
						$satuan2=$row["satuan"];
						$qty2=$row["qty"];
						$harga_jual2=$row["harga_jual"];
						$grandtotal=$grandtotal+($harga_jual2*$qty2);
						echo"
							<tr style='font-size:small;'>
								<td>$no</td>
								<td>$tanggal2</td>
								<td>$salesman2</td>
								<td>$customer2</td>															
								<td>$jenis2</td>
								<td>$barang2</td>
								<td>$satuan2</td>
								<td align='right'>".number_format($qty2,0,',','.')."</td>";
								if($_SESSION["iss21"]["position"]=="Admin"){
								    echo"
    								<td align='right'>".number_format($harga_jual2,0,',','.')."</td>
    								<td align='right'>".number_format($harga_jual2*$qty2,0,',','.')."</td>
    								";
								}
						echo"
							</tr>													
						";													
					}
					if($_SESSION["iss21"]["position"]=="Admin"){
    					echo"
    						<tr style='font-size:small;'>
    							<td colspan='9' align='right'>Grand Total</td>
    							<td align='right'>".number_format($grandtotal,0,',','.')."</td>
    						</tr>
    					";
					}
					
				}										
				?>											
			</tbody>
		</table>
		
	
	</page>	
	    
</body>
</html>
<script src="js/jquery-3.2.1.min.js"></script>

<?php
$halaman="sales-performance.php?awal=$awal&akhir=$akhir&kode_customer=$kode_customer&jenis=$jenis&kode=$kode&salesman=$salesman";
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
