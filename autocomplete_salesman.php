<?php
header("Content-Type: application/json; charset=UTF-8");
include("fc/fc_config.php");
$salesman = $_GET["query"];
$query  = $con->query("SELECT concat(fullname,' | ',address,' | ',phone) as salesman FROM TBLLOGIN 
	WHERE position='Salesman' and (userid LIKE '%$salesman%' or fullname LIKE '%$salesman%' or address LIKE '%$salesman%') ORDER BY fullname ASC");
$result = $query->fetch_All(MYSQLI_ASSOC);
if (count($result) > 0) {
    foreach($result as $data) {
        $output['suggestions'][] = [
            'value' => $data['salesman'],
            'salesman'  => $data['salesman']
        ];
    }
    echo json_encode($output);
} else {
    $output['suggestions'][] = [
        'value' => '',
        'salesman'  => ''
    ];
    echo json_encode($output);
}
?>
