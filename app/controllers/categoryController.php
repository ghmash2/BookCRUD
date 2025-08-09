<?php 
namespace app\controllers;
use PDO;
class CategoryController{
    private $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    public function getCategoryIdByName($categoryName){
      $sql = "SELECT id FROM category WHERE name = :categoryName";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(":categoryName", $categoryName, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetchColumn();
    }
    public function getBooksByCategory($categoryId){
           $sql = "SELECT *  FROM books b JOIN book_category bc ON b.id = bc.book_id WHERE category_id = :category_id";
           $stmt = $this->conn->prepare($sql);
           $stmt->execute( [":category_id"=> $categoryId] );
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getSelectedCategory($book_id){
        $stmt = $this->conn->prepare("SELECT category_id FROM book_category WHERE book_id=:book_id");
        $stmt->execute( [":book_id"=> $book_id ] );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>