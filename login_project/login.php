<?php
session_start(); // Start the session

// Database connection details
$servername = "localhost";  // Your MySQL server
$username = "root";         // MySQL username
$password = "";             // MySQL password (default is empty)
$dbname = "school_reservation"; // Your database name

// Create connection to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$user_or_email = $_POST['user_or_email'];
$pass = $_POST['password'];

// SQL query to check if the user exists with either username or email
$sql = "SELECT * FROM users WHERE username = ? OR email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $user_or_email, $user_or_email); // Bind username or email
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists and verify password
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); // Fetch the user data
    $hashed_password = $row['password']; // Get the hashed password

    // Verify the password
    if (password_verify($pass, $hashed_password)) {
        // Store user info in session
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        // Redirect based on role
        if ($_SESSION['role'] === 'teacher') {
            header("Location: teacher_dashboard.php");
        } else {
            header("Location: student_dashboard.php");
        }
        exit();
    } else {
        echo "Invalid username or password!";
    }
} else {
    echo "Invalid username or password!";
}

// Close the connection
$conn->close();
?>
