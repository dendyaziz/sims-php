<?php
session_start();
include("fc_config.php");
if(!empty($_POST["tanggal"]) && !empty($_POST["kode"]) && !empty($_POST["customer"]) && !empty($_POST["qty"]) ){	

	$branch=$_SESSION["iss21"]["branch"];	
	$tanggal=$_POST["tanggal"];
	$po=$_POST["po"];
	$tglpo=$_POST["tglpo"];
	$tgltempo=$_POST["tgltempo"];
	$ongkir=$_POST["ongkir"];
	$biaya_lainnya=$_POST["biaya_lainnya"];
	
	$faktur=$_POST["faktur"];
	if(empty($faktur)){
		$transNo="F".right(date('Ym'),4);
		$result = $con->query("Select faktur from OUTGOING where left(faktur,5)='$transNo' order by faktur desc limit 1");
		$count = mysqli_num_rows($result);
		if($count>0){
			while($row = mysqli_fetch_assoc($result))
			{
				$transno=right($row["faktur"],9)+1;
				$faktur="F".$transno;
			}
		}else{
			$faktur="F".right(date('Ym'),4)."00001";
		}
	}
	
	$tipe_outgoing=$_POST["tipe_outgoing"];
	
	$customer=$_POST["customer"];
	$address=$_POST["address"];
	$phone=$_POST["phone"];
	$contact=$_POST["contact"];
	$kode_customer=$_POST["kode_customer"];
	
    $kode=$_POST["kode"];
	$jenis=$_POST["jenis"];
	$subgroup=$_POST["subgroup"];
	$merk=$_POST["merk"];
	$barang=$_POST["barang"];
	$barang=str_replace("'","",$barang);
	$satuan=$_POST["satuan"];
	$qty=$_POST["qty"];
	$harga_beli=$_POST["harga_beli"];
	$harga_jual=$_POST["harga_jual"];
	$descr=$_POST["descr"];
	
	$username=$_POST["username"];
	$entrydate=date("Y-m-d")." ".date("H:i:s");
	
	$result = $con->query("Select * from OUTGOING Where branch='$branch' and tanggal='$tanggal' and faktur='$faktur' and customer='$customer' and kode='$kode'");
	$count = mysqli_num_rows($result);
	if($count>0){	
		$result = $con->query("update OUTGOING set qty=qty+$qty, harga_beli='$harga_beli', harga_jual='$harga_jual' Where branch='$branch' and tanggal='$tanggal' and faktur='$faktur' and customer='$customer' and kode='$kode'");
	}else{
		$result = $con->query("Insert Into OUTGOING (branch, tipe_outgoing, tanggal, faktur, po, tglpo, tgltempo, ongkir, biaya_lainnya, customer, address, phone, contact, kode_customer, kode, jenis, subgroup, merk, barang, satuan, qty, harga_beli, harga_jual, descr, username, entrydate) 
		values ('$branch','$tipe_outgoing','$tanggal','$faktur', '$po', '$tglpo', '$tgltempo', '$ongkir', '$biaya_lainnya', '$customer', '$address', '$phone', '$contact', '$kode_customer', '$kode', '$jenis', '$subgroup', '$merk', '$barang', '$satuan', '$qty', '$harga_beli', '$harga_jual', '$descr', '$username', '$entrydate')");
	}
	
	$result = $con->query("Select * from STOK Where branch='$branch' and kode='$kode'");
	$count = mysqli_num_rows($result);	
	if($count>0){		
		$result1 = $con1->query("update STOK set s_out=s_out+$qty, saldo=saldo-$qty where branch='$branch' and kode='$kode'");		
	}else{		
		$result1 = $con1->query("Insert into STOK (branch, jenis, barang, satuan, kode, s_in, s_out, saldo, username, entrydate) 
		values ('$branch', '$jenis', '$barang', '$satuan', '$kode', '0' , '-$qty', '-$qty', '$username', '$entrydate')");		
	}
	
	$result = $con->query("Select * from HISTORY Where branch='$branch' and transaksi='OUTGOING' and tanggal='$tanggal' and faktur='$faktur' and kode='$kode'");
	$count = mysqli_num_rows($result);
	if($count>0){
		$result = $con->query("update HISTORY set qty=qty+$qty, harga_beli='$harga_beli', harga_jual='$harga_jual' Where branch='$branch' and transaksi='OUTGOING' and tanggal='$tanggal' and faktur='$faktur' and kode='$kode'");
	}else{
		$result2 = $con2->query("Insert into HISTORY (branch, transaksi, faktur, tanggal, kode_customer, customer, address, phone, contact, kode_salesman, salesman, kode, barang, jenis, satuan, qty, harga_beli, harga_jual, username, entrydate, descr) 
		values ('$branch', 'OUTGOING', '$faktur', '$tanggal', '$kode_customer', '$customer', '$address', '$phone', '$contact', '', '', '$kode', '$barang', '$jenis', '$satuan', '$qty', '$harga_beli', '$harga_jual', '$username', '$entrydate', 'tipe_outgoing: $tipe_outgoing, PO: $po, TglPo: $tglpo, Tempo: $tgltempo, Ongkir: ".number_format($ongkir).", Biaya Lainnya: ".number_format($biaya_lainnya).", Note: $descr')");
	}
	
	header("location: ../outgoing.php?tanggal=$tanggal&faktur=$faktur&kode_customer=$kode_customer&ongkir=$ongkir&biaya_lainnya=$biaya_lainnya&po=$po&tglpo=$tglpo&tgltempo=$tgltempo&tipe_outgoing=$tipe_outgoing");
	
}else{	
	$tanggal=$_POST["tanggal"];
	$tipe_outgoing=$_POST["tipe_outgoing"];
	$faktur=$_POST["faktur"];
	$kode_customer=$_POST["kode_customer"];
	$po=$_POST["po"];
	$tglpo=$_POST["tglpo"];
	$tgltempo=$_POST["tgltempo"];
	$ongkir=$_POST["ongkir"];
	$biaya_lainnya=$_POST["biaya_lainnya"];
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../outgoing.php?tanggal=$tanggal&faktur=$faktur&kode_customer=$kode_customer&ongkir=$ongkir&biaya_lainnya=$biaya_lainnya&po=$po&tglpo=$tglpo&tgltempo=$tgltempo&tipe_outgoing=$tipe_outgoing");
}
?>