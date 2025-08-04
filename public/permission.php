<?php
session_start();
use app\controllers\AdminController;
use function app\Database\openDataConnection;
require_once '../app/controllers/AdminController.php';
require '../app/database.php';
require '../app/helpers/auth.php';

$conn = openDataConnection();
$controller = new AdminController($conn);
$roles = $controller->getRoles();
$permissions = $controller->getPermissions();
$selectedRoleId = $_GET['role_id'] ?? 2;     //default set "user"
$rolePermissions = $controller->getRolePermissions($selectedRoleId);

// if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== '1') {
//     header('HTTP/1.1 403 Forbidden');
//     exit('Access denied');
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roleId = (int)$_POST['role_id'];
    $permissionIds = array_map('intval', $_POST['permissions'] ?? []);

    if ($controller->updateRolePermissions($roleId, $permissionIds)) {
        $_SESSION['message'] = 'Permissions updated successfully';
    } else {
        $_SESSION['message'] = 'Failed to update permissions';
    }
    
    header("Location: permission.php?role_id=$roleId");
    exit();
}
require_once 'navBar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/permission.css">
    <title>Role Permissions Management</title>
    
</head>
<body>
    <h1>Role Permissions Management</h1>
    
    <div class="container">
        <!-- Role Selection -->
        <div class="role-list">
            <h2>Roles</h2>
            <ul>
                <?php foreach ($roles as $role): ?>
                    <li>
                        <a href="?role_id=<?= htmlspecialchars($role['id']) ?>">
                            <?= htmlspecialchars($role['name']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        
        <!-- Permission Management -->
        <div class="permission-list">
            <h2>Permissions for: <?= htmlspecialchars($roles[array_search($selectedRoleId, array_column($roles, 'id'))]['name']) ?></h2>
            
            <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>">
                <input type="hidden" name="role_id" value="<?= $selectedRoleId ?>">
                
                <?php foreach ($permissions as $permission): ?>
                    <div class="permission-item">
                        <label>
                            <input type="checkbox" 
                                   name="permissions[]" 
                                   value="<?= $permission['id'] ?>"
                                   <?= in_array($permission['id'], $rolePermissions) ? 'checked' : '' ?>>
                            <?= htmlspecialchars($permission['name']) ?>
                            <!-- <small>(<?= htmlspecialchars($permission['description']) ?>)</small> -->
                        </label>
                    </div>
                <?php endforeach; ?>
                 <?php if ((isset($_SESSION['user']['id'])) && has_permission($_SESSION['user']['id'], "permission-update")): ?>
                <button type="submit" class="btn">Update</button>
                <?php endif; ?>
            </form>
        </div>
    </div>
</body>
</html>