<?php
session_start();

$table_name = 'purchase_requests';
$table_assoc = 'pr_item';
$date_needed = $_POST['dateNeeded'];
$status = $_POST['PRStatus'];
$reason = $_POST['reason'];

$user = $_SESSION['user'];
$requested_by = $user['userID'];

$PR_id = isset($_POST['PRID']) ? $_POST['PRID'] : null;
$estimated_cost = 0.00;
$itemid = $_POST['itemID'];
$reQuant = $_POST['requestQuantity'];
$estCost = $_POST['estimatedCost'];
$suppliers = $_POST['supplier'];


print_r($_POST);
// foreach($itemid as $index => $item){
//     echo $index.'-'.$item[$index].',';
// }
// echo '</br>';
// foreach($suppliers as $index => $supplier){
//     echo $index.'-'.$supplier[$index].',';
// }
// echo '</br>';
// foreach($reQuant as $index => $req){
//     echo $index.'-'.$req[$index].',';
// }
// echo '</br>';

// foreach($suppliers as $index => $supplier ){
//     echo $index.'-'.$supplier[$index].',';
// }
// echo '</br>';
// foreach($suppliers as $index => $supplier ){
//     echo $index.$supplier[$index].',';
// }
// echo '</br>';
?>