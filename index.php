<?php
include 'config.php';
include 'Library.php';


$dbObj = new Database();
$db = $dbObj->connect();
$library = new Library($db);


$search = $_GET['search'] ?? '';
$genre = $_GET['genre'] ?? '';
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Library Home</title>
</head>
<body>
    <div class="container">
        <h1>Library</h1>

        <!-- Search & Filter -->
        <form method="get" action="Book.php" class="search-form">
            <input type="text" name="search" placeholder="Search by title or author" value="<?= htmlspecialchars($search); ?>">
            <select name="genre">
                <option value="">All Genres</option>
                <option value="History" <?= $genre=="History" ? "selected" : "" ?>>History</option>
                <option value="Science" <?= $genre=="Science" ? "selected" : "" ?>>Science</option>
                <option value="Fiction" <?= $genre=="Fiction" ? "selected" : "" ?>>Fiction</option>
            </select>
            <button type="submit" class="btn">Search</button>
        </form>

        <!-- Navigation Buttons -->
        <div class="nav-buttons">
            <a href="Book.php" class="btn">View Books</a>
            <a href="add.php" class="btn">Add Book</a>
        </div>
    </div>
</body>
</html>
