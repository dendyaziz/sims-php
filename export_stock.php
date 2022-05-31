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
			
			$file="Stock_Report.xls";
			if(!empty($_POST['branch'])){$branch=$_POST["branch"];}else{if(!empty($_GET["branch"])){$branch=$_GET["branch"];}else{if(strtolower($_SESSION["iss21"]["level"])=="admin"){$branch="All Branch";}else{$branch=$_SESSION["iss21"]["branch"];}}}
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
			
			
			
	$lastdate='Last Date '.date('d/m/Y H:m:s');
	$location='Location '.$branch;
	$table="
		<table width='100%' cellspacing='0' cellpadding='5'>
			<tr>
				<td><b>STOCK REPORT</b><br>$lastdate<br>$location</td>
			</tr>
		</table>
		<table border='1' width='100%' cellspacing='0' cellpadding='5'>
			<thead>
				<tr>
					<th>No</th>
					<th>Code</th>
					<th>Group</th>
					<th>Merk</th>
					<th>Item Description</th>
					<th class='text-center' align='center'>Saldo</th>
					<th class='text-center' align='center'>Unit</th>
					";
					if($_SESSION["iss21"]["position"]=="Admin"){
    					$table.="
    					<th class='text-right'>Nilai Beli</th>
    					<th class='text-right'>Nilai Jual</th>";
					}
			$table.="
				</tr>
			</thead>
			<tbody>
			";
			
			$nominal=0;
			$count=0;
			$no=0;
			if($kode=="All Item Code"){
				if($jenis=="All Group"){											
					if($branch=="All Branch"){
						$sql="Select a.kode, a.jenis, a.subgroup, a.merk, a.barang, a.satuan, sum(a.saldo) as saldo, b.harga_beli, b.harga_jual from STOK a inner join BARANG b on a.kode=b.kode group by a.kode, a.jenis, a.subgroup, a.merk, a.barang, a.satuan, b.harga_beli, b.harga_jual order by a.jenis,a.barang,a.satuan";
					}else{
						$sql="Select a.kode, a.jenis, a.subgroup, a.merk, a.barang, a.satuan, sum(a.saldo) as saldo, b.harga_beli, b.harga_jual from STOK a inner join BARANG b on a.kode=b.kode where a.branch='$branch' group by a.kode, a.jenis, a.subgroup, a.merk, a.barang, a.satuan, b.harga_beli, b.harga_jual order by a.jenis,a.barang,a.satuan";
					}												
				}else{
					if($branch=="All Branch"){
						$sql="Select a.kode, a.jenis, a.subgroup, a.merk, a.barang, a.satuan, sum(a.saldo) as saldo, b.harga_beli, b.harga_jual from STOK a inner join BARANG b on a.kode=b.kode where a.jenis='$jenis' group by a.kode, a.jenis, a.subgroup, a.merk, a.barang, a.satuan, b.harga_beli, b.harga_jual order by a.jenis,a.barang,a.satuan";
					}else{
						$sql="Select a.kode, a.jenis, a.subgroup, a.merk, a.barang, a.satuan, sum(a.saldo) as saldo, b.harga_beli, b.harga_jual from STOK a inner join BARANG b on a.kode=b.kode where a.branch='$branch' and a.jenis='$jenis' group by a.kode, a.jenis, a.subgroup, a.merk, a.barang, a.satuan, b.harga_beli, b.harga_jual order by a.jenis,a.barang,a.satuan";
					}
				}
			}else{
				if($branch=="All Branch"){
					$sql="Select a.kode, a.jenis, a.subgroup, a.merk, a.barang, a.satuan, sum(a.saldo) as saldo, b.harga_beli, b.harga_jual from STOK a inner join BARANG b on a.kode=b.kode where a.jenis='$jenis' and a.kode='$kode' group by a.kode, a.jenis, a.subgroup, a.merk, a.barang, a.satuan, b.harga_beli, b.harga_jual order by a.jenis,a.barang,a.satuan";
				}else{
					$sql="Select a.kode, a.jenis, a.subgroup, a.merk, a.barang, a.satuan, sum(a.saldo) as saldo, b.harga_beli, b.harga_jual from STOK a inner join BARANG b on a.kode=b.kode where a.branch='$branch' and a.jenis='$jenis' and a.kode='$kode' group by a.kode, a.jenis, a.subgroup, a.merk, a.barang, a.satuan, b.harga_beli, b.harga_jual order by a.jenis,a.barang,a.satuan";
				}												
			}
			$result = $con->query($sql);
			$count = mysqli_num_rows($result);
			if($count>0){
			    $totalsaldo=0;
				$totalbeli=0;
				$totaljual=0;
				while($row = mysqli_fetch_assoc($result))
				{
					$no++;
					$kode2=$row["kode"];
					$jenis2=$row["jenis"];
					$subgroup2=$row["subgroup"];
					$merk2=$row["merk"];
					$barang2=$row["barang"];
					$satuan2=$row["satuan"];
					$harga_beli2=$row["harga_beli"];
					$harga_jual2=$row["harga_jual"];
					$saldo2=$row["saldo"];
					$totalbeli=$totalbeli+($saldo2*$harga_beli2);
					$totaljual=$totaljual+($saldo2*$harga_jual2);
					$totalsaldo=$totalsaldo+$saldo2;
					$table.="
						<tr>
							<td>$no</td>
							<td>$kode2</td>
							<td>$jenis2</td>
							<td>$merk2</td>
							<td>$barang2</td>
							td align='right'>".number_format($saldo2,0,',','.')."</td>
							<td>$satuan2</td>
							";
							if($_SESSION["iss21"]["position"]=="Admin"){
							    $table.="
							    <td align='right'>".number_format($saldo2*$harga_beli2,0,',','.')."</td>
							    <td align='right'>".number_format($saldo2*$harga_jual2,0,',','.')."</td>
							    ";
							}
					$table.="		
						</tr>
					";														
				}
				if($_SESSION["iss21"]["position"]=="Admin"){
				    $table.="
						<tr>
							<th colspan='5' class='text-right' align='right'>Grand Total</th>
							<th class='text-center' align='center'>".number_format($totalsaldo,0,',','.')."</th>
							<th></th>
							<th class='text-right'>".number_format($totalbeli,0,',','.')."</th>
							<th class='text-right'>".number_format($totaljual,0,',','.')."</th>
						</tr>
					";
				}else{
				    $table.="
						<tr>
							<th colspan='5' class='text-right' align='right'>Grand Total</th>
							<th class='text-center' align='center'>".number_format($totalsaldo,0,',','.')."</th>
							<th></th>
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

