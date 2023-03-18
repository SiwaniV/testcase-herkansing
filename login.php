<?php
session_start();

require_once './class/DBconfig.php';
require_once 'partials/header.php';

if (isset($_POST['submit'])) {
    $username = htmlentities($_POST['username']);
    $password = htmlentities($_POST['password']);

    if (!empty($username) && !empty($password)) {
        $query = "SELECT * FROM staff WHERE Username = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Compare the entered password with the password stored in the database
            if ($password === $row['Password']) {
                $_SESSION['ID'] = $row['ID'];
                $_SESSION['USERNAME'] = $row['Username'];
                $_SESSION['loggedin'] = true;
                header("Location: dashboard.php");
                exit();
            } else {
                $errorMsg = "Invalid password";
            }
        } else {
            $errorMsg = "User not found";
        }
    } else {
        $errorMsg = "Please enter both username and password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2>Login Form</h2>
        <?php if (isset($errorMsg) && !empty($errorMsg)) { ?>
            <div class="alert alert-danger"><?php echo htmlentities($errorMsg); ?></div>
        <?php } ?>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>
    </div>
    <?php require_once './partials/footer.php' ?>
</body>

</html>
