<?php
require_once('./class/DBconfig.php');
?>

<header class="navtop">
    <div>
        <h1>My Simple Home</h1>
        <a href="index.php">Home</a>
        <?php
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        echo isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'staff' ? "" : '<a href="login.php">Login</a>';
        ?>
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