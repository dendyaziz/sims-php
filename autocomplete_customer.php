<?php
header("Content-Type: application/json; charset=UTF-8");
include("fc/fc_config.php");
$customer = $_GET["query"];
$query  = $con->query("SELECT concat(customer,' | ',address,' | ',phone,' | ',contact) as customer FROM CUSTOMER 
	WHERE customer LIKE '%$customer%' or address LIKE '%$customer%' or phone LIKE '%$customer%' or contact LIKE '%$customer%' ORDER BY customer ASC");
$result = $query->fetch_All(MYSQLI_ASSOC);
if (count($result) > 0) {
    foreach($result as $data) {
        $output['suggestions'][] = [
            'value' => $data['customer'],
            'customer'  => $data['customer']
        ];
    }
    echo json_encode($output);
} else {
    $output['suggestions'][] = [
        'value' => '',
        'customer'  => ''
    ];
    echo json_encode($output);
}
?>
