<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "savoy_cinema";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get booking ID from POST request
$booking_id = $_POST['booking_id'];

// Delete booking seats
$sql = "DELETE FROM `booking_seat` WHERE `booking_id`='$booking_id'";
$conn->query($sql);

// Delete booking
$sql = "DELETE FROM `booking` WHERE `id`='$booking_id'";
$conn->query($sql);

// Redirect back to the admin panel
header("Location: CheckBookings.php");
exit();
?>
