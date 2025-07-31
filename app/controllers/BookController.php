<?php
namespace app\controllers;

use DateTime;

use PDO;
use PDOException;


/*if(!isset($_SESSION["user"])){
    header("Location: index.php?action=login");
    exit;
}*/
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
            $created_by = $_SESSION['user'];
            $created_at = date("Y-m-d H:i:s");

            $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/book_img/";
            $imageName = basename($_FILES["image"]["name"]);
            $targetPath = $targetDir . $imageName;
            move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath);
            $stmt = $this->conn->prepare("INSERT INTO books(name, author_name, description, price, image, created_by, created_at) 
                                                 VALUES (:name, :author, :description, :price, :image, :created_by, :created_at)");

            $stmt->execute([
                ':name' => $name,
                ':author' => $author_name,
                ':description' => $description,
                ':price' => $price,
                ':image' => $imageName,
                ':created_by' => $created_by,
                'created_at' => $created_at
            ]);


            header("Location: index.php");
            exit();
        }
    }
    public function getBookById($id)
    {
        $stmt = $this->conn->prepare('SELECT * FROM books WHERE id= :id');

        $stmt->execute([':id' => $id]);

        return $stmt->fetch();
    }
    public function updateBook()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            $id = $_POST['id'];

            $name = $_POST["name"];

            $author_name = $_POST['author'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $imageName = $_POST['existing_image'];

            if (!empty($_FILES["image"]["name"])) {
                $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/book_img/";
                $NewImageName =uniqid() . '_' . basename($_FILES["image"]["name"]);
                $targetPath = $targetDir . $NewImageName;
                if ($imageName && file_exists($targetDir . $imageName)) {
                    unlink($targetDir . $imageName);
                }
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath)) {
                    $imageName = $NewImageName;
                }
            }

            $stmt = $this->conn->prepare("UPDATE books 
            SET name = :name, author_name = :author, description = :description, price = :price, image = :image 
            WHERE id = :id");



            $stmt->execute([
                ':name' => $name,
                ':author' => $author_name, // make sure variable matches input
                ':description' => $description,
                ':price' => $price,
                ':image' => $imageName,
                ':id' => $id
            ]);

        }
        header("Location: index.php");
    }
    public function deleteBook()
    {
        $id = $_GET["delete"];
        $stmt = $this->conn->prepare("SELECT image FROM books WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $image = $stmt->fetchColumn();

        $imagepath = $_SERVER['DOCUMENT_ROOT'] . "/uploads/book_img/" . $image;
        //echo realpath("../uploads/" . $image);
        if ($image && file_exists($imagepath)) {
            unlink($imagepath);
        }
        $stmt = $this->conn->prepare("DELETE FROM books WHERE id=:id");
        $stmt->execute(['id' => $id]);

        header("Location: index.php");
    }
}
