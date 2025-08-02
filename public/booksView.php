<?php


use app\controllers\UserController;
 require_once '../app/Database.php';
 require_once '../app/controllers/UserController.php';
 $userController = new UserController($conn);


?>
<!DOCTYPE html>
<html>

<head>
    <title>CRUD</title>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <h1><?php echo "Book List and" . " Operation" ?></h1>
    
    <table class="Table">
        <thead style="background-color:grey">
            <th>Name</th>
            <th>Author</th>
            <th>Description</th>
            <th>Image</th>
            <th>Price</th>
            <th>Created By</th>
            <th>Created At</th>
            <th colspan="2" style="background-color: F4F6FF"><a href="createBookForm.php" class="btn"
                    style="width: 100%">Add Book</a></th>

        </thead>

        <tbody>
            <?php foreach ($allBooks as $book): ?>
                <tr>
                    <td> <?= $book['name'] ?> </td>
                    <td> <?= $book['author_name'] ?> </td>
                    <td> <?= $book['description'] ?> </td>
                    <td> <?= $book['image'] ?> </td>
                    <td> <?= $book['price'] ?> </td>
                    <td> <?php echo $userController->getUserNameById($book['created_by']) ?> </td>
                    <td> <?= $book['created_at'] ?> </td>
                    <td>
                        <?php if (((isset($_SESSION['user']['id'])) && $book['created_by'] == $_SESSION['user']['id']) || $_SESSION['user']['role'] === 'admin'): ?>
                            <div>
                                <a href="createBookForm.php?id=<?= $book['id'] ?>" class="btn">Update</a>
                            </div>
                        <?php endif ?>
                    </td>
                    <td>
                        <?php if (((isset($_SESSION['user']['id'])) && $book['created_by'] == $_SESSION['user']['id']) || $_SESSION['user']['role'] === 'admin'): ?>
                            <form action="/" method="get">
                                <button class="btn" style=" background-color: darkred;" type="submit" name="delete"
                                    value="<?= $book['id'] ?>">Delete</button>
                            </form>

                        <?php endif ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>

    </table>


</body>

</html>