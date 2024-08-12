<?php
session_start();

// Check if the user is an admin
if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header('Location: login.html');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./admin.css">
    <title>Admin Page</title>
</head>
<style>

body{
    background-color: white;
}

/* Header */
.Header {
    display: flex;
    width: 98%;
    height: 100px;
    justify-content: space-between;
}

/* Dropdown Menu */
.nav-bar {
    position: relative;
    display: inline-block;
}

.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown img {
    cursor: pointer;
    margin-top: 5px;
    margin-left: 5px;
    background-color: #000;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #d9dcea5f;
    min-width: 160px;
    border-radius: 20px;
    gap: 5px;
    padding: 10px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    transition: 0.3s;
}

.dropdown-content a {
    color: rgb(0, 0, 0);
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: rgba(0, 0, 37, .8);
    border-radius: 20px;
    color: white;
    font-size: larger;
}

.dropdown:hover .dropdown-content {
    display: block;
}

/* Welcome Massage */
.wlcm h1 {
    color: rgb(0, 0, 0);
    margin-top: 10px;
}


/* Logout Button */
.logout {
    padding-top: 15px;
}

.logout a {
    background-color: white;
    text-decoration: none;
    color: #000;
    padding: 8px;
    border-radius: 30px;
    border: none;
    font-weight: bolder;
    cursor: pointer;
    transition: 0.4s;
}

.logout a:hover {
    background-color: rgba(0, 0, 37, .8);
    color: white;
}

    /* Styling for the movie table */
.movie-table {
    width: 300%;
    border-collapse: collapse;
    margin-top: 20px;
}

/* Styling for table headers */
.movie-header {
    background-color:  rgba(0, 0, 37, .8);
    color: white;
    padding: 10px;
    text-align: left;
    border: 1px solid #ddd;
}

/* Styling for table rows */
.movie-row:nth-child(even) {
    background-color: #f9f9f9;
}

/* Styling for table cells */
.movie-data {
    color: white;
    background-color: black;
    padding: 10px;
    text-align: center;
    border: 1px solid #ddd;
}

/* Styling for movie images */
.movie-image {
    max-width: 100px;
    height: auto;
    display: block;
    margin: 0 auto;
}

/* Styling for cast images */
.cast-image {
    max-width: 50px;
    height: auto;
    margin-right: 5px;
    vertical-align: middle;
}

/* Styling for trailer links */
.trailer-link {
    color: #007bff;
    text-decoration: none;
}

.trailer-link:hover {
    text-decoration: underline;
}
</style>

<body>

<!-- Header -->
<section>
    <div class="Header">
        <div class="nav-bar">
            <div class="dropdown">
                <a href="#"><img src="./uploads/icons/list.png" alt="Menu"></a>
                <div class="dropdown-content">
                    <a href="./adminpanel.php">Home</a>
                    <a href="./addmovies.html">Add Movies</a>
                    <a href="./staffSignup.html">Create Staff Account</a>
                    <a href="./CheckBookings.php">Check Bookings</a>
                    <a href="./addPromotions.html">Add Promotions</a>
                    <a href="./view_feedback.php">View Feedbacks</a>
                </div>
            </div>
        </div>
        <div class="wlcm">
            <h1>Welcome Admin Dashboard</h1>
        </div>
        <div class="logout">
            <a href="./Index.php">Logout</a>
        </div>
    </div>
</section>

<!-- View Added Movies -->
<section>
    <table class="movie-table">
        <thead>
            <tr>
                <th class="movie-header">Id</th>
                <th class="movie-header">Movie Name</th>
                <th class="movie-header">Release Date</th>
                <th class="movie-header">Movie Image</th>
                <th class="movie-header">Movie Description</th>
                <th class="movie-header">Movie Language</th>
                <th class="movie-header">Duration</th>
                <th class="movie-header">Showing Times</th>
                <th class="movie-header">Dimension</th>
                <th class="movie-header">Genre</th>
                <th class="movie-header">Rating</th>
                <th class="movie-header">Cast</th>
                <th class="movie-header">Trailer</th>
                <th class="movie-header">Movie Status</th>
            </tr>
        </thead>
        <tbody>
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

            // Fetch movies
            $sql_movies = "SELECT * FROM movies";
            $result_movies = $conn->query($sql_movies);

            if ($result_movies->num_rows > 0) {
                while ($movie = $result_movies->fetch_assoc()) {
                    echo "<tr class='movie-row'>";
                    echo "<td class='movie-data'>" . $movie["id"] . "</td>";
                    echo "<td class='movie-data'>" . $movie["movieName"] . "</td>";
                    echo "<td class='movie-data'>" . $movie["releaseDate"] . "</td>";
                    echo "<td class='movie-data'><img src='" . $movie["movieImage"] . "' alt='" . $movie["movieName"] . "' class='movie-image'></td>";
                    echo "<td class='movie-data'>" . $movie["movieDescription"] . "</td>";
                    echo "<td class='movie-data'>" . $movie["movieLanguage"] . "</td>";
                    echo "<td class='movie-data'>" . $movie["showingDate"] . " - " . $movie["endingDate"] . "</td>";
                    echo "<td class='movie-data'>" . $movie["showingTime1"] . " , " . $movie["showingTime2"] . " , " . $movie["showingTime3"] . "</td>";
                    echo "<td class='movie-data'>" . $movie["dimension"] . "</td>";
                    echo "<td class='movie-data'>" . $movie["genre"] . "</td>";
                    echo "<td class='movie-data'>" . $movie["rating"] . "</td>";
                    
                    // Fetch casts
                    $movieId = $movie["id"];
                    $sql_casts = "SELECT * FROM movie_casts WHERE movieId = $movieId";
                    $result_casts = $conn->query($sql_casts);
                    $casts = [];
                    if ($result_casts->num_rows > 0) {
                        while ($cast = $result_casts->fetch_assoc()) {
                            $casts[] = $cast["castName"] . " <img src='" . $cast["castImage"] . "' alt='" . $cast["castName"] . "' class='cast-image'>";
                        }
                    }
                    echo "<td class='movie-data'>" . implode(", ", $casts) . "</td>";

                    echo "<td class='movie-data'><a href='" . $movie["trailerLink"] . "' target='_blank' class='trailer-link'>Watch Trailer</a></td>";
                    echo "<td class='movie-data'>" . $movie["status"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='13'>No movies found</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</section>


</body>
</html>
