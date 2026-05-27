<?php
session_start();
$conn = new mysqli("localhost", "root", "", "car_maintenance_tracker");

$appointment_id = $_POST['appointment_id'];

$conn->query("
UPDATE appointment 
SET car_status = 'Cancelled'
WHERE appointment_id = $appointment_id
");

// Noti
$conn->query("
INSERT INTO notifications (message)
VALUES ('Appointment ID $appointment_id was cancelled')
");

header("Location: customer_dashboard.php");
exit();
?>