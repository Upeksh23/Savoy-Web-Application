<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" 
    integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="footer.css">

    <title>Savoy Cinema</title>

</head>

<script>
    function searchMovies() {
        const query = document.getElementById('searchInput').value;
        if (query.length < 3) {
            document.getElementById('searchResults').innerHTML = '';
            return;
        }
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'search_movies.php?q=' + query, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                const movies = JSON.parse(xhr.responseText);
                let resultsHTML = '';
                for (const movie of movies) {
                    resultsHTML += `<div class="result-item" onclick="goToMovie(${movie.id})">
                        <img src="${movie.movieImage}" alt="${movie.movieName}">
                        <span>${movie.movieName}</span>
                    </div>`;
                }
                document.getElementById('searchResults').innerHTML = resultsHTML;
            }
        };
        xhr.send();
    }

    function goToMovie(movieId) {
        window.location.href = 'booking.php?id=' + movieId;
    }
</script>

<style>

body {
    object-fit: cover;
    background-color: white;
    overflow-x: hidden;
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
    
}

/*Nav Bar*/
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: rgba(0, 0, 37, .8); 
    backdrop-filter: blur(10px); 
    padding: 10px 20px;
    position: relative;
    width: 97.3%;
    z-index: 10;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
}

.navbar .center a {
    color: white;
    padding: 14px 20px;
    text-decoration: none;
    text-align: center; margin-left: 50px; transition: 0.5s; }

.navbar .center a:hover, .navbar .center a.active {
    background-color: white;
    color: black;
    border-radius: 20px;
}

.left a .logo {
    width: 80px;
    height: auto;
    padding-top: 5px;
}

.right {
    display: flex;
}

.search-bar {
    padding: 5px;
    margin-top: 8px;
    margin-right: 10px;
}

.search-bar input {
    border-color: #ddd;
    height: 28px;
    border-radius: 10px;
    border: none;
}

input#searchInput {
    text-align: center;
}

.search-results {
        position: absolute;
        background: white;
/*        border: 1px solid #ccc; */
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
        width: 300px;
    }
    .search-results .result-item {
        padding: 10px;
        cursor: pointer;
        display: flex;
        align-items: center;
    }
    .search-results .result-item img {
        width: 50px;
        height: 75px;
        object-fit: cover;
        margin-right: 10px;
    }
    .search-results .result-item:hover {
        background-color: #f0f0f0;
    }

.profile-buttons {
    display: inline-block;
}

.profile-button {
    color: white;
    padding: 12px 16px;
    text-decoration: none;
    display: inline-block;
    transition: 0.3s;
    margin: 5px;
    background-color: rgba(255, 255, 255, 0.226);
    border-radius: 10px;
}

.profile-button:hover {
    background-color: white;
    color: black;
    border-radius: 5px;
}

    /* Image Slider */
.slider {
    position: relative;
    width: 90%;
    height: 600px;
    margin: auto;
    overflow: hidden;
    margin-top: 10px; 
}

.slides {
    display: flex;
    transition: transform 0.5s ease-in-out;
    height: 100%;
}

.slide {
    position: relative;
    min-width: 100%;
    box-sizing: border-box;
    height: 100%;
}

.slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.slide-content {
    position: absolute;
    bottom: 20px; /* Adjust as needed */
    left: 20px; /* Adjust as needed */
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    padding: 10px;
    color: white;
}

.slide-content h1 {
    margin: 0;
    font-size: 34px; /* Adjust as needed */
    padding-bottom: 10px;
}

.slide-content a {
    margin-top: 10px; /* Space between elements */
    background-color: white; /* Button background color */
    color: black;
    border: none;
    border-radius: 10px;
    font-size: 18px;
    padding: 8px 16px;
    cursor: pointer;
    transition: 0.4s;
}

.slide-content a:hover {
    color: black; 
    font-size: 20px;
}

.navigation {
    position: absolute;
    top: 50%;
    width: 100%;
    display: flex;
    justify-content: space-between;
    transform: translateY(-50%);
    
}

.prev, .next {
    cursor: pointer;
    background-color: rgba(0, 0, 37, .8);
    color: white;
    border: none;
    padding: 20px;
    font-size: 18px;
    border-radius: 10%;
}

.dots {
    text-align: center;
    position: absolute;
    bottom: 10px;
    width: 100%;
}

.dot {
    cursor: pointer;
    height: 15px;
    width: 15px;
    margin: 0 2px;
    background-color: #bbb;
    border-radius: 50%;
    display: inline-block;
    transition: background-color 0.6s ease;
}

.dot.active {
    background-color: #717171;
}


/* Movies */

.carousel-movies {
    display: flex;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 10px;
    background-color: transparent;
    width: 100%;
    margin-top: 20px;
    padding: 10px;
    box-sizing: border-box;
}

.up {
    color: rgba(0, 0, 37, .8);
    padding-left: 5px;
}

.movie {
    position: relative;
    height: 200px; /* Adjusted height */
    border-radius: 15px;
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
}

