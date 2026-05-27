<?php
session_start();

$conn = new mysqli("localhost", "root", "", "car_maintenance_tracker");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM customer WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();

    if ($row['password'] == $password) {

        $_SESSION['customer_id'] = $row['customer_id'];

        header("Location: customer_dashboard.php");
        exit();

    } else {
        echo "Incorrect password";
    }

} else {
    echo "No account found";
}
?>