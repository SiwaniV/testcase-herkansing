<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('./class/DBconfig.php');
require_once 'partials/header.php';

// Check if movie ID is set in URL parameter
if(isset($_GET['id'])){
    $movie_id = $_GET['id'];

    // Instantiate $conn object
    $conn = new mysqli($hostname, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Build SQL query to retrieve movie details
    $sql = "SELECT * FROM movie WHERE id = $movie_id";

    // Execute SQL query
    $result = $conn->query($sql);

?>
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<?php
    // Check if movie is found
    if ($result->num_rows == 1) {
        // Display movie details
        $row = $result->fetch_assoc();
        echo "<h1>" . $row['Title'] . "</h1>";
        echo "<p>" . $row['Description'] . "</p>";
    } else {
        // Movie not found, display error message
        echo "Movie not found.";
    }

    // Close database connection
    $conn->close();
} else {
    // Movie ID not set in URL parameter, redirect to home page
    header("Location: index.php");
    exit();
}

require_once ('./partials/footer.php');
?>
