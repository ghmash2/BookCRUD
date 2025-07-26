<!DOCTYPE html>
<html>

<head>
    <title>CRUD</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
 <form action="index.php" method="post" enctype="multipart/form-data" class="Form">
            <label for="name">User Name: </label>
            <input type="text" name="name" id="name" required>

            <label for="email">Author Name: </label>
            <input type="text" name="email" id="email" required>

            <label for="password">Password: </label>
            <input type="text" name="password" id="password" required>

            <label for="image">Upload Image: </label>
            <input type="file" name="image" id="image" accept="image/*">

            <button class= "Button" style= "background-color: green;" type="submit" name="register">Register</button>
        </form>
</body>