<?php
include 'database.php'; // your DB connection file

// Step 1: Get all categories
$categories = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Recipe Categories</title>
  <link rel="stylesheet" href="category.css">
</head>
<body>
   <?php include'navbar.php'?> 
<a href="home.php" class="back-btn">← Back to Home</a>

<section class="recipes" id="home">
<?php while ($cat = $categories->fetch_assoc()): ?>
  <h4><?= htmlspecialchars($cat['category_name']) ?></h4>
  <div class="recipe-section">
    <?php
      // Step 2: Get 4 recipes for this category
      $category_id = $cat['category_id'];
      $recipes = $conn->query("SELECT * FROM recipes WHERE category_id = $category_id ");
      while ($rec = $recipes->fetch_assoc()):
    ?>
    <div class="recipe-card">
        <img src="PictureS/<?= htmlspecialchars($rec['image_url']) ?>" alt="">
        <h3><?= htmlspecialchars($rec['title']) ?></h3>
        <a href="recipe_detail.php?id=<?= $rec['id'] ?>"class="view-btn">View Recipe</a>
    </div>
    <?php endwhile; ?>
  </div>
<?php endwhile; ?>
</section>
<!-- Mini Profile Box -->
<div id="miniProfileBox" style="display:none; position:absolute; top:70px; right:20px; width:260px; background:white;
 border:1px solid #ccc; border-radius:10px; box-shadow:0 4px 12px rgba(0,0,0,0.15); z-index:9999; padding:15px; 
 font-family:Segoe UI;">
  <p><strong>Email:</strong><br><span id="userEmail" style="color:gray;">Loading...</span></p>
  <p><strong>Password:</strong><br><span id="userPassword" style="color:gray;">********</span></p>
  <a href="favourites.php" style="display:block; margin-top:10px; padding:10px; background:#a71e1e; 
  color:white; text-align:center; text-decoration:none; border-radius:5px;">List of Favourite Recipes</a>
</div>
<script src="profileBox.js"></script>
<script>
    document.getElementById("backBtn").addEventListener("click", function () {
         window.history.back();
    });
</script>
</body>
</html>
