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
			
			$file="Laporan_Penerimaan_Barang.xls";
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
				$fullname="";		
				$address="";
				$phone="";
				$position="";		
				$dept="";	
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
			
			
			
	$period='Periode '.date('d/m/Y',strtotime($awal))." s/d ".date('d/m/Y',strtotime($akhir));
	$penerima='Penerima '.$nik." | ".$fullname." | ".$position." | ".$dept;
	$table="
		<table width='100%' cellspacing='0' cellpadding='5'>
			<tr>
				<td><b>LAPORAN PENERIMAAN BARANG</b><br>$period<br>$penerima</td>
			</tr>
		</table>
		<table border='1' width='100%' cellspacing='0' cellpadding='5'>
			<thead>
				<tr>
					<th>No</th>
					<th>Code</th>
					<th>Item Description</th>
					<th>Category</th>
					<th>Uom</th>
					<th class='text-right'>Qty</th>
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
					$sql="Select kode, barang, jenis, satuan, sum(qty) as terima 
					from OUTGOING 
					where (tanggal between '$pAwal' and '$pAkhir') and fullname='$fullname'
					group by kode, barang, jenis, satuan
					order by barang";
				}else{
					$sql="Select kode, barang, jenis, satuan, sum(qty) as terima 
					from OUTGOING 
					where (tanggal between '$pAwal' and '$pAkhir') and fullname='$fullname' and jenis='$jenis'
					group by kode, barang, jenis, satuan
					order by barang";
				}
			}else{
				if($jenis=="All Category"){
					$sql="Select kode, barang, jenis, satuan, sum(qty) as terima 
					from OUTGOING 
					where (tanggal between '$pAwal' and '$pAkhir') and fullname='$fullname' and kode='$kode'
					group by kode, barang, jenis, satuan
					order by barang";
				}else{
					$sql="Select kode, barang, jenis, satuan, sum(qty) as terima 
					from OUTGOING 
					where (tanggal between '$pAwal' and '$pAkhir') and fullname='$fullname' and jenis='$jenis' and kode='$kode'
					group by kode, barang, jenis, satuan
					order by barang";
				}
			}
			$result = $con->query($sql);
			$count = mysqli_num_rows($result);
			if($count>0){
				while($row = mysqli_fetch_assoc($result))
				{
					$no++;
					$kode2=$row["kode"];
					$jenis2=$row["jenis"];
					$barang2=$row["barang"];
					$satuan2=$row["satuan"];
					$terima2=$row["terima"];
					
					$table.="
						<tr style='font-size:small;'>
							<td>$no</td>
							<td>$kode2</td>
							<td>$barang2</td>
							<td>$jenis2</td>
							<td>$satuan2</td>
							<td align='right'>".number_format($terima2)."</td>
						</tr>
						
					";													
				}												
			}
													
	$table.="
			</tbody>
		</table>";

	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
	echo $table;
?>

