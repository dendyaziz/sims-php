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

    <title>Return Transaction Report :: <?php echo $app_name;?></title>	
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
			
			if(!empty($_POST['nik'])){$nik=$_POST['nik'];}else{if(!empty($_GET['nik'])){$nik=$_GET['nik'];}else{$nik="";}}
			if(!empty($nik)){
				$result = $con->query("Select * from KARYAWAN where nik='$nik'");											
				while($row = mysqli_fetch_assoc($result))
				{
					$fullname=$row["fullname"];
					$address=$row["address"];
					$phone=$row["phone"];
					$position=$row["position"];
					$dept=$row["dept"];
				}
			}else{
				$nik="All Employee";
			}
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
				<td><b>RETURN TRANSACTION REPORT</b><br><?php echo "Period ".date('d/m/Y',strtotime($awal))." s/d ".date('d/m/Y',strtotime($akhir));?><br><?php echo "Location ".$branch;?></td>
			</tr>
		</table>
		<table border="1" width="100%" cellspacing="0" cellpadding="5">
			<thead>
				<tr>
					<tr>
						<th>No</th>
						<th>Faktur</th>
						<th>Tanggal</th>
						<th>Employee</th>
						<th>Code</th>
						<th>Item Description</th>
						<th>Category</th>	
						<th>Uom</th>
						<th class="text-right">Qty</th>
					</tr>
				</tr>
			</thead>
			<tbody>
				<?php
				$count=0;
				$no=0;									
				$pAwal=$awal." 00:00:00";
				$pAkhir=$akhir." 23:59:59";
				if($kode=="All Item Code"){
					if($jenis=="All Category"){
						if($nik=="All Employee"){
							if($branch=="All Branch"){												
								$sql="Select * from RETUR where tanggal between '$pAwal' and '$pAkhir' order by tanggal, fullname, faktur, jenis, barang, satuan, kode";
							}else{
								$sql="Select * from RETUR where branch='$branch' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, fullname, faktur, jenis, barang, satuan, kode";
							}
						}else{
							if($branch=="All Branch"){												
								$sql="Select * from RETUR where nik='$nik' and tanggal between '$pAwal' and '$pAkhir' order by tanggal, fullname, faktur, jenis, barang, satuan, kode";
							}else{
								$sql="Select * from RETUR where nik='$nik' and branch='$branch' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, fullname, faktur, jenis, barang, satuan, kode";
							}
						}
					}else{
						if($nik=="All Employee"){
							if($branch=="All Branch"){												
								$sql="Select * from RETUR where jenis='$jenis' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, fullname, faktur, jenis, barang, satuan, kode";
							}else{
								$sql="Select * from RETUR where branch='$branch' and jenis='$jenis' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, fullname, faktur, jenis, barang, satuan, kode";
							}
						}else{
							if($branch=="All Branch"){												
								$sql="Select * from RETUR where nik='$nik' and jenis='$jenis' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, fullname, faktur, jenis, barang, satuan, kode";
							}else{
								$sql="Select * from RETUR where nik='$nik' and branch='$branch' and jenis='$jenis' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, fullname, faktur, jenis, barang, satuan, kode";
							}
						}
					}
				}else{
					
					if($nik=="All Employee"){
						if($branch=="All Branch"){												
							$sql="Select * from RETUR where jenis='$jenis' and kode='$kode' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, fullname, faktur, jenis, barang, satuan, kode";
						}else{
							$sql="Select * from RETUR where branch='$branch' and jenis='$jenis' and kode='$kode' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, fullname, faktur, jenis, barang, satuan, kode";
						}
					}else{
						if($branch=="All Branch"){												
							$sql="Select * from RETUR where nik='$nik' and jenis='$jenis' and kode='$kode' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, fullname, faktur, jenis, barang, satuan, kode";
						}else{
							$sql="Select * from RETUR where branch='$branch' and nik='$nik' and jenis='$jenis' and kode='$kode' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, fullname, faktur, jenis, barang, satuan, kode";
						}
					}

				}
				$result = $con->query($sql);
				$count = mysqli_num_rows($result);
				if($count>0){
					while($row = mysqli_fetch_assoc($result))
					{
						$no++;
						$tanggal2=$row["tanggal"];
						$tanggal2=date('Y-m-d',strtotime($tanggal2));
						$fullname2=$row["fullname"];
						$faktur2=$row["faktur"];
						$kode2=$row["kode"];
						$jenis2=$row["jenis"];
						$barang2=$row["barang"];
						$satuan2=$row["satuan"];
						$qty2=$row["qty"];
						if(empty($qty2)){$qty2=0;}
						
						$username2=$row["username"];
						
						echo"
							<tr style='font-size:small;'>
								<td>$no</td>
								<td>$faktur2</td>
								<td>$tanggal2</td>
								<td>$fullname2</td>
								<td>$kode2</td>
								<td>$barang2</td>
								<td>$jenis2</td>
								<td>$satuan2</td>
								<td align='right'>".number_format($qty2)."</td>															
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
$halaman="retur-report.php?faktur=$faktur&branch=$branch&awal=$awal&akhir=$akhir&nik=$nik&jenis=$jenis&kode=$kode";
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
