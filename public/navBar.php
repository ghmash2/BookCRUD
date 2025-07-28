<?php

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
            <a href="index.php" class="logo">BookCRUD</a>
            <a href="home.php" class="nav-link">Home</a>
            <a href="dashboard.php" class="nav-link">Dashboard</a>
            <a href="contact.php" class="nav-link">Contact</a>
        </div>

        <?php if (isset($_SESSION['user'])): ?>
            <div class="profile">
                <!-- <img src="https://i.pravatar.cc/300?img=2" alt="Profile"> -->
                <span>User Name</span>
            </div>
            <form action="index.php" method="post">
                <button class="Button" style=" background-color: green;" type="submit" name="logout"
                    value=logout>Logout</button>
            </form>
        <?php else: ?>
            <div class="profile">
                
                <a href="login.php" class="btn">Login</a>
                 <a href="register.php" class="btn">Register</a>
            </div>
        <?php endif; ?>
    </div>

</body>

</html>