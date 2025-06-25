<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to leave a review.";
    exit;
}

include 'database.php';

$recipe_id = intval($_POST['recipe_id']);
$user_id = $_SESSION['user_id'];
$comment = trim($_POST['comment']);
$rating = isset($_POST['rating']) && $_POST['rating'] !== '' ? intval($_POST['rating']) : null;


if (empty($comment) && $rating === 0) {
    header("Location: recipe_detail.php?id=$recipe_id&review=empty#reviewform");
    exit;
}


$sql = "INSERT INTO reviews (recipe_id, user_id, comment, rating) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iisi", $recipe_id, $user_id, $comment, $rating);

if ($stmt->execute()) {
    header("Location: recipe_detail.php?id=$recipe_id&review=success#reviewform");
    exit;
} else {
    echo "Error submitting review.";
}
?>
