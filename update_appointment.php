<?php
$conn = new mysqli("localhost", "root", "", "car_maintenance_tracker");
include 'functions.php';

if ($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

$id = (int)$_POST['appointment_id'];
$status = $_POST['car_status'];
$completion_date = $_POST['completion_date'];
$completion_time = $_POST['completion_time'];
$labor_cost = (float)$_POST['labor_cost'];

// 1. Update base appointment data
$conn->query("
UPDATE appointment 
SET
car_status='$status',
completion_date='$completion_date',
completion_time='$completion_time',
labor_cost=$labor_cost
WHERE appointment_id=$id
");

// 2. Auto calculate total
$total = calculateTotalCost($conn, $id);

// 3. Save total
$conn->query("
UPDATE appointment
SET total_cost = $total
WHERE appointment_id = $id
");

header("Location: admin_dashboard.php");
exit();
?>