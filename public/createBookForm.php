<?php

use function app\Database\openDataConnection;
use app\controllers\BookController;
session_start();

require_once '../app/controllers/BookController.php';
require_once '../app/Database.php';

 
 $conn = openDataConnection();

 $bookController = new BookController($conn);
 $bookToUpdate="";
 if(isset($_GET['id']))
 {
    $bookToUpdate = $bookController->getBookById($_GET['id']);
 }
 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/form.css">

</head>

<body>
    
    <?php if (isset($_SESSION['user']['id'])): ?>
        <?php if ($bookToUpdate): ?>
            <div class="form-container">
                <form action="/" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="hidden" name="id" value="<?= $bookToUpdate['id'] ?>">
                        <input type="hidden" name="existing_image" value="<?= $bookToUpdate['image'] ?>">
                    </div>
                    <div class="form-group">
                        <label>Book Name:</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($bookToUpdate['name']) ?>">
                    </div>
                    <div class="form-group">
                        <label>Author Name:</label>
                        <input type="text" name="author" value="<?= htmlspecialchars($bookToUpdate['author_name']) ?>">
                    </div>
                    <div class="form-group">
                        <label>Description:</label>
                        <input type="text" name="description" value="<?= htmlspecialchars($bookToUpdate['description']) ?>">
                    </div>
                    <div class="form-group">
                        <label>Price:</label>
                        <input type="number" name="price" step="0.00001"
                            value="<?= htmlspecialchars($bookToUpdate['price']) ?>">
                    </div>
                    <div class="form-group">
                        <label>New Image:</label>
                        <input type="file" name="image" accept="image/*">
                    </div>
                    <button class="btn" style=" background-color: green;" type="submit" name="update">Update</button>


                </form>
            </div>
        <?php else: ?>
            <div class="form-container">
                <form action="/" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Book Name: </label>
                        <input type="text" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="author">Author Name: </label>
                        <input type="text" name="author" id="author" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description: </label>
                        <input type="text" name="description" id="description" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price($): </label>
                        <input type="number" name="price" id="price" step="0.00001" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Upload Image: </label>
                        <input type="file" name="image" id="image" accept="image/*">
                    </div>
                    <button class="btn" style="background-color: green;" type="submit" name="create">Submit</button>
                </form>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <?php
         header('Location: \login.php');
        ?>
    <?php endif; ?>

</body>
</html>