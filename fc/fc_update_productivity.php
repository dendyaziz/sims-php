<?php
session_start();
include("fc_config.php");
include "classes/class.phpmailer.php";
if(!empty($_POST["id"])){	
	
	$id=$_POST["id"];
	$line_produksi=$_POST["line_produksi"];
	$shift=$_POST["shift"];
	$tanggal=$_POST["tanggal"];	
	$tgl=date('Y-m-d',strtotime($tanggal));
	$tgl_prod=$tgl." ".date("H:i:s");
	$entrydate=date("Y-m-d")." ".date("H:i:s");
	
	if(empty($_POST["planning"])){$planning=0;}else{$planning=$_POST["planning"];}
	$cav_dies=$_POST["cav_dies"];
	if(empty($_POST["actual_produksi"])){$actual_produksi=0;}else{$actual_produksi=$_POST["actual_produksi"];}
	if(empty($_POST["prod_trial"])){$prod_trial=0;}else{$prod_trial=$_POST["prod_trial"];}
	if(empty($_POST["repair"])){$repair=0;}else{$repair=$_POST["repair"];}
	if(empty($_POST["prod_ng"])){$prod_ng=0;}else{$prod_ng=$_POST["prod_ng"];}
	if(empty($_POST["prod_ok"])){$prod_ok=0;}else{$prod_ok=$_POST["prod_ok"];}
	$keterangan=$_POST["keterangan"];
	
	if(empty($_POST["misrun_sirip"])){$misrun_sirip=0;}else{$misrun_sirip=$_POST["misrun_sirip"];}
	if(empty($_POST["misrun_gate"])){$misrun_gate=0;}else{$misrun_gate=$_POST["misrun_gate"];}
	if(empty($_POST["misrun_dowel"])){$misrun_dowel=0;}else{$misrun_dowel=$_POST["misrun_dowel"];}
	if(empty($_POST["core_patah"])){$core_patah=0;}else{$core_patah=$_POST["core_patah"];}
	if(empty($_POST["keropos_part"])){$keropos_part=0;}else{$keropos_part=$_POST["keropos_part"];}
	if(empty($_POST["keropos_chain"])){$keropos_chain=0;}else{$keropos_chain=$_POST["keropos_chain"];}
	if(empty($_POST["keropos_area_gate"])){$keropos_area_gate=0;}else{$keropos_area_gate=$_POST["keropos_area_gate"];}
	if(empty($_POST["undercut"])){$undercut=0;}else{$undercut=$_POST["undercut"];}
	if(empty($_POST["penyok"])){$penyok=0;}else{$penyok=$_POST["penyok"];}
	if(empty($_POST["gompal"])){$gompal=0;}else{$gompal=$_POST["gompal"];}
	if(empty($_POST["blowhole"])){$blowhole=0;}else{$blowhole=$_POST["blowhole"];}
	if(empty($_POST["inklusi_pasir"])){$inklusi_pasir=0;}else{$inklusi_pasir=$_POST["inklusi_pasir"];}
	if(empty($_POST["part_nempel"])){$part_nempel=0;}else{$part_nempel=$_POST["part_nempel"];}
	if(empty($_POST["cutting_ng"])){$cutting_ng=0;}else{$cutting_ng=$_POST["cutting_ng"];}
	
	if(empty($_POST["lost_1"])){$lost_1=0;}else{$lost_1=$_POST["lost_1"];}
	if(empty($_POST["lost_2"])){$lost_2=0;}else{$lost_2=$_POST["lost_2"];}
	if(empty($_POST["lost_3"])){$lost_3=0;}else{$lost_3=$_POST["lost_3"];}
	if(empty($_POST["lost_4"])){$lost_4=0;}else{$lost_4=$_POST["lost_4"];}
	
	$ket_lost_1=$_POST["ket_lost_1"];
	$ket_lost_2=$_POST["ket_lost_2"];
	$ket_lost_3=$_POST["ket_lost_3"];
	$ket_lost_4=$_POST["ket_lost_4"];	
	
	$result = $con->query("Select * from PRODUKSI Where line_produksi='$line_produksi' and shift='$shift' and DATE(tanggal) = '$tgl' and id='$id'");
	$count = mysqli_num_rows($result);
	if($count>0){
		$result = $con->query("update PRODUKSI set planning='$planning',cav_dies='$cav_dies',actual_produksi='$actual_produksi',prod_trial='$prod_trial', repair='$repair', prod_ng='$prod_ng',prod_ok='$prod_ok',keterangan='$keterangan',misrun_sirip='$misrun_sirip',misrun_gate='$misrun_gate',misrun_dowel='$misrun_dowel',core_patah='$core_patah',keropos_part='$keropos_part',keropos_chain='$keropos_chain',keropos_area_gate='$keropos_area_gate',undercut='$undercut',penyok='$penyok',gompal='$gompal',blowhole='$blowhole',inklusi_pasir='$inklusi_pasir',part_nempel='$part_nempel',cutting_ng='$cutting_ng',lost_1='$lost_1',lost_2='$lost_2',lost_3='$lost_3',lost_4='$lost_4',ket_lost_1='$ket_lost_1',ket_lost_2='$ket_lost_2',ket_lost_3='$ket_lost_3',ket_lost_4='$ket_lost_4'	Where line_produksi='$line_produksi' and shift='$shift' and DATE(tanggal) = '$tgl' and id='$id'");		
		$count = mysqli_num_rows($result);
		header("location: ../edit-productivity.php?info1=Hasil produksi yang anda update sudah berhasil diubah.");
	}else{
		header("location: ../edit-productivity.php?info1=Hai, sepertinya ada yang salah nih, mohon ulangi kembali.");
	}
}else{
	header("location: ../edit-productivity.php?info1=Hai, sepertinya ada yang salah nih, mohon ulangi kembali.");
}
?>