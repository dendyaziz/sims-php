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

    <title>RETUR Report :: <?php echo $app_name;?></title>	
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
			if(!empty($_POST['faktur'])){$faktur=$_POST['faktur'];}else{if(!empty($_GET['faktur'])){$faktur=$_GET['faktur'];}else{$faktur="";}}
			if(!empty($_POST['branch'])){$branch=$_POST["branch"];}else{if(!empty($_GET["branch"])){$branch=$_GET["branch"];}else{if(strtolower($_SESSION["iss21"]["level"])=="admin"){$branch="All Branch";}else{$branch=$_SESSION["iss21"]["branch"];}}}
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
			
			if(!empty($_POST['jenis'])){$jenis=$_POST['jenis'];}else{if(!empty($_GET['jenis'])){$jenis=$_GET['jenis'];}else{$jenis="All Group";}}
			
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
				<td><b>RETURN TRANSACTION REPORT</b><br><?php echo "Period ".date('d/m/Y',strtotime($awal))." s/d ".date('d/m/Y',strtotime($akhir));?><br><?php echo "Location ".$branch;?></td>
			</tr>
		</table>
		<table border="1" width="100%" cellspacing="0" cellpadding="5">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Customer</th>
					<th>Faktur</th>
					<th>Code</th>
					<th>Group</th>
					<th>Merk</th>
					<th>Item Description</th>
					<th>Keterangan</th>
					<th>Qty</th>
					<th>Unit</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$count=0;
				$no=0;									
				$pAwal=$awal." 00:00:00";
				$pAkhir=$akhir." 23:59:59";
				if($kode=="All Item Code"){
					
					if($jenis=="All Group"){
						if($kode_customer=="All Customer"){
							if($branch=="All Branch"){												
								$sql="Select * from RETUR where faktur like '%$faktur%' and tanggal between '$pAwal' and '$pAkhir' order by tanggal, customer, faktur, jenis, barang, satuan, kode";
							}else{
								$sql="Select * from RETUR where faktur like '%$faktur%' and branch='$branch' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
							}
						}else{
							if($branch=="All Branch"){												
								$sql="Select * from RETUR where faktur like '%$faktur%' and kode_customer='$kode_customer' and tanggal between '$pAwal' and '$pAkhir' order by tanggal, customer, faktur, jenis, barang, satuan, kode";
							}else{
								$sql="Select * from RETUR where faktur like '%$faktur%' and kode_customer='$kode_customer' and branch='$branch' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
							}
						}
					}else{
						if($kode_customer=="All Customer"){
							if($branch=="All Branch"){												
								$sql="Select * from RETUR where faktur like '%$faktur%' and jenis='$jenis' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
							}else{
								$sql="Select * from RETUR where faktur like '%$faktur%' and branch='$branch' and jenis='$jenis' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
							}
						}else{
							if($branch=="All Branch"){												
								$sql="Select * from RETUR where faktur like '%$faktur%' and kode_customer='$kode_customer' and jenis='$jenis' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
							}else{
								$sql="Select * from RETUR where faktur like '%$faktur%' and kode_customer='$kode_customer' and branch='$branch' and jenis='$jenis' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
							}
						}
					}
					
					
					
					
					
					
				}else{
					
					if($kode_customer=="All Customer"){
						if($branch=="All Branch"){												
							$sql="Select * from RETUR where faktur like '%$faktur%' and jenis='$jenis' and kode='$kode' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
						}else{
							$sql="Select * from RETUR where faktur like '%$faktur%' and branch='$branch' and jenis='$jenis' and kode='$kode' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
						}
					}else{
						if($branch=="All Branch"){												
							$sql="Select * from RETUR where faktur like '%$faktur%' and kode_customer='$kode_customer' and jenis='$jenis' and kode='$kode' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
						}else{
							$sql="Select * from RETUR where faktur like '%$faktur%' and branch='$branch' and kode_customer='$kode_customer' and jenis='$jenis' and kode='$kode' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
						}
					}
					
					
					
					
					

				}
				
				$result = $con->query($sql);
				$count = mysqli_num_rows($result);
				if($count>0){
				    $totalreturn=0;
					while($row = mysqli_fetch_assoc($result))
					{
						$no++;
						$tanggal1=$row["tanggal"];
						$tanggal2=date('d/m/Y',strtotime($tanggal1));
						$customer2=$row["customer"];
						$salesman2=$row["salesman"];
						$faktur2=$row["faktur"];
						$kode2=$row["kode"];
						$jenis2=$row["jenis"];
						$subgroup2=$row["subgroup"];
						$merk2=$row["merk"];
						$barang2=$row["barang"];
						$satuan2=$row["satuan"];
						$qty2=$row["qty"];
						$descr2=$row["descr"];
						
						$username2=$row["username"];
						
						$totalreturn=$totalreturn+$qty2;
						
						echo"
							<tr style='font-size:small;'>
								<td>$no</td>
								<td>$tanggal2</td>
								<td>$customer2</td>
								<td>$faktur2</td>
								<td>$kode2</td>
								<td>$jenis2</td>
								<td>$merk2</td>
								<td>$barang2</td>
								<td>$descr2</td>
								<td align='center'>".number_format($qty2,0,',','.')."</td>
								<td align='center'>$satuan2</td>
							</tr>													
						";													
					}
					echo"
						<tr>
							<th colspan='9' class='text-right'>Grand Total</th>
							<th class='text-center' align='center'>".number_format($totalreturn,0,',','.')."</th>
							<th></th>
						</tr>
					";
					
				}else{
				    echo"<tr><td colspan='11' align='center'>No Data Found</td></tr>";
				}									
				?>											
			</tbody>
		</table>
		
	
	</page>	
	    
</body>
</html>
<script src="js/jquery-3.2.1.min.js"></script>

<?php
$halaman="return-report.php?faktur=$faktur&branch=$branch&awal=$awal&akhir=$akhir&kode_customer=$kode_customer&jenis=$jenis&kode=$kode&salesman=$salesman";
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
