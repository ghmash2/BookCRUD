<?php
namespace app\public\index;


require_once '../config/Config.php';
require_once '../app/Database.php';
require_once '../app/controllers/BookController.php';


use app\controllers\BookController;
use function app\Database\openDataConnection;


use PDO;
use PDOException;

$conn = openDataConnection();

$allBooks = $conn->query("SELECT * FROM books ORDER BY id DESC")->fetchAll();

$bookController = new BookController($conn);

//create
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $bookController->createBook();
}

//update
$bookToUpdate = null;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['update'])) {

    $bookToUpdate = $bookController->updateBook();
    var_dump($bookToUpdate); 
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $bookController->updateBook();
}

//delete
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'])) {
    echo "Delete Item: ";
    $bookController->deleteBook();
}


?>




<!DOCTYPE html>
<html>

<head>
    <title><?php echo $title ?></title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <h1><?php echo "Book List and" . " Operation" ?></h1>
    <table class="Table">
        <thead>
            <th>Name</th>
            <th>Author</th>
            <th>Description</th>
            <th>Image</th>
            <th>Price</th>
            <th></th>
            <th></th>
        </thead>

        <tbody>
            <?php foreach ($allBooks as $book): ?>
                <tr>
                    <td> <?= $book['name'] ?> </td>
                    <td> <?= $book['author_name'] ?> </td>
                    <td> <?= $book['description'] ?> </td>
                    <td> <?= $book['image'] ?> </td>
                    <td> <?= $book['price'] ?> </td>
                    <td>
                        <form action="index.php" method="get">
                            <input type="hidden" name="update" value="<?= $book['id'] ?>">
                            <button type="submit" name="update">Update</button>
                        </form>
                    </td>
                    <td>
                        <form action="index.php" method="get">
                            <input type="hidden" name="delete" value="<?= $book['id'] ?>">
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>

    </table>



    <?php if ($bookToUpdate): ?>
        <form action="index.php" method="post" enctype="multipart/form-data" class="Form">
            <input type="hidden" name="update_id" value="<?= $bookToUpdate['id'] ?>">
            <input type="hidden" name="image" value="<?= $bookToUpdate['image'] ?>">

            <label>Book Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($bookToUpdate['name']) ?>">
            <label>Author Name:</label>
            <input type="text" name="author" value="<?= htmlspecialchars($bookToUpdate['author_name']) ?>">

            <label>Description:</label>
            <input type="text" name="description" value="<?= htmlspecialchars($bookToUpdate['description']) ?>">

            <label>Price:</label>
            <input type="number" name="price" value="<?= htmlspecialchars($bookToUpdate['price']) ?>">

            <label>New Image:</label>
            <input type="file" name="image" accept="image/*">

            <button type="submit" name="update">Update</button>


        </form>

    <?php else: ?>
        <form action="index.php" method="post" enctype="multipart/form-data" class="Form">
            <label for="name">Book Name: </label>
            <input type="text" name="name" id="name" required>

            <label for="author">Author Name: </label>
            <input type="text" name="author" id="author" required>

            <label for="description">Description: </label>
            <input type="text" name="description" id="description" required>

            <label for="price">Price($): </label>
            <input type="number" name="price" id="price" step="0.00001" required>

            <label for="image">Upload Image: </label>
            <input type="file" name="image" id="image" accept="image/*">

            <button type="submit" name="create">Submit</button>
        </form>
    <?php endif; ?>
</body>

</html>