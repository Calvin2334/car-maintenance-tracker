<?php
$conn = new mysqli("localhost", "root", "", "car_maintenance_tracker");

include 'functions.php';

if ($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

$appointment_id = (int)$_POST['appointment_id'];
$part_id = (int)$_POST['part_id'];
$quantity = (int)$_POST['quantity'];

// insert part
$conn->query("
INSERT INTO appointment_part (appointment_id, part_id, quantity)
VALUES ($appointment_id, $part_id, $quantity)
");

// auto update total after adding part
$total = calculateTotalCost($conn, $appointment_id);

$conn->query("
UPDATE appointment
SET total_cost = $total
WHERE appointment_id = $appointment_id
");

header("Location: admin_dashboard.php");
exit();
?>