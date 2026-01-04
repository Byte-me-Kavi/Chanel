<?php
// Database connection
$host = "localhost";
$user = "root";      // your DB username
$pass = "";          // your DB password
$dbname = "chanel_db";  // your DB name

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Save postal code
if (isset($_POST['save_postal']) && !empty($_POST['postal_code'])) {
    $postal = $conn->real_escape_string($_POST['postal_code']);
    $sql = "INSERT INTO store_search (postal_code) VALUES ('$postal')";
    if ($conn->query($sql)) {
        echo "Postal code saved successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Save email
if (isset($_POST['save_email']) && !empty($_POST['email'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $sql = "INSERT INTO newsletter (email) VALUES ('$email')";
    if ($conn->query($sql)) {
        echo "Email saved successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>



