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
    $name = mysqli_real_escape_string($conn, $_POST['movieName']);
    $description = mysqli_real_escape_string($conn, $_POST['movieDescription']);
    $movieLanguage = mysqli_real_escape_string($conn, $_POST['movieLanguage']);
    $showing_date = $_POST['showingDate'];
    $ending_date = $_POST['endingDate'];
    $dimension = $_POST['dimension'];
    $genre = $_POST['genre'];
    $rating = $_POST['rating'];
    $trailer_link = $_POST['trailerLink'];
    $release_date = $_POST['releaseDate'];

    // Validate file type and size for movie image
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_file_size = 2 * 1024 * 1024; // 2MB

    if (!in_array($_FILES['movieImage']['type'], $allowed_types) || $_FILES['movieImage']['size'] > $max_file_size) {
        echo "Invalid file type or size for movie image.";
        exit;
    }

    $target_dir = "uploads/";
    $image = $target_dir . basename($_FILES["movieImage"]["name"]);
    if (!move_uploaded_file($_FILES["movieImage"]["tmp_name"], $image)) {
        echo "Error uploading image.";
        exit;
    }

    // Determine the table to insert into based on the release date
    $currentDate = date("Y-m-d");
    if ($release_date <= $currentDate) {
        $table = "now_showing";
        $status = "now_showing";
    } else {
        $table = "upcoming_movies";
        $status = "Upcoming";
    }

    // Convert times from 24-hour format to 12-hour format and set to NULL if not provided
    function convertTo12HourFormat($time) {
        return $time ? date("h:i A", strtotime($time)) : NULL;
    }

    $showing_time1 = convertTo12HourFormat($_POST['showingTime1']);
    $showing_time2 = convertTo12HourFormat($_POST['showingTime2']);
    $showing_time3 = convertTo12HourFormat($_POST['showingTime3']);

    // Insert movie details into the appropriate table using prepared statements
    $stmt = $conn->prepare("INSERT INTO $table (movieName, movieImage, movieDescription, showingDate, endingDate, showingTime1, showingTime2, showingTime3, dimension, genre, rating, trailerLink, releaseDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssss", $name, $image, $description, $showing_date, $ending_date, $showing_time1, $showing_time2, $showing_time3, $dimension, $genre, $rating, $trailer_link, $release_date);

    if ($stmt->execute()) {
        $movie_id = $stmt->insert_id; // Get the last inserted movie ID

        // Insert into the movies table with the status
        $stmt_movies = $conn->prepare("INSERT INTO movies (movieName, movieImage, movieDescription, movieLanguage, showingDate, endingDate, showingTime1, showingTime2, showingTime3, dimension, genre, rating, trailerLink, releaseDate, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt_movies->bind_param("sssssssssssssss", $name, $image, $description, $movieLanguage, $showing_date, $ending_date, $showing_time1, $showing_time2, $showing_time3, $dimension, $genre, $rating, $trailer_link, $release_date, $status);

        if ($stmt_movies->execute()) {
            $movie_id_movies_table = $stmt_movies->insert_id; // Get the last inserted movie ID from movies table

            // Handling cast inputs
            foreach ($_POST['castName'] as $index => $castName) {
                // Validate file type for cast image
                if (!in_array($_FILES['castImage']['type'][$index], $allowed_types)) {
                    echo "Invalid file type for cast image.";
                    exit;
                }

                $cast_image = $target_dir . basename($_FILES["castImage"]["name"][$index]);
                if (!move_uploaded_file($_FILES["castImage"]["tmp_name"][$index], $cast_image)) {
                    echo "Error uploading cast image.";
                    exit;
                }

                $stmt_cast = $conn->prepare("INSERT INTO movie_casts (movieId, castName, castImage) VALUES (?, ?, ?)");
                $stmt_cast->bind_param("iss", $movie_id_movies_table, $castName, $cast_image);

                if (!$stmt_cast->execute()) {
                    echo "Error: " . $stmt_cast->error;
                }

                $stmt_cast->close();
            }

            echo "<script>alert('Movie and casts added successfully!');</script>";
        } else {
            echo "Error: " . $stmt_movies->error;
        }

        $stmt_movies->close();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
</body>
</html>
