<?php
session_start();
include("fc/fc_config.php");

$Qbranch=$_SESSION["iss21"]["branch"];
$data=$_POST['data'];
$result = $con->query("Select convert(tanggal, DATE) as tgl,faktur,kode_customer,customer,alamat,telepon,person 
	from OUTGOING 
	where branch='$Qbranch' and concat(faktur,' | ',customer, ' | ',convert(tanggal, DATE))='$data'
	group by convert(tanggal, DATE),faktur,kode_customer,customer,alamat,telepon,person
	limit 1
	");
$count = mysqli_num_rows($result);
if($count>0){
	while($row = mysqli_fetch_assoc($result))
	{		
		$faktur=$row["faktur"];
		$tanggal=$row["tgl"];
		$kode=$row["kode_customer"];
		$customer=$row["customer"];
		$alamat=$row["alamat"];
		$telepon=$row["telepon"];
		$person=$row["person"];
		echo json_encode(array('tanggal'=>$tanggal,'faktur'=>$faktur,'kode'=>$kode,'customer'=>$customer,'alamat'=>$alamat,'telepon'=>$telepon,'person'=>$person));
	}
}
?>
