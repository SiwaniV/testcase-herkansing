<?php
function displayNavLinks()
{
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        // User is logged in as client
        echo '<a href="dashboard.php">Dashboard</a>';
        echo '<a href="logout.php">Logout</a>';
    } else {
        echo '<a href="login.php">Login</a>';
    }
}
?>

<header class="navtop">
    <div>
        <h1>My Simple Home</h1>
        <a href="index.php">Home</a>
        <?php displayNavLinks(); ?>
        <form action="" method="post">
            <input type="text" placeholder="Search..." name="search_term">
            <select name="search_criteria">
                <option value="title">Title</option>
                <option value="category">Genre</option>
                <option value="actor">Actor</option>
            </select>
            <button type="submit" name="submit">Search</button>
        </form>
    </div>
</header>
