<?php
session_start();
use app\controllers\UserController;
use function app\Database\openDataConnection;
require_once '../app/Database.php';
require_once '../app/controllers/UserController.php';

$conn = openDataConnection();
$userController = new UserController($conn);
$user = "";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user = $userController->getUserById($id);
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset( $_POST['update'])) {
    $userController->updateUser($_POST, $_FILES);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/profile.css">

</head>

<body>
    <div class="profile-container">
        <div class="profile-header">
            <img src="/uploads/user_img/<?= basename($user['image']) ?>" alt="Profile Picture" class="avatar">
            <div class="user-info">
                <h1><?= $user['name'] ?></h1>
                <p><?= $user['email'] ?></p>
                <span class="badge"><?php  if($_SESSION['user']['role'] == 2) echo "user"; else echo "admin"; ?></span>
            </div>
        </div>

        <div class="profile-details">
            <div class="detail-card">
                <h3>Personal Information</h3>
                <p><strong>Joined:</strong> January 15, 2022</p>
                <p><strong>Location:</strong> New York, USA</p>
                <p><strong>Phone:</strong> (123) 456-7890</p>
            </div>

            <div class="detail-card">
                <h3>Account Details</h3>
                <p><strong>User ID:</strong> U-123456</p>
                <p><strong>Status:</strong> Active</p>
                <p><strong>Last Login:</strong> Today, 10:30 AM</p>
            </div>

            <!-- <div class="detail-card">
                <h3>Bio</h3>
                <p>Software developer with 5 years of experience in web development. Passionate about creating
                    user-friendly interfaces.</p>
            </div>

            <div class="detail-card">
                <h3>Skills</h3>
                <p>HTML, CSS, JavaScript, PHP, MySQL, React</p>
            </div>
        </div> -->

            <div class="action-buttons">

                <div>
                    <a href="register.php?id=<?= $user['id'] ?>" class="btn btn-primary" style="text-decoration: none;">Edit Profile</a>
                </div>

                <!-- <button class="btn btn-secondary">Change Password</button> -->
            </div>
        </div>
</body>

</html>