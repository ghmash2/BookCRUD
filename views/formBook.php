<?php 
  
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="favicon.png">
    <title>Books Catalog</title>
</head>

<body>
   <form action="bookController.php" method="post" enctype="multipart/form-data">
    <label for="name">Book Name: </label>
    <input type="text" name="name" id="name" required>

    <label for="author">Author Name: </label>
    <input type="text" name="author" id="author" required>
     
    <label for="description">Description: </label>
    <input type="text" name="description" id="description" required>

    <label for="price">Price($): </label>
    <input type="number" name="price" id="price" required>

    <label for="image">Upload Image: </label>
    <input type="file" name="image" id="image" accept="image/*">

    <button type="submit">Submit</button>
   </form>
</body>

</html>