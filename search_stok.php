<?php
header("Content-Type: application/json; charset=UTF-8");
$user_name = "mysql_iss21";
$password = "Password1!2021";
$database = "mysql_iss21";
$host_name = "localhost";
$conB=new mysqli($host_name, $user_name, $password, $database);
$barang = $_GET["query"];


$query  = $conB->query("SELECT * from STOK where barang like '%$barang%' group by barang");
$result = $query->fetch_All(MYSQLI_ASSOC);
if (count($result) > 0) {
    foreach($result as $data) {
        $output['suggestions'][] = [
            'value' => $data['barang'],
            'barang'  => $data['barang']
        ];
    }
    echo json_encode($output);
} else {
    $output['suggestions'][] = [
        'value' => '',
        'barang'  => ''
    ];
    echo json_encode($output);
}
?>
