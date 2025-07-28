<head>
  <link rel="stylesheet" href="css/form.css">

</head>

<body>
  <div class="form-container">
    <form action="index.php" method="post">
      <h2>LogIn</h2>
      <div class="form-group">
        <label for="email">Email: </label>
        <input type="email" name="email" id="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password: </label>
        <input type="password" name="password" id="password" required>
      </div>
      <button class="btn" style=" background-color: green;" type="submit" name="login" value=login>Login</button>
      <div><?= $message ?></div>
      <div class="extra-links">
        <p>Don't have an account? <a href="register.php">Register</a></p>

      </div>
    </form>
  </div>
</body>