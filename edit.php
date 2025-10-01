<?php
require_once 'Library.php';
include 'config.php';

$dbObj = new Database();
$conn = $dbObj->connect();


$errors = '';
$success = '';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
   
    $stmt = $conn->prepare("SELECT * FROM book WHERE id = ?");
    $stmt->execute([$id]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$book) {
        die("Book not found.");
    }
} else {
    die("No book ID provided.");
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title     = trim($_POST['title']);
    $author    = trim($_POST['author']);
    $genre     = trim($_POST['genre']);
    $year      = intval($_POST['year']);
    $publisher = trim($_POST['publisher']);
    $copies    = intval($_POST['copies']);

    if ($title === '' || $author === '' || $genre === '' || $year <= 0) {
        $errors = "Please fill in required fields.";
    } else {
        $sql = "UPDATE book 
                SET title=?, author=?, genre=?, publication_year=?, publisher=?, copies=? 
                WHERE id=?";
        $stmt = $conn->prepare($sql);

        if ($stmt->execute([$title, $author, $genre, $year, $publisher, $copies, $id])) {
            header("Location: Book.php");
            exit;
        } else {
            $errors = "Failed to update book.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
</head>
<body>
    <h1>Edit Book</h1>
    <?php if ($errors): ?><div style="color:red"><?= htmlspecialchars($errors) ?></div><?php endif; ?>

    <form method="post">
        <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>
        <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" required>
        <input type="text" name="genre" value="<?= htmlspecialchars($book['genre']) ?>" required>
        <input type="number" name="year" value="<?= htmlspecialchars($book['publication_year']) ?>" required>
        <input type="text" name="publisher" value="<?= htmlspecialchars($book['publisher']) ?>">
        <input type="number" name="copies" value="<?= htmlspecialchars($book['copies']) ?>" min="1">
        <button type="submit">Update</button>
    </form>

    <p><a href="Book.php">Back</a></p>
</body>
</html>
