<?php 

use function app\Database\openDataConnection;


function has_permission($userid , $permission) {
static $conn = null;
if (is_null($conn)) {
    $conn = openDataConnection();
}
$stmt = $conn->prepare("SELECT * > 0 FROM user_roles AS ur
                               JOIN role_permissions AS rp ON ur.role_id = rp.role_id
                               JOIN permissions AS p ON rp.permission_id = p.id
                               WHERE user_id = : user_id AND name = :name
                               ");

}
?>