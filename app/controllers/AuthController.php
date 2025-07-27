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
    public function showLogin()
    {
      require_once __DIR__ . '../../views/login.php';
    }
    public function showRegister()
    {
        require 'views/register.php';
    }
    public function register()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST["name"];
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $email = $_POST["email"];

            $stmt = $this->conn->prepare("INSERT INTO user(name, email, password) 
                                                 VALUES (:name, :email, :password)");
            $stmt->execute([
                ":name" => $name,
                ":email" => $email,
                ":password" => $password
            ]);

            //header("Location: index.php");
        }
    }
    public function login()
    {   

        $email = $_POST["email"];
        $password = $_POST["password"];
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->execute([":email" => $email]);
        $user = $stmt->fetch();
    
        if ($user) {
            if ($user && password_verify($password, $user["password"])) {
                $_SESSION["user"] = $user["email"];
                //session_start();
                var_dump($_SESSION["user"]);
                //header("Location : index.php");
            } else {
                echo "Invalid email or password";

            }
        } else {
            echo "Not Registered Yet!!!";
        }
    }
    public function logout()
    {
        session_start();
        session_destroy();
        // header("Location: index.php");
    }
}
