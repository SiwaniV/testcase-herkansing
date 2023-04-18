<?php
require_once('./class/DBconfig.php');
require_once('./class/MovieSearch.php');

// Start session
session_start();

// Check if user is logged in
if (isset($_SESSION['username'])) {
    $logged_in = true;
} else {
    $logged_in = false;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Search Movies</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <?php require_once 'partials/header.php'; ?>
    <div class="container">
        <?php
        // Instantiate $conn object
        $conn = new mysqli($hostname, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if search form has been submitted
        if (isset($_POST['submit'])) {
            // Check if search criteria is set
            if (isset($_POST['search_criteria'])) {
                $search_criteria = $_POST['search_criteria'];
            } else {
                $search_criteria = '';
            }
            $search_term = $_POST['search_term'];

            // Instantiate MovieSearch object
            $movieSearch = new MovieSearch($conn, $search_criteria, $search_term);

            // Execute search and display results
            $movies = $movieSearch->search();

            if ($movies !== null) {
                echo "<h2>Search Results</h2>";
                foreach ($movies as $movie) {
                    echo "<div>";
                    echo "<h3>" . $movie['title'] . "</h3>";
                    echo "<p><strong>Category:</strong> " . $movie['category_name'] . "</p>";
                    echo "<p><strong>Starring:</strong> " . $movie['first_name'] . "</p>";
                    echo "<p><strong>Description:</strong> " . $movie['description'] . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No results found.</p>";
            }
        } else {
            // Display the home page text
            echo "<h2>Welcome to My Simple Home Page</h2>";
            echo "<p>This is a simple home page created using PHP and MySQL.</p>";

            // Display login button if user is not logged in
        }
        ?>
    </div>
    <?php
    require_once('./partials/footer.php'); ?>
</body>

</html>