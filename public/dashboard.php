<?php
session_start();
use app\controllers\AdminController;
use app\controllers\UserController;
use function app\Database\openDataConnection;
require '../app/controllers/userController.php';
require '../app/controllers/adminController.php';
require '../app/database.php';
require '../app/helpers/auth.php';

$conn = openDataConnection();
$userController = new UserController($conn);
$allusers = $userController->getAllUsers();
$adminController = new AdminController($conn);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'updateUserRole') {
  $userId = (int) $_POST['user_id'];
  $roleId = (int) $_POST['role_id'];

  $adminController->updateUser($userId, $roleId);
  header("Location: dashboard.php");
  exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'])) {
  $adminController->deleteUser($_GET['delete']);
  header("Location: dashboard.php");
  exit();
}
require 'navBar.php';
?>
<!DOCTYPE html>
<html>

<head>
  <title>Admin Panel</title>
  <link rel="stylesheet" href="css/index.css">
</head>

<body>
  <h1><?php echo "Users List" ?></h1>
  <?php if ((isset($_SESSION['user']['id'])) && has_permission($_SESSION['user']['id'], "permission-view")): ?>
    <div>
      <a href="/permission.php" class="btn" style="width: 200px;">Permission Option</a>
    </div>
  <?php endif ?>
  <table class="Table">
    <thead style="background-color:grey">
      <th>Name</th>
      <th>Email</th>
      <th>Image</th>
      <th>Role</th>
      <!-- <th>Created By</th>
            <th>Created At</th>
            <th colspan="2" style="background-color: F4F6FF"><a href="createuserForm.php" class="btn"
                    style="width: 100%">Add user</a></th> -->

    </thead>

    <tbody>
      
        <?php foreach ($allusers as $user): ?>
          <?php if (((isset($_SESSION['user']['id'])) && ($_SESSION['user']['id'] == $user['id'])) || $_SESSION['user']['role'] == 1): ?>
          <tr>
           
            <td> <?= $user['name'] ?> </td>
            <td> <?= $user['email'] ?> </td>
            <td> <?= $user['image'] ?> </td>
            <td> <?= $adminController->getRoleId($user['id']) == 2 ? "user" : "admin"?> </td>


            <!-- <td> <?php echo $userController->getUserNameById($user['created_by']) ?> </td>
                    <td> <?= $user['created_at'] ?> </td> -->

            <td>
              <?php if (((isset($_SESSION['user']['id'])) && has_permission($_SESSION['user']['id'], "role-update"))): ?>
                <div>
                  <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                    <?php $currentRoleId = $adminController->getRoleId($user['id']); ?>
                    <input type="hidden" name="action" value="updateUserRole">
                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">

                    <!-- <label for="role">User Role:</label> -->
                    <select name="role_id" id="role" class="">
                      <option value=1 <?= $currentRoleId == 1 ? 'selected' : '' ?>>Admin</option>
                      <option value=2 <?= $currentRoleId == 2 ? 'selected' : '' ?>>User</option>
                    </select>
                    <button type="submit" class="">Update</button>
                  </form>
                </div>
              <?php endif ?>
            </td>
            <td>
              <?php if ((isset($_SESSION['user']['id'])) && has_permission($_SESSION['user']['id'], "role-delete")): ?>
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="get">
                  <button class="btn" style=" background-color: darkred; width: 100px;" type="submit" name="delete"
                    value="<?= $user['id'] ?>">Delete</button>
                </form>

              <?php endif ?>
            </td>
          </tr>
          <?php endif; ?>
        <?php endforeach ?>
      
    </tbody>


  </table>
</body>