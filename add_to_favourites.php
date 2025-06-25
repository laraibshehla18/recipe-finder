<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'])) {
    // Agar user login nahi hai to redirect to login page
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['recipe_id'])) {
    $user_id = $_SESSION['user_id'];
    $recipe_id = $_POST['recipe_id'];

    // Duplicate check: pehle se favourite mein to nahi
    $check = $conn->prepare("SELECT * FROM favourites WHERE user_id = ? AND recipe_id = ?");
    $check->bind_param("ii", $user_id, $recipe_id);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows === 0) {
        // Insert new favorite
        $stmt = $conn->prepare("INSERT INTO favourites (user_id, recipe_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $recipe_id);
        if ($stmt->execute()) {
            // Successfully added
            header("Location: recipe_detail.php?id=$recipe_id&fav=added");
            exit();
        } else {
            echo "Error adding to favourites.";
        }
    } else {
        // Already in favourites
        header("Location: recipe_detail.php?id=$recipe_id&fav=exists");
        exit();
    }
} else {
    // Invalid access
    header("Location: home.php");
    exit();
}
?>
