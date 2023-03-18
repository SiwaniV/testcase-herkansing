<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'class/DBconfig.php';
require_once 'partials/header.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php"); // redirect to the login page if not logged in
    exit;
}


// Instantiate $conn object
$conn = new mysqli($hostname, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <?php
        // Check if search form has been submitted
        if (isset($_POST['submit'])) {

            // Check if search criteria is set
            if (isset($_POST['search_criteria'])) {
                // Get search criteria from form
                $search_criteria = $conn->real_escape_string($_POST['search_criteria']);
            }
            $search_term = $conn->real_escape_string($_POST['search_term']);

            // Build SQL query based on search criteria
            $sql = "SELECT * FROM movie WHERE ";
            switch ($search_criteria) {
                case 'title':
                    $sql .= "title LIKE '%$search_term%'";
                    break;
                case 'description':
                    $sql .= "description LIKE '%$search_term%'";
                    break;
                case 'actor':
                    $sql .= "actor LIKE '%$search_term%'";
                    break;
                default:
                    $sql .= "1=0"; // Invalid search criteria, return no results
                    break;
            }

            // Execute SQL query
            $result = $conn->query($sql);

            // Check if any movies were found
            if ($result->num_rows > 0) {
                // Display list of movies
                echo "<ul>";
                while ($row = $result->fetch_assoc()) {
                    echo "<li><a href='movie_details.php?id=" . $row['LanguageID'] . "'>" . $row['Title'] . "</a></li>";
                }
                echo "</ul>";
            } else {
                // No movies found, display error message
                echo "No movies found matching your search criteria.";
            }

        } else {
            // Display the home page text
            $username = $_SESSION['username'] ?? '';
            echo "<h2>Welcome to the dashboard $username</h2>";
        }
        // Close database connection
        $conn->close();
        ?>
    </div>
    <?php require_once('./partials/footer.php') ?>
</body>

</html>
