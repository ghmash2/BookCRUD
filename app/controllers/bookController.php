<?php 

namespace App\Controllers;

use App\Models\Book;



class BookController
{
    private $model;

    public function __construct() {
        $this->model = new Book();
    }

    public function index() {
        $books = $this->model->all();
        include __DIR__ . '/../views/books/index.php';
    }

      public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->create($_POST);
            header("Location: index.php");
        } else {
            include __DIR__ . '/../views/books/create.php';
        }
    }


}