<?php
session_start();

$conn = new mysqli("localhost", "root", "", "car_maintenance_tracker");

if ($conn->connect_error){
	die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$sql = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
$result = $conn->query($sql);

if ($result && $result->num_rows === 1){
	$admin = $result->fetch_assoc();
	$_SESSION['admin_id'] = $admin['admin_id'];
	$_SESSION['username'] = $admin['username'];
	
	header("Location: admin_dashboard.php");
	exit();
} else {
	header("Location: admin_login.php?error=1");
	exit();
}
?>