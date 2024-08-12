<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user ID from session
    $user_id = $_SESSION['user_id'];

    // Get feedback from POST request
    $feedback = $_POST['feedback'];

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

    // Fetch user's name from the database
    $stmt = $conn->prepare("SELECT name FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($name);
    $stmt->fetch();
    $stmt->close();

    if ($name) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO feedback (user_id, name, feedback) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $name, $feedback);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<!DOCTYPE html>
                  <html lang='en'>
                  <head>
                      <meta charset='UTF-8'>
                      <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                      <title>Feedback</title>
                      <style>
                          body {
                              font-family: Arial, sans-serif;
                              background-color: black;
                              margin: 0;
                              display: flex;
                              justify-content: center;
                              align-items: center;
                              height: 100vh;
                          }

                        

                          .thank-you {
                              text-align: center;
                              color: #600086;
                              font-size: 24px;
                          }

                      </style>
                      <script>
                          setTimeout(function(){
                              window.location.href = 'index.php';
                          }, 300); // 0.3 seconds
                        </script>
                  </head>
                  <body>
                      <div class='thank-you'>
                          Thank you for your feedback!
                      </div>
                  </body>
                  </html>";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "User not found.";
    }
} else {
    header('Location: feedback.html');
    exit();
}
?>
