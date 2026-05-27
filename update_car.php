<?php
// Update car info
$conn = new mysqli("localhost", "root", "", "car_maintenance_tracker");
if ($conn->connect_error) die("Connection failed: ".$conn->connect_error);

if (isset($_POST['car_id'])) {
    $id = intval($_POST['car_id']);
    $customer_id = intval($_POST['customer_id']);
    $make = $conn->real_escape_string($_POST['make']);
    $model = $conn->real_escape_string($_POST['model']);
    $car_year = intval($_POST['car_year']);
    $license_plate = $conn->real_escape_string($_POST['license_plate']);

    $conn->query("
        UPDATE car 
        SET customer_id=$customer_id, make='$make', model='$model', car_year=$car_year, license_plate='$license_plate'
        WHERE car_id=$id
    ");
}

header("Location: admin_dashboard.php");
exit();
?>