<!DOCTYPE html>
<html lang="en">
  <head>
    
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- local css -->
      <link rel="stylesheet" href="../styles/recipe_page.css">
    <!-- end of local csss -->

    <title>CookBook</title>
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
            <a class="nav-link nav-text4" href="recipe_page.php">RECIPES</a>
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

<!-- This is the start of the first-block -->
<section class = "first-block">

<div class="container">
    <div class="row justify-content-center">
        <h1 id="recipeTitle" class="text-center">RECIPES</h1>
            <div class="col-12">
                    <nav class="navbar bg-transparent">
                        <form class="form-inline w-100">
                            <input id="searchRecipe" class="form-control w-100" type="search" placeholder="Search Recipes/Categories" aria-label="Search">
                        </form>
                    </nav>

                    <div class="d-flex justify-content-center">
                        <div class="btn-group mx-3">
                            <button type="button" class="btn recipe-dropdown dropdown-toggle"
                                    data-toggle="dropdown">
                                Ingredient
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Chicken</a>
                                <a class="dropdown-item" href="#">Beef</a>
                                <a class="dropdown-item" href="#">Pork</a>
                            </div>
                        </div>

                        <div class="btn-group mx-3">
                            <button type="button" class="btn recipe-dropdown dropdown-toggle"
                                    data-toggle="dropdown">
                                Cuisine
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Italian</a>
                                <a class="dropdown-item" href="#">Japanese</a>
                                <a class="dropdown-item" href="#">Filipino</a>
                            </div>
                        </div>

                        <div class="btn-group mx-3">
                            <button type="button" class="btn recipe-dropdown dropdown-toggle"
                                    data-toggle="dropdown">
                                Category
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Breakfast</a>
                                <a class="dropdown-item" href="#">Lunch</a>
                                <a class="dropdown-item" href="#">Dinner</a>
                            </div>
                        </div>
                    </div>
            </div>
    </div>
</div>

</section>
<!-- This is the end of the first-block -->

<!-- This is the start of the second-block -->
<!-- This is the start of the second-block -->
<section class="second-block">

    <h1 id="recipeTitle" class="category-title text-center">BROWSE RECIPE CATEGORIES</h1>

    <div class="container">
        <div class="row">

            <div class="col-md-4 text-center category-card">
                <a href="#">
                    <img id="mealImages" src="../images/breakfast_recipe_page.jpg" class="category-img" alt="Breakfast">
                </a>
                <h3 id="mealNames">Breakfast</h3>
            </div>

            <div class="col-md-4 text-center category-card">
                <a href="#">
                    <img id="mealImages" src="../images/lunch_recipe_page.jpg" class="category-img" alt="Lunch">
                </a>
                <h3 id="mealNames">Lunch</h3>
            </div>

            <div class="col-md-4 text-center category-card">
                <a href="#">
                    <img id="mealImages" src="../images/dinner_recipe_page.jpg" class="category-img" alt="Dinner">
                </a>
                <h3 id="mealNames">Dinner</h3>
            </div>

            <div class="col-md-4 text-center category-card">
                <a href="#">
                    <img id="mealImages" src="../images/dessert_recipe_page.jpg" class="category-img" alt="Dessert">
                </a>
                <h3 id="mealNames">Dessert</h3>
            </div>

            <div class="col-md-4 text-center category-card">
                <a href="#">
                    <img id="mealImages" src="../images/snack_recipe_page.jpg" class="category-img" alt="Snack">
                </a>
                <h3 id="mealNames">Snack</h3>
            </div>

            <div class="col-md-4 text-center category-card">
                <a href="#">
                    <img id="mealImages" src="../images/drinks_recipe_page.jpg" class="category-img" alt="Drinks">
                </a>
                <h3 id="mealNames">Drinks</h3>
            </div>

        </div>
    </div>

</section>
<!-- This is the end of the second-block -->
<!-- This is the end of the second-block -->

<!-- This is the start of the third-block -->
<section class = "third-block">
  
</section>
<!-- This is the end of the third-block -->

<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

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

</body>
</html>