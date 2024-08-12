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

$currentDate = date("Y-m-d");

$sql = "SELECT * FROM upcoming_movies WHERE releaseDate <= '$currentDate'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sql_insert = "INSERT INTO now_showing (name, image, description, showing_date, ending_date, showing_time1, showing_time2, showing_time3, dimension, genre, rating, trailer_link, release_date)
                    VALUES ('".$row['name']."', '".$row['image']."', '".$row['description']."', '".$row['showing_date']."', '".$row['ending_date']."', '".$row['showing_time1']."', '".$row['showing_time2']."', '".$row['showing_time3']."', '".$row['dimension']."', '".$row['genre']."', '".$row['rating']."', '".$row['trailer_link']."', '".$row['release_date']."')";
        if ($conn->query($sql_insert) === TRUE) {
            $sql_delete = "DELETE FROM upcoming_movies WHERE id=".$row['id'];
            $conn->query($sql_delete);
        }
    }
}

$conn->close();
?>
