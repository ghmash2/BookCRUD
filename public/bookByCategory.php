<?php
session_start();
use app\controllers\BookController;
use app\controllers\CategoryController;
use function app\Database\openDataConnection;

require '../app/database.php';
require '../app/controllers/categoryController.php';
require '../app/controllers/bookController.php';

$conn = openDataConnection();
$categoryController = new CategoryController($conn);
$bookController = new BookController($conn);
$categoryName = "";

if (isset($_GET["name"])) {
    $categoryName = $_GET["name"];
    $selectedCategory = $categoryController->getCategoryIdByName($categoryName);
}
if (isset($_GET['category']))
    $selectedCategory = $_GET['category'] ?? null;

$booksByCategory = $categoryController->getBooksByCategory($selectedCategory);
$categories = $bookController->getCategories();
$allBooks = $bookController->getAllBooks();

require 'navBar.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bookByCategory.css">
    <title>Book Category Browser</title>
</head>

<body>
    <div class="container">
        <h1>Book Category Browser</h1>

        <form method="GET" class="category-form">
            <select name="category">
                <option value="">-- All Categories --</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>" <?= ($selectedCategory == $category['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Filter</button>
        </form>

        <div class="books-container">
            <?php if (empty($booksByCategory)): ?>
                <?php if ($selectedCategory == null): ?>
                    <?php foreach ($allBooks as $book): ?>
                        <a href="/bookDetails.php?id=<?=$book['id']?>" style="text-decoration: none">
                        <div class="book-card">
                            <div class="book-image-container book-image">
                                <img src="/uploads/book_img/<?= $book['image'] ?>" alt="Book Cover">
                            </div>
                            <div class="book-title"><?= htmlspecialchars($book['name']) ?></div>
                            <div class="book-author">by <?= htmlspecialchars($book['author_name']) ?></div>
                            <div class="book-price">$<?= number_format($book['price'], 2) ?></div>
                        </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-books">No books found</div>
                <?php endif; ?>
            <?php else: ?>
                <?php foreach ($booksByCategory as $book): ?>
                    <a href="/bookDetails.php?id=<?=$book['id']?>" style="text-decoration: none">
                    <div class="book-card">
                        <div class="book-image-container book-image">
                            <img src="/uploads/book_img/<?= $book['image'] ?>" alt="Book Cover">
                        </div>
                        <div class="book-title"><?= htmlspecialchars($book['name']) ?></div>
                        <div class="book-author">by <?= htmlspecialchars($book['author_name']) ?></div>
                        <div class="book-price">$<?= number_format($book['price'], 2) ?></div>
                    </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>
</body>

</html>