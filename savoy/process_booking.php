<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uid = $_SESSION["user_id"];
    $mid = $_POST['mid'];
    $date = $_POST['date'];
    $btime = $_POST['btime'];
    $parkingSlot = $_POST['parkingSlot'];
    $seats = isset($_POST['seats']) ? $_POST['seats'] : [];
    $booking_date = date('Y-m-d H:i:s');

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "savoy_cinema";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM `movies` WHERE `id` = '" . $mid . "'";
    $result = $conn->query($sql);

    $stmt = $conn->prepare("INSERT INTO `booking` (`moive_id`, `date`, `time`,`parking_slots`,`users_id`,`booking_date`) VALUES (?, ?, ?,?,?,?)");
    $stmt->bind_param("ssssss", $mid, $date, $btime, $parkingSlot, $uid,$booking_date);

    if ($stmt->execute()) {
        $booking_id = $stmt->insert_id;
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO `booking_seat` (`booking_id`, `seat_id`) VALUES (?, ?)");
        foreach ($seats as $seat_id) {
            $stmt->bind_param("ii", $booking_id, $seat_id);
            $stmt->execute();
        }
        $stmt->close();

        echo "Booking successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