.movie img {
    width: 200px;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.movie:hover img {
    transform: scale(1.1);
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent background */
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    opacity: 0; /* Hidden by default */
    transition: opacity 0.3s ease;
}

.movie:hover .overlay {
    opacity: 1; /* Show overlay on hover */
}

.overlay h3 {
    font-size: 1.5rem;
    margin-bottom: 10px;
}

.buttons {
    display: flex;
}


.btn-book  {
    margin: 0 5px;
    padding: 8px 16px;
    background-color: #fff;
    color: #000;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.btn-trailer{
    margin: 0 5px;
    padding: 8px 16px;
    background-color: #fff;
    color: #000;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.buttons a:hover {
    background-color: black;
    color: white;
}


</style>
<body>
<!-- Navigation bar -->
<section>
    <nav class="navbar">
        <div class="left">
            <a href="./Index.php"><img src="./uploads/icons/savoy.png" alt="Logo" class="logo"></a>
        </div>
        <div class="center">
            <a href="./Index.php" id="home-link">Home</a>
            <a href="./Aboutus.html" id="about-link">About Us</a>
            <a href="./promotion.php" id="promotions-link">Promotions</a>
        </div>
        <div class="right">
                <div class="search-bar">
                    <input type="text" id="searchInput" placeholder="Search Your Movie..." onkeyup="searchMovies()">
                    <div id="searchResults" class="search-results"></div>
                </div>

            <div class="profile-buttons">
                <a href="./Signup.html" class="profile-button">Sign Up</a>
                <a href="./Login.html" class="profile-button">Login</a>
            </div>
        </div>
    </nav>
</section>

<!-- Viewport -->
<section>
    <div class="slider">
        <div class="slides">
            <?php
            // PHP code to fetch and display movies from database
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

            $sql = "SELECT * FROM `movies` WHERE `status` = 'now_showing'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="slide">';
                    echo '<img src="' . $row["movieImage"] . '" alt="' . $row["movieName"] . '">';
                    echo '<div class="slide-content">';
                    echo '<h1>' . $row["movieName"] . '</h1>';
                    echo '<a href="./booking.php?id='.$row["id"].'" class="btn-book">Book Tickets</a>';
                    echo '<a href="' . $row["trailerLink"] . '" class="btn-trailer" target="_blank">Play Trailer</a>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "No movies currently showing.";
            }

            $conn->close();
            ?>

        

        </div>

        <div class="navigation">
            <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
            <button class="next" onclick="moveSlide(1)">&#10095;</button>
        </div>

        <div class="dots">
            <?php
            // PHP code to generate dots for slides
            if ($result->num_rows > 0) {
                for ($i = 1; $i <= $result->num_rows; $i++) {
                    echo '<span class="dot" onclick="currentSlide(' . $i . ')"></span>';
                }
            }
            ?>
        </div>
    </div>
    <script src="./script.js"></script>
</section>

<!-- Now Showing Movies -->
<section>
    <h1 class="up">Now Showing</h1>
    <div class="carousel-movies">
        <?php
        // PHP code to fetch and display now showing movies
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM movies WHERE status = 'now_showing'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="movie">';
                echo '<img src="' . $row["movieImage"] . '" alt="' . $row["movieName"] . '">';
                echo '<div class="overlay">';
                echo '<h3>' . $row["movieName"] . '</h3>';
                echo '<div class="buttons">';
                echo '<a href="./booking.php?id='.$row["id"].'" class="btn-book">Book Tickets</a>';
                echo '<a href="' . $row["trailerLink"] . '" class="btn-trailer" target="_blank">Watch Trailer</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "No movies currently showing.";
        }

        $conn->close();
        ?>
    </div>
</section>

<!-- Upcoming Movies -->
<section>
    <h1 class="up">Upcoming Movies</h1>
    <div class="carousel-movies">
        <?php
        // PHP code to fetch and display upcoming movies
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM movies WHERE status = 'Upcoming'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="movie">';
                echo '<img src="' . $row["movieImage"] . '" alt="' . $row["movieName"] . '">';
                echo '<div class="overlay">';
                echo '<h3>' . $row["movieName"] . '</h3>';
                echo '<div class="buttons">';
                echo '<a href="' . $row["trailerLink"] . '" class="btn-trailer" target="_blank">Watch Trailer</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "No upcoming movies.";
        }

        $conn->close();
        ?>
    </div>
</section>

<!-- Footer -->
<footer>
        <div class="footercontainer">

            <div class="socialIcons">
                <a href=""><i class="fa-brands fa-facebook"></i></a>
                <a href=""><i class="fa-brands fa-instagram"></i></a>
                <a href=""><i class="fa-brands fa-twitter"></i></a>
            </div>

            <div class="footerNav">
                <ul>
                    <li><a href="./privacyPolicy.html">Privacy Policy</a></li>
                    <li><a href="./TermsandConditions.html">Terms and Conditions</a></li>
                    <li><a href="./TermsofUse.html">Services</a></li>
                    <li><a href="./contactus.html">Contact Us</a></li>
                    <li><a href="./feedback.html">Feedback</a></li>
                </ul>
            </div>
        </div>
        <div class="footerBottom">
            <p>Copyright &copy;2023; Designed by <samp class="designer">Savoy</samp></p>
        </div>
    </footer>

</body>
</html>
