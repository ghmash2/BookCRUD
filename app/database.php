<?php
namespace app\Database;


use PDO;
use PDOException;

function openDataConnection()
{
  try {
    $pdo = new PDO("mysql:host=localhost; dbname=testdatabase", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
  } catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
  }
}

function closeDataConnection(&$conn)
{
  $conn = null;
}
?>