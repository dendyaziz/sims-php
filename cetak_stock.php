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

    <title>Stock Report :: <?php echo $app_name;?></title>	
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
		?>
	
		<table width="100%" cellspacing="0" cellpadding="5">
			<tr>
				<td><b>STOCK REPORT</b><br><?php echo "Last Date ".date("d/m/Y H:m:s");?><br><?php echo "Location ".$branch;?></td>
			</tr>
		</table>
		<table border="1" width="100%" cellspacing="0" cellpadding="5">
			<thead>
				<tr>
					<th>No</th>
					<th>Code</th>
					<th>Group</th>
					<th>Merk</th>
					<th>Item Description</th>
					<th>Saldo</th>
					<th>Unit</th>
					<?php if($_SESSION["iss21"]["position"]=="Admin"){ ?>
					<th class="text-right">Nilai Beli</th>
					<th class="text-right">Nilai Jual</th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php
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
						echo"
							<tr>
								<td>$no</td>
								<td>$kode2</td>
								<td>$jenis2</td>
								<td>$merk2</td>
								<td>$barang2</td>
								<td class='text-center' align='center'>".number_format($saldo2,0,',','.')."</td>
								<td class='text-center' align='center'>$satuan2</td>
								";
								if($_SESSION["iss21"]["position"]=="Admin"){
								    echo"
								    <td align='right'>".number_format($saldo2*$harga_beli2,0,',','.')."</td>
								    <td align='right'>".number_format($saldo2*$harga_jual2,0,',','.')."</td>
								    ";
								}
						echo"		
							</tr>
						";													
					}
					if($_SESSION["iss21"]["position"]=="Admin"){
					    echo"
							<tr>
								<th colspan='5' class='text-right' align='right'>Grand Total</th>
								<th class='text-center' align='center'>".number_format($totalsaldo,0,',','.')."</th>
								<th></th>
								<th class='text-right'>".number_format($totalbeli,0,',','.')."</th>
								<th class='text-right'>".number_format($totaljual,0,',','.')."</th>
							</tr>
						";
					}else{
					    echo"
							<tr>
								<th colspan='5' class='text-right' align='right'>Grand Total</th>
								<th class='text-center' align='center'>".number_format($totalsaldo,0,',','.')."</th>
								<th></th>
							</tr>
						";
					}
				}else{
				    if($_SESSION["iss21"]["position"]=="Admin"){
					    echo"<tr><td colspan='9' align='center'>No Data Found</td></tr>";
				    }else{
				        echo"<tr><td colspan='7' align='center'>No Data Found</td></tr>";
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
$halaman="stock.php?branch=$branch&jenis=$jenis&kode=$kode";
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
