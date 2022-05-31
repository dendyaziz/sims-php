<?php
	session_start();
	include("fc_config.php");
	
	if(!empty($_POST['userid']) && !empty($_POST['password'])){
		$userid = strtolower($_POST['userid']);
		$password = $_POST['password'];
		
		$result = $con->query("Select * from TBLLOGIN Where userid='$userid'");
		$count = mysqli_num_rows($result);
		if($count>0){
			while($row = mysqli_fetch_assoc($result))
			{
				$email=$row["email"];
				$pass=$row["password"];
				$fullname=$row["fullname"];
				$branch=$row["branch"];
				$position=$row["position"];				
				$level=$row["level"];
				$status=$row["status"];
				$img=$row["img"];
				if(empty($img)){$img="default.png";}
				
				$id=$row["id"];
				if(!empty($pass)){
					if($pass==$password){
						if(!empty($status)){
							if(strtolower($status)=="aktif"){
								$_SESSION["iss21"]["authentication"]="VALID";						
								$_SESSION["iss21"]["userid"]=$userid;
								$_SESSION["iss21"]["email"]=$email;
								$_SESSION["iss21"]["password"]=$password;
								$_SESSION["iss21"]["fullname"]=$fullname;
								$_SESSION["iss21"]["branch"]=$branch;
								$_SESSION["iss21"]["position"]=$position;
								$_SESSION["iss21"]["level"]=$level;
								$_SESSION["iss21"]["status"]=$status;
								$_SESSION["iss21"]["img"]=$img;
								$_SESSION["iss21"]["id"]=$id;
								header("location: ../dashboard.php");
							}else{
								session_destroy();
								session_start();
								$_SESSION["iss21"]["info"]="Gagal, mohon maaf user anda sudah tidak aktif, untuk informasi lebih lanjut hubungi administrator website kami.";
								header("location: ../index.php");
							}
						}else{
							session_destroy();
							session_start();
							$_SESSION["iss21"]["info"]="Gagal, mohon maaf status user anda tidak kami ketahui, untuk informasi lebih lanjut hubungi administrator website kami.";
							header("location: ../index.php");
						}
					}else{
						session_destroy();
						session_start();
						$_SESSION["iss21"]["info"]="Gagal, sepertinya anda salah memasukan password. Silahkan coba kembali.";
						header("location: ../index.php");
					}
				}else{
					session_destroy();
					session_start();
					$_SESSION["iss21"]["info"]="Gagal, mohon maaf user anda tidak terdaftar. Silahkan registrasi terlebih dahulu dengan menghubungi administrator website kami.";
					header("location: ../index.php");
				}
			}
		}else{
			session_destroy();
			session_start();
			$_SESSION["iss21"]["info"]="Gagal, mohon maaf user anda tidak terdaftar. Silahkan registrasi terlebih dahulu dengan menghubungi administrator website kami.";
			header("location: ../index.php");
		}
		
	}else{
		session_destroy();
		session_start();
		$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
		header("location: ../index.php");
	}
	
?>
