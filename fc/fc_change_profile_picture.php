<?php
session_start();
include("fc_config.php");
if(!empty($_POST["id"])){	
	$id=$_POST["id"];	
	if(isset($_FILES['img'])){		
		$errors= array();
		$file_tmp =$_FILES['img']['tmp_name'];	
		$file_size =$_FILES['img']['size'];
		$file_ext=strtolower(end(explode('.',$_FILES['img']['name'])));
		$file_name=$id.".".$file_ext;
		$extensions= array("jpeg","jpg","png");		
		if(in_array($file_ext,$extensions)=== false){
			$errors="Ektensi gambar tidak diijinkan, mohon untuk memilih JPG, JPEG atau PNG.";
			header("location: ../pages-profile.php?info=Gagal, $errors");
		}else if ($file_size > 500000) {
			$errors="Maaf, hanya ukuran foto dibawah 500KB yang diijinkan.";
			header("location: ../pages-profile.php?info=Gagal, $errors");
		}else{
			if(empty($errors)==true){
				if(file_exists("../assets/images/users/".$file_name)){unlink("../assets/images/users/".$file_name);}
				move_uploaded_file($file_tmp,"../assets/images/users/".$file_name);	
				$result = $con->query("Update TBLLOGIN set img='$file_name' where id='$id'");
				$count = mysqli_num_rows($result);
				$_SESSION["iss21"]["img"]=$file_name;
				header("location: ../pages-profile.php?info=Gambar profil anda sudah berhasil diperbarui.");		
			}
		}		
	}else{
		header("location: ../pages-profile.php?info=Hai, sepertinya ada yang salah nih, mohon ulangi kembali.");
	}	
}else{
	header("location: ../pages-profile.php?info=Hai, sepertinya ada yang salah nih, mohon ulangi kembali.");
}
?>