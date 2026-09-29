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

// 2. Get and Validate Recipe ID from URL
$recipeId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($recipeId <= 0) {
    die("Invalid Recipe ID.");
}

// 3. Fetch Recipe Details
$stmt = $pdo->prepare('
    SELECT 
        r.recipe_id AS id,
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

// 4. Load the matching recipe image, with a placeholder fallback
$imageSrc = 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 300 150"><rect width="100%" height="100%" fill="%23e9ecef"/><text x="50%" y="50%" fill="%236c757d" dominant-baseline="middle" text-anchor="middle">No Image Available</text></svg>';
$imageFiles = glob(__DIR__ . '/../images/Recipe images/*') ?: [];
foreach ($imageFiles as $imageFile) {
    if (strtolower(pathinfo($imageFile, PATHINFO_FILENAME)) === strtolower($recipe['title'])) {
        $imageSrc = '../images/Recipe%20images/' . rawurlencode(basename($imageFile));
        break;
    }
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
      <li class="nav-item"><a class="nav-link" href="index.php">RECIPES</a></li>
    <li class="nav-item"><a class="nav-link" href="collections.php">COLLECTIONS</a></li>
    </ul>
  </div>
</nav>

<!-- Recipe Content -->
<main class="container my-5">
    <a href="collections.php" class="btn btn-outline-secondary mb-4">&larr; Back to Collections</a>
    
    <div class="card">
        <img src="<?php echo htmlspecialchars($imageSrc, ENT_QUOTES, 'UTF-8'); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8'); ?>" style="max-height: 400px; object-fit: cover;">
        <div class="card-body">
            <h1 class="card-title"><?php echo htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8'); ?></h1>
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