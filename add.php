<?php
require_once 'config.php';
require_once 'Library.php';

$dbObj = new Database();
$conn = $dbObj->connect();

$errors = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title     = trim($_POST['title'] ?? '');
    $author    = trim($_POST['author'] ?? '');
    $genre     = trim($_POST['genre'] ?? '');
    $year      = intval($_POST['year'] ?? 0);
    $publisher = trim($_POST['publisher'] ?? null);
    $copies    = max(1, intval($_POST['copies'] ?? 1));
    $currentYear = intval(date('Y'));

    if ($title === '' || $author === '' || $genre === '' || $year <= 0) {
        $errors = 'Please fill in required fields.';
    } elseif ($year > $currentYear) {
        $errors = 'Publication year cannot be in the future.';
    } else {
        try {
            $chk = $conn->prepare('SELECT id FROM book WHERE title = ?');
            $chk->execute([$title]);

            if ($chk->fetch()) {
                $errors = 'This title already exists.';
            } else {
                $sql = 'INSERT INTO book (title, author, genre, publication_year, publisher, copies)
                        VALUES (?, ?, ?, ?, ?, ?)';
                $stmt = $conn->prepare($sql);
                $stmt->execute([$title, $author, $genre, $year, $publisher, $copies]);

                // redirect to Book.php (adjust case/filename if needed)
                header('Location: Book.php');
                exit;
            }
        } catch (PDOException $e) {
            $errors = 'Database error: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add Book</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Add Book</h1>

    <?php if ($errors): ?>
        <div class="error"><?php echo htmlspecialchars($errors); ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="title" placeholder="Title" required>
        <input type="text" name="author" placeholder="Author" required>
        <select name="genre" required>
            <option value="">--Genre--</option>
            <option value="history">History</option>
            <option value="science">Science</option>
            <option value="fiction">Fiction</option>
        </select>
        <input type="number" name="year" placeholder="Year" min="1" max="<?php echo date('Y'); ?>" required>
        <input type="text" name="publisher" placeholder="Publisher (optional)">
        <input type="number" name="copies" value="1" min="1">
        <button type="submit">Add Book</button>
    </form>

    <p><a class="btn" href="Book.php">View Books</a></p>
</div>
</body>
</html>
