<?php
session_start();
include("fc_config.php");
include "classes/class.phpmailer.php";
if(!empty($_POST["email"])){	
	
	$email=$_POST["email"];
	
	$result = $con->query("Select * from TBLLOGIN Where email='$email'");
	$count = mysqli_num_rows($result);
	if($count>0){
		while($row = mysqli_fetch_assoc($result))
		{
			$userid=$_POST["userid"];
			$email=$_POST["email"];
			$password=$_POST["password"];
			$fullname=$_POST["fullname"];
			$branch=$_POST["branch"];
			$position=$_POST["position"];
			$level=$_POST["level"];
			$status=$_POST["status"];	
			
			if(!empty($fullname)){
				
				$msg="
					Dear $fullname,<br><br>
					ini adalah email otomatis dari web aplikasi SIMPANSE.<br>
					Berikut adalah informasi login anda :<br><br>
					
					UserID=$userid<br>
					Email=$email<br>
					Password=$password<br>
					Nama Lengkap=$fullname<br>
					Cabang=$branch<br>
					Jabatan=$position<br>
					status=$status<br><br>					
					silahkan klik link berikut ini untuk login kembali : https://invbiocycleindo.com <br><br>					
					Best Regards,<br>
					Website Administrator			
				";				
				
				$mail = new PHPMailer; 
				$mail->IsSMTP();
				$mail->SMTPSecure = 'ssl'; 
				$mail->Host = "sabang.iixcp.rumahweb.net"; //host masing2 provider email
				$mail->SMTPDebug = 0;
				$mail->Port = 465;
				$mail->SMTPAuth = true;
				$mail->Username = "admin@invbiocycleindo.com"; //user email
				$mail->Password = "Password1!2021"; //password email 
				$mail->SetFrom("admin@invbiocycleindo.com"); //set email pengirim
				$mail->Subject = "Forgot Password - SIMPANSE"; //subyek email
				$mail->AddAddress($email,$fullname);  //tujuan email
				$mail->MsgHTML($msg);
				if($mail->Send()){
					$_SESSION["iss21"]["info"]="Informasi login sudah dikirim ke email anda, silahkan cek email anda!";
					header("location: ../index.php");
				}else{
					$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada yang salah nih, silahkan coba kembali nanti!";
					header("location: ../forgot-password.php");
				}					
				
			}else{
				$_SESSION["iss21"]["info"]="Gagal, email $email tidak terdaftar, mohon diperiksa kembali!";
				header("location: ../forgot-password.php?email=$email");
			}				
		}
	}else{
		$_SESSION["iss21"]["info"]="Gagal, email $email tidak terdaftar, mohon diperiksa kembali!";
		header("location: ../forgot-password.php?email=$email");
	}
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada yang salah nih, silahkan coba kembali nanti!";
	header("location: ../forgot-password.php");
}

?>