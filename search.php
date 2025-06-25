<?php
include('database.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$searchQuery = "";
$recipes = [];


    if (isset($_GET['searchquery'])) {
    $searchQuery = trim($_GET['searchquery']);


    // Break the search query into keywords
    $keywords = preg_split('/\s+/', $searchQuery);

    // Build dynamic WHERE clause
    $conditions = [];
    $params = [];
    $types = "";

    foreach ($keywords as $keyword) {
        $conditions[] = "(title LIKE ? OR description LIKE ?)";
        $likeTerm = "%" . $keyword . "%";
        $params[] = $likeTerm;
        $params[] = $likeTerm;
        $types .= "ss";
    }

    $whereClause = implode(" AND ", $conditions);
    $sql = "SELECT * FROM recipes WHERE $whereClause";

    $stmt = $conn->prepare($sql);

    if ($stmt && !empty($params)) {
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $recipes[] = $row;
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
    <link rel="stylesheet" href="search.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php';?>
<div class="search-header">
    <button id="backBtn">← Back</button>
    <h2>Search Results for "<span><?php echo htmlspecialchars($searchQuery); ?></span>"</h2>
</div>
<?php
$totalResults = count($recipes); // ← Count recipes
?>
<div class="recipe-section <?php echo ($totalResults === 1) ? 'single-result' : ''; ?>">
    <?php if ($totalResults > 0): ?>
        <?php foreach ($recipes as $recipe): ?>
            <div class="recipe-card">
                <img src="PictureS/<?php echo htmlspecialchars($recipe['image_url']); ?>" alt="Recipe Image">
                <h3><?php echo htmlspecialchars($recipe['title']); ?></h3>
                <a href="recipe_detail.php?id=<?php echo $recipe['id']; ?>" class="view-btn">View Recipe</a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="no-result">No recipes found.</p>
    <?php endif; ?>
</div>


<!-- Mini Profile Box -->
<div id="miniProfileBox" style="display:none; position:absolute; top:70px; right:20px; width:260px; background:white; border:1px solid #ccc; border-radius:10px; box-shadow:0 4px 12px rgba(0,0,0,0.15); z-index:9999; padding:15px; font-family:Segoe UI;">
  <p><strong>Email:</strong><br><span id="userEmail" style="color:gray;">Loading...</span></p>
  <p><strong>Password:</strong><br><span id="userPassword" style="color:gray;">********</span></p>
  <a href="favourites.php" style="display:block; margin-top:10px; padding:10px; background:#a71e1e; 
  color:white; text-align:center; text-decoration:none; border-radius:5px;">List of Favourite Recipes</a>
</div>

<script>
    document.getElementById("backBtn").addEventListener("click", function () {
         window.history.back();
    });
</script>
<script src="profileBox.js"></script>

</body>
</html>
