<?php
require_once('./class/DBconfig.php');

class Client {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function login() {
        if (isset($_POST['submit'])) {
            $username = htmlentities($_POST['username']);
            $password = htmlentities($_POST['password']);

            if (!empty($username) && !empty($password)) {
                $row = $this->getUser($username);

                if ($row !== null) {
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
    }

    private function getUser($username) {
        $query = "SELECT * FROM client WHERE Username = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return null;
    }
}

?>


