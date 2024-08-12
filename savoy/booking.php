<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: Login.html');
    exit();
}

?>

<?php
if (isset($_GET["id"])) {

    $mid = $_GET["id"];


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

    $sql = "SELECT * FROM `movies` WHERE `id` = '" . $mid . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $movieName = $row["movieName"];
        $movieImage = $row["movieImage"];
        $movieDescription = $row["movieDescription"];
        $movieLanguages = $row["movieLanguage"];
        $showingDate = $row["showingDate"];
        $endingDate = $row["endingDate"];
        $showingTime1 = $row["showingTime1"];
        $showingTime2 = $row["showingTime2"];
        $showingTime3 = $row["showingTime3"];
        $dimension = $row["dimension"];
        $genre = $row["genre"];
        $rating = $row["rating"];
        $trailerLink = $row["trailerLink"];
        $status = $row["status"];
    } else {
        echo "No movies currently showing.";
    }

    // $conn->close();


?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" 
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="./style.css">
        <link rel="stylesheet" href="./footer.css">
        <title>Ticket Booking</title>

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

    </head>

    <style>

.body {
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
    text-align: center;
    margin-left: 50px;
    transition: 0.5s;
}

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

 /* Search bar */

.search-results {
            position: absolute;
            background: white;
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

        .abt-sc{
            display: flex;
            justify-content: center;
        }


        /* About Movie */

        .movie-bg {
            position: relative;
            width: 100%;
            height: 600px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            /* Ensure children are clipped to this container */
        }

        .blur-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('<?php echo $movieImage; ?>') center center no-repeat;
            background-size: cover;
            filter: blur(10px);
            /* Blur the background image */
            z-index: 1;
            /* Ensure the background stays behind other elements */
        }

        .movie-booking {
            position: relative;
            z-index: 2;
            /* Ensure the movie poster is above the blurred background */
            display: flex;
            height: 90%;
            justify-content: center;
            align-items: center;
        }

        .movie-booking img {
            height: 100%;
            /* Match the height of the movie-bg */
            max-width: auto;
            /* Maintain aspect ratio */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            /* Optional: Add a shadow to the poster */
        }

        .Booking-Content {
            position: absolute;
            bottom: 20px;
            /* Adjust as needed */
            left: 20px;
            /* Adjust as needed */
            padding: 10px;
            color: white;
            z-index: 1;
        }

        .Booking-Content h1 {
            margin: 0;
            font-size: 34px;
            /* Adjust as needed */
        }

        .Booking-Content button {
            margin-top: 10px;
            /* Space between elements */
            background-color: #600086;
            /* Button background color */
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 20px;
            padding: 8px 16px;
            cursor: pointer;
            transition: 0.4s;
        }

        .Booking-Content button:hover {
            background-color: #45005c;
            /* Darker color on hover */
            padding: 10px 18px;
        }

        /* Dates and Ranges */
        .abt-movie {
            color: #bbb;
            padding: 10px;
        }

        .abt-movie label{
            font-size: 23px;
            font-weight: bold;
        }

        .cast h1 {
            color: white;
            text-align: center;
            margin-bottom: 25px;
            padding-left: 10px;
        }

        .abt-cast {
            display: flex;
            flex-wrap: wrap;
            padding-left: 10px;
            justify-content: center;
            align-items: center;
            gap: 20px;
        }

        .cast-member {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-right: 15px;
            margin-bottom: 20px;
        }

        .cast-member img {
            background-color: #600086;
            height: 100px;
            width: 100px;
            border-radius: 50%;
            object-fit: cover;
        }

        .cast-member span {
            color: white;
            margin-top: 10px;
            text-align: center;
        }

        /* Dates and Ranges */
        .dates-ranges-bg {
            color: white;
            display: flex;
            font-weight: bold;
            background-color: transparent;
            width: 100%;
            height: 100px;
            justify-content: center;
            align-items: center;
            padding: 0 20px;
            text-align: center;
        }

        .dates-section {
            display: flex;
            align-items: center;
            padding-left: 20px;
            justify-content: flex-start;
            font-weight: bold;
            flex-grow: 1;
        }

        .dates-section div {
            margin: 0 10px;
        }

        .dates-section a {
            text-decoration: none;
            color: rgb(255, 255, 255);
            font-size: 20px;
            padding-right: 20px;
            transition: color 0.3s ease;
        }

        .dates-section a:hover {
            color: #600086;
            font-size: 25px;
        }


        .range-time-section {
            display: flex;
            align-items: center;
            padding-right: 60px;
        }


        .location h3 {
            color: white;
            padding-left: 15px;
            font-size: medium;
            font-size: 25px;
        }

        .Times {
            color: white;
            font-weight: bold;
            display: flex;
            padding: 30px;
            width: 500px;
            justify-content: flex-start;
        }

        .Times a {
            color: white;
            font-size: small;
            text-decoration: none;
            margin: 10px;
            transition: 0.4s;
            font-size: 20px;
            padding-right: 10px;
        }

        .Times a:hover {
            color: #ffffff;
            background-color: #600086;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            border-radius: 20px;
            font-weight: bolder;
            padding: 10px;
        }

        .showing-times-label {
            color: white;
            font-weight: bold;
            margin-right: 20px; 
        }

        .date_radio_group {
            display: flex;
            gap: 10px;
        }

        .date_radio_label {
            display: flex;
            justify-content: center;
            color: white;
            padding: 5px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.5s;
        }

        .date_radio_label:hover {
            background: #600086;
            scale: 1.5;
            transition: 0.5s;
        }

        .date_radio_group input:checked+.date_radio_label {
            background: #600086;
            scale: 1.5;
        }

        .date_radio_group input {
            display: none;
        }

        .bookBtnDiv {
            display: flex;
            justify-content: end;
            padding-right: 100px;
            padding-bottom: 100px;
        }

        .bookingBtn {
            padding: 10px;
            padding-left: 50px;
            padding-right: 50px;
            background: #600086;
            border: none;
            border-radius: 50px;
            color: white;
            cursor: pointer;
            transition: 0.5s;
            font-size: 32px;
        }

        .bookingBtn:hover {
            scale: 1.2;
            transition: 0.5s;
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

        <!--About Movie-->
        <section>
            <section>
                <div class="movie-bg">
                    <div class="blur-background"></div>

                    <div class="Booking-Content">
                        <h1><?php echo $movieName; ?></h1>
                        <a href="<?php echo $trailerLink; ?>"><button>Watch Trailer</button></a>

                    </div>

                    <div class="movie-booking">
                        <img src="<?php echo $movieImage; ?>" alt="Movie Poster">
                    </div>
                </div>
            </section>
        </section>

        <!--About Movie-->
        <section>
            <div class="abt">
                <div class="abt-movie">
                    <p><label>Description: </label> <?php echo $movieDescription; ?></p>
                    <p><label>Genre: </label> <?php echo $genre; ?> </p>
                    <p><label>Rating: </label> <?php echo $rating; ?> </p>
                </div>


                <div class="cast">
                    <h1>Cast</h1>

                    <div class="abt-cast">

                        <?php
                        $moiveCast_query = "SELECT * FROM `movie_casts` WHERE `movieId` = '" . $mid . "'";
                        $moiveCast_rs = $conn->query($moiveCast_query);

                        $moiveCast_num = $moiveCast_rs->num_rows;

                        for ($i = 0; $i < $moiveCast_num; $i++) {
                            $moiveCast_data = $moiveCast_rs->fetch_assoc();
                        ?>
                            <div class="cast-member">
                                <img src="<?php echo $moiveCast_data["castImage"]; ?>" alt="">
                                <span><?php echo $moiveCast_data["castName"]; ?></span>
                            </div>
                        <?php
                        }
                        ?>

                    </div>
                </div>
        </section>

        <hr>

        <!--Dates and Ranges-->
        <section>
            <div class="dates-ranges-bg">
            <span class="showing-dates-label">Showing dates:</span>
                <div class="dates-section">
                    <?php
                    $start_date = new DateTime($showingDate);
                    $end_date = new DateTime($endingDate);
                    $interval = DateInterval::createFromDateString('1 day');
                    $period = new DatePeriod($start_date, $interval, $end_date->modify('+1 day'));

                    foreach ($period as $date) {
                        $showing_date_str = $date->format("d");
                    ?>
                        <!-- <div>
                        <a href="./booking.php?id=<?php echo $row['id']; ?>"><?php echo $showing_date_str; ?></a>
                        </div> -->
                        <div class="date_radio_group">
                            <input type="radio" name="date" id="<?php echo $showing_date_str; ?>" value="<?php echo $showing_date_str; ?>">
                            <label for="<?php echo $showing_date_str; ?>" class="date_radio_label"><?php echo $showing_date_str; ?></label>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </section>

        <hr>

        <!--Location and Times-->
        <section>

            <div class="loc-time">
                <div class="location">
                    <br>
                    <h3><?php echo $movieLanguages; ?> <?php echo $dimension; ?></h3>
                </div>

                <div class="Times">
                <span class="showing-times-label">Showing times:</span>
                    <div class="date_radio_group">
                        <input type="radio" name="time" id="<?php echo $showingTime1; ?>" value="<?php echo $showingTime1; ?>">
                        <label for="<?php echo $showingTime1; ?>" class="date_radio_label"><?php echo $showingTime1; ?></label>
                    </div>
                    <div class="date_radio_group">
                        <input type="radio" name="time" id="<?php echo $showingTime2; ?>" value="<?php echo $showingTime2; ?>">
                        <label for="<?php echo $showingTime2; ?>" class="date_radio_label"><?php echo $showingTime2; ?></label>
                    </div>
                    <div class="date_radio_group">
                        <input type="radio" name="time" id="<?php echo $showingTime3; ?>" value="<?php echo $showingTime3; ?>">
                        <label for="<?php echo $showingTime3; ?>" class="date_radio_label"><?php echo $showingTime3; ?></label>
                    </div>

                    <!-- <a href="seat_booking.php?id=<?php echo $mid; ?>&date=<?php echo $date->format('Y-m-d'); ?>&time=<?php echo urlencode($showingTime1); ?>"><?php echo $showingTime1; ?></a>
                    <a href="seat_booking.php?id=<?php echo $mid; ?>&date=<?php echo $date->format('Y-m-d'); ?>&time=<?php echo urlencode($showingTime2); ?>"><?php echo $showingTime2; ?></a>
                    <a href="seat_booking.php?id=<?php echo $mid; ?>&date=<?php echo $date->format('Y-m-d'); ?>&time=<?php echo urlencode($showingTime3); ?>"><?php echo $showingTime3; ?></a> -->
                </div>

                <div class="bookBtnDiv">
                    <button onclick="getbookingdate(<?php echo $mid; ?>);" class="bookingBtn">Book</button>
                </div>
            </div>

        </section>

        <!-- footer -->
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

        <script>
            function getbookingdate(id) {
                const dateRadio = document.getElementsByName('date');
                const timeRadio = document.getElementsByName('time');

                let selectedDate = null;
                let selectedtime = null;

                for (let date of dateRadio) {
                    if (date.checked) {
                        selectedDate = date.value;
                        break;
                    }
                }

                for (let time of timeRadio) {
                    if (time.checked) {
                        selectedtime = time.value;
                        break;
                    }
                }

                if (selectedDate == null) {
                    alert("Please Select Date");
                } else if (selectedtime == null) {
                    alert("Please Select Time");
                } else {
                    window.location.href = "seat_booking.php?id=" + id+"&date="+selectedDate+"&time="+selectedtime;
                }
            }
        </script>

    </body>

    </html>
<?php
} else {
    header("location:Hoome.php");
}
?>
