<?php
ob_start();session_start();
include("fc_config.php");
if(!empty($_GET["tanggal"]) && !empty($_GET["faktur"]) && !empty($_GET["po"]) && !empty($_GET["kode_supplier"]) ){	
	
	$branch=$_SESSION["iss21"]["branch"];
	$username=$_SESSION["iss21"]["fullname"];
	$tanggal=$_GET["tanggal"];
	$faktur=$_GET["faktur"];
	$po=$_GET["po"];
	$kode_supplier=$_GET["kode_supplier"];
	
	$transNo="I".right(date('Ym'),4);
	$result = $con->query("Select faktur from PEMBELIAN where left(faktur,5)='$transNo' order by faktur desc limit 1");
	$count = mysqli_num_rows($result);
	if($count>0){
		while($row = mysqli_fetch_assoc($result))
		{
			$transno=right($row["faktur"],9)+1;
			$faktur2="I".$transno;
		}
	}else{
		$faktur2="I".right(date('Ym'),4)."00001";
	}
	
	$entrydate=date("Y-m-d")." ".date("H:i:s");
	
	$result = $con->query("Select * from TMPOUT Where branch='$branch' and tanggal='$tanggal' and faktur='$faktur' and po='$po' and kode_supplier='$kode_supplier' and username='$username'");
	$count = mysqli_num_rows($result);
	if($count>0){
		while($row = mysqli_fetch_assoc($result))
		{
			$tanggal=$row["tanggal"];	
			$do=$row["do"];	
			$po=$row["po"];	
			$tanggal_po=$row["tanggal_po"];	
			$kode_supplier=$row["kode_supplier"];	
			$supplier=$row["supplier"];	
			$address=$row["address"];	
			$phone=$row["phone"];	
			$contact=$row["contact"];	
			
			$kode=$row["kode"];
			$barang=$row["barang"];
			$jenis=$row["jenis"];
			$satuan=$row["satuan"];
			$qty=$row["qty"];
			
			$result2 = $con2->query("Insert Into PEMBELIAN (branch, tanggal, faktur, do, po, tanggal_po, kode_supplier, supplier, address, phone, contact, kode, barang, jenis, satuan, qty, username, entrydate) 
				values ('$branch', '$tanggal','$faktur', '$do', '$po', '$tanggal_po', '$kode_supplier', '$supplier', '$address', '$phone', '$contact', '$kode', '$barang', '$jenis', '$satuan', '$qty', '$username', '$entrydate')");
			$result2 = $con2->query("update PO set qty=qty-$qty Where branch='$branch' and po='$po' and kode_supplier='$kode_supplier' and kode='$kode'");
			$result2 = $con2->query("update PO set qty3=qty2-qty Where branch='$branch' and po='$po' and kode_supplier='$kode_supplier' and kode='$kode'");
			
			$result2 = $con2->query("Select * from PO Where branch='$branch' and po='$po' and kode_supplier='$kode_supplier' and kode='$kode'");
			$count2 = mysqli_num_rows($result2);	
			if($count2>0){	
				while($row2 = mysqli_fetch_assoc($result2))
				{
					$qty_PO=$row2["qty"];
					if($qty_PO==0){
						$result3 = $con3->query("update PO set status='CLOSE' Where branch='$branch' and po='$po' and kode_supplier='$kode_supplier' and kode='$kode'");
					}
				}
			}
			
			$result2 = $con2->query("Select * from STOK Where branch='$branch' and kode='$kode'");
			$count2 = mysqli_num_rows($result2);	
			$incoming=$qty;
			if($count2>0){		
				$result3 = $con3->query("update STOK set s_in=s_in+$incoming, saldo=saldo+$incoming where branch='$branch' and kode='$kode'");		
			}else{		
				$result3 = $con3->query("Insert into STOK (branch, kode, barang, jenis, satuan, s_in, saldo, username, entrydate) 
					values ('$branch', '$kode', '$barang', '$jenis', '$satuan', '$incoming', '$incoming', '$username','$entrydate')");
			}
			
			$result2 = $con2->query("Select * from HISTORY Where branch='$branch' and transaksi='INCOMING' and tanggal='$tanggal' and faktur='$faktur' and kode='$kode'");
			$count2 = mysqli_num_rows($result2);
			if($count2>0){
				$result3 = $con3->query("update HISTORY set qty=qty+$qty Where branch='$branch' and transaksi='INCOMING' and tanggal='$tanggal' and faktur='$faktur' and  kode='$kode'");
			}else{
				$result3 = $con3->query("Insert into HISTORY (branch, transaksi, do, po, faktur, tanggal, kode_supplier, supplier, address, phone, contact, kode, barang, jenis, satuan, qty, username, entrydate, descr) 
				values ('$branch', 'INCOMING', '$do', '$po', '$faktur', '$tanggal', '$kode_supplier', '$supplier', '$address', '$phone', '$contact', '$kode', '$barang', '$jenis', '$satuan', '$qty', '$username', '$entrydate', 'PO: $po, Date: $tanggal_po')");
			}
				
			$result2 = $con2->query("delete from TMPOUT Where branch='$branch' and po='$po' and tanggal='$tanggal' and faktur='$faktur' and username='$username' and kode='$kode'");

		}
	}
	
	header("location: ../po.php");
	
}else{
	$tanggal=$_POST["tanggal"];
	$faktur=$_POST["faktur"];
	$po=$_POST["po"];
	$do=$_POST["do"];
	$kode_supplier=$_POST["kode_supplier"];
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../incoming_by_po.php?tanggal=$tanggal&po=$po&kode_supplier=$kode_supplier&faktur=$faktur&do=$do");
}
?>