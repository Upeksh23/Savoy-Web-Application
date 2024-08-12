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

$current_date = date("Y-m-d");

// Delete promotions where the end date has passed
$stmt = $conn->prepare("DELETE FROM promotions WHERE end_date < ?");
$stmt->bind_param("s", $current_date);

if ($stmt->execute()) {
    echo "Expired promotions deleted successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
