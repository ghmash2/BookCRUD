<?php
namespace app\public\index;


require_once '../config/Config.php';
require_once '../app/Database.php';

use app\BookControllers\BookController;
use function app\Database\openDataConnection;


use PDO;
use PDOException;
// or new PDO(...) if you're not using a function


$conn = openDataConnection();
if ($conn instanceof PDO) {
    echo "Database Connected Successfully";
} else {
    echo "!!!!Database is not Connected!. Unexpected Error!!!!";
}
$allBooks = $conn->query("SELECT * FROM books ORDER BY id DESC")->fetchAll();


?>




<!DOCTYPE html>
<html>

<head>
    <title><?php echo $title ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <h1><?php echo "Book List and" . " Operation" ?></h1>
    <table>
        <thead>
         <th>Name</th>
         <th>Author</th>
         <th>Description</th>
         <th>Image</th>
         <th>Price</th>
         <th></th>
         <th></th>
        </thead>
        <?php foreach ($allBooks as $book): ?>
        <tbody>
           <td> <?= $book['name'] ?> </td>
           <td> <?= $book['author_name'] ?> </td>
           <td> <?= $book['description'] ?> </td>
           <td> <?= $book['image'] ?> </td>
           <td> <?= $book['price'] ?> </td>
           <td><button>Update</button></td>
           <td><button>Delete</button></td>
        </tbody>
        <?php endforeach?>
    </table>

    <form action="BookController.php" method="post" enctype="multipart/form-data">
    <label for="name">Book Name: </label>
    <input type="text" name="name" id="name" required>

    <label for="author">Author Name: </label>
    <input type="text" name="author" id="author" required>
     
    <label for="description">Description: </label>
    <input type="text" name="description" id="description" required>

    <label for="price">Price($): </label>
    <input type="number" name="price" id="price" required>

    <!--<label for="image">Upload Image: </label>
    <input type="file" name="image" id="image" accept="image/*"> -->

    <button type="submit">Submit</button>
   </form>
</body>

</html>