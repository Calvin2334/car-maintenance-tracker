<?php
$conn = new mysqli("localhost", "root", "", "car_maintenance_tracker");

$id = $_GET['id'];
$conn->query("DELETE FROM services WHERE service_id=$id");

header("Location: admin_dashboard.php");
exit();
?>