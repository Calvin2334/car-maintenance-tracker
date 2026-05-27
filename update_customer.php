<?php
// Update customer info
$conn = new mysqli("localhost", "root", "", "car_maintenance_tracker");
if ($conn->connect_error) die("Connection failed: ".$conn->connect_error);

if (isset($_POST['customer_id'])) {
    $id = intval($_POST['customer_id']);
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);

    $conn->query("
        UPDATE customer 
        SET first_name='$first_name', last_name='$last_name', email='$email', phone='$phone'
        WHERE customer_id=$id
    ");
}

header("Location: admin_dashboard.php");
exit();
?>