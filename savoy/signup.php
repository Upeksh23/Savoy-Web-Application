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
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

if(!preg_match("/07[0,1,2,4,5,6,7,8][0-9]/",$phone_number)){

    echo "<script>alert('1.Invalid Mobile Number'); window.location.href = 'signup.html';</script>";
        exit();
} else if (strlen($phone_number)!=10){
    echo "<script>alert('2. Invalid Mobile Number Length'); window.location.href = 'signup.html';</script>";
        exit();
} 


    // Check if email already exists
    $check_email = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $check_email->store_result();

    if ($check_email->num_rows > 0) {
        echo "<script>alert('Email already exists! Please use a different email.'); window.location.href = 'signup.html';</script>";
        exit();
    }
    $check_email->close();

    $stmt = $conn->prepare("INSERT INTO users (name, email, phone_number, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phone_number, $password);

    if ($stmt->execute()) {
        // Start session and store user details
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;

        echo "<script>alert('Registration successful!'); window.location.href = './Login.html';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
