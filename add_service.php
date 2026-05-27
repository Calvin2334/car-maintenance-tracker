<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: admin_login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "car_maintenance_tracker");
if ($conn->connect_error) die("Connection failed: ".$conn->connect_error);

$appointment_id = $_POST['appointment_id'];
$service_name = $_POST['service_name'];
$time_to_complete = $_POST['time_to_complete'];
$service_description = $_POST['service_description'];

$conn->query("
    INSERT INTO services (appointment_id, service_name, time_to_complete, service_description)
    VALUES ('$appointment_id', '$service_name', '$time_to_complete', '$service_description')
");

header("Location: admin_dashboard.php");
exit();
?>