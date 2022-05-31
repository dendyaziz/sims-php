<?php
session_start();
include("fc_config.php");
include "classes/class.phpmailer.php";
if(!empty($_POST["id"])){	

	$id=$_POST["id"];
	$branch=$_POST["branch"];
	$position=$_POST["position"];
	$userid=$_POST["userid"];
	$password=$_POST["password"];
	$fullname=$_POST["fullname"];
	$email=$_POST["email"];
	$address=$_POST["address"];
	$phone=$_POST["phone"];	
	$level="Admin";
	$status=$_POST["status"];
	
	$username=$_POST["username"];
	$entrydate=date("Y-m-d")." ".date("H:i:s");
	
	$result = $con->query("Select * from TBLLOGIN Where id='$id'");
	$count = mysqli_num_rows($result);
	if($count>0){		
		while($row = mysqli_fetch_assoc($result))
		{	
			$result1 = $con1->query("delete From TBLLOGIN Where id='$id'");	
			$msg="
				Dear $fullname,<br><br>
				ini adalah email otomatis dari web aplikasi SIMPANSE.<br>
				User anda telah dihapus oleh administrator website kami, untuk informasi lebih lanjut silahkan hubungi administrator website kami.<br><br>				
				Best Regards,<br>
				Website Administrator			
			";			
			$mail = new PHPMailer; 
			$mail->IsSMTP();
			$mail->SMTPSecure = 'ssl'; 
			$mail->Host = "mail.softkita.monster"; //host masing2 provider email
			$mail->SMTPDebug = 0;
			$mail->Port = 465;
			$mail->SMTPAuth = true;
			$mail->Username = "admin@softkita.monster"; //user email
			$mail->Password = "Password1!2021"; //password email 
			$mail->SetFrom("admin@softkita.monster","Website Administrator"); //set email pengirim
			$mail->Subject = "Deleted User - SIMPANSE"; //subyek email
			$mail->AddAddress($email,$fullname);  //tujuan email
			$mail->MsgHTML($msg);
			if($mail->Send()){
				header("location: ../user.php");
			}else{
				$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah dengan email kami saat ini, mohon ulangi kembali nanti.";
				header("location: ../user.php");
			}
		}
	}else{
		$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
		header("location: ../user.php");
	}
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih dengan kolom inputan yang sudah dilakukan, mohon lakukan pengecekan ulang dan ulangi kembali nanti.";
	header("location: ../user.php");
}
?>