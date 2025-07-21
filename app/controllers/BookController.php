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
                'image'=> $imageName
            ]);


           // header("Location: index.php");
        }
    }
    public function updateBook()
    {
      if($_SERVER['REQUEST_METHOD'] === 'GET' &&  isset($_GET['update'])) {
         $id = $_GET['update'];
         
         $stmt = $this->conn->prepare('SELECT * FROM books WHERE id= :id');
         
         $stmt->execute([':id' => $id]);
         
         return $stmt->fetch();
      }
      if($_SERVER['REQUEST_METHOD'] === 'POST'&& isset($_POST['update'])) {

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
                'image'=> $imageName
            ]);

      }
       
    }
    public function deleteBook()
    {
         echo"Inside Cintroller";
           
        header("Location: index.php");
    }
}
