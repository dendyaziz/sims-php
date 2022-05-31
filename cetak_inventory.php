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

    <title>Inventory Report :: <?php echo $app_name;?></title>	
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
			
			if(!empty($_POST['branch'])){$branch=$_POST["branch"];}else{if(!empty($_GET["branch"])){$branch=$_GET["branch"];}else{$branch=$_SESSION["iss21"]["branch"];}}
			if(!empty($_POST['awal'])){$awal=date('Y-m-d',strtotime($_POST['awal']));}else{if(!empty($_GET['awal'])){$awal=date('Y-m-d',strtotime($_GET['awal']));}else{$awal=date("Y-m-d");}}
			if(!empty($_POST['akhir'])){$akhir=date('Y-m-d',strtotime($_POST['akhir']));}else{if(!empty($_GET['akhir'])){$akhir=date('Y-m-d',strtotime($_GET['akhir']));}else{$akhir=date("Y-m-d");}}									
			
		?>
	
		<h5 class="card-title"><b><?php echo $branch; ?></b><br>Period <?php echo date('d/m/Y',strtotime($awal))." s/d ".date('d/m/Y',strtotime($akhir)); ?></h5>
		<table border="1" cellpadding="5" cellspacing="0" style='color:black;font-size:small;'>
			<thead>
				<tr>
					<th>Code</th>
					<th>Group</th>
					<th>Merk</th>
					<th>Item Description</th>
					<th>Opening Balance</th>
					<th>Received Items</th>
					<th>Outgoing Items</th>
					<th>Adjustment Stock</th>
					<th>Destruction</th>
					<th>Ending Balance</th>
					<th>Unit</th>
				</tr>
			</thead>
			<tbody>
				<?php
				
				$total_last=0;
				$total_incoming=0;
				$total_outgoing=0;
				$total_opname=0;
				$total_ending=0;
				$total_destroy=0;
				
				$count=0;
				$no=0;											
				$pAwal=$awal." 00:00:00";
				$pAkhir=$akhir." 23:59:59";
				
					$sql="
						Select a.kode, a.barang, a.jenis, a.subgroup, a.merk, a.satuan,
							ifnull((Select sum(b.qty) from PEMBELIAN b where b.branch='$branch' and a.kode=b.kode and b.tanggal<'$pAwal'),0)
							-											
							ifnull((Select sum(c.qty) from OUTGOING c where c.branch='$branch' and a.kode=c.kode and c.tanggal<'$pAwal'),0)
							-											
							ifnull((Select sum(c.qty) from PEMUSNAHAN c where c.branch='$branch' and a.kode=c.kode and c.tanggal<'$pAwal'),0)
							+											
							ifnull((Select sum(c.qty-c.stok) from OPNAME c where c.branch='$branch' and a.kode=c.kode and c.tanggal<'$pAwal'),0)
							
							as last,
							ifnull((Select sum(d.qty) from PEMBELIAN d where d.branch='$branch' and a.kode=d.kode and (d.tanggal between '$pAwal' and '$pAkhir')),0)as incoming,
							ifnull((Select sum(e.qty) from OUTGOING e where e.branch='$branch' and a.kode=e.kode and (e.tanggal between '$pAwal' and '$pAkhir')),0) as outgoing,
							ifnull((Select sum(g.qty-g.stok) from OPNAME g where  g.branch='$branch' and a.kode=g.kode and (g.tanggal between '$pAwal' and '$pAkhir')),0) as opname,
							ifnull((Select sum(h.qty) from PEMUSNAHAN h where  h.branch='$branch' and a.kode=h.kode and (h.tanggal between '$pAwal' and '$pAkhir')),0) as destroy
						from BARANG a
						group by a.kode, a.barang, a.jenis, a.subgroup, a.merk, a.satuan
						order by a.jenis, a.subgroup, a.merk, a.barang
					";
					
					$result = $con->query($sql);
					$count = mysqli_num_rows($result);
					if($count>0){
						while($row = mysqli_fetch_assoc($result))
						{
							$kode2=$row["kode"];
							$jenis2=$row["jenis"];
							$subgroup2=$row["subgroup"];
							$merk2=$row["merk"];
							$barang2=$row["barang"];
							$satuan2=$row["satuan"];														
							$last=$row["last"];														
							$incoming=$row["incoming"];														
							$outgoing=$row["outgoing"];
							$opname=$row["opname"];
							$destroy=$row["destroy"];
							
							echo"
								<tr style='font-size:small;'>
									<td>$kode2</td>
									<td>$jenis2</td>
									<td>$merk2</td>
									<td>$barang2</td>
									<td align='center'>".number_format($last,0,",",".")."</td>
									<td align='center'>".number_format($incoming,0,",",".")."</td>
									<td align='center'>".number_format($outgoing,0,",",".")."</td>
									<td align='center'>".number_format($opname,0,",",".")."</td>
									<td align='center'>".number_format($destroy,0,",",".")."</td>
									<td align='center'>".number_format($last+$incoming-$outgoing+$opname-$destroy,0,",",".")."</td>
									<td>$satuan2</td>
								</tr>
								
							";

							$total_last=$total_last+$last;
							$total_incoming=$total_incoming+$incoming;
							$total_outgoing=$total_outgoing+$outgoing;
							$total_opname=$total_opname+$opname;
							$total_destroy=$total_destroy+$destroy;
							
						}
						echo"
							<tr>
								<td align='center' colspan='4'><b>GRAND TOTAL</b></td>
								<td align='center'>".number_format($total_last,0,",",".")."</td>
								<td align='center'>".number_format($total_incoming,0,",",".")."</td>
								<td align='center'>".number_format($total_outgoing,0,",",".")."</td>
								<td align='center'>".number_format($total_opname,0,",",".")."</td>
								<td align='center'>".number_format($total_destroy,0,",",".")."</td>
								<td align='center'>".number_format($total_last+$total_incoming-$total_outgoing+$total_opname-$total_destroy,0,",",".")."</td>
								<td></td>
							</tr>	
						";
					}else{
    				    echo"
    						<tr><td colspan='12' align='center'>No Data Found</td></tr>
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
$halaman="inventory.php?awal=$awal&akhir=$akhir&branch=$branch";
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
