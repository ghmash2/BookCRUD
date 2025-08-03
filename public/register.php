<?php
session_start();
use app\controllers\UserController;
use function app\Database\openDataConnection;
require '../app/controllers/userController.php';
require '../app/database.php';
require '../app/helpers/auth.php';
$conn = openDataConnection();
$userController = new UserController($conn);
$user = "";
if (isset($_GET["id"])) {
    $user = $userController->getUserById($_GET["id"]);
}
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
            <?php if ($user && has_permission($_SESSION['user']['id'], "post-update")): ?>
                <form action="profile.php" method="post" enctype="multipart/form-data">
                    <h2>Edit Profile</h2>

                    <div class="form-group">
                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                        <input type="hidden" name="existing_image" value="<?= $user['image'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="name">New Name: </label>
                        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">New Password:</label>
                        <input type="password" name="password">
                    </div>
                    <div class="form-group">
                        <label>New Image:</label>
                        <input type="file" name="image" accept="image/*">
                    </div>
                    <button class="btn" style=" background-color: green;" type="submit" name="update">Confirm</button>

                </form>
            <?php else: ?>
                <form action="/" method="post" enctype="multipart/form-data">
                    <h2>Register</h2>
                    <div class="form-group">
                        <label for="name">User Name: </label>
                        <input type="text" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email: </label>
                        <input type="email" name="email" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password: </label>
                        <input type="text" name="password" id="password" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Upload Image: </label>
                        <input type="file" name="image" id="image" accept="image/*">
                    </div>
                    <button class="btn" style=" background-color: green;" type="submit" name="register"
                        value=register>Register</button>

                </form>
            <?php endif; ?>
        </div>
    </div>

</body>