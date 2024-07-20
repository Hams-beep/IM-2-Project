<?php
session_start();
if (!isset($_SESSION['user'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized access!'
    ]);
    exit;
}

include('connect.php');

$data = json_decode(file_get_contents('php://input'), true);
$pr_id = isset($data['request_id']) ? (int) $data['request_id'] : 0;
$status = isset($data['statses']) ? $data['statses'] : 0;

//&& $status == 'pending'
try {
    if ($pr_id > 0 ) {
        $stmt = $conn->prepare("DELETE FROM pr_item WHERE PRID = :PRID");
        $stmt->bindParam(':PRID', $pr_id, PDO::PARAM_INT);
        $stmt->execute();

        $stmt = $conn->prepare("DELETE FROM purchase_requests WHERE PRID = :PRID");
        $stmt->bindParam(':PRID', $pr_id, PDO::PARAM_INT);
        $stmt->execute();

        $response = [
            'success' => true,
            'message' => 'Purchase Request successfully deleted from the system.'
        ];
    } else {
        throw new Exception('Invalid Purchase Request ID.');
    }
} catch (Exception $e) {
    $response = [
        'success' => false,
        'message' => $e->getMessage()
    ];
}

echo json_encode($response);
?>