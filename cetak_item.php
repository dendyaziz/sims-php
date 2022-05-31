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

    <title>List Items :: <?php echo $app_name;?></title>	
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
			if(!empty($_POST['jenis'])){$jenis=$_POST['jenis'];}else{if(!empty($_GET['jenis'])){$jenis=$_GET['jenis'];}else{$jenis="All Group";}}
		?>
	
		<table width="100%" cellspacing="0" cellpadding="5">
			<tr>
				<td><b>LIST ITEMS</b></td>
			</tr>
			<tr>
				<td><b><?php echo "Last Date ".date("d/m/Y H:m:s");?></b></td>
			</tr>
		</table>
		<table border="1" width="100%" cellspacing="0" cellpadding="5">
			<thead>
				<tr>
					<th>No</th>
					<th>Code</th>
					<th>Group</th>
					<th>Sub Group</th>
					<th>Merk</th>
					<th>Item Description</th>												
					<th>Unit</th>
					<th class="text-right">Harga Beli</th>
					<th class="text-right">Harga Jual</th>
				</tr>
			</thead>
			<tbody>
				<?php
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
						echo"
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
				?>											
			</tbody>
		</table>
		
	
	</page>	
	    
</body>
</html>
<script src="js/jquery-3.2.1.min.js"></script>

<?php
$halaman="all-item.php?jenis=$jenis";
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
