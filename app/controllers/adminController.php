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

    }
}


?>