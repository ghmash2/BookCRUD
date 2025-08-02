<?php
namespace app\controllers;

use PDO;

class UserController
{
   private PDO $conn;
   public function __construct($conn)
   {
      $this->conn = $conn;
   }

   public function getUserNameById($id)
   {
      $stmt = $this->conn->prepare("SELECT name FROM user WHERE id=:id");
      $stmt->execute([':id' => $id]);

      return $stmt->fetchColumn();
   }
   public function getUserById($id)
   {
      $stmt = $this->conn->prepare("SELECT * FROM user WHERE id=:id");
      $stmt->execute([':id' => $id]);

      return $stmt->fetch();
   }
   public function updateUser($postdata, $filedata)
   {

      $id = $postdata['id'];
      $name = $postdata['name'];
      !empty($postdata['password']) ? $password = password_hash($postdata['password'], PASSWORD_DEFAULT) : null;

      $imageName = $postdata['existing_image'];

      if (!empty($filedata['image']['name'])) {
         $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/user_img/';
         $newImageName = uniqid() . '_' . basename($filedata['image']['name']);
         $targetPath = $targetDir . $newImageName;
         if ($imageName && file_exists($targetDir . $imageName)) {
            unlink($targetDir . $imageName);
         }
         if (move_uploaded_file($filedata['image']['tmp_name'], $targetPath)) {
            $imageName = $newImageName;
         }
      }
      if ($password != null) {
         $stmt = $this->conn->prepare("UPDATE user SET name = :name, image = :image, password = :password 
                                           WHERE id = :id");

         $stmt->execute([
            ":name" => $name,
            ":image" => $imageName,
            ":password" => $password,
            ":id" => $id
         ]);
      } else {
         $stmt = $this->conn->prepare("UPDATE user SET name = :name, image = :image 
                                           WHERE id = :id");

         $stmt->execute([
            ":name" => $name,
            ":image" => $imageName,
            ":id" => $id
         ]);
      }
      $fetchStmt = $this->conn->prepare("SELECT name, image FROM user WHERE id=:id");
      $fetchStmt->execute([':id' => $id]);
      $updatedUser = $fetchStmt->fetch(PDO::FETCH_ASSOC);

      $_SESSION['user'] = [
         'id' => $id,
         'username' => $updatedUser['username'],
         'image' => $updatedUser['image']
      ];

      header("Location: profile.php?id=" . $id);
      exit();

   }

}
?>