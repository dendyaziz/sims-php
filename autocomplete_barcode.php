<?php
header("Content-Type: application/json; charset=UTF-8");
include("fc/fc_config.php");

$barcode=str_replace("'","",$_GET["query"]);
$query  = $con->query("SELECT kode as barcode, barang FROM BARANG WHERE kode LIKE '%$barcode%'");
$result = $query->fetch_All(MYSQLI_ASSOC);
if (count($result) > 0) {
    foreach($result as $data) {
        $output['suggestions'][] = [
            'value' => $data['barcode'],
            'barcode'  => $data['barcode'],
        ];
    }
    echo json_encode($output);
} else {
    $output['suggestions'][] = [
        'value' => '',
        'barcode'  => ''
    ];
    echo json_encode($output);
}
?>
