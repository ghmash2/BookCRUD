<?php
namespace app\controllers\BookController;

require_once '../app/Database.php';

use PDO;
use PDOException;
use function app\Database\openDataConnection;

// Connect to the database
$conn = openDataConnection();
$bookController = new BookController($conn);
$bookController->createBook();
class BookController
{
    private PDO $conn;
    public function __construct($conn)
    {
            $this->conn = $conn;
    }
    public function createBook()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST["name"];
            $author_name = $_POST['author'];
            $description = $_POST['description'];
            $price = $_POST['price'];


            $stmt = $this->conn->prepare("INSERT INTO books(name, author_name, description, price) VALUES (:name, :author, :description, :price)");

            $stmt->execute([
                ':name' => $name,
                ':author' => $author_name,
                ':description' => $description,
                ':price' => $price
            ]);


            header("Location: index.php");
        }
    }
}
