<?php
session_start();
include("fc/fc_config.php");
header("Content-Type: application/json; charset=UTF-8");
$user_name = "mysql_iss21";
$password = "Password1!2021";
$database = "mysql_iss21";
$host_name = "localhost";
$conB=new mysqli($host_name, $user_name, $password, $database);
$search = $_GET["query"];
$branch=$_SESSION["iss21"]["branch"];
$query  = $conB->query("SELECT concat(faktur,' | ',supplier, ' | ',convert(tanggal, DATE)) as faktur FROM PEMBELIAN 
	WHERE (supplier LIKE '%$search%' and branch='$branch') or (faktur LIKE '%$search%' and branch='$branch') 
	group by concat(faktur,' | ',supplier, ' | ',convert(tanggal, DATE)) 
	ORDER BY concat(faktur,' | ',supplier, ' | ',convert(tanggal, DATE))");
$result = $query->fetch_All(MYSQLI_ASSOC);
if (count($result) > 0) {
    foreach($result as $data) {
        $output['suggestions'][] = [
            'value' => $data['faktur'],
            'faktur'  => $data['faktur']
        ];
    }
    echo json_encode($output);
} else {
    $output['suggestions'][] = [
        'value' => '',
        'faktur'  => ''
    ];
    echo json_encode($output);
}
?>
