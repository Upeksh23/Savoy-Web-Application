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

$sql = "SELECT * FROM promotions";
$result = $conn->query($sql);

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
    <title>Promotions</title>

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
    background-color: black;
    overflow-x: hidden;
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
}

/*Nav Bar*/
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: rgba(255, 255, 255, 0.2); 
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
    transition: 0.3s;
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
    padding: 8px;
    margin-right: 10px;
}

/* Search bar */

.search-results {
        position: absolute;
        background: white;
        border: 1px solid #ccc;
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

.search-bar input {
    background-color: transparent;
    height: 20px;
    border-radius: 10px;
    border-color: black;
    color: white;
    padding: 5px;
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


        .bdy {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;

        }
        .promotion {
            background: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
            margin: 20px;
            width: 300px;
            text-align: center;
        }
        .promotion img {
            width: 100%;
            height: auto;
        }
        .promotion-details {
            padding: 15px;
        }
        .promotion-details h2 {
            font-size: 20px;
            margin: 0;
            color: #333;
        }
        .promotion-details p {
            font-size: 16px;
            margin: 10px 0;
            color: #777;
        }
        .promotion-details .discount {
            font-size: 24px;
            color: #e74c3c;
        }

    </style>
</head>
<body>

<!-- Navigation bar -->
<section>
            <nav class="navbar">

                <div class="left">
                    <a href="#"><img src="./uploads/icons/savoy.png" alt="Logo" class="logo"></a>
                </div>

                <div class="center">
                    <a href="./Index.php">Home</a>
                    <a href="./Aboutus.html">About Us</a>
                    <a href="./promotion.php">Promotions</a>
                </div>

                <div class="right">
                    <div class="profile-buttons">
                        <a href="./Signup.html" class="profile-button">Sign Up</a>
                        <a href="./Login.html" class="profile-button">Login</a>
                    </div>
                </div>

            </nav>
        </section>
    
    <!-- Promotions Section -->
    <div class="bdy">
        <?php
        // Check if there are promotions to display
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="promotion">
                    <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>">
                    <div class="promotion-details">
                        <h2><?php echo $row['title']; ?></h2>
                        <p><?php echo $row['description']; ?></p>
                        <p class="discount"><?php echo $row['discount']; ?></p>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "No promotions available.";
        }
        $conn->close();
        ?>
    </div>

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
                </ul>
            </div>
        </div>
        <div class="footerBottom">
            <p>Copyright &copy;2023; Designed by <samp class="designer">Savoy</samp></p>
        </div>
    </footer>

</body>
</html>
