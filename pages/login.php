<?php  
session_start();
// Database connection
$conn = new mysqli('localhost', 'root', '', 'petfinder');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for messages
$login_msg = '';
$signup_msg = '';

// Handle the sign-up form submission
if (isset($_POST['signup'])) {
    $username = $_POST['signup_username'];
    $email = $_POST['signup_email'];
    $password = $_POST['signup_password'];
    $confirm_password = $_POST['signup_confirm_password'];
    $mobile = $_POST['mobile'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $signup_msg = "Passwords do not match.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert into the database
        $sql = "INSERT INTO users (username, email, password,mobile,gender,address) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $username, $email, $hashed_password,  $mobile,  $gender,  $address);

        if ($stmt->execute()) {
            $signup_msg = "Sign-up successful!";
            echo "<script>alert('Signup Sucess'); </script>";
            
        } else {
            $signup_msg = "Error: " . $conn->error;
        }

        $stmt->close();
    }
}

// Handle the login form submission
if (isset($_POST['login'])) {
    $username = $_POST['login_username'];
    $password = $_POST['login_password'];

    // Fetch user from the database
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify password
    if ($user && password_verify($password, $user['password'])) {
        // Store user information in session
        $_SESSION['user'] = array(
            'username' => $user['username'],
            'email' => $user['email'],
            'mobile' => $user['mobile'],
            'gender' => $user['gender'],
            'address' => $user['address']
        );

        // Redirect to the profile page
        header("Location: profile.php");
        exit();
    } else {
        $login_msg = "Invalid username or password.";
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="../styles/style2.css?v=1.0">
</head>
<body>
    <h1>PETFINDER</h1>
    <div class="container">
    
        <div class="login-signup">
            <button class="toggle-button" id="login-button">Login</button>
            <button class="toggle-button" id="signup-button">Sign Up</button>
        </div>

        <!-- Login Form -->
        <form class="login-form" id="login-form" method="POST" style="display: block;">
            <input type="text" name="login_username" id="username" placeholder="Username" required>
            <input type="password" name="login_password" id="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
            <p class="error"><?= $login_msg; ?></p>
        </form>

        <!-- Sign-up Form -->
        <form class="signup-form" id="signup-form" method="POST" style="display: none;">
            <input type="text" name="signup_username" id="signup-username" placeholder="Username" required>
            <input type="email" name="signup_email" id="signup-email" placeholder="Email" required>
            <input type="password" name="signup_password" id="signup-password" placeholder="Password" required>
            <input type="password" name="signup_confirm_password" id="signup-confirm-password" placeholder="Confirm Password" required>
            <input type="tel"  id="ab"name="mobile" placeholder="Mobile No" required style="width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    background-color: #00000015;
    color: white;">
            <select name="gender" id="ab2" required style="width: 100%;padding: 10px; margin-bottom: 20px;  border: 1px solid #ccc; border-radius: 5px;font-size: 16px; background-color: #00000015; color: white;">
                <option value="" style="background-color : black ; ">Select Gender</option>
                <option value="Male" style="background-color : black ; ">Male</option>
                <option value="Female" style="background-color : black ; ">Female</option>
                <option value="Other" style="background-color : black ; ">Other</option>
            </select>
            <textarea name="address"id="ab3" placeholder="Address" required style="width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    background-color: #00000015;
    color: white;"></textarea>
            <button type="submit" name="signup">Sign Up</button>
            <p class="error"><?= $signup_msg; ?></p>
        </form>
        
    </div>

    <script >
        const loginButton = document.getElementById('login-button');
        const signupButton = document.getElementById('signup-button');
        const loginForm = document.getElementById('login-form');
        const signupForm = document.getElementById('signup-form');

        loginButton.addEventListener('click', () => {
            loginForm.style.display = 'block';
            signupForm.style.display = 'none';
            loginButton.classList.add('active');
            signupButton.classList.remove('active');
        });

        signupButton.addEventListener('click', () => {
            loginForm.style.display = 'none';
            signupForm.style.display = 'block';
            signupButton.classList.add('active');
            loginButton.classList.remove('active');
        });
    </script>
</body>
</html>
