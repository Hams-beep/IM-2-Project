<?php
// Adding Completed
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

if($itemid == null){
    $_SESSION['error_message'] = 'Error processing purchase request';
    header('location: ../PR.php');
}
try {
    include('connect.php');

    if ($PR_id != null) {
        $command = "UPDATE $table_name SET PRDateRequested = current_timestamp(), dateNeeded = :dateNeeded, PRStatus = :PRStatus, estimatedCost = :estimatedCost, reason = :reason WHERE PRID = :PRID";
        $stmt = $conn->prepare($command);
         $stmt->bindParam(':PRID', $PR_id);

        // $commandItem = "UPDATE $table_assoc SET itemID = :item, supplierID = :supplier, requestQuantity = :req, estimatedCost = :est WHERE PRID = :PRID AND itemID = :item";
        // $gftf = $conn->prepare($commandItem);
    } else {
        $command = "INSERT INTO $table_name (requestedBy, PRDateRequested, dateNeeded, PRStatus, estimatedCost, reason) VALUES (:requestedBy, current_timestamp(), :dateNeeded, :PRStatus, :estimatedCost, :reason)";
        $stmt = $conn->prepare($command);
        $stmt->bindParam(':requestedBy', $requested_by);

        // $commandItem = "INSERT INTO $table_assoc (PRID, itemID, supplierID, requestQuantity, estimatedCost) VALUES (:PRID, :item, :supplier, :req, :est)";
        // $gftf = $conn->prepare($commandItem);
    }

    $stmt->bindParam(':dateNeeded', $date_needed);
    $stmt->bindParam(':PRStatus', $status);
    $stmt->bindParam(':estimatedCost', $estimated_cost);
    $stmt->bindParam(':reason', $reason);
    $stmt->execute();       

    $NEW = ($PR_id != null) ? $PR_id : $conn->lastInsertId();
    
    //  delete pr items that are not in the form anymore
    $existingItems = $conn->prepare("SELECT itemID FROM $table_assoc WHERE PRID = :PRID");
    $existingItems->bindParam(':PRID', $NEW);
    $existingItems->execute();
    $existingItemIDs = $existingItems->fetchAll(PDO::FETCH_COLUMN);

    $submittedItemIDs = array_column($itemid, 'itemID');
    $itemsToDelete = array_diff($existingItemIDs, $submittedItemIDs);
    if (!empty($itemsToDelete)) {
            $deleteCommand = "DELETE FROM $table_assoc WHERE PRID = :PRID AND itemID = :itemID";
            $deleteStmt = $conn->prepare($deleteCommand);
            foreach ($itemsToDelete as $itemToDelete) {
                $deleteStmt->execute([':PRID' => $NEW, ':itemID' => $itemToDelete]);
        }
    }
    
    //adding or updating pr items
    $supploop = 0;
    foreach ($itemid as $index => $itemId) {
        $itemEstimatedCost = $estCost[$index];
        $estimated_cost += $itemEstimatedCost;

        $checkItem = $conn->prepare("SELECT COUNT(*) FROM $table_assoc WHERE PRID = :PRID AND itemID = :itemID");
        $checkItem->execute([':PRID' => $NEW, ':itemID' => $itemId]);
        $exists = $checkItem->fetchColumn();

        if ($exists) {
            $commandItem = "UPDATE $table_assoc SET supplierID = :supplier, requestQuantity = :req, estimatedCost = :est WHERE PRID = :PRID AND itemID = :item";
        } else {
            $commandItem = "INSERT INTO $table_assoc (PRID, itemID, supplierID, requestQuantity, estimatedCost) VALUES (:PRID, :item, :supplier, :req, :est)";    
        }
        
        $gftf = $conn->prepare($commandItem);

        /*supplier array count is less than the number of pr items because their supplier ids can be null so this is to ensure that those pr items
         get their proper values */
        if($itemEstimatedCost != 0){
            $supp = $suppliers[$supploop];
            $supploop++;
        } else {
            $supp = null;
        }

        $data = [
            ':PRID' => $NEW,
            ':item' => $itemId,
            ':supplier' => $supp,
            ':req' => $reQuant[$index],
            ':est' => $itemEstimatedCost
        ];

        $gftf->bindValue(':PRID', $data[':PRID']);
        $gftf->bindValue(':item', $data[':item']);
        $gftf->bindValue(':req', $data[':req']);
        $gftf->bindValue(':est', $data[':est']);
        if ($data[':supplier'] == 0) {
            $gftf->bindValue(':supplier', null, PDO::PARAM_NULL);
        } else {
            $gftf->bindValue(':supplier', $data[':supplier']);
        }
        $gftf->execute();
    }

    $command = "UPDATE $table_name SET estimatedCost = :estimatedCost WHERE PRID = :PRID";
    $stmt = $conn->prepare($command);
    $stmt->bindParam(':PRID', $NEW);  
    $stmt->bindParam(':estimatedCost', $estimated_cost);
    $stmt->execute();

    //changing inventory if PR status is marked completed
    if($status == 'completed'){
        $command = "SELECT i.itemID, i.quantity, p.PRID, p.requestQuantity FROM item i JOIN pr_item p ON i.itemID = p.itemID WHERE PRID = :PRID;";
        $stmt = $conn->prepare($command);
        $stmt->bindParam(':PRID', $NEW);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $invChange = $stmt->fetchAll();

        foreach($invChange as $inv){
            //inserting into the changes table
            $old_quantity = $inv['quantity'];
            $adjusted = $inv['requestQuantity'];
            $newQuantity = $adjusted + $old_quantity;
            $command = "INSERT INTO item_changes (dateModified, itemID, description,  oldQuantity, adjustedQuantity, newQuantity) VALUES (current_timestamp(), :item_id, :comment, :old_quantity, :adjusted, :quantity)";
            $desc = 'Purchase Request #'.htmlspecialchars($PR_id);
            $stmt = $conn->prepare($command);
            $stmt->bindParam(':item_id', $inv['itemID']);
            $stmt->bindParam(':comment', $desc);
            $stmt->bindParam(':old_quantity', $old_quantity);
            $stmt->bindParam(':adjusted', $adjusted);
            $stmt->bindParam(':quantity', $newQuantity);
            $stmt->execute();

            //updating inventory
            $command = "UPDATE item SET quantity = :quantity WHERE itemID = :item_id";
            $stmt = $conn->prepare($command);
            $stmt->bindParam(':item_id', $inv['itemID']);
            $stmt->bindParam(':quantity', $newQuantity);
            $stmt->execute();
        }
       
    }

    $message = "Purchase request successfully " . ($PR_id ? "updated" : "added") . ".";
    $_SESSION['success_message'] = $message;
    header('location: ../PR.php');
} catch (PDOException $e) {
    $_SESSION['error_message'] = 'Error processing purchase request';
    header('location: ../PR.php');
}
?>