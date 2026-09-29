<?php
require_once __DIR__ . '/../includes/auth.php';
$pdo = cookbook_db();
$currentUser = cookbook_current_user();

// 2. Get and Validate Recipe ID from URL
$recipeId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($recipeId <= 0) {
    die("Invalid Recipe ID.");
}

// 3. Fetch Recipe Details
$stmt = $pdo->prepare('
    SELECT 
        r.recipe_id AS id,
        r.owner_id,
        r.photo,
        r.title,
        r.prep_time_minutes,
        r.cook_time_minutes,
        r.calories_per_serving,
        r.instructions
    FROM recipes r
    WHERE r.recipe_id = :id
');
$stmt->execute(['id' => $recipeId]);
$recipe = $stmt->fetch();

if (!$recipe) {
    die("Recipe not found.");
}

$mediaStatement = $pdo->prepare('SELECT media_path, media_type, mime_type FROM recipe_media WHERE recipe_id = ? ORDER BY media_id');
$mediaStatement->execute([$recipeId]);
$mediaItems = $mediaStatement->fetchAll();

// 4. Load the matching recipe image, with a placeholder fallback
$imageSrc = 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 300 150"><rect width="100%" height="100%" fill="%23e9ecef"/><text x="50%" y="50%" fill="%236c757d" dominant-baseline="middle" text-anchor="middle">No Image Available</text></svg>';
$canManageRecipe = $currentUser && (
    $currentUser['role'] === 'admin' || (int) $recipe['owner_id'] === (int) $currentUser['id']
);

if (!$mediaItems && $recipe['photo'] && is_file(__DIR__ . '/../images/recipes/' . basename($recipe['photo']))) {
    $mediaItems[] = [
        'media_path' => 'recipes/' . basename($recipe['photo']),
        'media_type' => 'image',
        'mime_type' => 'image/jpeg',
    ];
}
if (!$mediaItems) {
    foreach (glob(__DIR__ . '/../images/Recipe images/*') ?: [] as $imageFile) {
        if (strtolower(pathinfo($imageFile, PATHINFO_FILENAME)) === strtolower($recipe['title'])) {
            $mediaItems[] = [
                'media_path' => 'Recipe images/' . basename($imageFile),
                'media_type' => 'image',
                'mime_type' => mime_content_type($imageFile) ?: 'image/jpeg',
            ];
            break;
        }
    }
}

function recipe_media_url(string $path): string
{
    return '../images/' . implode('/', array_map('rawurlencode', explode('/', ltrim($path, '/\\'))));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title><?php echo htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8'); ?> — CookBook</title>
    <link rel="icon" type="image/x-icon" href="../images/cblogo2.png">
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-light">
    <a class="gochihand nav-name" href="index.php">
        <img class="logo" src="../images/cblogo1.png" alt="CookBook Logo" title="CookBook logo">
        CookBook
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ralewayextrabold nav-text">
            <li class="nav-item"><a class="nav-link nav-text4" href="recipe_page.php">RECIPES</a></li>
        </ul>
        <div class="ml-auto d-flex align-items-center">
            <form class="form-inline" action="recipe_page.php" method="get">
                <input class="form-control navbar-search" type="search" name="search" placeholder="SEARCH" aria-label="Search recipes">
            </form>
            <?php if ($currentUser): ?>
                <a class="nav-link nav-text4 login-link" href="myaccount.php">ACCOUNT</a>
                <form class="form-inline" method="post" action="logout.php">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(cookbook_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                    <button class="register-button" type="submit">LOG OUT</button>
                </form>
            <?php else: ?>
                <a class="nav-link nav-text4 login-link" href="login.php">LOGIN</a>
                <a class="register-button" href="register.php">REGISTER</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- Recipe Content -->
<main class="container my-5">
    <a href="recipe_page.php" class="btn btn-outline-secondary mb-4">&larr; Back to Recipes</a>
    
    <div class="card">
                <?php if ($mediaItems): ?>
                    <div class="row no-gutters">
                        <?php foreach ($mediaItems as $media): ?>
                            <div class="col-md-6 p-2">
                                <?php if ($media['media_type'] === 'video'): ?>
                                    <video controls class="w-100" style="max-height: 400px;"><source src="<?php echo htmlspecialchars(recipe_media_url($media['media_path']), ENT_QUOTES, 'UTF-8'); ?>" type="<?php echo htmlspecialchars($media['mime_type'], ENT_QUOTES, 'UTF-8'); ?>"></video>
                                <?php else: ?>
                                    <img src="<?php echo htmlspecialchars(recipe_media_url($media['media_path']), ENT_QUOTES, 'UTF-8'); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8'); ?>" style="max-height: 400px; object-fit: cover;">
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <img src="<?php echo htmlspecialchars($imageSrc, ENT_QUOTES, 'UTF-8'); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8'); ?>" style="max-height: 400px; object-fit: cover;">
                <?php endif; ?>
        <div class="card-body">
            <h1 class="card-title"><?php echo htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8'); ?></h1>
                        <?php if ($canManageRecipe): ?>
                            <a href="edit-recipe.php?id=<?php echo (int) $recipeId; ?>" class="btn btn-outline-primary mb-3">Edit recipe</a>
                            <form method="post" action="delete-recipe.php" class="d-inline" onsubmit="return confirm('Delete this recipe and its uploaded media?');">
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(cookbook_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                                <input type="hidden" name="recipe_id" value="<?php echo (int) $recipeId; ?>">
                                <button type="submit" class="btn btn-outline-danger mb-3">Delete recipe</button>
                            </form>
                        <?php endif; ?>
            <p class="text-muted">
                Prep Time: <?php echo (int)($recipe['prep_time_minutes'] ?? 0); ?> mins | 
                Cook Time: <?php echo (int)($recipe['cook_time_minutes'] ?? 0); ?> mins | 
                Calories: <?php echo (int)($recipe['calories_per_serving'] ?? 0); ?> kcal
            </p>
            <hr>
            <h3>Instructions</h3>
            <p><?php echo nl2br(htmlspecialchars($recipe['instructions'] ?? 'No instructions provided.', ENT_QUOTES, 'UTF-8')); ?></p>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<footer class="text-center text-lg-start bg-body-tertiary text-muted footer">
    <section>
        <div class="container text-center mt-5">
            <div class="row mt-3">
                <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                    <h6 class="fw-bold mb-4">
                        <a class="gochihand footer-text1" href="index.php"><img class="logo" src="../images/cblogo2.png" alt="CookBook Logo" title="CookBook logo">CookBook</a>
                    </h6>
                    <p class="footer-text2 ralewaybold">Improve the cooking experience.</p>
                    <hr>
                    <p>
                        <a href="#" class="footer-links ralewaybold footer-text2">Instagram</a>
                        <a href="#" class="footer-links ralewaybold footer-text2">Facebook</a>
                        <a href="#" class="footer-links ralewaybold footer-text2">Tiktok</a>
                        <a href="#" class="footer-links ralewaybold footer-text2">YouTube</a>
                    </p>
                </div>
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                    <h6 class="text-uppercase ralewayextrabold footer-text1 mb-4">Quick links</h6>
                    <p><a href="index.php" class="footer-links ralewaybold">Home</a></p>
                    <p><a href="recipe_page.php" class="footer-links ralewaybold">Recipes</a></p>
                    <p><a href="collections.php" class="footer-links ralewaybold">Collections</a></p>
                </div>
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                    <h6 class="text-uppercase ralewayextrabold footer-text1 mb-4">GROUP INFORMATION</h6>
                    <p><span class="footer-text2 ralewaybold">Joewiey Franzine Ibanez - K231663</span></p>
                    <p><span class="footer-text2 ralewaybold">Sheirina Glee Nadera - K240664</span></p>
                    <p><span class="footer-text2 ralewaybold">Regil Maharjan - K240722</span></p>
                    <p><span class="footer-text2 ralewaybold">Chauncey Ariel Nieto - K240938</span></p>
                    <p><span class="footer-text2 ralewaybold">Cassandra Noeribelle Dejucos - K240945</span></p>
                </div>
            </div>
        </div>
    </section>
    <div class="text-center p-4">
        <p class="ralewaybold footer-text2">This website was created for the final assessment for DWIN309 at Kent Institute Australia - Trimester 2, 2026</p>
        <p class="ralewaybold footer-text2">&copy; CookBook 2026. All rights reserved.</p>
    </div>
</footer>

</body>
</html>