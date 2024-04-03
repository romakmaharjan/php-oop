<?php
require_once "database.php";
$db = Database::Instance();

// Handle record deletion
if (!empty($_GET['id'])) {
    $delete_id = $_GET['id'];
    $db->Delete('students', 'id', $delete_id);
    // Redirect to avoid resubmission on page refresh
    header("Location: index.php");
    exit();
} else {
    // If no ID is provided, display message 
    echo "There is no data to delete";
    exit();
}
?>