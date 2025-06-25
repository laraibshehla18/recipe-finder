
 <?php

include 'database.php'; // Make sure db.php connects using mysqli
if (session_status() === PHP_SESSION_NONE)
  {
    session_start();
}
$recipe_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($recipe_id <= 0) {
    echo "Invalid recipe ID.";
    exit;
}

// Fetch recipe info
$recipe_sql = "SELECT * FROM recipes WHERE id = ?";
$stmt = $conn->prepare($recipe_sql);
$stmt->bind_param("i", $recipe_id);
$stmt->execute();
$recipe_result = $stmt->get_result();
$recipe = $recipe_result->fetch_assoc();

if (!$recipe) {
    echo "Recipe not found.";
    exit;
}

// Fetch ingredients
$ingredient_sql = "SELECT i.ingredient_name, ri.quantity
                   FROM recipe_ingredient ri
                   JOIN ingredients i ON ri.ingredient_id = i.ingredient_id
                   WHERE ri.recipe_id = ?";
$ing_stmt = $conn->prepare($ingredient_sql);
$ing_stmt->bind_param("i", $recipe_id);
$ing_stmt->execute();
$ingredients_result = $ing_stmt->get_result();


?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($recipe['title']); ?></title>
    <link rel="stylesheet" href="recipe_detail.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  
  <?php include 'navbar.php'; ?>

    <button id="backBtn">  Back </button>
    
<?php if (isset($_GET['fav'])): ?>
    <div id="popup" class="popup-message">
        <?php
        if ($_GET['fav'] == 'added') {
            echo "✅ Successfully added to favourites!";
        } elseif ($_GET['fav'] == 'exists') {
            echo "⚠️ Already in favourites.";
        }
        ?>
    </div>
<?php endif; ?>

<div class="fav-button-container">
    <form method="post" action="add_to_favourites.php">
        <input type="hidden" name="recipe_id" value="<?php echo $recipe_id; ?>">
        <button type="submit" class="fav-button">Add to Favorites</button>
    </form>
</div>


    <div class="recipe-box">
        <div class="image-section">
            <img src="PictureS/<?php echo htmlspecialchars($recipe['image_url']); ?>" alt="Recipe Image">
        </div>
        <div class="info-section">
            <h2><?php echo htmlspecialchars($recipe['title']); ?></h2>
            <p><strong>Cooking Time:</strong> <?php echo intval($recipe['cooking_time']); ?> mins</p>
        </div>
    </div>

    <h3>Ingredients</h3>
    <ul>
        <?php while ($row = $ingredients_result->fetch_assoc()) { ?>
            <li><?php echo htmlspecialchars($row['quantity']) . " - " . htmlspecialchars($row['ingredient_name']); ?></li>
        <?php } ?>
    </ul>

    <h3>Description</h3>
    <p><?php echo nl2br(htmlspecialchars($recipe['description'])); ?></p>

    <div class="review-contact-wrapper">
    <div class="review-form">
        <h3>Leave a Review</h3>
        <form method="post" action="submit review.php" id="reviewform">
            <input type="hidden" name="recipe_id" value="<?php echo $recipe_id; ?>">
            <textarea name="comment" placeholder="Leave your comment"></textarea>
            <br>
            <label>Rating:</label>
            <div class="stars">
                <?php for ($i = 1; $i <= 5; $i++) { ?>
                    <input type="radio" name="rating" value="<?= $i ?>" id="star<?= $i ?>">
                    <label for="star<?= $i ?>">★</label>
                <?php } ?>
            </div>
            <br>
            <button type="submit">Submit Review</button>

            <?php if (isset($_GET['review']) && $_GET['review'] == 'success'): ?>
                <div id="popup" class="popup-message-inline">💬 We are glad for your review!</div>
            <?php endif; ?>
        </form>
    </div>

    <!-- Contact Box (right side) -->
    <div class="contact contact-side">
        <h2>Contact Us</h2>
        <ul class="contact-list">
            <li><i class="fas fa-phone"></i> <a href="tel:+92005566778">+92 00 55 66 77 8</a></li>
            <li><i class="fab fa-instagram"></i> <a href="https://www.instagram.com" target="_blank">instagram.com</a></li>
            <li><i class="fab fa-facebook"></i> <a href="https://www.facebook.com" target="_blank">facebook.com</a></li>
            <li><i class="fas fa-envelope"></i> <a href="mailto:contact@recipefinder.com">contact@recipefinder.com</a></li>
            <li><i class="fas fa-map-marker-alt"></i> Gujarkhan, Pakistan</li>
        </ul>
    </div>
</div>


<!-- Mini Profile Box -->
<div id="miniProfileBox" style="display:none; position:absolute; top:70px; right:20px; width:260px; background:white; border:1px solid #ccc; border-radius:10px; box-shadow:0 4px 12px rgba(0,0,0,0.15); z-index:9999; padding:15px; font-family:Segoe UI;">
  <p><strong>Email:</strong><br><span id="userEmail" style="color:gray;">Loading...</span></p>
  <p><strong>Password:</strong><br><span id="userPassword" style="color:gray;">********</span></p>
  <a href="favourites.php" style="display:block; margin-top:10px; padding:10px; background:#a71e1e; 
  color:white; text-align:center; text-decoration:none; border-radius:5px;">List of Favourite Recipes</a>
</div>

<script>
document.getElementById("backBtn").addEventListener("click", function() {
      window.history.back();
});
</script>
<script src="profileBox.js"></script>
<script>
  setTimeout(function() {
    const popup = document.getElementById("popup");
    if (popup) {
      popup.style.display = "none";
    }
  }, 3000); // Hide after 3 seconds
</script>

</body>
</html>

