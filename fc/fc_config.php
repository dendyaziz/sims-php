<?PHP
	
	date_default_timezone_set('Asia/Jakarta');
	
	$app_name="S.I.M.S";

	$user_name = "root";
	$password = "password";
	$database = "sarf8487_mysql_iss21";
	$host_name = "localhost";	
	$con=new mysqli($host_name, $user_name, $password, $database);
	$con1=new mysqli($host_name, $user_name, $password, $database);
	$con2=new mysqli($host_name, $user_name, $password, $database);
	$con3=new mysqli($host_name, $user_name, $password, $database);
	$con4=new mysqli($host_name, $user_name, $password, $database);
	$con5=new mysqli($host_name, $user_name, $password, $database);
	if ($con->connect_error) {
	   die('Maaf koneksi gagal: '. $con->connect_error);
	}
	function rupiah($angka){	
		$hasil_rupiah = "Rp ".number_format($angka);
		return $hasil_rupiah; 
	}
	function romawi($angka){	
		if($angka=="01" or $angka=="1"){
			$hasil_romawi = "I";
		}else if($angka=="02" or $angka=="2"){
			$hasil_romawi = "II";
		}else if($angka=="03" or $angka=="3"){
			$hasil_romawi = "III";
		}else if($angka=="04" or $angka=="4"){
			$hasil_romawi = "IV";
		}else if($angka=="05" or $angka=="5"){
			$hasil_romawi = "V";
		}else if($angka=="06" or $angka=="6"){
			$hasil_romawi = "VI";
		}else if($angka=="07" or $angka=="7"){
			$hasil_romawi = "VII";
		}else if($angka=="08" or $angka=="8"){
			$hasil_romawi = "VIII";
		}else if($angka=="09" or $angka=="9"){
			$hasil_romawi = "IX";
		}else if($angka=="10"){
			$hasil_romawi = "X";
		}else if($angka=="11"){
			$hasil_romawi = "XI";
		}else if($angka=="12"){
			$hasil_romawi = "XII";
		}
		return $hasil_romawi; 
	}
	function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " Seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " Seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim(penyebut($nilai));
		} else {
			$hasil = trim(penyebut($nilai));
		}     		
		return "Terbilang : ".$hasil." rupiah";
	}
	function left($str, $length) {
		 return substr($str, 0, $length);
	}
	 
	function right($str, $length) {
		 return substr($str, -$length);
	}
		
	function lapor($msg) {
		if(left($msg,5)=="Gagal"){
			$icon="warning";
			echo "
				<script type='text/javascript'>
				$(document).ready(function(){
					swal({ 
						position: 'top-end',
						title: 'PERINGATAN',
						text: '$msg',
						icon: '$icon',
						dangerMode: true,
						buttons: [false, 'OK']	 
					})		  
				});
				</script>";
		}else{
			$icon="success";			
			echo "
				<script type='text/javascript'>
				$(document).ready(function(){
					swal({ 
						position: 'top-end',
						title: 'INFORMASI',
						text: '$msg',
						icon: '$icon',
						buttons: [false, 'OK'] 
					})
				});
				</script>";			
		}
	}
?>
