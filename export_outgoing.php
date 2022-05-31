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
			
			$file="Outgoing_Report.xls";
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
			
			if(!empty($_POST['salesman'])){$salesman=$_POST['salesman'];}else{if(!empty($_GET['salesman'])){$salesman=$_GET['salesman'];}else{$salesman="All Salesman";}}
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
			
			if(!empty($_POST['tipe_outgoing'])){$tipe_outgoing=$_POST['tipe_outgoing'];}else{if(!empty($_GET['tipe_outgoing'])){$tipe_outgoing=$_GET['tipe_outgoing'];}else{$tipe_outgoing="All Type Outgoing";}}
			
	$period="Period ".date('d/m/Y',strtotime($awal))." s/d ".date('d/m/Y',strtotime($akhir));
	$location='Location '.$branch;
	$table="
		<table width='100%' cellspacing='0' cellpadding='5'>
			<tr>
				<td><b>OUTGOING REPORT</b><br>$period<br>$location<br>Salesman $salesman</td>
			</tr>
		</table>
		<table border='1' width='100%' cellspacing='0' cellpadding='5'>
			<thead>
				
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Type</th>
					<th>Customer</th>
					<th>Faktur</th>
					<th>Tanggal PO</th>
					<th>Code</th>
					<th>Group</th>
					<th>Brand</th>
					<th>Item Description</th>
					<th>Qty</th>
					<th>Unit</th>
					";
					if($_SESSION["iss21"]["position"]=="Admin"){
    					$table.="
    					<th class='text-right'>Harga Jual</th>
    					<th class='text-right'>Total</th>
    					";
					}
					
			$table.="
			</thead>
			<tbody>
			";
			
			$count=0;
			$no=0;									
			$pAwal=$awal." 00:00:00";
			$pAkhir=$akhir." 23:59:59";
			if($tipe_outgoing=="All Type Outgoing"){
			    if($kode=="All Item Code"){
					
					if($jenis=="All Group"){
						if($kode_customer=="All Customer"){
							if($branch=="All Branch"){												
								$sql="Select * from OUTGOING where faktur like '%$faktur%' and tanggal between '$pAwal' and '$pAkhir' order by tanggal, customer, faktur, jenis, barang, satuan, kode";
							}else{
								$sql="Select * from OUTGOING where faktur like '%$faktur%' and branch='$branch' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
							}
						}else{
							if($branch=="All Branch"){												
								$sql="Select * from OUTGOING where faktur like '%$faktur%' and kode_customer='$kode_customer' and tanggal between '$pAwal' and '$pAkhir' order by tanggal, customer, faktur, jenis, barang, satuan, kode";
							}else{
								$sql="Select * from OUTGOING where faktur like '%$faktur%' and kode_customer='$kode_customer' and branch='$branch' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
							}
						}
					}else{
						if($kode_customer=="All Customer"){
							if($branch=="All Branch"){												
								$sql="Select * from OUTGOING where faktur like '%$faktur%' and jenis='$jenis' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
							}else{
								$sql="Select * from OUTGOING where faktur like '%$faktur%' and branch='$branch' and jenis='$jenis' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
							}
						}else{
							if($branch=="All Branch"){												
								$sql="Select * from OUTGOING where faktur like '%$faktur%' and kode_customer='$kode_customer' and jenis='$jenis' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
							}else{
								$sql="Select * from OUTGOING where faktur like '%$faktur%' and kode_customer='$kode_customer' and branch='$branch' and jenis='$jenis' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
							}
						}
					}
					
					
					
				}else{
					
					if($kode_customer=="All Customer"){
						if($branch=="All Branch"){												
							$sql="Select * from OUTGOING where faktur like '%$faktur%' and jenis='$jenis' and kode='$kode' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
						}else{
							$sql="Select * from OUTGOING where faktur like '%$faktur%' and branch='$branch' and jenis='$jenis' and kode='$kode' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
						}
					}else{
						if($branch=="All Branch"){												
							$sql="Select * from OUTGOING where faktur like '%$faktur%' and kode_customer='$kode_customer' and jenis='$jenis' and kode='$kode' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
						}else{
							$sql="Select * from OUTGOING where faktur like '%$faktur%' and branch='$branch' and kode_customer='$kode_customer' and jenis='$jenis' and kode='$kode' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
						}
					}
					
				
				}
			}else{
			    if($kode=="All Item Code"){
					
					if($jenis=="All Group"){
						if($kode_customer=="All Customer"){
							if($branch=="All Branch"){												
								$sql="Select * from OUTGOING where tipe_outgoing='$tipe_outgoing' and faktur like '%$faktur%' and tanggal between '$pAwal' and '$pAkhir' order by tanggal, customer, faktur, jenis, barang, satuan, kode";
							}else{
								$sql="Select * from OUTGOING where tipe_outgoing='$tipe_outgoing' and faktur like '%$faktur%' and branch='$branch' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
							}
						}else{
							if($branch=="All Branch"){												
								$sql="Select * from OUTGOING where tipe_outgoing='$tipe_outgoing' and faktur like '%$faktur%' and kode_customer='$kode_customer' and tanggal between '$pAwal' and '$pAkhir' order by tanggal, customer, faktur, jenis, barang, satuan, kode";
							}else{
								$sql="Select * from OUTGOING where tipe_outgoing='$tipe_outgoing' and faktur like '%$faktur%' and kode_customer='$kode_customer' and branch='$branch' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
							}
						}
					}else{
						if($kode_customer=="All Customer"){
							if($branch=="All Branch"){												
								$sql="Select * from OUTGOING where tipe_outgoing='$tipe_outgoing' and faktur like '%$faktur%' and jenis='$jenis' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
							}else{
								$sql="Select * from OUTGOING where tipe_outgoing='$tipe_outgoing' and faktur like '%$faktur%' and branch='$branch' and jenis='$jenis' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
							}
						}else{
							if($branch=="All Branch"){												
								$sql="Select * from OUTGOING where tipe_outgoing='$tipe_outgoing' and faktur like '%$faktur%' and kode_customer='$kode_customer' and jenis='$jenis' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
							}else{
								$sql="Select * from OUTGOING where tipe_outgoing='$tipe_outgoing' and faktur like '%$faktur%' and kode_customer='$kode_customer' and branch='$branch' and jenis='$jenis' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
							}
						}
					}
					
					
					
				}else{
					
					if($kode_customer=="All Customer"){
						if($branch=="All Branch"){												
							$sql="Select * from OUTGOING where tipe_outgoing='$tipe_outgoing' and faktur like '%$faktur%' and jenis='$jenis' and kode='$kode' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
						}else{
							$sql="Select * from OUTGOING where tipe_outgoing='$tipe_outgoing' and faktur like '%$faktur%' and branch='$branch' and jenis='$jenis' and kode='$kode' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
						}
					}else{
						if($branch=="All Branch"){												
							$sql="Select * from OUTGOING where tipe_outgoing='$tipe_outgoing' and faktur like '%$faktur%' and kode_customer='$kode_customer' and jenis='$jenis' and kode='$kode' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
						}else{
							$sql="Select * from OUTGOING where tipe_outgoing='$tipe_outgoing' and faktur like '%$faktur%' and branch='$branch' and kode_customer='$kode_customer' and jenis='$jenis' and kode='$kode' and (tanggal between '$pAwal' and '$pAkhir') order by tanggal, customer, faktur, jenis, barang, satuan, kode";
						}
					}
					
				
				}
			}
			
			$result = $con->query($sql);
			$count = mysqli_num_rows($result);
			if($count>0){
			    $totalqty=0;
			    $totaloutgoing=0;
				while($row = mysqli_fetch_assoc($result))
				{
					$no++;
					$tanggal1=$row["tanggal"];
					$tanggal2=date('d/m/Y',strtotime($tanggal1));
					$customer2=$row["customer"];
					$faktur2=$row["faktur"];
					$tipe2=$row["tipe_outgoing"];
					$po2=$row["po"];
					$tglpo2=$row["tglpo"];
					$tglpo2=date('d/m/Y',strtotime($tglpo2));
					$kode2=$row["kode"];
					$jenis2=$row["jenis"];
					$subgroup2=$row["subgroup"];
					$merk2=$row["merk"];
					$barang2=$row["barang"];
					$satuan2=$row["satuan"];
					$qty2=$row["qty"];
					$harga_jual2=$row["harga_jual"];
					$descr2=$row["descr"];
					
					$username2=$row["username"];
					
					
					$totaloutgoing=$totaloutgoing+($harga_jual2*$qty2);
					$totalqty=$totalqty+$qty2;
					
					$table.="
						<tr style='font-size:small;'>
							<td>$no</td>
							<td>$tanggal2</td>
							<td>$tipe2</td>
							<td>$customer2</td>
							<td>$faktur2</td>
							<td>$tglpo2</td>
							<td>$kode2</td>
							<td>$jenis2</td>
							<td>$merk2</td>
							<td>$barang2</td>
							<td align='right'>".number_format($qty2,0,',','.')."</td>
							<td>$satuan2</td>
							";
							if($_SESSION["iss21"]["position"]=="Admin"){
								$table.="
								<td align='right'>".number_format($harga_jual2,0,',','.')."</td>
								<td align='right'>".number_format(($harga_jual2*$qty2)-$disc,0,',','.')."</td>
								";
							}
					$table.="
						</tr>													
					";													
				}
				if($_SESSION["iss21"]["position"]=="Admin"){
					$table.="
						<tr>
							<th colspan='10' class='text-right'>Grand Total</th>
							<th class='text-right'>".number_format($totalqty,0,',','.')."</th>
							<th></th>
							<th class='text-right' colspan='2'>".number_format($totaloutgoing,0,',','.')."</th>
						</tr>
					";
				}else{
				    $table.="
						<tr>
							<th colspan='10' class='text-right'>Total</th>
							<th class='text-center' align='center'>".number_format($totalqty,0,',','.')."</th>
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

