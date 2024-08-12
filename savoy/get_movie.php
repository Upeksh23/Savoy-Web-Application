<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "savoy_cinema";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}

// Check if id is set
if (!isset($_GET['id'])) {
    die(json_encode(['error' => 'No movie ID provided']));
}

$movieId = intval($_GET['id']);

// Prepare and execute the query
$stmt = $conn->prepare("SELECT * FROM movies WHERE id = ?");
$stmt->bind_param("i", $movieId);
$stmt->execute();
$result = $stmt->get_result();

// Fetch movie details
if ($result->num_rows > 0) {
    $movie = $result->fetch_assoc();

    // Fetch casts
    $casts = [];
    $castStmt = $conn->prepare("SELECT * FROM movie_casts WHERE movieId = ?");
    $castStmt->bind_param("i", $movieId);
    $castStmt->execute();
    $castResult = $castStmt->get_result();
    while ($cast = $castResult->fetch_assoc()) {
        $casts[] = $cast;
    }

    // Add casts to movie details
    $movie['casts'] = $casts;

    // Return movie details as JSON
    echo json_encode($movie);
} else {
    echo json_encode(['error' => 'Movie not found']);
}

// Close the connection
$conn->close();
?>
