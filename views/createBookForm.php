<h1><?php echo "Book List and" . " Operation" ?></h1>

<?php if (isset($_SESSION['user'])): ?>
    <?php if ($bookToUpdate): ?>
        <form action="index.php" method="post" enctype="multipart/form-data" class="Form">
            <input type="hidden" name="id" value="<?= $bookToUpdate['id'] ?>">
            <input type="hidden" name="existing_image" value="<?= $bookToUpdate['image'] ?>">

            <label>Book Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($bookToUpdate['name']) ?>">
            <label>Author Name:</label>
            <input type="text" name="author" value="<?= htmlspecialchars($bookToUpdate['author_name']) ?>">

            <label>Description:</label>
            <input type="text" name="description" value="<?= htmlspecialchars($bookToUpdate['description']) ?>">

            <label>Price:</label>
            <input type="number" name="price" step="0.00001" value="<?= htmlspecialchars($bookToUpdate['price']) ?>">

            <label>New Image:</label>
            <input type="file" name="image" accept="image/*">

            <button class="Button" style=" background-color: green;" type="submit" name="update">Update</button>


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

            <button class="Button" style="background-color: green;" type="submit" name="create">Submit</button>
        </form>
    <?php endif; ?>
<?php endif ?>