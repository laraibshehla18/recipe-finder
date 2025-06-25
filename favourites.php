
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


// Remove from favourites
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_id'])) {
    $remove_recipe_id = $_POST['remove_id'];

    $delete = $conn->prepare("DELETE FROM favourites WHERE user_id = ? AND recipe_id = ?");
    $delete->bind_param("ii", $user_id, $remove_recipe_id);
    $delete->execute();
}

// Fetch favourite recipes
$sql = "SELECT r.id, r.title, r.image_url, r.cooking_time
        FROM favourites f
        JOIN recipes r ON f.recipe_id = r.id
        WHERE f.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$fav_recipes = [];
while ($row = $result->fetch_assoc()) {
    $fav_recipes[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favourite Recipes</title>
    <style>
body {
    
  font-family: 'Poppins', sans-serif;
  margin: 30;
  padding: 30;
  background-color: #f7f7f7;
  padding-top: 80px;
}

/* Top bar with heading + back button */
.top-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 30px 50px 10px;
}

.top-bar h2 {
  font-size: 30px;
  color: #a71e1e;
  margin: 0;
}

.back-btn {
  background-color: #a71e1e;
  color: white;
  padding: 10px 20px;
  text-decoration: none;
  border-radius: 5px;
  font-weight: bold;
}

.back-btn:hover {
  background-color: #8b1a1a;
}

/* Recipe Grid */
.recipe-section {
    padding-top: 80px;
  width: 90%;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 30px;
}

/* Recipe Card */
.recipe-card {
  background: white;
  border-radius: 8px;
  border: 1px solid #ccc;
  overflow: hidden;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.recipe-card img {
  width: 100%;
  height: 250px;
  object-fit: cover;
}

.recipe-card h3 {
  font-size: 22px;
  padding: 20px;
  text-align: center;
}

/* Button area inside card */
.recipe-card .buttons {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
  padding: 15px;
}

/* View & Remove buttons */
.view-btn,
.remove-btn {
  width: 90%;
  padding: 10px 0;
  border: none;
  border-radius: 10px;
  font-weight: bold;
  font-size: 18px;
  text-align: center;
  background-color: gray;
  color: aliceblue;
  text-decoration: none;
   border-top: 1px solid #ccc;
  transition: background-color 0.2s ease-in-out;
  cursor: pointer;
}

.view-btn:hover,
.remove-btn:hover {
  background-color: rgb(168, 30, 30);
}

.remove-btn {
  background-color: #a71e1e;
}

.remove-btn:hover {
  background-color: #7d1717;
}

/* Responsive: 2 columns on tablets, 1 on phones */
@media (max-width: 992px) {
  .recipe-section {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 600px) {
  .recipe-section {
    grid-template-columns: 1fr;
  }
}


    </style>
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="top-bar">
        <h2>Your Favourite Recipes</h2>
        <a href="home.php" class="back-btn">← Back to Home</a>
    </div>

    <div class="recipe-section">
        <?php if (count($fav_recipes) > 0): ?>
            <?php foreach ($fav_recipes as $recipe): ?>
                <div class="recipe-card">
                    <img src="PictureS/<?php echo htmlspecialchars($recipe['image_url']); ?>" alt="Recipe Image">
                    <h3><?php echo htmlspecialchars($recipe['title']); ?></h3>
                    <div class="buttons">
                        <a href="recipe_detail.php?id=<?php echo $recipe['id']; ?>" class="view-btn">View Recipe</a>

                        <!-- Remove button -->
                        <form method="POST" action="favourites.php">
                            <input type="hidden" name="remove_id" value="<?php echo $recipe['id']; ?>">
                            <button type="submit" class="remove-btn">Remove from Favourites</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align:center; font-size :large; width:130%;">No favourite recipes found.</p>
        <?php endif; ?>
    </div>
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
