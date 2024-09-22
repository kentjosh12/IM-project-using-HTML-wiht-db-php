<?php
// Database connection details
$servername = "localhost";  // Your MySQL server (localhost since it is local)
$username = "root";         // MySQL username (default for XAMPP is 'root')
$password = "";             // MySQL password (default is empty)
$dbname = "school_reservation"; // The database name you created in phpMyAdmin

// Create connection to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $user = isset($_POST['username']) ? $_POST['username'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $pass = isset($_POST['password']) ? $_POST['password'] : null;
    $role = isset($_POST['role']) ? $_POST['role'] : null;

    // Check for empty values
    if (is_null($user) || is_null($email) || is_null($pass) || is_null($role)) {
        die("Error: Please fill in all fields.");
    }

    // Hash the password for security
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    // Check if username already exists
    $check_sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Username already exists. Please choose another username.";
    } else {
        // Insert the new user into the database
        $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $user, $email, $hashed_password, $role);

        if ($stmt->execute()) {
            // Redirect to login page after successful registration
            header("Location: login.html");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
} else {
    echo "Error: Form not submitted.";
}

// Close the connection
$conn->close();
?>
