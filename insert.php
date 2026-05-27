<?php
$conn = new mysqli("localhost", "root", "", "car_maintenance_tracker");

if ($conn->connect_error){
	die("connection failed: " .$conn->connect_error);
}


//Getting Post Values 
$first_name = $_POST['first_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';
$phone = $_POST['phone'] ?? '';
$email = $_POST['email'] ?? '';

$make = $_POST['make'] ?? '';
$model = $_POST['model'] ?? '';
$license_plate = $_POST['license_plate'] ?? '';


$appointment_date = $_POST['appointment_date'] ?? '';
$appointment_time = $_POST['appointment_time'] ?? '';

$year = isset($_POST['year']) ? (int)$_POST['year'] : null;

if($year <=0 ){
	die("Invalid year provided.");
}


//Customer Insert 
$conn->query("INSERT INTO customer(first_name, last_name, phone, email)
VALUES ('$first_name', '$last_name', '$phone', '$email')");

$customer_id = $conn->insert_id;

//Car Insert
$conn->query("INSERT INTO car (customer_id, make, model, car_year, license_plate)
VALUES ($customer_id, '$make', '$model', $year, '$license_plate')");

$car_id = $conn->insert_id;


//Appointment Insert 
$conn->query("INSERT INTO appointment (car_id,appointment_date, appointment_time, car_status)
VALUES($car_id, '$appointment_date', '$appointment_time', 'Pending')");

// Format date and time
$formatted_date = date("F j, Y", strtotime($appointment_date));
$formatted_time = date("g:i A", strtotime($appointment_time));

// Output
echo "<h2>Appointment booked!</h2>";
echo "<p>Customer: $first_name $last_name</p>";
echo "<p>Car: $make $model ($year)</p>";
echo "<p>Appointment: $formatted_date at $formatted_time</p>";

?>
