<?php 

namespace App\Models;


use App\Database;
class Book{
    private $pdo;

    public function __construct() {
        $this->pdo = Database::connect();
    }

    public function all() {
        return $this->pdo->query("SELECT * FROM books ORDER BY id DESC")->fetchAll();
    }
}
