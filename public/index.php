<?php
namespace app\public\index;


require_once '../config/Config.php';
require_once '../app/Database.php';
require_once '../app/controllers/BookController.php';
require_once '../app/controllers/AuthController.php';
//require_once 'css/index.css';


use app\controllers\BookController;
use app\controllers\AuthController;
use function app\Database\openDataConnection;
use PDO;
use PDOException;

require '../views/navBar.php';


$conn = openDataConnection();

/*
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
var_dump($uri);
$routes = [
      '/'=> '/app/controllers/index.php',
      '/login'=> '../app/controllers/AuthController.php',
      '/register'=> '../app/controllers/AuthController.php',
      '/viewBooks'=> '../app/controllers/BookController.php',
      '/createBook'=> '../app/controllers/BookController.php'
];
if(array_key_exists($uri, $routes)) {
    echo $uri;
    //require $routes[$uri];
}
*/


$authController = new AuthController($conn);

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
   $authController->register();
}
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
   //$authController->showLogin();
   $authController->login();
}
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout'])) {
    
   $authController->logout();
}



$allBooks = $conn->query("SELECT * FROM books ORDER BY id DESC")->fetchAll();
$bookController = new BookController($conn);


//create
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $bookController->createBook();
}

//update
$bookToUpdate = null;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['update'])) {

    $bookToUpdate = $bookController->updateBook();
    
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
   
    $bookController->updateBook();
}

//delete
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'])) {
    echo "Delete Item: ";
    $bookController->deleteBook();
}

require_once '../views/login.php';
require_once '../views/createBookForm.php';
require_once '../views/booksView.php';