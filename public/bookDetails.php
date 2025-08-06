<?php 

use app\controllers\BookController;
use function app\Database\openDataConnection;

require_once '../app/controllers/BookController.php';
require_once '../app/Database.php';

 $conn = openDataConnection();

 $bookController = new BookController($conn);
 $book="";
 $id = null;
 if(isset($_GET['id']))
 {
    $id = $_GET['id'];
    $book = $bookController->getBookById($id);
 }
 $categories = $bookController->getBookCategory($id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bookDetails.css">
    <title>Book Details</title>
    
</head>
<body>
    <div class="container">
        <div class="book-details">
            <div class="book-image">
                <img src="/uploads/book_img/<?= $book['image'] ?>" alt="Book Cover">
            </div>
            <div class="book-info">
                <h1 class="book-title"><?=$book['name']?></h1>
                <p class="book-author">by<?=" " . $book['author_name']?></p>
                
                <!-- <div class="rating">
                    <div class="stars">★★★★★</div>
                    <span>(4,382 reviews)</span>
                </div>
                 -->
                <div class="book-meta">
                    <div class="meta-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 6h18M7 12h10M5 18h14"></path>
                        </svg>
                        <span>
                        <?php foreach($categories as $category): {
                            echo $category . ", ";
                        }
                        ?>
                        <?php endforeach ?>
                        </span>
                    </div>
                    <div class="meta-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span>Published: 2020</span>
                    </div>
                    <div class="meta-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                        </svg>
                        <span>304 pages</span>
                    </div>
                </div>
                
                <div class="book-price"><?=$book['price']."$"?></div>
                
                <div class="book-description">
                    <p><?=$book['description']?></p>
                </div>
                
                <div class="action-buttons">
                    <button class="btn btn-primary">Add to Cart</button>
                    <button class="btn btn-secondary">Add to Wishlist</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>