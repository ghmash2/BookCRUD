<?php
namespace app\controllers;

use PDO;

class AuthController
{

    private PDO $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    /* public function showLogin()
     {
     }
     public function showRegister()
     {
         require 'views/register.php';
     }*/
    public function register()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST["name"];
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $email = $_POST["email"];


            $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/user_img/";
            $imageName = basename($_FILES["image"]["name"]);
            $targetPath = $targetDir . $imageName;
            move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath);



            $stmt = $this->conn->prepare("INSERT INTO user(name, email, image, password) 
                                                 VALUES (:name, :email, :image, :password)");
            $stmt->execute([
                ":name" => $name,
                ":email" => $email,
                ":image" => $imageName,
                ":password" => $password
            ]);

            $id = $this->conn->lastInsertId();
            $roleId = $roleId ?? 2;
            $stmt = $this->conn->prepare("INSERT INTO user_roles(user_id, role_id)
                                                 VALUES (:user_id, :role_id)");
            $stmt->execute([
                ":user_id" => $id,
                ":role_id"=> $roleId
            ]);
            header("Location: login.php");
            exit();
        }
    }
    public function login()
    {
        $message = "";
        $email = $_POST["email"];
        $password = $_POST["password"];
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->execute([":email" => $email]);
        $user = $stmt->fetch();

        if ($user) {
            if ($user && password_verify($password, $user["password"])) {

                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'image' => $user['image'],
                    'role' => $user['role'],
                    'message' => ""
                ];
               
                $_SESSION['user']['message'] = "Successfully Logged in";
                //var_dump($_SESSION["user"]);
                header("Location: /index.php");
                exit();
            } else {

                $_SESSION['user']['message'] = "Invalid email or password";
                header("Location: /login.php");
                exit();

            }
        } else {

           $_SESSION['user']['message'] = "Not Registered Yet!!!";
            header("Location: /login.php");
            exit();
        }

    }
    public function logout()
    {

        session_destroy();
        header("Location: index.php");
    }
}
