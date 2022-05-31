<?php
header("Content-Type: application/json; charset=UTF-8");
include("fc/fc_config.php");

$supplier = $_GET["query"];
$query  = $con->query("SELECT concat(supplier,' | ',address,' | ',phone,' | ',contact) as supplier FROM SUPPLIER WHERE supplier LIKE '%$supplier%' or address LIKE '%$supplier%' or phone LIKE '%$supplier%' or contact LIKE '%$supplier%' ORDER BY supplier ASC");
$result = $query->fetch_All(MYSQLI_ASSOC);
if (count($result) > 0) {
    foreach($result as $data) {
        $output['suggestions'][] = [
            'value' => $data['supplier'],
            'supplier'  => $data['supplier']
        ];
    }
    echo json_encode($output);
} else {
    $output['suggestions'][] = [
        'value' => '',
        'supplier'  => ''
    ];
    echo json_encode($output);
}
?>
