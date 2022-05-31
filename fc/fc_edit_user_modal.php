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
			$xuserid=$row["userid"];
			$xemail=$row["email"];
			$xfullname=$row["fullname"];			
			$result1 = $con1->query("Update TBLLOGIN set branch='$branch', position='$position', userid='$userid', password='$password', fullname='$fullname', email='$email', address='$address', phone='$phone', status='$status', lastname='$username', lastdate='$entrydate' where id='$id'");			
			
			
			$msg="
				Dear $fullname,<br><br>
				ini adalah email otomatis dari web aplikasi SIMPANSE<br>
				Informasi user anda telah diubah oleh administrator website kami, Berikut adalah informasi terbaru login anda :<br><br>
				Branch= $branch<br>
				Position= $position<br>
				User ID=$userid<br>
				Password=$password<br>
				FullName=$fullname<br>
				Email=$email<br>
				Address=$address<br>
				Phone=$phone<br>
				Status=$status<br><br>			
				silahkan klik link berikut ini untuk login web aplikasi SIMPANSE : https://iss4.softkita.monster <br><br>				
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
			$mail->Subject = "Update User - SIMPANSE"; //subyek email
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