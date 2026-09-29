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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <title><?php echo htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8'); ?> — CookBook</title>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
  <a class="navbar-brand nav-name" href="index.php">CookBook</a>
  <div class="collapse navbar-collapse">
    <ul class="navbar-nav mr-auto">
    <li class="nav-item"><a class="nav-link" href="recipe_page.php">RECIPES</a></li>
    <li class="nav-item"><a class="nav-link" href="collections.php">COLLECTIONS</a></li>
    </ul>
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

</body>
</html>