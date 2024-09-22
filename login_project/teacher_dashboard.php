<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo "You must be logged in to view this page.";
    exit(); // Stop the execution if not logged in
}

// Database connection details
$servername = "localhost";  
$username = "root";         
$password = "";             
$dbname = "school_reservation"; 

// Create connection to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the username from the session
$user = $_SESSION['username'];

// SQL query to check if the user exists
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); 
    $hashed_password = $row['password']; 

    // Display the teacher dashboard
    if ($row['role'] === 'teacher') {
      
        echo '<link rel="stylesheet" type="text/css" href="css/teacher_navbar.css">';
        // Navigation bar
        echo '<nav>
                <div class="navbar">
                    <img src="images/logo1.jpg" alt="Logo 1" class="logo">
                    <img src="images/logo2.jpg" alt="Logo 2" class="logo2">
                    <ul>
                        <li><a href="home.php">Home</a></li>
                        <li><a href="reserve.php">Reserve</a></li>
                        <li><a href="sanction.php">Sanction</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </div>
              </nav>';
    } else {
        echo "You are logged in, but this is not a teacher account.";
    }
} else {
    echo "User not found!";
}

// Close the connection
$conn->close();
?>


