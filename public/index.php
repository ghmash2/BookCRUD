<?php
require_once '../config/config.php';
include_once __DIR__ . '/../app/database.php';

use App\Controllers\BookController;
use App\models\Book;
use function App\Database\openDataConnection;

// or new PDO(...) if you're not using a function

$conn = openDataConnection();
if ($conn instanceof PDO) {
   echo "Database Connected Successfully";
}
else {
    echo "Database is not Connected. Unexpected Error!";
}

$controller = new BookController();
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

switch ($action) {
    case 'create':
        $controller->create();
        break;
    case 'edit':
        $controller->edit($id);
        break;
    case 'delete':
        $controller->delete($id);
        break;
    default:
        $controller->index();
        break;
}

?>