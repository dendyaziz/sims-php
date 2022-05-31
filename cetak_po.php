<?php
session_start();
include("fc/fc_config.php");
if($_SESSION["iss21"]["authentication"]=="VALID"){
	
	$filenameImages =$_SESSION["iss21"]["img"];
	$filemtimeImages = filemtime("assets/images/users/".$filenameImages);
	$profile_picture=$filenameImages."?".$filemtimeImages;
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
	<meta charset="utf-8">
	<title>Purchase Order</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.css">
	<style>
		body {
			font-size: normal;
			font-family: "Arial";
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
			min-height: 297mm;
			padding: 0;
			margin: 0 auto;
		}
		page[size="A4"] {  
		  width: 210mm;
		  height: 297mm;
		}
		@media print {
		  body, page {
		    font-size: normal;
			font-family: "Arial";
			margin: 0;
			box-shadow: 0;
		  }
		}	
	</style>
	
</head>
<body>
	<?php
		
		if(!empty($_POST['branch'])){
			$branch=$_POST["branch"];
		}else{
			
			if(!empty($_GET["branch"])){
				$branch=$_GET["branch"];
			}else{
				
				if(strtolower($_SESSION["iss21"]["level"])=="admin"){
					$branch="All Branch";
				}else{
					$branch=$_SESSION["iss21"]["branch"];
				}
			}
		}
		
		if(!empty($_POST['tanggal'])){
			$tanggal=date('Y-m-d',strtotime($_POST['tanggal']));
		}else{
			if(!empty($_GET['tanggal'])){
				$tanggal=date('Y-m-d',strtotime($_GET['tanggal']));
			}else{
				$tanggal=date("Y-m-d");
			}
		}
		
		if(!empty($_POST['po'])){
			$po=$_POST['po'];
		}else{
			if(!empty($_GET['po'])){
				$po=$_GET['po'];
			}else{
				$po="";
			}
		}
		
	
	?>
	<page size="A4">
	<table border="0" align="center" width="100%" cellpadding="5" cellspacing="0">
		<tr>
			<td align="center">
					<table width="100%">
						<tr>
							<td valign="top"><b>PT. ENERGI MEDISTRON</b><br>Ruko Cinere Terrace Commercial Blok JC No. 5<br>Pangkalan Jati, Cinere, Depok</td>
							<td valign="top" align="right">
							    <table border="1">
							        <tr>
							            <td style="padding:10px;font-size:x-large;font-weight:bold;padding-left:20px; padding-right:20px;">
							                Purchase Order
							            </td>
							        </tr>
							    </table>
							</td>
						</tr>
					</table>
					<hr>
				<?php
					$po1="";
					$tanggal1="";
					$supplier1="";							
					$address1="";
					$phone1="";
					$contact1="";
					
					$sql="Select po, tanggal, supplier, address, phone, contact
						from PO where po='$po' 
						group by po, tanggal, supplier, address, phone, contact";
					$result = $con->query($sql);
					$count = mysqli_num_rows($result);
					if($count>0){
						while($row = mysqli_fetch_assoc($result))
						{
							$po1=$row["po"];
							$tanggal1=$row["tanggal"];
							$supplier1=$row["supplier"];							
							$address1=$row["address"];
							$phone1=$row["phone"];
							$contact1=$row["contact"];
						}
					}
					
				?>
				<table width="100%" align="center">
					<tr>						
						<td width="35%" valign="top" style="border:1px solid black;">
						    <table width="100%">
						        <tr>
						            <td style="padding:10px;">
						                Request To. :<br><br><?php echo $supplier1."<br>".$address1;?>
						            </td>
						        </tr>
						    </table>
						</td>
						<td width="30%">
						</td>
						<td width="35%" valign="top" style="border:1px solid black;">
						    <table>
						        <tr>
						            <td style="padding-left:10px; padding-top:10px; padding-right:5px;">No.</td>
						            <td style="padding-right:5px;"> : </td>
						            <td style="padding-right:5px;" nowrap><?php echo $po;?></td>
						        </tr>
						        <tr>
						            <td style="padding-left:10px; padding-right:5px;">Date</td>
						            <td style="padding-right:5px;"> : </td>
						            <td style="padding-right:5px;"><?php echo date("d M Y",strtotime($tanggal1));?></td>
						        </tr>
						        
						    </table>
						</td>
					</tr>
				</table>	
				
			</td>
		</tr>
		<tr><td style="height:10px"></td></tr>
		<tr>
			<td>
				<table border="1" width="100%" cellpadding="5" cellspacing="0" width="100%">
					<tr>						
						<td align="center" >No.</td>
						<td align="center" style="padding:5px;">Group</td>
						<td align="center" style="padding:5px;">Merk</td>
						<td align="center" style="padding:5px;">tipe</td>
						<td align="center" style="padding:5px;">Item Description</td>
						<td align="center" style="padding:5px;">Note</td>
					</tr>
					<?php
						$no=0;
						$sql="Select * from PO where po='$po' order by jenis,tipe,merk,barang";
						$result = $con->query($sql);
						$count = mysqli_num_rows($result);
						if($count>0){
							while($row = mysqli_fetch_assoc($result))
							{
								$no++;			
								$jenis2=$row["jenis"];
								$tipe=$row["tipe"];
								$merk=$row["merk"];
								$barang2=$row["barang"];
								$note2=$row["descr"];
								
								echo"
									<tr>												
										<td align='center'>$no</td>
										<td style='padding:5px;'>$jenis2</td>
										<td style='padding:5px;'>$merk</td>
										<td style='padding:5px;'>$tipe</td>
										<td style='padding:5px;'>$barang2</td>
										<td style='padding:5px;'>$note2</td>
									</tr>										
								";													
							}							
						}
					?>
					
				</table>
				
				
					
			</td>
		</tr>
		<tr><td style="height:10px"></td></tr>
		<tr><td>
		    <?php
		        $tanggalX=date('d-m-Y');
				function getDayIndonesia($date){
                    if($date != '0000-00-00'){
                        $data = hari(date('D', strtotime($date)));
                    }else{
                        $data = '-';
                    }
                    return $data;
                }
              
                function hari($day) {
                    $hari = $day;
                    switch ($hari) {
                        case "Sun":
                            $hari = "Sunday";
                            break;
                        case "Mon":
                            $hari = "Monday";
                            break;
                        case "Tue":
                            $hari = "Tuesday";
                            break;
                        case "Wed":
                            $hari = "Wednesday";
                            break;
                        case "Thu":
                            $hari = "Thursday";
                            break;
                        case "Fri":
                            $hari = "Friday";
                            break;
                        case "Sat":
                            $hari = "Saturday";
                            break;
                    }
                    return $hari;
                }
                
			
			echo getDayIndonesia($tanggal1).", ".$tanggalX;
		    
		    ?>
		    <br><br>
			Best Regards,
		</td></tr>
		<tr><td style="height:60px"></td></tr>
		<tr><td>
		    <table border="1" width="100%">
		        <tr>
		            <td valign="top" style="padding:10px;height:80px">
		                Note :
		            </td>
		        </tr>
		    </table>
		</td></tr>
		
	</table>
	
	
	
									
	</page>	
</body>
</html>
<script src="js/jquery-3.2.1.min.js"></script>
<?php
$halaman=$_GET['halaman'];
if($halaman=="po"){
	$halaman="po.php";
}else{
	$halaman="po.php";
}

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
<?php

}else{
	session_destroy();
	session_start();
	$_SESSION["iss21"]["info"]="Gagal, anda tidak memiliki ijin untuk mengakses halaman tersebut atau session anda sudah habis, silahkan login ulang.";
	header("location: index.php");
}


?>