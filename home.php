
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['email'])) {
    header("Location: login.php"); 
    exit();
}
?>




<!-- rest of  HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <title>RECIPE FINDER</title>
</head>
<body>
    <header>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
         <div class="container">
            <a href="#home"class="logo">RECIPE FINDER</a>
            <nav>
                <a href="#home" class="active">Home</a>
                 <a href="category.php">Categories</a>
                 <a href="favourites.php">Favourite Recipes</a>
                <a href="#about">About Us</a>
                <a href="login.php">Login</a>
                <a href="#" onclick="toggleProfileBox()">Profile</a>

            </nav>
        </div>
    </header>


    <section class="main" id="home">
        <div class="main_section">
            <h2><strong>Welcome to Recipe Finder!</strong></h2>
            <p>Search mouth watering recipes to satisfy 
                your craving.</p>
                 <form action="search.php" class="Search-box" method="GET">
                    <input type="text" name="searchquery" placeholder="Search recipes" required>
                    <button type="submit">Search</button>
          </form>
        </div>
    </section>


    <section class="recipes" id="home">
        <h4>Featured Recipes</h4>
        <div class="recipe-section">
            <div class="recipe-card">
                <img src="PictureS\talbina.webp" alt="">
                <h3>Talbina with Dates Recipe</h3>
                <a href="recipe_detail.php?id=3">View Recipe</a> 
                
            </div>
            <div class="recipe-card">
                <img src="PictureS\maxresdefault.jpg" alt="">
                <h3>Halwa Puri with Aloo Chanay Recipe</h3>
                 <a href="recipe_detail.php?id=10">View Recipe</a>
            </div>
            <div class="recipe-card">
                <img src="PictureS\toast stick.jpeg" alt="">
                <h3>French Toast Dippers </h3>
                <a href="recipe_detail.php?id=9">View Recipe</a>
            </div>
            <div class="recipe-card">
                <img src="PictureS\hq720.jpg" alt="">
                <h3>Sausage Flower Bread Recipe</h3>
                <a href="recipe_detail.php?id=11">View Recipe</a>
            </div>
        </div>
    </section>

    <section class="about-contact-wrapper">
  <div class="about-us" id="about">
    <h2>About Us</h2>
    <p>
      Welcome to <strong>Recipe Finder!</strong>We created this website with a passionate aim to simplify the cooking 
            journey for beginners and provide valuable resources for overseas students. 
            Cooking can sometimes feel overwhelming, but our goal is to make it enjoyable and 
            straightforward for everyone. We also want to tell you about our website 
            functionalities which are: 
    </p>
    <h3>Key Features</h3>
    <ul>
      <li><strong>Search Recipes:</strong> Find any recipe by name or keyword.</li>
      <li><strong>Rate and Review:</strong> Share your feedback and help others decide.</li>
      <li><strong>Favorites:</strong> Save recipes you love for quick access.</li>
      <li><strong>User Login:</strong> Create a profile and access personalized features.</li>
      <li><strong>Categories:</strong> Browse breakfast, lunch, and dinner easily.</li>
    </ul>
    <p>
      Whether you're a college student abroad or a beginner at home, This website is your
       perfect kitchen companion!
    </p>
  </div>
<div class="contact" id="contact">
  <h2>Contact Us</h2>
  <ul class="contact-list">
    <li><i class="fas fa-phone"></i> <a href="tel:+92005566778">+92 00 55 66 77 8</a></li>
    <li><i class="fab fa-instagram"></i> <a href="https://www.instagram.com" target="_blank">instagram.com</a></li>
    <li><i class="fab fa-facebook"></i> <a href="https://www.facebook.com" target="_blank">facebook.com</a></li>
    <li><i class="fas fa-envelope"></i> <a href="mailto:contact@recipefinder.com">contact@recipefinder.com</a></li>
    <li><i class="fas fa-map-marker-alt"></i> Gujarkhan, Pakistan</li>
  </ul>
</div>


</section>
<!-- Mini Profile Box -->
<div id="miniProfileBox" style="display:none; position:absolute; top:70px; right:20px; width:260px; background:white; border:1px solid #ccc; border-radius:10px; box-shadow:0 4px 12px rgba(0,0,0,0.15); z-index:9999; padding:15px; font-family:Segoe UI;">
  <p><strong>Email:</strong><br><span id="userEmail" style="color:gray;">Loading...</span></p>
  <p><strong>Password:</strong><br><span id="userPassword" style="color:gray;">********</span></p>
  <a href="favourites.php" style="display:block; margin-top:10px; padding:10px; background:#a71e1e;
   color:white; text-align:center; text-decoration:none;
    border-radius:5px;">List of Favourite Recipes</a>
</div>

    <footer>
        <div>
            <p>&copy; 2025 Delocious Recipes</p>
        </div>
    </footer>
    <script src="home.js"></script>
    <script src="profileBox.js"></script>

</body>
</html>