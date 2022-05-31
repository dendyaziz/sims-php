<?php
header("Content-Type: application/json; charset=UTF-8");
include("fc/fc_config.php");
$karyawan = $_GET["query"];
$query  = $con->query("SELECT concat(nik,' | ',fullname,' | ',dept,' | ',address) as karyawan FROM KARYAWAN 
	WHERE nik LIKE '%$karyawan%' or fullname LIKE '%$karyawan%' or dept LIKE '%$karyawan%' or address LIKE '%$karyawan%' ORDER BY fullname ASC");
$result = $query->fetch_All(MYSQLI_ASSOC);
if (count($result) > 0) {
    foreach($result as $data) {
        $output['suggestions'][] = [
            'value' => $data['karyawan'],
            'karyawan'  => $data['karyawan']
        ];
    }
    echo json_encode($output);
} else {
    $output['suggestions'][] = [
        'value' => '',
        'karyawan'  => ''
    ];
    echo json_encode($output);
}
?>
