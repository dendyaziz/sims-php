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
			
			$file="All_Items.xls";
			
			if(!empty($_POST['jenis'])){$jenis=$_POST['jenis'];}else{if(!empty($_GET['jenis'])){$jenis=$_GET['jenis'];}else{$jenis="All Group";}}
	$lastdate='Last Date '.date('d/m/Y H:m:s');
	$table="
		<table width='100%' cellspacing='0' cellpadding='5'>
			<tr>
				<td><b>LIST ITEMS</b><br>$lastdate</td>
			</tr>
		</table>
		<table border='1' width='100%' cellspacing='0' cellpadding='5'>
			<thead>
				<tr>
					<th>No</th>
					<th>Code</th>
					<th>Group</th>
					<th>Sub Group</th>
					<th>Merk</th>
					<th>Item Description</th>												
					<th>Unit</th>
					<th class='text-right'>Harga Beli</th>
					<th class='text-right'>Harga Jual</th>
				</tr>
			</thead>
			<tbody>
			";
			
			$count=0;
			$no=0;
			if($jenis=="All Group"){
				$sql="Select * from BARANG order by barang";
			}else{
				$sql="Select * from BARANG where jenis='$jenis' order by barang";
			}
			$result = $con->query($sql);
			$count = mysqli_num_rows($result);
			if($count>0){
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
					$table.="
						<tr>
							<td>$no</td>
							<td>$kode2</td>
							<td>$jenis2</td>
							<td>$subgroup2</td>
							<td>$merk2</td>
							<td>$barang2</td>
							<td>$satuan2</td>
							<td align='right'>".number_format($harga_beli2,0,",",".")."</td>
							<td align='right'>".number_format($harga_jual2,0,",",".")."</td>
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

