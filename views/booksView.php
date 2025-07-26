<!DOCTYPE html>
<html>

<head>
    <title>CRUD</title>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    
    <table class="Table">
        <thead style="background-color:grey">
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
                            <button class= "Button" style=" background-color: green;" type="submit" name="update" value="<?= $book['id'] ?>">Update</button>
                        </form>
                    </td>
                    <td>
                        <form action="index.php" method="get">
                            <button class= "Button" style=" background-color: darkred;" type="submit" name="delete" value="<?= $book['id'] ?>">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>

    </table>
     

</body>

</html>