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
		<?php		
			
			/*
				XLS
				$file="demo.xls";
				$test="<table  ><tr><td>Cell 1</td><td>Cell 2</td></tr></table>";
				header("Content-type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=$file");
				echo $test;
				
				XLSX
				$file="demo.xls";
				$test="<table  ><tr><td>Cell 1</td><td>Cell 2</td></tr></table>";
				header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
				header("Content-Disposition: attachment; filename=$file");
				echo $test;
			*/
			
			$file="Destruction_Transaction_Report.xls";
			if(!empty($_POST['faktur'])){$faktur=$_POST['faktur'];}else{if(!empty($_GET['faktur'])){$faktur=$_GET['faktur'];}else{$faktur="";}}	
			if(!empty($_POST['branch'])){$branch=$_POST["branch"];}else{if(!empty($_GET["branch"])){$branch=$_GET["branch"];}else{if(strtolower($_SESSION["iss21"]["level"])=="admin"){$branch="All Branch";}else{$branch=$_SESSION["iss21"]["branch"];}}}
			if(!empty($_POST['awal'])){$awal=date('Y-m-d',strtotime($_POST['awal']));}else{if(!empty($_GET['awal'])){$awal=date('Y-m-d',strtotime($_GET['awal']));}else{$awal=date("Y-m-d");}}
			if(!empty($_POST['akhir'])){$akhir=date('Y-m-d',strtotime($_POST['akhir']));}else{if(!empty($_GET['akhir'])){$akhir=date('Y-m-d',strtotime($_GET['akhir']));}else{$akhir=date("Y-m-d");}}									
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
			
			
			
	$period="Period ".date('d/m/Y',strtotime($awal))." s/d ".date('d/m/Y',strtotime($akhir));
	$location='Location '.$branch;
	$table="
		<table width='100%' cellspacing='0' cellpadding='5'>
			<tr>
				<td><b>DESTRUCTION TRANSACTION REPORT</b><br>$period<br>$location<br>Salesman $salesman</td>
			</tr>
		</table>
		<table border='1' width='100%' cellspacing='0' cellpadding='5'>
			<thead>
				
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Faktur</th>
					<th>Code</th>
					<th>Group</th>
					<th>Merk</th>
					<th>Item Description</th>
					<th>Keterangan</th>
					<th>Destruction</th>
					<th>Unit</th>
				</tr>
				
			</thead>
			<tbody>
			";
			
			$count=0;
			$no=0;											
			$pAwal=$awal." 00:00:00";
			$pAkhir=$akhir." 23:59:59";
			if($kode=="All Item Code"){
				if($jenis=="All Category"){
					if($branch=="All Branch"){												
						$sql="Select * from PEMUSNAHAN where faktur like '%$faktur%' and tanggal between '$pAwal' and '$pAkhir' order by tanggal, faktur, jenis, barang, satuan, kode";
					}else{
						$sql="Select * from PEMUSNAHAN where faktur like '%$faktur%' and branch='$branch' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, faktur, jenis, barang, satuan, kode";
					}
				}else{
					if($branch=="All Branch"){												
						$sql="Select * from PEMUSNAHAN where faktur like '%$faktur%' and jenis='$jenis' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, faktur, jenis, barang, satuan, kode";
					}else{
						$sql="Select * from PEMUSNAHAN where faktur like '%$faktur%' and branch='$branch' and jenis='$jenis' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, faktur, jenis, barang, satuan, kode";
					}
				}
			}else{
				
				if($branch=="All Branch"){												
					$sql="Select * from PEMUSNAHAN where faktur like '%$faktur%' and jenis='$jenis' and kode='$kode' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, faktur, jenis, barang, satuan, kode";
				}else{
					$sql="Select * from PEMUSNAHAN where faktur like '%$faktur%' and branch='$branch' and jenis='$jenis' and kode='$kode' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, faktur, jenis, barang, satuan, kode";
				}

			}
			$grandtotal=0;
			$result = $con->query($sql);
			$count = mysqli_num_rows($result);
			if($count>0){
			    $totaldestroy=0;
				while($row = mysqli_fetch_assoc($result))
				{
					$no++;
					$tanggal2=$row["tanggal"];
					$tanggal2=date('Y-m-d',strtotime($tanggal2));
					
					$faktur2=$row["faktur"];
					$kode2=$row["kode"];
					$jenis2=$row["jenis"];
					$subgroup2=$row["subgroup"];
					$merk2=$row["merk"];
					$barang2=$row["barang"];
					$satuan2=$row["satuan"];
					$qty2=$row["qty"];
					$keterangan2=$row["keterangan"];
					
					$username2=$row["username"];
					$totaldestroy=$totaldestroy+$qty2;
					
					$table.="
						<tr style='font-size:small;'>
							<td>$no</td>
							<td>$tanggal2</td>
							<td>$faktur2</td>
							<td>$kode2</td>
							<td>$jenis2</td>
							<td>$merk2</td>
							<td>$barang2</td>
							<td>$keterangan2</td>
							<td align='center'>".number_format($qty2)."</td>
							<td align='center'>$satuan2</td>
						</tr>
					";													
				}
				$table.="
					<tr>
						<th colspan='8' class='text-right'>Grand Total</th>
						<th class='text-center' align='center'>".number_format($totaldestroy,0,',','.')."</th>
						<th></th>
					</tr>
				";
			}else{
			    $table.="
					<tr><td colspan='10' align='center'>No Data Found</td></tr>
				";
			}		
													
	$table.="
			</tbody>
		</table>";

	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
	echo $table;
?>

