<!DOCTYPE html>
<html>
<head>
    <title>Book List</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>Book List</h1>
    <a href="index.php?action=create" class="btn">+ Add Book</a>
    <table>
        <tr><th>ID</th><th>Title</th><th>Author</th><th>Year</th><th>Actions</th></tr>
        <?php foreach ($books as $book): ?>
        <tr>
            <td><?= $book['id'] ?></td>
            <td><?= htmlspecialchars($book['title']) ?></td>
            <td><?= htmlspecialchars($book['author']) ?></td>
            <td><?= $book['year'] ?></td>
            <td>
                <a href="index.php?action=edit&id=<?= $book['id'] ?>">Edit</a>
                <a href="index.php?action=delete&id=<?= $book['id'] ?>" onclick="return confirm('Delete this book?')">Delete</a>
            </td>
        </tr>
        <?php endforeach ?>
    </table>
</body>
</html>
