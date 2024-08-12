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

// Function to update movies table from now_showing and upcoming_movies
function updateMoviesTable($conn) {
    // Fetch movies from now_showing
    $nowShowingQuery = "SELECT * FROM now_showing";
    $nowShowingResult = $conn->query($nowShowingQuery);

    if ($nowShowingResult->num_rows > 0) {
        while ($row = $nowShowingResult->fetch_assoc()) {
            // Check if the movie already exists in the movies table
            $checkQuery = "SELECT * FROM movies WHERE movieName = ? AND releaseDate = ?";
            $checkStmt = $conn->prepare($checkQuery);
            $checkStmt->bind_param("ss", $row['movieName'], $row['releaseDate']);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();

            if ($checkResult->num_rows > 0) {
                // Update the existing record
                $updateQuery = "UPDATE movies SET status = 'now_showing', movieImage = ?, movieDescription = ?, showingDate = ?, endingDate = ?, showingTime1 = ?, showingTime2 = ?, showingTime3 = ?, dimension = ?, genre = ?, rating = ?, trailerLink = ? WHERE movieName = ? AND releaseDate = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param("sssssssssssss", $row['movieImage'], $row['movieDescription'], $row['showingDate'], $row['endingDate'], $row['showingTime1'], $row['showingTime2'], $row['showingTime3'], $row['dimension'], $row['genre'], $row['rating'], $row['trailerLink'], $row['movieName'], $row['releaseDate']);
            } else {
                // Insert a new record
                $updateQuery = "INSERT INTO movies (movieName, movieImage, movieDescription, showingDate, endingDate, showingTime1, showingTime2, showingTime3, dimension, genre, rating, trailerLink, releaseDate, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'now_showing')";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param("sssssssssssss", $row['movieName'], $row['movieImage'], $row['movieDescription'], $row['showingDate'], $row['endingDate'], $row['showingTime1'], $row['showingTime2'], $row['showingTime3'], $row['dimension'], $row['genre'], $row['rating'], $row['trailerLink'], $row['releaseDate']);
            }

            $updateStmt->execute();
            $checkStmt->close();
        }
    }

    // Fetch movies from upcoming_movies
    $upcomingMoviesQuery = "SELECT * FROM upcoming_movies";
    $upcomingMoviesResult = $conn->query($upcomingMoviesQuery);

    if ($upcomingMoviesResult->num_rows > 0) {
        while ($row = $upcomingMoviesResult->fetch_assoc()) {
            // Check if the movie already exists in the movies table
            $checkQuery = "SELECT * FROM movies WHERE movieName = ? AND releaseDate = ?";
            $checkStmt = $conn->prepare($checkQuery);
            $checkStmt->bind_param("ss", $row['movieName'], $row['releaseDate']);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();

            if ($checkResult->num_rows > 0) {
                // Update the existing record
                $updateQuery = "UPDATE movies SET status = 'Upcoming', movieImage = ?, movieDescription = ?, showingDate = ?, endingDate = ?, showingTime1 = ?, showingTime2 = ?, showingTime3 = ?, dimension = ?, genre = ?, rating = ?, trailerLink = ? WHERE movieName = ? AND releaseDate = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param("sssssssssssss", $row['movieImage'], $row['movieDescription'], $row['showingDate'], $row['endingDate'], $row['showingTime1'], $row['showingTime2'], $row['showingTime3'], $row['dimension'], $row['genre'], $row['rating'], $row['trailerLink'], $row['movieName'], $row['releaseDate']);
            } else {
                // Insert a new record
                $updateQuery = "INSERT INTO movies (movieName, movieImage, movieDescription, showingDate, endingDate, showingTime1, showingTime2, showingTime3, dimension, genre, rating, trailerLink, releaseDate, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Upcoming')";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param("sssssssssssss", $row['movieName'], $row['movieImage'], $row['movieDescription'], $row['showingDate'], $row['endingDate'], $row['showingTime1'], $row['showingTime2'], $row['showingTime3'], $row['dimension'], $row['genre'], $row['rating'], $row['trailerLink'], $row['releaseDate']);
            }

            $updateStmt->execute();
            $checkStmt->close();
        }
    }
}

// Call the function to update the movies table
updateMoviesTable($conn);

$conn->close();
?>
