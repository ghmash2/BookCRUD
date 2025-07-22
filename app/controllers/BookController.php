<?php
namespace app\controllers;


use PDO;
use PDOException;



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

            $targetDir = "../uploads/";
            $imageName = basename($_FILES["image"]["name"]);
            $targetPath = $targetDir . $imageName;
            move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath);
            $stmt = $this->conn->prepare("INSERT INTO books(name, author_name, description, price, image) VALUES (:name, :author, :description, :price, :image)");

            $stmt->execute([
                ':name' => $name,
                ':author' => $author_name,
                ':description' => $description,
                ':price' => $price,
                'image' => $imageName
            ]);


            header("Location: index.php");
        }
    }
    public function updateBook()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['update'])) {
            $id = $_GET['update'];
            // var_dump($id);

            $stmt = $this->conn->prepare('SELECT * FROM books WHERE id= :id');

            $stmt->execute([':id' => $id]);

            return $stmt->fetch();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            $id = $_POST['id'];

            $name = $_POST["name"];

            $author_name = $_POST['author'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $imageName = $_POST['existing_image'];

            if (!empty($_FILES["image"]["name"])) {
                $targetDir = "../uploads/";
                $NewImageName = basename($_FILES["image"]["name"]);
                $targetPath = $targetDir . $NewImageName;
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

        $stmt = $this->conn->prepare("DELETE FROM books WHERE id=:id");

        $image = $stmt->fetchColumn();
        if ($image && file_exists("../uploads/" . $image)) {
            unlink("../uploads/" . $image);
        }

        $stmt->execute(['id' => $id]);

        header("Location: index.php");
    }
}
