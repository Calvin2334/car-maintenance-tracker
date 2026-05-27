<?php
$conn = new mysqli("localhost", "root", "", "car_maintenance_tracker");

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];

// Check if email exists
$result = $conn->query("SELECT * FROM customer WHERE email='$email'");

if ($result->num_rows > 0) {

    $customer = $result->fetch_assoc();

    // Customer exists but has no password yet
    if ($customer['password'] == NULL || $customer['password'] == '') {

        $conn->query("
        UPDATE customer
        SET 
            first_name='$first_name',
            last_name='$last_name',
            phone='$phone',
            password='$password'
        WHERE email='$email'
        ");

        echo "Password created successfully! 
        <a href='customer_login.php'>Login here</a>";

    } else {

        echo "Account already exists. 
        <a href='customer_login.php'>Login here</a>";
    }

} else {

    // Completely new customer
    $conn->query("
    INSERT INTO customer (first_name, last_name, email, phone, password)
    VALUES ('$first_name', '$last_name', '$email', '$phone', '$password')
    ");

    echo "Account created! 
    <a href='customer_login.php'>Login</a>";
}
?>