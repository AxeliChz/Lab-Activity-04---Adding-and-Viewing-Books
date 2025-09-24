<?php
include 'config.php';
include 'Library.php';

// create connection properly
$dbObj = new Database();
$db = $dbObj->connect();

$library = new Library($db);

$books = [];

$search = $_GET['search'] ?? '';
$genre = $_GET['genre'] ?? '';

$books = $library->getBooks($search, $genre);
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Books</title>
</head>
<body>
    <div class="container">
        <h1>Book List</h1>
        <table>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Genre</th>
                <th>Year</th>
                <th>Publisher</th>
                <th>Copies</th>
            </tr>
            <?php if (!empty($books)): ?>
                <?php foreach ($books as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['title']); ?></td>
                    <td><?= htmlspecialchars($row['author']); ?></td>
                    <td><?= htmlspecialchars($row['genre']); ?></td>
                    <td><?= htmlspecialchars($row['publication_year']); ?></td>
                    <td><?= htmlspecialchars($row['publisher']); ?></td>
                    <td><?= htmlspecialchars($row['copies']); ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">No books found.</td></tr>
            <?php endif; ?>
        </table>

        <a href="index.php" class="btn">Back Home</a>
    </div>
</body>
</html>
