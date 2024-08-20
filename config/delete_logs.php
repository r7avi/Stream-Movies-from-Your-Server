<?php
// delete_logs.php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['logIds'])) {
    $logIds = explode(',', $_GET['logIds']);
    $logIds = array_map('intval', $logIds); // Sanitize input as integers

    if (!empty($logIds)) {
        $logIdsString = implode(',', $logIds);
        $deleteQuery = "DELETE FROM login_history WHERE id IN ($logIdsString)";
        
        if ($conn->query($deleteQuery)) {
            // Logs deleted successfully, redirect back to logs.php
            header("Location: https://ktmracing.site/logs.php");
            exit();
        } else {
            echo "Error deleting logs: " . $conn->error;
        }
    } else {
        echo "No log IDs provided.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
