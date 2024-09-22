<?php
session_start(); // Start the session

// Check if the user is logged in and is a student
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php"); // Redirect to login if not logged in as a student
    exit();
}

// Display the dashboard for the logged-in student
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/student_dashboard.css"> <!-- Link to your CSS file -->
    <title>Student Dashboard</title>
</head>
<body>
    <div class="container">
        <h1>Welcome to the Student Dashboard</h1>
        <p>You are logged in as: <?php echo htmlspecialchars($_SESSION['username']); ?></p>
        <nav>
            <ul>
                <li><a href="view_courses.php">View Courses</a></li>
                <li><a href="view_assignments.php">View Assignments</a></li>
                <li><a href="profile.php">View Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
</body>
</html>
