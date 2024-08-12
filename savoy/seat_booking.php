<?php
if (isset($_GET["id"])) {

    $mid = $_GET["id"];
    $bdate = $_GET["date"];
    $btime = $_GET["time"];


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
        <link rel="stylesheet" href="footer.css">
        <link rel="stylesheet" href="./style.css">
        <title>Seat Booking</title>
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
    overflow-x: hidden;
}

        /* Search bar */

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
        /* Seat Booking */

        .Booking-box {
            text-align: center;
        }

        .Booking-box h1 {
            color: #ddd;
        }

        .screen {
            background-color: #333;
            height: 400px;
            width: 80%;
            margin: 20px auto;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        .screen::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: url('<?php echo $movieImage; ?>') center/cover no-repeat;
            filter: blur(8px);
            z-index: 1;
            opacity: 0.5;
        }

        .screen img {
            height: 90%;
            position: relative;
            z-index: 2;
            border-radius: 10px;
        }

        .seat-box {
            display: flex;
            width: 100%;
            height: auto;
            padding: 20px;
            justify-content: center;
            gap: 50px;
        }

        .left-seats {
            width: 200px;
            height: auto;
        }

        .middle-seats {
            width: 350px;
            height: auto;
        }

        .right-seats {
            width: 200px;
            height: auto;
        }

        .seat-rows {
            display: flex;
            padding-top: 10px;
        }

        .seat {
            display: flex;
            background-color: #fffdfd;
            height: 30px;
            width: 40px;
            margin: 3px;
            border-radius: 5px;
            cursor: pointer;
            justify-content: center;
            align-items: center;
            transition: background-color 0.3s;
        }

        .seat.selected {
            background-color: #600086;
        }

        .seat:hover {
            background-color: #bd58e6;
        }

        /* .seatRow{
    display: grid;
} */

        .seatDiv {
            width: 15px;
            display: inline-block;
            /* padding: 10px; */
            width: 30px;
            height: 30px;
            padding-top: 5px;
            background-color: #fffdfd;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 3px;
            transition: background-color 0.3s;
        }

        .seatCheckBox {
            display: none;
        }

        .seatDiv:hover {
            background-color: #bd58e6;
            transition: 0.5s;
        }

        .seatCheckBox:checked+.seatDiv {
            background-color: #bd58e6;
        }

        .parkDiv {
            margin-top: 50px;
            margin-bottom: 30px;
        }

        .parkingSlotInput {
            padding-left: 20px;
            width: 300px;
            height: 30px;
        }

        .bookingSubmitBtn {
            color: white;
            height: 40px;
            border-radius: 50px;
            background: #bd58e6;
            padding-left: 80px;
            padding-right: 80px;
            margin-bottom: 50px;
            cursor: pointer;
            transition: 0.5s;
        }

        .bookingSubmitBtn:hover {
            scale: 1.2;
            transition: 0.5s;
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
    </style>

    <body>
  <!-- Navigation bar -->
        <section>
            <nav class="navbar">

                <div class="left">
                <a href="#"><img src="./uploads/icons/savoy.png" alt="Logo" class="logo"></a>
                </div>

                <div class="center">
                    <a href="./index.php">Home</a>
                    <a href="./Aboutus.html">About Us</a>
                    <a href="./promotion.php">Promotions</a>
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


        <div class="Booking-box">
            <h1>Book Your Seat</h1>

            <!--Screen-->
            <div class="screen">
                <img src="<?php echo $movieImage; ?>" alt="">
            </div>

            <!--About Seats-->
            <div class="abt-seats">
                <div class="Available-seats">
                    <div></div>
                    <p>Available</p>
                </div>

                <div class="Booked-seats">
                    <div></div>
                    <p>Booked</p>
                </div>

                <div class="Unavailable-seats">
                    <div></div>
                    <p>Unavailable</p>
                </div>
            </div>

            <div class="seat-box">
                <div class="left-seats">

                    <?php

                    $bookedSeats_query = "SELECT `booking_seat`.`seat_id` FROM `booking` INNER JOIN `booking_seat` ON `booking`.`id`=`booking_seat`.`booking_id` WHERE `booking`.`date`='" . $bdate . "' AND `booking`.`time`='" . $btime . "'";
                    $bookedSeats_rs = $conn->query($bookedSeats_query);
                    $bookedSeats = [];

                    while ($row = $bookedSeats_rs->fetch_assoc()) {
                        $bookedSeats[] = $row['seat_id'];
                    }

                    $leftSeats_query = "SELECT * FROM `seat` WHERE `seat_type_id`='1'";
                    $leftSeats_rs = $conn->query($leftSeats_query);

                    $leftSeats_num = $leftSeats_rs->num_rows;

                    for ($i = 0; $i < $leftSeats_num; $i++) {
                        $leftSeats_data = $leftSeats_rs->fetch_assoc();
                        $seat_id = $leftSeats_data["id"];
                        $isBooked = in_array($seat_id, $bookedSeats);

                        if ($isBooked) {
                    ?>
                            <label style="background-color: #600086;" class="seatDiv" for="<?php echo $leftSeats_data["id"]; ?>"><?php echo $leftSeats_data["name"]; ?></label>
                        <?php
                        } else {
                        ?>
                            <input class="seatCheckBox" type="checkbox" id="<?php echo $leftSeats_data["id"]; ?>" name="seats" value="<?php echo $leftSeats_data["id"]; ?>" onchange="updateTotalPrice(this)">
                            <label class="seatDiv" for="<?php echo $leftSeats_data["id"]; ?>"><?php echo $leftSeats_data["name"]; ?></label>
                    <?php
                        }
                    }
                    ?>

                </div>

                <div class="middle-seats">
                    <?php
                    $leftSeats_query = "SELECT * FROM `seat` WHERE `seat_type_id`='2'";
                    $leftSeats_rs = $conn->query($leftSeats_query);

                    $leftSeats_num = $leftSeats_rs->num_rows;

                    for ($i = 0; $i < $leftSeats_num; $i++) {
                        $leftSeats_data = $leftSeats_rs->fetch_assoc();
                        $seat_id = $leftSeats_data["id"];
                        $isBooked = in_array($seat_id, $bookedSeats);

                        if ($isBooked) {
                    ?>
                            <label style="background-color: #600086;" class="seatDiv" for="<?php echo $leftSeats_data["id"]; ?>"><?php echo $leftSeats_data["name"]; ?></label>
                        <?php
                        } else {
                        ?>
                            <input class="seatCheckBox" type="checkbox" id="<?php echo $leftSeats_data["id"]; ?>" name="seats" value="<?php echo $leftSeats_data["id"]; ?>" onchange="updateTotalPrice(this)">
                            <label class="seatDiv" for="<?php echo $leftSeats_data["id"]; ?>"><?php echo $leftSeats_data["name"]; ?></label>
                    <?php
                        }
                    }
                    ?>
                </div>

                <div class="right-seats">
                    <?php
                    $leftSeats_query = "SELECT * FROM `seat` WHERE `seat_type_id`='3'";
                    $leftSeats_rs = $conn->query($leftSeats_query);

                    $leftSeats_num = $leftSeats_rs->num_rows;

                    for ($i = 0; $i < $leftSeats_num; $i++) {
                        $leftSeats_data = $leftSeats_rs->fetch_assoc();
                        $seat_id = $leftSeats_data["id"];
                        $isBooked = in_array($seat_id, $bookedSeats);

                        if ($isBooked) {
                    ?>
                            <label style="background-color: #600086;" class="seatDiv" for="<?php echo $leftSeats_data["id"]; ?>"><?php echo $leftSeats_data["name"]; ?></label>
                        <?php
                        } else {
                        ?>
                            <input class="seatCheckBox" type="checkbox" id="<?php echo $leftSeats_data["id"]; ?>" name="seats" value="<?php echo $leftSeats_data["id"]; ?>" onchange="updateTotalPrice(this)">
                            <label class="seatDiv" for="<?php echo $leftSeats_data["id"]; ?>"><?php echo $leftSeats_data["name"]; ?></label>
                    <?php
                        }
                    }
                    ?>
                </div>

            </div>

            <hr>

            <div class="parkDiv">
                <label for="parkinSlot" style="color: white;">Parking Slots</label>
                <input class="parkingSlotInput" id="parkinSlot" type="number" value="0" placeholder="Enter Parking Solts" min="0" />
            </div>

            <div class="parkDiv">
                <span style="color: white; font-size: 32px;">Total Price : Rs. <span style="font-weight: bold;" id="totalPrice">00</span> /=</span>
            </div>

            <label id="btime" style="display: none;"><?php echo $btime; ?></label>
            <button class="bookingSubmitBtn" onclick="submitBooking(<?php echo $mid; ?>,<?php echo $bdate; ?>);">Submit Booking</button>
    

            <script src="script.js"></script>
        </div>

        <!-- footer -->
        <section>
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
        </section>

        <script>
            const seatPrice = 500;

            function updateTotalPrice(checkbox) {
                let totalPriceElement = document.getElementById('totalPrice');
                let totalPrice = parseInt(totalPriceElement.innerText);

                if (checkbox.checked) {
                    totalPrice += seatPrice;
                } else {
                    totalPrice -= seatPrice;
                }

                totalPriceElement.innerText = totalPrice;
            }

            function submitBooking(mid, date) {
                let btimel = document.getElementById("btime");
                let btime = btimel.innerHTML;
                const parkingSlot = document.getElementById("parkinSlot").value;

                const checkboxes = document.querySelectorAll('input[name="seats"]:checked');
                const selectedValues = [];

                checkboxes.forEach((checkbox) => {
                    selectedValues.push(checkbox.value);
                });

                if (selectedValues.length === 0) {
                    alert('Please select at least one seat.');
                } else if (parkingSlot < 0) {
                    alert("Please Enter Valide PArking Slots");
                } else {
                    const formData = new FormData();
                    formData.append('mid', mid);
                    formData.append('date', date);
                    formData.append('btime', btime);
                    formData.append('parkingSlot', parkingSlot);
                    selectedValues.forEach(value => formData.append('seats[]', value));

                    // Send the data using Fetch API
                    fetch('process_booking.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.text())
                        .then(data => {
                            // Display the result from the PHP script
                            alert(data);
                            window.location.reload();
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }

                // document.getElementById('result').innerText = selectedValues.length > 0 ? 
                //     `Selected values: ${selectedValues.join(', ')}` : 'No options selected';


            }
        </script>
    </body>

    </html>
<?php
}
?>
