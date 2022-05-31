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

    <title>Incoming Report :: <?php echo $app_name;?></title>	
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
			if(!empty($_POST['kode_supplier'])){$kode_supplier=$_POST['kode_supplier'];}else{if(!empty($_GET['kode_supplier'])){$kode_supplier=$_GET['kode_supplier'];}else{$kode_supplier="";}}
			if(!empty($kode_supplier)){
				$result = $con->query("Select * from SUPPLIER where kode='$kode_supplier'");											
				while($row = mysqli_fetch_assoc($result))
				{
					$supplier=$row["supplier"];
					$address=$row["address"];
					$phone=$row["phone"];
					$contact=$row["contact"];		
				}
			}else{
				$kode_supplier="All Supplier";
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
				<td><b>INCOMING REPORT</b><br><?php echo "Period ".date('d/m/Y',strtotime($awal))." s/d ".date('d/m/Y',strtotime($akhir));?><br><?php echo "Location ".$branch;?></td>
			</tr>
		</table>
		<table border="1" width="100%" cellspacing="0" cellpadding="5">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Code</th>
					<th>Group</th>
					<th>Item Description</th>
					<th>Qty</th>
					<th>Unit</th>
					<th>IN</th>
					<th>Ending Balance</th>
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
						if($kode_supplier=="All Supplier"){
							if($branch=="All Branch"){												
								$sql="
								Select a.tanggal, a.jenis, a.kode, a.barang, a.satuan,
										(Select sum(b.qty) from PEMBELIAN b where b.branch=b.branch and b.tanggal<'$pAwal' and b.kode=a.kode) as qty,
										(Select b.descr from PEMBELIAN b where b.branch=b.branch and b.tanggal=a.tanggal and b.kode=a.kode limit 1) as descr,
										(Select sum(b.qty) from PEMBELIAN b where b.branch=b.branch and (b.tanggal between '$pAwal' and '$pAkhir') and b.kode=a.kode) as incoming
									from PEMBELIAN a 
									where (a.tanggal between '$pAwal' and '$pAkhir')
									Group By a.tanggal, a.jenis, a.kode, a.barang, a.satuan
									order by a.jenis, a.kode, a.barang, a.satuan";
							}else{
								$sql="
								Select a.tanggal, a.jenis, a.kode, a.barang, a.satuan,
										(Select sum(b.qty) from PEMBELIAN b where b.branch=b.branch and b.tanggal<'$awal' and b.kode=a.kode) as qty,
										(Select b.descr from PEMBELIAN b where b.branch=b.branch and b.tanggal=a.tanggal and b.kode=a.kode limit 1) as descr,
										(Select sum(b.qty) from PEMBELIAN b where b.branch=b.branch and (b.tanggal between '$pAwal' and '$pAkhir') and b.kode=a.kode) as incoming
									from PEMBELIAN a
									Where a.branch='$branch' and (a.tanggal between '$pAwal' and '$pAkhir')
									Group By a.tanggal, a.jenis, a.kode, a.barang, a.satuan
									order by a.jenis, a.kode, a.barang, a.satuan";
							}
						}else{
							if($branch=="All Branch"){
								$sql="
								Select a.tanggal, a.jenis, a.kode, a.barang, a.satuan,
										(Select sum(b.qty) from PEMBELIAN b where b.branch=b.branch and b.tanggal<'$awal' and b.kode=a.kode) as qty,
										(Select b.descr from PEMBELIAN b where b.branch=b.branch and b.tanggal=a.tanggal and b.kode=a.kode limit 1) as descr,
										(Select sum(b.qty) from PEMBELIAN b where b.branch=b.branch and (b.tanggal between '$pAwal' and '$pAkhir') and b.kode=a.kode) as incoming
									from PEMBELIAN a
									Where a.kode_supplier='$kode_supplier' and (a.tanggal between '$pAwal' and '$pAkhir')
									Group By a.tanggal, a.jenis, a.kode, a.barang, a.satuan
									order by a.jenis, a.kode, a.barang, a.satuan";
							}else{
								$sql="
									Select a.tanggal, a.jenis, a.kode, a.barang, a.satuan,
										(Select sum(b.qty) from PEMBELIAN b where b.branch=b.branch and b.tanggal<'$awal' and b.kode=a.kode) as qty,
										(Select b.descr from PEMBELIAN b where b.branch=b.branch and b.tanggal=a.tanggal and b.kode=a.kode limit 1) as descr,
										(Select sum(b.qty) from PEMBELIAN b where b.branch=b.branch and (b.tanggal between '$pAwal' and '$pAkhir') and b.kode=a.kode) as incoming
									from PEMBELIAN a
									Where a.branch='$branch' and a.kode_supplier='$kode_supplier' and (a.tanggal between '$pAwal' and '$pAkhir')
									Group By a.tanggal, a.jenis, a.kode, a.barang, a.satuan
									order by a.jenis, a.kode, a.barang, a.satuan";
							}
						}
					}else{
						if($kode_supplier=="All Supplier"){
							if($branch=="All Branch"){	
								$sql="
								Select a.tanggal, a.jenis, a.kode, a.barang, a.satuan,
										(Select sum(b.qty) from PEMBELIAN b where b.branch=b.branch and b.tanggal<'$awal' and b.kode=a.kode) as qty,
										(Select b.descr from PEMBELIAN b where b.branch=b.branch and b.tanggal=a.tanggal and b.kode=a.kode limit 1) as descr,
										(Select sum(b.qty) from PEMBELIAN b where b.branch=b.branch and (b.tanggal between '$pAwal' and '$pAkhir') and b.kode=a.kode) as incoming
									from PEMBELIAN a
									Where a.jenis='$jenis'
									Group By a.tanggal, a.jenis, a.kode, a.barang, a.satuan
									order by a.jenis, a.kode, a.barang, a.satuan";
							}else{
								$sql="
								Select a.tanggal, a.jenis, a.kode, a.barang, a.satuan,
										(Select sum(b.qty) from PEMBELIAN b where b.branch=b.branch and b.tanggal<'$awal' and b.kode=a.kode) as qty,
										(Select b.descr from PEMBELIAN b where b.branch=b.branch and b.tanggal=a.tanggal and b.kode=a.kode limit 1) as descr,
										(Select sum(b.qty) from PEMBELIAN b where b.branch=b.branch and (b.tanggal between '$pAwal' and '$pAkhir') and b.kode=a.kode) as incoming
									from PEMBELIAN a
									Where a.branch='$branch' and a.jenis='$jenis' and (a.tanggal between '$pAwal' and '$pAkhir')
									Group By a.tanggal, a.jenis, a.kode, a.barang, a.satuan
									order by a.jenis, a.kode, a.barang, a.satuan";
							}
						}else{
							if($branch=="All Branch"){	
								$sql="
								Select a.tanggal, a.jenis, a.kode, a.barang, a.satuan,
										(Select sum(b.qty) from PEMBELIAN b where b.branch=b.branch and b.tanggal<'$awal' and b.kode=a.kode) as qty,
										(Select b.descr from PEMBELIAN b where b.branch=b.branch and b.tanggal=a.tanggal and b.kode=a.kode limit 1) as descr,
										(Select sum(b.qty) from PEMBELIAN b where b.branch=b.branch and (b.tanggal between '$pAwal' and '$pAkhir') and b.kode=a.kode) as incoming
									from PEMBELIAN a
									Where a.kode_supplier='$kode_supplier' and a.jenis='$jenis' and (a.tanggal between '$pAwal' and '$pAkhir')
									Group By a.tanggal, a.jenis, a.kode, a.barang, a.satuan
									order by a.jenis, a.kode, a.barang, a.satuan";
							}else{
								$sql="
								Select a.tanggal, a.jenis, a.kode, a.barang, a.satuan,
										(Select sum(b.qty) from PEMBELIAN b where b.branch=b.branch and b.tanggal<'$awal' and b.kode=a.kode) as qty,
										(Select b.descr from PEMBELIAN b where b.branch=b.branch and b.tanggal=a.tanggal and b.kode=a.kode limit 1) as descr,
										(Select sum(b.qty) from PEMBELIAN b where b.branch=b.branch and (b.tanggal between '$pAwal' and '$pAkhir') and b.kode=a.kode) as incoming
									from PEMBELIAN a
									Where a.kode_supplier='$kode_supplier' and a.branch='$branch' and a.jenis='$jenis' and (a.tanggal between '$pAwal' and '$pAkhir')
									Group By a.tanggal, a.jenis, a.kode, a.barang, a.satuan
									order by a.jenis, a.kode, a.barang, a.satuan";
							}
						}
					}
				}else{
					
					if($kode_supplier=="All Supplier"){
						if($branch=="All Branch"){	
							$sql="
								Select a.tanggal, a.jenis, a.kode, a.barang, a.satuan,
										(Select sum(b.qty) from PEMBELIAN b where b.branch=b.branch and b.tanggal<'$awal' and b.kode=a.kode) as qty,
										(Select b.descr from PEMBELIAN b where b.branch=b.branch and b.tanggal=a.tanggal and b.kode=a.kode limit 1) as descr,
										(Select sum(b.qty) from PEMBELIAN b where b.branch=b.branch and (b.tanggal between '$pAwal' and '$pAkhir') and b.kode=a.kode) as incoming
									from PEMBELIAN a
									Where a.jenis='$jenis' and a.kode='$kode' and (a.tanggal between '$pAwal' and '$pAkhir')
									Group By a.tanggal, a.jenis, a.kode, a.barang, a.satuan
									order by a.jenis, a.kode, a.barang, a.satuan";
						}else{
							$sql="
								Select a.tanggal, a.jenis, a.kode, a.barang, a.satuan,
										(Select sum(b.qty) from PEMBELIAN b where b.branch=b.branch and b.tanggal<'$awal' and b.kode=a.kode) as qty,
										(Select sum(b.qty) from PEMBELIAN b where b.branch=b.branch and (b.tanggal between '$pAwal' and '$pAkhir') and b.kode=a.kode) as incoming
									from PEMBELIAN a
									Where a.branch='$branch' and a.jenis='$jenis' and a.kode='$kode' and (a.tanggal between '$pAwal' and '$pAkhir')
									Group By a.tanggal, a.jenis, a.kode, a.barang, a.satuan
									order by a.jenis, a.kode, a.barang, a.satuan";
						}
					}else{
						if($branch=="All Branch"){
							$sql="
								Select a.tanggal, a.jenis, a.kode, a.barang, a.satuan,
										(Select sum(b.qty) from PEMBELIAN b where b.branch=b.branch and b.tanggal<'$awal' and b.kode=a.kode) as qty,
										(Select b.descr from PEMBELIAN b where b.branch=b.branch and b.tanggal=a.tanggal and b.kode=a.kode limit 1) as descr,
										(Select sum(b.qty) from PEMBELIAN b where b.branch=b.branch and (b.tanggal between '$pAwal' and '$pAkhir') and b.kode=a.kode) as incoming
									from PEMBELIAN a
									Where a.kode_supplier='$kode_supplier' and a.jenis='$jenis' and a.kode='$kode' and (a.tanggal between '$pAwal' and '$pAkhir')
									Group By a.tanggal, a.jenis, a.kode, a.barang, a.satuan
									order by a.jenis, a.kode, a.barang, a.satuan";
						}else{
							$sql="
								Select a.tanggal, a.jenis, a.kode, a.barang, a.satuan,
										(Select sum(b.qty) from PEMBELIAN b where b.branch=b.branch and b.tanggal<'$awal' and b.kode=a.kode) as qty,
										(Select b.descr from PEMBELIAN b where (b.tanggal between '$pAwal' and '$pAkhir') and b.kode=a.kode limit 1) as descr,
										(Select sum(b.qty) from PEMBELIAN b where (b.tanggal between '$pAwal' and '$pAkhir') and b.kode=a.kode) as incoming
									from PEMBELIAN a
									Where a.branch='$branch' and a.kode_supplier='$kode_supplier' and a.jenis='$jenis' and a.kode='$kode' and (a.tanggal between '$pAwal' and '$pAkhir')
									Group By a.tanggal, a.jenis, a.kode, a.barang, a.satuan
									order by a.jenis, a.kode, a.barang, a.satuan";
						}
					}

				}
				
				$result = $con->query($sql);
				$count = mysqli_num_rows($result);
				if($count>0){
					$total_last_in=0;
					$total_in=0;
					$total_ending=0;
					while($row = mysqli_fetch_assoc($result))
					{
						$no++;
						$tanggal2=$row["tanggal"];
						$kode2=$row["kode"];
						$jenis2=$row["jenis"];
						$barang2=$row["barang"];
						$satuan2=$row["satuan"];
						$qty2=$row["qty"];
						if(empty($qty2)){$qty2=0;}
						$incoming2=$row["incoming"];
						if(empty($incoming2)){$incoming2=0;}
						$ending2=$qty2+$incoming2;
						if(empty($ending2)){$ending2=0;}
																				
						$total_last_in=$total_last_in+$qty2;
						$total_in=$total_in+$incoming2;														
						$total_ending=$total_ending+$ending2;
						
						$descr2=$row["descr"];
						
						echo"
							<tr style='font-size:small;'>
								<td>$no</td>
								<td nowrap>$tanggal2</td>
								<td>$kode2</td>
								<td>$jenis2</td>
								<td>$barang2</td>
								<td align='center'>".number_format($qty2,0,',','.')."</td>
								<td>$satuan2</td>
								<td align='center'>".number_format($incoming2,0,',','.')."</td>
								<td align='center'>".number_format($ending2,0,',','.')."</td>																
							</tr>													
						";	
					}
					echo"
						<tr>
							<th colspan='5' class='text-right'>Grand Total</th>
							<th class='text-center'>".number_format($total_last_in,0,',','.')."</th>
							<th></th>
							<th class='text-center'>".number_format($total_in,0,',','.')."</th>
							<th class='text-center'>".number_format($total_ending,0,',','.')."</th>															
						</tr>
					";
				}else{
				    echo"
						<tr><td colspan='9' align='center'>No Data Found</td></tr>
					";
				}
												
				?>											
			</tbody>
		</table>
		
	
	</page>	
	    
</body>
</html>
<script src="js/jquery-3.2.1.min.js"></script>

<?php
$halaman="incoming-report.php?faktur=$faktur&branch=$branch&awal=$awal&akhir=$akhir&kode_supplier=$kode_supplier&jenis=$jenis&kode=$kode";
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
