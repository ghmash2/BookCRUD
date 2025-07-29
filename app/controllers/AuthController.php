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

            $stmt = $this->conn->prepare("INSERT INTO user(name, email, password) 
                                                 VALUES (:name, :email, :password)");
            $stmt->execute([
                ":name" => $name,
                ":email" => $email,
                ":password" => $password
            ]);

            header("Location: login.php");
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

                 $_SESSION['login_error'] = "Successfully Logged in";
                //var_dump($_SESSION["user"]);
                header("Location : /");
                exit();
            } else {

                 $_SESSION['login_error'] = "Invalid email or password";
                header("Location: /login.php");
                exit();

            }
        } else {

            $message = "Not Registered Yet!!!";

        }
        header("Location: index.php");
        return $message;

    }
    public function logout()
    {

        session_destroy();
        header("Location: index.php");
    }
}
