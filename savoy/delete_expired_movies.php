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

// Current date/time
$current_date = date('Y-m-d H:i:s');

// SQL to delete expired movies
$sql_delete = "DELETE FROM movies WHERE endingDate < '$current_date'";

if ($conn->query($sql_delete) === TRUE) {
    echo "Expired movies deleted successfully.";
} else {
    echo "Error deleting expired movies: " . $conn->error;
}

$conn->close();
?>
