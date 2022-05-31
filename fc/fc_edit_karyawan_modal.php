<?php
session_start();
include("fc_config.php");
if(!empty($_POST["id"])){	

	$id=$_POST["id"];
	$dept=$_POST["dept"];
	$nik=$_POST["nik"];
	$fullname=$_POST["fullname"];
	$position=$_POST["position"];
	$address=$_POST["address"];
	$phone=$_POST["phone"];
	
	$username=$_POST["username"];
	$entrydate=date("Y-m-d")." ".date("H:i:s");
	
	$result = $con->query("Select * from KARYAWAN Where nik='$nik' and id !='$id'");
	$count = mysqli_num_rows($result);
	if($count>0){
		while($row = mysqli_fetch_assoc($result))
		{
			$xfullname=$row["fullname"];
			$_SESSION["iss21"]["info"]="Gagal, NIK karyawan $nik sudah terdaftar atas nama $xfullname.";
			header("location: ../karyawan.php");
		}
	}else{
		$result1 = $con1->query("Update KARYAWAN set dept='$dept', nik='$nik', fullname='$fullname', position='$position', address='$address', phone='$phone', username='$username', entrydate='$entrydate' where id='$id'");			
		header("location: ../karyawan.php");	
	}
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../karyawan.php");
}
?>