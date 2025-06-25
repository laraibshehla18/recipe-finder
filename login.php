<?php
session_start();
include 'database.php';

$error_message = ""; // Default error message

// LOGIN SECTION
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['password']) && !isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['password'] = $user['password'];
        header("Location: home.php");
        exit();
    } else {
        $error_message = "Invalid login credentials.";
    }
}

// REGISTER SECTION
if (isset($_POST['register']) && isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows > 0) {
        $error_message = "User already exists. Try logging in.";
    } else {
        $insert = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $insert->bind_param("ss", $email, $password);
        if ($insert->execute()) {
            $new_user_id = $conn->insert_id;
            $_SESSION['user_id'] = $new_user_id;
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;

            header("Location: home.php");
            exit();
        } else {
            $error_message = "Error registering user.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="login.css">
    
</head>
<body>

<div class="login-box">
    <h2>Login</h2>
    <form method="POST" action="" onsubmit="return validateForm()">
        <input type="email" name="email" id="email" placeholder="Email" required>
        <div class="password-container">
            <input type="password" name="password" id="password" placeholder="Password" required>
            <img src="PictureS/eyeclose.png" id="eyeicon" onclick="togglePassword()">
        </div>
        <button type="submit" name="login">Login</button>
        <button type="submit" name="register">Register</button>
    </form> 
</div>

<?php if (!empty($error_message)): ?>
    <div id="popupMessage" class="popup">
        <?php echo $error_message; ?>
    </div>
    <script>
        setTimeout(function () {
            document.getElementById("popupMessage").style.display = "none";
        }, 3000);
    </script>
<?php endif; ?>

<script>
function validateForm() {
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();
    if (email === "" || password === "") {
        alert("Please fill out all fields.");
        return false;
    }
    return true;
}
</script>

<script>
function togglePassword() {
    const password = document.getElementById("password");
    const eyeicon = document.getElementById("eyeicon");

    if (password.type === "password") {
        password.type = "text";
        eyeicon.src = "PictureS/eyeopen.jpeg"; 
    } else {
        password.type = "password";
        eyeicon.src = "PictureS/eyeclose.png"; 
    }
}
</script>

</body>
</html>
