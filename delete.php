<?php
require_once 'Library.php';
include 'config.php';

$dbObj = new Database();
$conn = $dbObj->connect();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("DELETE FROM book WHERE id = ?");
    if ($stmt->execute([$id])) {
        header("Location: Book.php");
        exit;
    } else {
        echo "Error deleting book.";
    }
} else {
    echo "No book ID provided.";
}
?>
