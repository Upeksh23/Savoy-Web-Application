<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "savoy_cinema";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = $_GET['q'];

$sql = "SELECT id, movieName, movieImage FROM movies WHERE movieName LIKE '%$query%' LIMIT 15";
$result = $conn->query($sql);

$movies = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $movies[] = $row;
    }
}

echo json_encode($movies);

$conn->close();
?>
