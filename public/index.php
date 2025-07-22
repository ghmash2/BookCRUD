<?php
namespace app\public\index;


require_once '../config/Config.php';
require_once '../app/Database.php';
require_once '../app/controllers/BookController.php';


use app\controllers\BookController;
use function app\Database\openDataConnection;


use PDO;
use PDOException;

$conn = openDataConnection();

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


require_once '../views/createBookForm.php';
require_once '../views/booksView.php';