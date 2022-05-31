<?php
session_start();
include("fc_config.php");
	
if(!empty($_POST["branch"]) && !empty($_POST["jual_panjang"]) && !empty($_POST["jumlah"]) && !empty($_POST["harga"]) && !empty($_POST["id"])){
	
	$id=$_POST["id"];
	$faktur=$_POST["faktur"];
	$branch=$_POST["branch"];
	$jual_panjang=$_POST["jual_panjang"];
	$jual_lebar=$_POST["jual_lebar"];
	if(empty($jual_lebar)){
		$jual_lebar="0";
	}
	$jumlah=$_POST["jumlah"];
	$harga=$_POST["harga"];
	
	$username=$_SESSION["iss21"]["fullname"];
	$date=date("Y-m-d")." ".date("H:i:s");	
	
	$result = $con->query("Select * from PENJUALAN where id='$id'");
	$count = mysqli_num_rows($result);
	if($count>0){
		while($row = mysqli_fetch_assoc($result))
		{
			$branch=($row["branch"]);
			$jenis=($row["jenis"]);
			$barang=($row["barang"]);
			$panjang=($row["panjang"]);
			$lebar=($row["lebar"]);
			if(empty($lebar)){
				$lebar="0";
			}
			$jual_panjangA=($row["jual_panjang"]);
			$jual_lebarA=($row["jual_lebar"]);
			if(empty($jual_lebarA)){
				$jual_lebarA="0";
			}
			$jumlahA=($row["jumlah"]);
			
			$selisih=($jumlahA - $jumlah);
			$selisih1=($jumlah - $jumlahA);
			
			if($selisih>0){
				/* Penambahan */
				$result1 = $con1->query("update PENJUALAN set jual_lebar='$jual_lebar', jual_panjang='$jual_panjang', jumlah=$jumlah, harga=$harga, lastname='$username', lastdate='$date' where id='$id'");		
				$result1 = $con1->query("update STOK set s_out=s_out-$selisih, saldo=saldo+$selisih, lastname='$username', lastdate='$date' where branch='$branch' and jenis='$jenis' and barang='$barang'");		
				$result1 = $con1->query("Insert into HISTORY (branch, faktur, tanggal, transcd, jenis, barang, panjang, lebar, s_out, username, entrydate);
				values ('$branch', '$faktur', '$date', 'G', '$jenis','$barang','$panjang','$lebar','$selisih','$username','$date')");
			}else{
				/* Pengurangan */
				$result1 = $con1->query("update PENJUALAN set jual_lebar='$jual_lebar', jual_panjang='$jual_panjang', jumlah=$jumlah, harga=$harga, lastname='$username', lastdate='$date' where id='$id'");		
				$result1 = $con1->query("update STOK set s_out=s_out+$selisih1, saldo=saldo-$selisih1, lastname='$username', lastdate='$date' where branch='$branch' and jenis='$jenis' and barang='$barang'");
				$result1 = $con1->query("Insert into HISTORY (branch, faktur, tanggal, transcd, jenis, barang, panjang, lebar, s_out, username, entrydate) 
				values ('$branch', '$faktur', '$date', 'H', '$jenis','$barang','$panjang','$lebar','$selisih1','$username','$date')");
			}
			
		}
	}			
	
	header("location: ../edit-penjualan.php?id=$id");
	
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../edit-penjualan.php?id=$id");
}
?>