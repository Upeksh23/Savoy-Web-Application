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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./admin.css">
    <title>Document</title>
</head>

<style>
    body {
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
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
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

    /* Booking Details */

    .bk-heading {
        display: flex;
        justify-content: center;
        color: white;
    }


    table {
        width: 300%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th,
    td {
        border: 5px solid #ccc;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: rgba(0, 0, 37, 0.684);
        color: white;
        text-align: center;
    }
</style>

<body>

    <!--Header-->
    <section>
        <div class="Header">
            <div class="nav-bar">
                <div class="dropdown">
                    <a href="#"><img src="./uploads/icons/list.png" alt="Menu"></a>
                    <div class="dropdown-content">
                        <a href="./adminpanel.php">Home</a>
                        <a href="./addmovies.html">Add Movies</a>
                        <a href="./staffSignup.html">Create Staff Account</a>
                        <a href="./CheckBookings.html">Check Bookings</a>
                        <a href="./addPromotions.html">Add Promotions</a>
                        <a href="./view_feedback.php">View Feedbacks</a>
                    </div>
                </div>
            </div>
            <div class="logout">
                <a href="./Index.php">Logout</a>
            </div>
        </div>
    </section>


    <div class="bk-heading">
        <h1>Booking Details</h1>
    </div>


    <table>
        <thead>
            <tr>
                <th>Date of Booking</th>
                <th>Customer Name</th>
                <th>Customer Phone number</th>
                <th>Movie Name</th>
                <th>Movie Date</th>
                <th>Movie Time</th>
                <th>Movie Dimension</th>
                <th>No of Seats</th>
                <th>No of Parking Spaces</th>
                <th>Total Price</th>
                <th>Manage</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT `booking`.`id`,`booking`.`booking_date`, `users`.`name`,`users`.`phone_number`,`movies`.`movieName`,`booking`.`date`, `booking`.`time`,`movies`.`dimension`,`booking`.`parking_slots` FROM `booking` INNER JOIN `users` ON `booking`.`users_id`=`users`.`id` INNER JOIN `movies` ON `booking`.`moive_id`=`movies`.`id` ";
            $bookig_rs = $conn->query($sql);

            $bookig_num=$bookig_rs->num_rows;

            for($i=0;$i<$bookig_num;$i++){
                $bookig_data=$bookig_rs->fetch_assoc();

                $seatcount_rs=$conn->query("SELECT COUNT(id) AS `seat_num` FROM `booking_seat` WHERE `booking_id`='".$bookig_data["id"]."'");
                $seatcount_data = $seatcount_rs->fetch_assoc();

                $totalPrice = $seatcount_data["seat_num"]*500;
                ?>
                <tr>
                <th><?php echo $bookig_data["booking_date"]; ?></th>
                <th><?php echo $bookig_data["name"]; ?></th>
                <th><?php echo $bookig_data["phone_number"]; ?></th>
                <th><?php echo $bookig_data["movieName"]; ?></th>
                <th><?php echo $bookig_data["date"]; ?></th>
                <th><?php echo $bookig_data["time"]; ?></th>
                <th><?php echo $bookig_data["dimension"]; ?></th>
                <th><?php echo $seatcount_data["seat_num"]; ?></th>
                <th><?php echo $bookig_data["parking_slots"]; ?></th>
                <th><?php echo $totalPrice; ?></th>
                <th><button>status</button></th>

                <th>
                    <form method="POST" action="delete_booking.php">
                        <input type="hidden" name="booking_id" value="<?php echo $bookig_data['id']; ?>">
                        <button type="submit">Delete</button>
                    </form>
                </th>
                
            </tr>
                <?php
            }
            ?>
        </tbody>
    </table>


</body>

</html>
