<?php
namespace app\public;
session_start();

if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = []; // Initialize as empty array
} elseif (!is_array($_SESSION['user'])) {
    // If corrupted, reset it
    $_SESSION['user'] = [];
}
if (!isset($_SESSION['user']['role'])) {
    $_SESSION['user']['role'] = "user";
}


require_once '../config/Config.php';
require_once '../app/Database.php';
require_once '../app/controllers/BookController.php';
require_once '../app/controllers/AuthController.php';
//require_once 'css/index.css';


use app\controllers\bookController;
use app\controllers\authController;
use function app\Database\openDataConnection;
use PDO;
use PDOException;
echo $_SERVER['REQUEST_URI'];



$conn = openDataConnection();


/*$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
var_dump($uri);
$routes = [
      '/'=> 'index.php',
      '/login'=> '../app/controllers/AuthController.php',
      '/register'=> '../app/controllers/AuthController.php',
      '/viewBooks'=> '../app/controllers/BookController.php',
      '/createBook'=> '../app/controllers/BookController.php'
];
if(array_key_exists($uri, $routes)) {
    echo $uri;
    require $routes[$uri];
} */

$message = "";

$authController = new AuthController($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $authController->register();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    //$authController->showLogin();
     $authController->login();
    
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout'])) {

    $authController->logout();
}



$allBooks = $conn->query("SELECT * FROM books ORDER BY id DESC")->fetchAll();
$bookController = new BookController($conn);


//create
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $bookController->createBook();
}

//update

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {

    $bookController->updateBook();
}

//delete
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'])) {
    //echo "Delete Item: ";
    $bookController->deleteBook();
}

require 'navBar.php';
require_once 'booksView.php';