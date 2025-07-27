<body>
    <form action="index.php" method="post">
        <label for="email">Email: </label>
        <input type="text" name="email" id="email" required>

        <label for="password">Password: </label>
        <input type="text" name="password" id="password" required>
        <button class="Button" style=" background-color: green;" type="submit" name="login" value=login>Login</button>
        
    </form>
  <form action="index.php" method="post">
    <button class="Button" style=" background-color: green;" type="submit" name="logout" value=logout>Logout</button>
  </form>
    <form action="index.php" method="post" enctype="multipart/form-data" class="Form">
         <?php include 'register.php' ?>
    </form>
</body>