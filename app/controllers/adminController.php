<?php
namespace app\controllers;

use PDO;

class AdminController
{
    private PDO $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    public function getAllUsers()
    {
        return $this->conn->query("SELECT * FROM user ORDER BY id DESC")->fetchAll();
    }
    public function getUserById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE id=:id");
        $stmt->execute([':id' => $id]);

        return $stmt->fetch();
    }
    public function getRoleId($user_id)
    {
        $stmt = $this->conn->prepare("SELECT role_id FROM user_roles WHERE user_id = :user_id");
        $stmt->execute([":user_id" => $user_id]);
        return $stmt->fetchColumn() ?? 2;
    }
    public function updateUser($userId, $roleId)
    {
        $user_id = $userId;
        // $stmt = $this->conn->prepare("SELECT role_id FROM user_roles WHERE user_id = :user_id");
        // $stmt->execute([":user_id" => $user_id]);
        // $role_id = $stmt->fetchColumn();
        $role_id = $roleId;
        if ($role_id == null)
            $role_id = 2;

        $stmt = $this->conn->prepare("UPDATE user_roles SET role_id = :role_id
                                           WHERE user_id = :user_id");
        $stmt->execute([
            ":role_id" => $role_id,
            ":user_id" => $user_id
        ]);

        $_SESSION['user']['role']= $role_id;

    }
    public function deleteUser($id)
    {
       $stmt = $this->conn->prepare("SELECT image FROM user WHERE id=:id");
       $stmt->execute([":id"=> $id]);
       $image = $stmt->fetchColumn();
       $imagePath = $_SERVER['DOCUMENT_ROOT'] ."/uploads/book_img/". $image;
       if($image && file_exists($imagePath)){
        unlink($imagePath);
       }

       $stmt = $this->conn->prepare("DELETE FROM user WHERE id=:id");
       $stmt->execute([":id"=> $id]);


    }
     public function getRoles(): array {
        $stmt = $this->conn->query("SELECT * FROM roles");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPermissions(): array {
        $stmt = $this->conn->query("SELECT * FROM permissions");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRolePermissions(int $roleId): array {
        $stmt = $this->conn->prepare("
            SELECT permission_id 
            FROM role_permissions 
            WHERE role_id = ?
        ");
        $stmt->execute([$roleId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    public function updateRolePermissions(int $roleId, array $permissionIds): bool {
        try {
            $this->conn->beginTransaction();
            
            // Clear existing permissions
            $stmt = $this->conn->prepare("DELETE FROM role_permissions WHERE role_id = ?");
            $stmt->execute([$roleId]);
            
            // Insert new permissions
            $stmt = $this->conn->prepare("INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)");
            foreach ($permissionIds as $permId) {
                $stmt->execute([$roleId, $permId]);
            }
            
            $this->conn->commit();
            return true;
        } catch (\PDOException $e) {
            $this->conn->rollBack();
            error_log("Permission update failed: " . $e->getMessage());
            return false;
        }
    }
}


?>