<?php
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
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $discount = mysqli_real_escape_string($conn, $_POST['discount']);
    $duration = (int)$_POST['duration'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Validate file type and size for promotion image
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_file_size = 2 * 1024 * 1024; // 2MB

    if (!in_array($_FILES['image']['type'], $allowed_types) || $_FILES['image']['size'] > $max_file_size) {
        echo "Invalid file type or size for promotion image.";
        exit;
    }

    $target_dir = "uploads/";
    $image = $target_dir . basename($_FILES["image"]["name"]);
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $image)) {
        echo "Error uploading image.";
        exit;
    }

    // Insert promotion details into the promotions table using prepared statements
    $stmt = $conn->prepare("INSERT INTO promotions (title, description, discount, duration, image, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssisss", $title, $description, $discount, $duration, $image, $start_date, $end_date);

    if ($stmt->execute()) {
        echo "<script>alert('Promotion added successfully!'); window.location = 'adminpanel.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
