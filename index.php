<?php

$tokensPath = 'token.json';
 

if (file_exists($tokensPath)) {
    $jsonContent = file_get_contents($tokensPath);
    $tokens = json_decode($jsonContent, true)['tokens'] ?? [];
} else {
    $tokens = []; 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Borrowing Form</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <div class="box header">
      <h1> Easy Book Borrowing </h1>
      <img src="image.png" alt="Student ID" class="top-right-image">
    </div>
    <div class="main-content-area">
      <div class="box left-sidebar">
        <h3>Invalied Tokens</h3>
        <ul>
          <?php
          // Load used tokens from used_token.json
          $usedTokensPath = 'used_token.json';
          $usedTokens = file_exists($usedTokensPath) ? json_decode(file_get_contents($usedTokensPath), true)['used_tokens'] ?? [] : [];
          foreach ($usedTokens as $usedToken) {
              echo "<li>" . htmlspecialchars($usedToken) . "</li>";
          }
          ?>
        </ul>
      </div>
      <div class="content-wrapper">
        <div class="box content1">“The more that you read, the more things you will know. The more that you learn, the more places you’ll go.”</div>
        
        <div class="box content3">
  <h2>Search Books</h2>
  <form action="" method="get">
    <label for="search"></label>
    <input type="text" id="search" name="search" required value="<?php if(isset($_GET['search'])) { echo $_GET['search']; } ?>" class="form-control" placeholder="Search by Title or Author">
    <button type="submit" class="btn btn-primary">Search </button>
  </form>
  <div class="col-md-1">
    <div class="card mt-4">
      <div class="card-body">
        <table class=class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
          <thead>
            <tr>
              <th>ID</th>
              <th>Book Name</th>
              <th>Author Name</th>
              <th>Price</th>
              <th>Quantity</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $con = mysqli_connect("localhost", "root", "", "library");
            if (!$con) {
                die("Connection failed: " . mysqli_connect_error());
            }

            if (isset($_GET['search'])) {
                $filtervalues = mysqli_real_escape_string($con, $_GET['search']);
                $query = "SELECT * FROM books WHERE CONCAT(book_name, author_name, price, quantity) LIKE '%$filtervalues%'";
                $query_run = mysqli_query($con, $query);

                if (!$query_run) {
                    die("Query failed: " . mysqli_error($con));
                }

                if (mysqli_num_rows($query_run) > 0) {
                    foreach ($query_run as $items) {
                        echo "<tr>
                            <td>{$items['id']}</td>
                            <td>{$items['book_name']}</td>
                            <td>{$items['author_name']}</td>
                            <td>{$items['price']}</td>
                            <td>{$items['quantity']}</td>
                          </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No Books found ???</td></tr>";
                }
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

        <div class="box content2">
          <h2>Add Book Details</h2>
          <form action="add_book.php" method="post" id="bookDetailsForm">
            <label for="book-name">Book Name:</label>
            <input type="text" id="book-name" name="book-name" placeholder="Enter book name" required>
           
            <label for="author-name">Author Name:</label>
            <input type="text" id="author-name" name="author-name" placeholder="Enter author name" required>
 
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" placeholder="Enter price" required>
 
            <label for="quantity">Available Quantity:</label>
            <input type="number" id="quantity" name="quantity" placeholder="Enter available quantity" required>
 
            <label for="isbn">ISBN Number:</label>
            <input type="text" id="isbn" name="isbn" placeholder="Enter ISBN number" required>
 
            <button type="submit">Add</button>
          </form>
        </div>
        <div class="small-content">
          <div class="box">Story Books</div>
          <div class="box">Fantasy Books</div>
          <div class="box">Novels</div>
        </div>
      </div>
      <div class="box right-sidebar">
  <h2>All Books</h2>
  <table style="border: 1px solid black; border-collapse: collapse; width: 100%;">
    <thead>
      <tr>
        <!-- <th style="border: 1px solid black; padding: 8px;">ID</th> -->
        <th style="border: 1px solid black; padding: 8px;">Book Name</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $con = mysqli_connect("localhost", "root", "", "library");
      if (!$con) {
          die("Connection failed: " . mysqli_connect_error());
      }

      $sql = "SELECT book_name FROM books";
      $result = mysqli_query($con, $sql);

      if ($result && mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>
                      
                      <td style='border: 1px solid black; padding: 8px;'>{$row['book_name']}</td>
                    </tr>";
          }
      } else {
          echo "<tr><td colspan='2' style='border: 1px solid black; padding: 8px; text-align: center;'>No books found</td></tr>";
      }

      mysqli_close($con);
      ?>
    </tbody>
  </table>
</div>

    </div>
    <div class="footer-area">
      <div class="box footer">
        <h2 style="font-size: 14px; text-align: center;"> Book Borrow Form</h2>
        <form action="process.php" method="post">
 
          <label for="student-name">Student Full Name:</label>
          <input type="text" id="student-name" name="student-name" required>
         
          <label for="student-id">Student ID:</label>
          <input type="text" id="student-id" name="student-id" required>
         
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required>
         
          <label for="book-title">Book Title:</label>
          <select id="book-title" name="book-title" required>
              <option value="Book 1">Sellected Book 1</option>
              <option value="Book 2">Sellected Book 2</option>
              <option value="Book 3">Sellected Book 3</option>
              <option value="Book 4">Sellected Book 4</option>
              <option value="Book 5">Sellected Book 5</option>
          </select>
 
          <label for="borrow-date">Borrow Date:</label>
          <input type="date" id="borrow-date" name="borrow-date" required>
         
          <label for="return-date">Return Date:</label>
          <input type="date" id="return-date" name="return-date" required>
         
          <label for="token">Enter Token:</label>
          <input type="text" id="token" name="token" placeholder="Enter your token">  
         
          <label for="fees">Fees (in TK):</label>
          <input type="number" id="fees" name="fees" required>
         
          <input type="submit" value="Submit">
        </form>
      </div>
      <div class="box footer2">
        <h3>Available Tokens</h3>
        <ul class="scrollable">
          <?php
          if (!empty($tokens)) {
              foreach ($tokens as $token) {
                  echo "<li>" . htmlspecialchars($token) . "</li>";
              }
          } else {
              echo "<li>Token is not available</li>";
          }
          ?>
        </ul>
      </div>
    </div>
  </div>
</body>
</html>
