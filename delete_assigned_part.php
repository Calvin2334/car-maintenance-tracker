<?php 
$conn = new mysqli("localhost", "root", "", "car_maintenance_tracker");

$appointment_id = $_GET['appointment_id'];
$part_id = $_GET['part_id'];

$conn->query("
DELETE FROM appointment_parts
WHERE appointment_id = $appointment_id AND part_id = $part_id
");

header("Location: admin_dashboard.php");
exit();
?>