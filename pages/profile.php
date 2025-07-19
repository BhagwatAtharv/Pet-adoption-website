<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}
$conn = new mysqli('localhost', 'root', '', 'petfinder');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pateName = $_POST['pateName'];
    $pateAge = $_POST['pateAge'];
    $pateType = $_POST['type'];

    // Handle image upload
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["pateImage"]["name"]);
    move_uploaded_file($_FILES["pateImage"]["tmp_name"], $target_file);

    // Assuming you have a connection to the database in $conn
    $sql = "INSERT INTO petinfo (name, age, image, type) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siss", $pateName, $pateAge, $target_file,$pateType);
    $stmt->execute();

    // Redirect or give feedback
    echo "<script>alert('Pate added successfully!');</script>";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/userinfostyle.css?v=1.0">
    <title>User Profile</title>
</head>
<body>
    <div class="indexbar">
        <div class="name1"><h3>PETFINDER</h3></div>
        <div class="name2"><h3>User Profile</h3></div>
    </div>

    <div id="profileDetails" style="display:block;">
        <p><strong>Username:</strong> <span id="displayUsername"></span></p>
        <p><strong>Email:</strong> <span id="displayEmail"></span></p>
        <p><strong>Mobile:</strong> <span id="displayMobile"></span></p>
        <p><strong>Gender:</strong> <span id="displayGender"></span></p>
        <p><strong>Address:</strong> <span id="displayAddress"></span></p>
    </div>
    <div class="addp"><button class="addPate"  onclick="showAddPateForm()"> ADD PATE </button></div>
    <div class="add">
    
            <div id="addPateForm" style="display:none;">
    <form id="pateForm" enctype="multipart/form-data" method="POST">
        <label for="pateName">Pate Name:</label>
        <input type="text" id="pateName" name="pateName" required><br>

        <label for="pateImage">Upload Image:</label>
        <input type="file" id="pateImage" name="pateImage" accept="image/*" required><br>

        <label for="pateAge">Age:</label>
        <input type="number" id="pateAge" name="pateAge" required><br>

         <select name="type" id="ab2" required >
                <option value="" style="background-color : black ; ">Select type</option>
                <option value="Dog" style="background-color : black ; ">Dog</option>
                <option value="Cat" style="background-color : black ; ">Cat</option>
                <option value="Bird" style="background-color : black ; ">Bird</option>
            </select>

        <button type="submit">Submit</button>
    </form>
      </div> 
        </div>

    <?php   
     $sql = "SELECT * FROM petinfo ";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Display each pet
echo '<div class="card-container">';
while ($row = $result->fetch_assoc()) {
    echo '<div class="card" style="display">';
    echo '<img src="' . $row['image'] . '" alt="Pet Image">';
    echo '<div class="card-info">';
    echo '<h3>Owner: ' . $_SESSION['user']['username'] . '</h3>';
    echo '<p>Mobile: ' . $_SESSION['user']['mobile'] . '</p>';
    echo '<p>Address: ' . $_SESSION['user']['address'] . '</p>';
    echo '<p>Pet Name: ' . $row['name'] . '</p>';
    echo '<p>Age: ' . $row['age'] . '</p>';
    echo '<button type="delet">Delet</button>';
    echo '</div>';
    echo '</div>';
    
}
echo '</div>';
?>





    <script>
        // Retrieve user data from PHP session
        let userData = <?php echo json_encode($_SESSION['user']); ?>;

        // Function to dynamically update the profile information
        function displayProfile(userData) {
            document.getElementById('displayUsername').textContent = userData.username;
            document.getElementById('displayEmail').textContent = userData.email;
            document.getElementById('displayMobile').textContent = userData.mobile;
            document.getElementById('displayGender').textContent = userData.gender;
            document.getElementById('displayAddress').textContent = userData.address;
        }

        // Call the function to display the profile
        displayProfile(userData);


        function showAddPateForm() {
    document.getElementById('addPateForm').style.display = 'block';
}
    </script>
</body>
</html>
