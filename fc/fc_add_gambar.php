<?php
	session_start();
	include("fc_config.php");
	
	
	if($_POST['id']){
		$id=$_POST['id'];
		$ekstensi_diperbolehkan	= array('png','jpg');
		$nama = $_FILES['file']['name'];
		$x = explode('.', $nama);
		$ekstensi = strtolower(end($x));
		$ukuran	= $_FILES['file']['size'];
		$file_tmp = $_FILES['file']['tmp_name'];	

		if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
			if($ukuran < 504070){			
				move_uploaded_file($file_tmp, '../barang/'.$id.".".$ekstensi);
				$result = $con->query("update BARANG set gambar='$id.$ekstensi' where id='$id'");
				if($result){
					header("location: ../item.php");
				}else{
					$_SESSION["iss21"]["info"]="Gagal, Upload file gambar tidak berhasil.";
					header("location: ../item.php");
				}
			}else{
				$_SESSION["iss21"]["info"]="Gagal, Ukuran gambar terlalu besar.";
				header("location: ../item.php");
			}
		}else{
			$_SESSION["iss21"]["info"]="Gagal, ektensi file gambar tidak diijinkan.";
			header("location: ../item.php");
		}
	}else{
		$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada yang salah nih. Mohon ulangi lagi nanti.";
		header("location: ../item.php");
	}
	?>
	