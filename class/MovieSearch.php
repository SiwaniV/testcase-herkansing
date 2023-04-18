<?php
class MovieSearch {
    private $conn;
    private $search_criteria;
    private $search_term;

    public function __construct($conn, $search_criteria, $search_term) {
        $this->conn = $conn;
        $this->search_criteria = $search_criteria;
        $this->search_term = $search_term;
    }
    public function search() {
        // Build SQL query based on search criteria
        $sql = "SELECT Movie.*, Actor.First_Name, Category.Name
            FROM Movie
            LEFT JOIN Movie_Actor ON Movie.ID = Movie_Actor.MovieID
            LEFT JOIN Actor ON Movie_Actor.ActorID = Actor.ID
            LEFT JOIN Movie_Category ON Movie.ID = Movie_Category.MovieID
            LEFT JOIN Category ON Movie_Category.CategoryID = Category.ID";

        switch ($this->search_criteria) {
            case 'title':
                $sql .= " WHERE Title LIKE '%" . $this->conn->real_escape_string($this->search_term) . "%'";
                break;
            case 'category':
                $sql .= " WHERE Category.Name LIKE '%" . $this->conn->real_escape_string($this->search_term) . "%'";
                break;
            case 'description':
                $sql .= " WHERE Description LIKE '%" . $this->conn->real_escape_string($this->search_term) . "%'";
                break;
            case 'actor':
                $sql .= " WHERE Actor.First_Name LIKE '%" . $this->conn->real_escape_string($this->search_term) . "%'";
                break;
            default:
                $sql .= " WHERE 1=0"; // Invalid search criteria, return no results
                break;
        }

        // Execute SQL query
        $result = $this->conn->query($sql);

        // Check if any movies were found
        if ($result !== false && $result->num_rows > 0) {
            // Return list of movies
            $movies = array();
            while ($row = $result->fetch_assoc()) {
                $movies[] = array(
                    'id' => $row['ID'],
                    'title' => $row['Title'],
                    'first_name' => $row['First_Name'],
                    'category_name' => $row['Name'],
                    'description' => $row['Description']
                );
            }
            return $movies;
        } else {
            // No movies found, return null
            return null;
        }
    }
}



?>
