<?php
session_start();
include("fc_config.php");
include "classes/class.phpmailer.php";
if(!empty($_POST["email"])){	
	
	$email=$_POST["email"];
	$password=$_POST["password"];
	$fullname=$_POST["fullname"];	
	$position=$_POST["position"];
	$pages=$_POST["pages"];
	
	if(empty($_POST["level"])){
		$level="users";
	}else{
		$level=$_POST["level"];
	}
	if(empty($_POST["status"])){
		$status="aktif";
	}else{
		$status=$_POST["status"];
	}
	
	$result = $con->query("Select * from TBLLOGIN Where email='$email'");
	$count = mysqli_num_rows($result);
	if($count>0){
		while($row = mysqli_fetch_assoc($result))
		{
			$Cfullname=$row["fullname"];
		}
	}
	
	
	if(!empty($Cfullname)){
		if($pages=="user-registration.php"){$pages="add-user.php";}
		header("location: ../".$pages."?info=Gagal, email $email sudah terfdaftar atas nama $Cfullname.");
	}else{
		$result1 = $con1->query("Insert Into TBLLOGIN (email, password, fullname, position, level, status) values ('$email', '$password', '$fullname', '$position', '$level', '$status')");
		$count1 = mysqli_num_rows($result1);

		$msg="
			Dear $fullname,<br><br>
			thanks to register LPDC Performance, this is your login information for LPDC Performance web application :<br>
			email=$email<br>
			password=$password<br>
			fullname=$fullname<br>			
			position=$position<br>
			level=$level<br>
			status=$status<br><br>			
			Follow this link to login http://billi.softkita.monster <br><br>			
			Best Regards,<br>
			LPDC Administrator			
		";	
		
		$mail = new PHPMailer; 
		$mail->IsSMTP();
		$mail->SMTPSecure = 'ssl'; 
		$mail->Host = "mail.softkita.monster"; //host masing2 provider email
		$mail->SMTPDebug = 0;
		$mail->Port = 465;
		$mail->SMTPAuth = true;
		$mail->Username = "webmaster@softkita.monster"; //user email
		$mail->Password = "Password1!2021"; //password email 
		$mail->SetFrom("webmaster@softkita.monster","WebSys Administrator"); //set email pengirim
		$mail->Subject = "New Registration - WebSys"; //subyek email
		$mail->AddAddress($email,$fullname);  //tujuan email
		$mail->MsgHTML($msg);
		if($mail->Send()){
			header("location: ../".$pages."?info=Pendaftaran berhasil dan email perihal informasi login anda sudah dikirim ke email.");
		}else{
			if($pages=="user-registration.php"){$pages="add-user.php";}
			header("location: ../".$pages."?info=Gagal, mohon maaf pendaftaran berhasil namun email perihal informasi login anda tidak berhasil kami kirim ke email.");
		}
	}

}else{
	if($pages=="user-registration.php"){$pages="add-user.php";}
	header("location: ../".$pages."?info=Hai, sepertinya ada yang salah nih, mohon ulangi kembali.");
}
?>