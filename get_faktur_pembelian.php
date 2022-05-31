<?php
session_start();
include("fc/fc_config.php");

$Qbranch=$_SESSION["iss21"]["branch"];
$data=$_POST['data'];
$result = $con->query("Select convert(tanggal, DATE) as tgl,faktur,kode_supplier,supplier,alamat_supplier,telepon_supplier,person_supplier 
	from PEMBELIAN 
	where branch='$Qbranch' and concat(faktur,' | ',supplier, ' | ',convert(tanggal, DATE))='$data'
	group by convert(tanggal, DATE),kode_supplier,faktur,supplier,alamat_supplier,telepon_supplier,person_supplier
	limit 1
	");
$count = mysqli_num_rows($result);
if($count>0){
	while($row = mysqli_fetch_assoc($result))
	{		
		$faktur=$row["faktur"];
		$tanggal=$row["tgl"];
		$kode=$row["kode_supplier"];
		$supplier=$row["supplier"];
		$alamat=$row["alamat_suplier"];
		$telepon=$row["telepon_suplier"];
		$person=$row["person_suplier"];
		echo json_encode(array('tanggal'=>$tanggal,'faktur'=>$faktur,'kode'=>$kode,'supplier'=>$supplier,'alamat'=>$alamat,'telepon'=>$telepon,'person'=>$person));
	}
}
?>
