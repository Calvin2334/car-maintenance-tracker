<?php
$conn = new mysqli("localhost", "root", "", "car_maintenance_tracker");

$id = $_POST['service_id'];
$service_name = $_POST['service_name'];
$time_to_complete = $_POST['time_to_complete'];
$service_description = $_POST['service_description'];

$conn->query("
    UPDATE services 
    SET 
        service_name='$service_name',
        time_to_complete='$time_to_complete',
        service_description='$service_description'
    WHERE service_id=$id
");

header("Location: admin_dashboard.php");
exit();
?>