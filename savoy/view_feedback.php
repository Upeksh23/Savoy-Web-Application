<?php
// Database credentials
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

// Fetch feedbacks from the database
$sql = "SELECT user_id, name, feedback, created_at FROM feedback ORDER BY created_at DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedbacks</title>



    <style>
body {
    font-family: Arial, sans-serif;
    background-color: #000000;
    margin: 0;
    padding: 0;
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
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #635e5e5f;
    min-width: 160px;
    border-radius: 20px;
    gap: 5px;
    padding: 10px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    transition: 0.3s;
}

.dropdown-content a {
    color: rgb(255, 255, 255);
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: #600086;
    border-radius: 20px;
    color: white;
    font-size: larger;
}

.dropdown:hover .dropdown-content {
    display: block;
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
    background-color: #600086;
    color: white;
}

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #f0f0f0;
            margin-bottom: 20px;
            border-bottom: 2px solid #600086;
            padding-bottom: 10px;
        }

        .feedback-box {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
        }

        .feedback-box h2 {
            margin: 0;
            font-size: 20px;
            color: white;
        }

        .feedback-box p {
            margin: 10px 0 0;
            color: #f0f0f0;
        }

        .feedback-box .date {
            font-size: 14px;
            color: #777777;
        }


    </style>
</head>
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
                        <a href="./addPromotions.html">Add Promotions</a>
                        <a href="./staffSignup.html">Create Staff Account</a>
                        <a href="./CheckBookings.php">Check Bookings</a>
                        <a href="./view_feedback.php">View Feedbacks</a>
                    </div>
                </div>
            </div>
            <div class="logout">
                <a href="./Index.php">Logout</a>
            </div>
        </div>
    </section>

<div class="container">
    <h1>Feedbacks</h1>
    <?php
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<div class='feedback-box'>";
            echo "<h2>" . htmlspecialchars($row['name']) . "</h2>";
            echo "<p>" . htmlspecialchars($row['feedback']) . "</p>";
            echo "<p class='date'>" . htmlspecialchars($row['created_at']) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No feedbacks found.</p>";
    }
    $conn->close();
    ?>
</div>
</body>
</html>
