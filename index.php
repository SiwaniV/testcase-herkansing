<?php
require_once('./class/DBconfig.php');
require_once('partials/header.php');




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
    <div class="container">
        <?php
        // Check if search form has been submitted
        if (isset($_POST['submit'])) {
            // Instantiate $conn object
            $conn = new mysqli($hostname, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            // Check if search criteria is set
            if (isset($_POST['search_criteria'])) {
                // Get search criteria from form
                $search_criteria = $conn->real_escape_string($_POST['search_criteria']);
            }
            $search_term = $conn->real_escape_string($_POST['search_term']);

            // Build SQL query based on search criteria
            $sql = "SELECT Movie.*, Actor.First_Name, Category.Name
            FROM Movie
            LEFT JOIN Movie_Actor ON Movie.ID = Movie_Actor.MovieID
            LEFT JOIN Actor ON Movie_Actor.ActorID = Actor.ID
            LEFT JOIN Movie_Category ON Movie.ID = Movie_Category.MovieID
            LEFT JOIN Category ON Movie_Category.CategoryID = Category.ID";
switch ($search_criteria) {
    case 'title':
        $sql .= " WHERE Title LIKE '%$search_term%'";
        break;
    case 'category':
        $sql .= " WHERE Category.Name LIKE '%$search_term%'";
        break;
    case 'description':
        $sql .= " WHERE Description LIKE '%$search_term%'";
        break;
    case 'actor':
        $sql .= " WHERE Actor.First_Name LIKE '%$search_term%'";
        break;
    default:
        $sql .= " WHERE 1=0"; // Invalid search criteria, return no results
        break;
}



            // Execute SQL query
            $result = $conn->query($sql);

            // Check if any movies were found
            if ($result !== false && $result->num_rows > 0) {
                // Display list of movies
                echo "<ul>";
                while ($row = $result->fetch_assoc()) {
                    echo "<li><a href='movie_details.php?id=" . $row['ID'] . "'>" . $row['Title'] . "</a></li>";
                }
                echo "</ul>";
            } else {
                // No movies found, display error message
                echo "No movies found matching your search criteria.";
            }
            // Close database connection
            $conn->close();
        } else {
            // Display the home page text
            echo "<h2>Welcome to My Simple Home Page</h2>";
            echo "<p>This is a simple home page created using PHP and MySQL.</p>";
        }
        ?>
    </div>
    <?php
    require_once('./partials/footer.php'); ?>
</body>

</html>