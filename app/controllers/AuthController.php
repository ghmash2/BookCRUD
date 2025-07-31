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


                $_SESSION["user"] = $user["id"];
                $_SESSION["username"] = $user["name"];
                $_SESSION["role"] = $user["role"];
                $_SESSION["image"] = $user["image"];

                $_SESSION['login_error'] = "Successfully Logged in";
                //var_dump($_SESSION["user"]);
                header("Location: /index.php");
                exit();
            } else {

                $_SESSION['login_error'] = "Invalid email or password";
                header("Location: /login.php");
                exit();

            }
        } else {

            $_SESSION['login_error'] = "Not Registered Yet!!!";
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
