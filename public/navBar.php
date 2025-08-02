<?php
use app\controllers\UserController;
   require_once '../app/Database.php';
   require_once '../app/controllers/UserController.php';
   $userController = new UserController($conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="css/navBar.css">

</head>

<body>

    <div class="topnav">
        <div class="left-section">
            <a href="/" class="logo">BookCRUD</a>
            <a href="index.php" class="nav-link">Home</a>
            <a href="dashboard.php" class="nav-link">Dashboard</a>
            <a href="contact.php" class="nav-link">Contact</a>
        </div>

        <?php if (isset($_SESSION['user']['id'])): ?>
            <div class="profile">
                <!--  -->
               
                <a href="\profile.php?id=<?= $_SESSION['user']['id'] ?>" style="color: #e5ecf3ff; text-decoration: none;">
                    <img src= "/uploads/user_img/<?= $_SESSION['user']['image'] ?>" alt="Profile">
                    <!-- <span><?= $_SESSION['user']['username'] ?></span> -->
                </a>

                <form action="/" method="post">
                    <button class="btn" style=" background-color: green;" type="submit" name="logout"
                        value=logout>Logout</button>
                </form>
            </div>
        <?php else: ?>
            <div class="profile">

                <a href="login.php" class="btn">Login</a>
                <a href="register.php" class="btn">Register</a>
            </div>
        <?php endif; ?>
    </div>

</body>

</html>