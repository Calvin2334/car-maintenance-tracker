<?php
// Delete a car
$conn = new mysqli("localhost", "root", "", "car_maintenance_tracker");
if ($conn->connect_error) die("Connection failed: ".$conn->connect_error);

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM car WHERE car_id=$id");
}

header("Location: admin_dashboard.php");
exit();
?>