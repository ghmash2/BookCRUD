<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
        }

        .topnav {
            background-color: #333;
            color: white;
            padding: 0.75rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topnav .left-section {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .topnav .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
            text-decoration: none;
        }

        .topnav a.nav-link {
            color: white;
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .topnav a.nav-link:hover {
            background-color: #555;
        }

        .topnav .profile {
            display: flex;
            align-items: center;
        }

        .topnav .profile img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }

        .topnav .profile span {
            font-size: 1rem;

        }
    </style>
</head>

<body>

    <div class="topnav">
        <div class="left-section">
            <a href="index.html" class="logo">BookCRUD</a>
            <a href="home.html" class="nav-link">Home</a>
            <a href="dashboard.html" class="nav-link">Dashboard</a>
            <a href="contact.html" class="nav-link">Contact</a>
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
                <form action="index.php" method="post">

                    <button class="Button" style=" background-color: green;" type="submit" name="login"
                        value=login>Login</button>
                </form>
                <form action="index.php" method="post" enctype="multipart/form-data">
                    <a href="/app/controllers/AuthController.php">
                        <button class="Button" style="background-color: green;" type="submit" name="register"
                            value="register">Register</button>
                    </a>
                </form>
            </div>
        <?php endif; ?>
    </div>

</body>

</html>