<!-- navbar.php -->
<header>
  <div class="container">
      <a href="#home.php" class="logo">RECIPE FINDER</a>
      <nav>
          <a href="home.php">Home</a>
           <a href="category.php">Categories</a>
           <a href="favourites.php">Favourite Recipes</a>
          <a href="home.php#about">About Us</a>
          <a href="login.php">Login</a>
          <a href="#" onclick="toggleProfileBox()">Profile</a>


      </nav>
  </div>
</header>

<style>
header {
    height: 60px;
    width: 100%;
    background-color: rgb(46, 44, 44);
    color: whitesmoke;
    display: flex;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 999;
}
.container {
    width: 100%;
    padding: 0 120px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
nav a {
    margin-right: 20px;
    font-weight: 800;
    cursor: pointer;
    color: whitesmoke;
    text-decoration: none;
    transition: 0.3s;
}
nav a:hover {
    color: rgb(168, 30, 30);
}
.logo {
    font-size: 24px;
    color: whitesmoke;
    font-weight: 600;
    text-decoration: none;
}
</style>
