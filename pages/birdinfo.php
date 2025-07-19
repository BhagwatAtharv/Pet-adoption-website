<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petfinder</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../styles/styleinfo.css">
</head>
<body>

    <header>
        PETFINDER
    </header>
    <div class="search-bar">
        <input type="text" placeholder="Search By City">
        <input type="submit" value="Search">
    </div>

    <div class="card-container">
        <?php  
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: login.php"); 
            exit();
        } 
        $conn = new mysqli('localhost', 'root', '', 'petfinder');
        
        $type = 'bird'; 

        
        $sql = "SELECT * FROM petinfo WHERE type = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $type); 
        $stmt->execute();
        $result = $stmt->get_result();;


while ($row = $result->fetch_assoc()) {
    echo '<div class="card" style="display">';
    echo '<img src="' . $row['image'] . '" alt="Pet Image">';
    echo '<div class="card-info">';
    echo '<h3>Owner: ' . $_SESSION['user']['username'] . '</h3>';
    echo '<p>Mobile: ' . $_SESSION['user']['mobile'] . '</p>';
    echo '<p>Address: ' . $_SESSION['user']['address'] . '</p>';
    echo '<p>Pet Name: ' . $row['name'] . '</p>';
    echo '<p>Age: ' . $row['age'] . '</p>';
    echo '<button type="submit">adopt</button>';
    echo '</div>';
    echo '</div>';
    
}
?>
        <div class="card">
            <img src="" alt="Pet Image">
            <div class="card-info">
                <h3>Owner: John Doe</h3>
                <p>Mobile: +123456789</p>
                <p>Address: 1234 Elm Street</p>
                <p>City: Springfield</p>
            </div>
        </div>

        <div class="card">
            <img src="https://via.placeholder.com/150" alt="Pet Image">
            <div class="card-info">
                <h3>Owner: Jane Smith</h3>
                <p>Mobile: +987654321</p>
                <p>Address: 5678 Oak Avenue</p>
                <p>City: Riverside</p>
            </div>
        </div>

        <div class="card">
            <img src="https://via.placeholder.com/150" alt="Pet Image">
            <div class="card-info">
                <h3>Owner : Jane Smith</h3>
                <p>Mobile: +987654321</p>
                <p>Address: 5678 Oak Avenue</p>
                <p>City: Riverside</p>
            </div>
        </div>
        <div class="card">
            <img src="https://via.placeholder.com/150" alt="Pet Image">
            <div class="card-info">
                <h3>Owner: Jane Smith</h3>
                <p>Mobile: +987654321</p>
                <p>Address: 5678 Oak Avenue</p>
                <p>City: Riverside</p>
            </div>
        </div>
        <div class="card">
            <img src="https://via.placeholder.com/150" alt="Pet Image">
            <div class="card-info">
                <h3>Owner: Jane Smith</h3>
                <p>Mobile: +987654321</p>
                <p>Address: 5678 Oak Avenue</p>
                <p>City: Riverside</p>
            </div>
        </div>

        <div class="card">
            <img src="https://via.placeholder.com/150" alt="Pet Image">
            <div class="card-info">
                <h3>Owner: Jane Smith</h3>
                <p>Mobile: +987654321</p>
                <p>Address: 5678 Oak Avenue</p>
                <p>City: Riverside</p>
            </div>
        </div>
    </div>

    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h4>Adoption</h4>
                <ul>
                    <li>Dogs</li>
                    <li>Cats</li>
                    <li>Birds</li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>About us</h4>
                <ul>
                    <li>About</li>
                    <li>Adoption Centre</li>
                    <li>Pet Hospitals</li>
                    <li>Nutrition Centre</li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Help and support</h4>
                <ul>
                    <li>Help center</li>
                    <li>Contact us</li>
                    <li>Privacy & Terms</li>
                    <li>Sitemap</li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Community</h4>
                <ul>
                    <li>Food Bank</li>
                    <li>Medical Centre</li>
                    <li>Support Group</li>
                </ul>
            </div></div>
            <div class="playstore">
                <div class="play">
                    <i class="fa-brands fa-apple"></i>
                    <div class="b1">
                    <div class="a1"><p>Download on the</p></div>
                    <div class="a2"><p>App Store</p></div>
                    </div>
                </div>
                <div class="play">
                    <i class="fa-brands fa-google-play"></i>
                    <div class="b1">
                    <div class="a1"><p>Get it on </p></div>
                    <div class="a2"><p>Google Play</p></div>
                    </div>
                </div>
            </div>
            </footer>
</body>
</html>
