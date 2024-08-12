<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "savoy_cinema";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $password = $_POST['password'];

    // Admin credentials
    $admin_phone_number = '0775198164'; // Replace with actual admin phone number
    $admin_password = '1234@'; // Replace with actual admin password

    if ($phone_number === $admin_phone_number && $password === $admin_password) {
        // Admin credentials are correct
        $_SESSION['admin'] = true;
        echo "<script>alert('Admin login successful!'); window.location.href = 'adminpanel.php';</script>";
    } else {
        // Check for staff
        $stmt = $conn->prepare("SELECT id, name, phone_number, password FROM staff WHERE phone_number = ?");
        $stmt->bind_param("s", $phone_number);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($staff_id, $name, $phone_number, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                // Password is correct, start a session
                $_SESSION['staff_id'] = $staff_id;
                $_SESSION['name'] = $name;
                $_SESSION['phone_number'] = $phone_number;

                echo "<script>alert('Staff login successful!'); window.location.href = 'Staff_add_movies.html';</script>";
            } else {
                // Password is incorrect
                echo "<script>alert('Invalid phone number or password.'); window.location.href = 'login.html';</script>";
            }
        } else {
            // Check for regular user
            $stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE phone_number = ?");
            $stmt->bind_param("s", $phone_number);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($user_id, $name, $email, $hashed_password);
                $stmt->fetch();

                if (password_verify($password, $hashed_password)) {
                    // Password is correct, start a session
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['name'] = $name;
                    $_SESSION['email'] = $email;

                    echo "<script>alert('Login successful!'); window.location.href = './Index.php';</script>";
                } else {
                    // Password is incorrect
                    echo "<script>alert('Invalid phone number or password.'); window.location.href = 'login.html';</script>";
                }
            } else {
                // Phone number not found
                echo "<script>alert('Invalid phone number or password.'); window.location.href = 'login.html';</script>";
            }

            $stmt->close();
        }
    }
}

$conn->close();
?>