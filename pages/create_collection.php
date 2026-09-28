<?php
// 1. Database Connection Configuration
$host    = 'localhost';
$user    = 'root';     // Replace with your DB username
$pass    = '';         // Replace with your DB password
$db      = 'cookbook'; // Replace with your DB name
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$message = '';

// 2. Form Submission Handling
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $collection_name = trim($_POST['name'] ?? '');

    if ($collection_name !== '') {
        try {
            $stmt = $pdo->prepare("INSERT INTO categories (category_name) VALUES (:name)");
            $stmt->execute(['name' => $collection_name]);

            // Redirect back to main page on success
            header("Location: collections.php?status=success");
            exit();
        } catch (\PDOException $e) {
            $message = "Error saving collection: " . $e->getMessage();
        }
    } else {
        $message = "Collection name is required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- local css -->
    <link rel="stylesheet" href="../styles/styles.css">

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Create New Collection — CookBook</title>
    <link rel="icon" type="image/x-icon" href="../images/cblogo2.png">
</head>
<body>

<!-- This is the start of the nav bar -->
 
<!-- THIS IS THE START OF THE NAV BAR (MENU SECTION) -->
<nav class="navbar navbar-expand-lg navbar-light">
  <!-- Logo -->
  <a class="gochihand nav-name" href="index.php">
    <img class="logo" src="../images/cblogo1.png" alt="CookBook Logo" title="CookBook logo">
    CookBook
  </a>

  <!-- Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">

      <!-- Left Side of Navbar -->
        <ul class="navbar-nav ralewayextrabold nav-text">
          <li class="nav-item">
            <a class="nav-link nav-text4" href="recipes.php">RECIPES</a>
          </li>
        </ul>

      <!-- Right Side of Navbar -->
       <div class="ml-auto d-flex align-items-center">
        <!-- For Search -->
        <form class="form-inline">
          <input class="form-control navbar-search" type="search" placeholder="SEARCH">
        </form>
        <!-- For Login -->
        <a class="nav-link nav-text4 login-link" href="#">LOGIN</a>
        <!-- For Register -->
        <a class="register-button" href="#">REGISTER</a>
      </div>
      </div>
</nav>
<!-- THIS IS THE END OF THE NAV BAR (MENU SECTION) -->

<!-- MAIN CONTENT FORM -->
<main class="container my-5" style="max-width: 600px;">
    <h2 class="mb-4">Create New Collection</h2>

    <?php if ($message !== ''): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php endif; ?>

    <form action="create_collection.php" method="POST">
        <div class="form-group mb-3">
            <label for="name" class="font-weight-bold">Collection Name:</label>
            <input type="text" id="name" name="name" class="form-control" required placeholder="e.g. Italian Dishes">
        </div>

        <div class="form-group mb-4">
            <label for="description" class="font-weight-bold">Description:</label>
            <textarea id="description" name="description" class="form-control" rows="4" placeholder="Brief description of this recipe collection..."></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save Collection</button>
        <a href="collections.php" class="btn btn-secondary ml-2">Cancel</a>
    </form>
</main>

<!-- start of footer -->

 <!-- Footer -->
 <footer class="text-center text-lg-start bg-body-tertiary text-muted footer">

<!-- Section: Links  -->
<section class="">
  <div class="container text-center mt-5">
    <!-- Grid row -->
    <div class="row mt-3">
      <!-- Grid column -->
      <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
        <!-- Content -->
        <h6 class="fw-bold mb-4">
        <a class="fas fa-gem me-3 gochihand footer-text1" href="index.php"><img class="logo" src="../images/cblogo2.png" alt="CookBook Logo" title="CookBook logo">CookBook</a>
        </h6>
        <p class="footer-text2 ralewaybold">
          Improve the cooking experience.
        </p>
        <hr>
        <p>
          <a href="#" class="footer-links ralewaybold footer-text2">Instagram</a>
          <a href="#" class="footer-links ralewaybold footer-text2">Facebook</a>
          <a href="#" class="footer-links ralewaybold footer-text2">Tiktok</a>
          <a href="#" class="footer-links ralewaybold footer-text2">YouTube</a>
        </p>
      </div>
      <!-- Grid column -->


      <!-- Grid column -->
      <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
        <!-- Links -->
        <h6 class="text-uppercase ralewayextrabold footer-text1 mb-4">
          Quick links
        </h6>
        <p>
          <a href="index.php" class="footer-links ralewaybold">Home</a>
        </p>
        <p>
          <a href="recipes.php" class="footer-links ralewaybold">Recipes</a>
        </p>
        <p>
          <a href="mycollections.php" class="footer-links ralewaybold">Collections</a>
        </p>
      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
        <!-- Links -->
        <h6 class="text-uppercase ralewayextrabold footer-text1 mb-4">GROUP INFORMATION</h6>
        <p>
          <a class="footer-links ralewaybold footer-text2">Joewiey Franzine Ibanez - K231663</a>
        </p>
        <p>
          <a class="footer-links ralewaybold footer-text2">Sheirina Glee Nadera - K240664</a>
        </p>
        <p>
          <a class="footer-links ralewaybold footer-text2">Regil Maharjan - K240722</a>
        </p>
        <p>
          <a class="footer-links ralewaybold footer-text2">Chauncey Ariel Nieto - K240938</a>
        </p>
        <p>
          <a class="footer-links ralewaybold footer-text2">Cassandra Noeribelle Dejucos - K240945</a>
        </p>
      </div>
      <!-- Grid column -->
    </div>
    <!-- Grid row -->
  </div>
</section>
<!-- Section: Links  -->

<!-- Copyright -->
<div class="text-center p-4">
<p class ="ralewaybold footer-text2">This website was created for the final assessment for DWIN309 at Kent Institute Australia - Trimester 2, 2026</p>
  <p class ="ralewaybold footer-text2">&copy; CookBook 2026. All rights reserved.</p>
</div>
<!-- Copyright -->
</footer>
<!-- Footer -->
<!-- end of footer -->

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>