<?php
header("Content-Type: application/json; charset=UTF-8");
include("fc/fc_config.php");

$barang=str_replace("'","",$_GET["query"]);
$query  = $con->query("SELECT concat(kode,' | ',jenis,' | ',subgroup,' | ',merk,' | ',barang) as barang 
    FROM BARANG WHERE kode like '%$barang%' or jenis like '%$barang%' or subgroup like '%$barang%' or merk like '%$barang%' or barang LIKE '%$barang%' 
    ORDER BY barang ASC");
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
