<?php
session_start();
?>

<head>
  <link rel="stylesheet" href="css/form.css">
</head>

<body>
  <div style=" padding-top: 20px;">
    <a href="\" class="btn">Home</a>
  </div>
  <div class="formBody">
    <div class="form-container">
      <form action="/" method="post">
        <h2>LogIn</h2>
        <?php if (isset($_SESSION['login_error'])): ?>
          <div
            style="color: red; padding: 10px; margin-bottom: 15px; border: 1px solid #ff9999; border-radius: 5px; background: #ffeeee;">
            <?= $_SESSION['login_error'] ?>
          </div>
          <?php unset($_SESSION['login_error']); ?>
        <?php endif; ?>
        <div class="form-group">
          <label for="email">Email: </label>
          <input type="email" name="email" id="email" required>
        </div>
        <div class="form-group">
          <label for="password">Password: </label>
          <input type="password" name="password" id="password" required>
        </div>
        <button class="btn" style=" background-color: green;" type="submit" name="login" value=login>Login</button>
        <!-- <div><?= $message ?></div> -->
        <div class="extra-links">
          <p>Don't have an account? <a href="register.php">Register</a></p>

        </div>
      </form>
    </div>
  </div>
</body>