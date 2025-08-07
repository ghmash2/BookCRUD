<?php
// session_start();

use app\controllers\UserController;
require_once '../app/Database.php';
require_once '../app/controllers/UserController.php';
require_once '../app/helpers/auth.php';
$userController = new UserController($conn);


?>
<!DOCTYPE html>
<html>

<head>
    <title>CRUD</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/popup.css">
</head>

<body>
    <h1><?php echo "Book List and" . " Operation" ?></h1>

    <table class="Table">
        <thead style="background-color:grey">
            <th>Name</th>
            <th>Author</th>
            <!-- <th>Description</th>
            <th>Image</th> -->
            <th>Price</th>
            <th>Details</th>
            <!-- <th>Created By</th> -->
            <!-- <th></th> -->
            <th colspan="2" style="background-color: F4F6FF"><a href="createBookForm.php" class="btn"
                    style="width: 100%">Add Book</a></th>

        </thead>

        <tbody>
            <?php foreach ($allBooks as $book): ?>
                <tr>
                    <td> <?= $book['name'] ?> </td>
                    <td> <?= $book['author_name'] ?> </td>
                    <!-- <td> <?= $book['description'] ?> </td>
                    <td> <?= $book['image'] ?> </td> -->
                    <td> <?= $book['price'] ?> </td>
                    <!-- <td> <?php echo $userController->getUserNameById($book['created_by']) ?> </td>
                    <td> <?= $book['created_at'] ?> </td> -->
                    <td>
                        <!-- <?php if (((isset($_SESSION['user']['id'])) && has_permission($_SESSION['user']['id'], "post-view")) || $_SESSION['user']['role'] === 1): ?> -->
                            <!-- <?php endif ?> -->
                        <div>
                            <a href="bookDetails.php?id=<?= $book['id'] ?>" class="btn"
                                style="background-color: grey;">Details</a>
                        </div>
                    </td>
                    <td>
                        <?php if (((isset($_SESSION['user']['id'])) && $book['created_by'] == $_SESSION['user']['id'] && has_permission($_SESSION['user']['id'], "post-update")) || $_SESSION['user']['role'] === 1): ?>
                            <div>
                                <a href="createBookForm.php?id=<?= $book['id'] ?>" class="btn">Update</a>
                            </div>
                        <?php endif ?>
                    </td>
                    <td>
                        <?php if (((isset($_SESSION['user']['id'])) && $book['created_by'] == $_SESSION['user']['id'] && has_permission($_SESSION['user']['id'], "post-delete")) || $_SESSION['user']['role'] === 1): ?>
                            <!-- <form action="/" method="get" onsubmit="return confirm('Are you sure you want to delete this book?');">
                                <button class="btn" style=" background-color: darkred;" type="submit" name="delete"
                                    value="<?= $book['id'] ?>">Delete</button>
                            </form> -->
                            <button type="button" onclick="document.getElementById('deleteModal').style.display='block'"
                                class="btn" style=" background-color: darkred;">Delete</button>
                            <div id="deleteModal" class="modal">
                                <div class="modal-content">
                                    <span onclick="document.getElementById('deleteModal').style.display='none'" class="close">
                                        &times; </span>
                                    <h2>Confirm Deletion</h2>
                                    <p style="padding: 30px">Are you sure you want to delete this item?</p>
                                    <form action=" /" method="GET">
                                        <button type="submit" class="btn confirm-btn" name="delete"
                                            value="<?= $book['id'] ?>">Confirm</button>
                                        <button type="button"
                                            onclick="document.getElementById('deleteModal').style.display='none'"
                                            class="btn cancel-btn">Cancel</button>
                                    </form>
                                </div>
                            </div>

                        <?php endif ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>

    </table>


</body>

</html>