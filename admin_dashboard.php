<?php
include 'functions.php';

session_start();

// Redirect if admin not logged in
if(!isset($_SESSION['admin_id'])){
    header("Location: admin_login.php");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "car_maintenance_tracker");
if ($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
}

// 🔔 Notifications
$notifications = $conn->query("
SELECT * FROM notifications 
WHERE is_read = 0 
ORDER BY created_at DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        table{
            border-collapse: collapse;
            margin: 20px auto;
            width: 90%;
        }
        th, td{
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        th{
            background-color: #ccc;
        }
        h2{
            text-align: center;
        }
    </style>
</head>
<body>

<h1 style="text-align:center;">Welcome, <?php echo $_SESSION['username']; ?>!</h1>
<a href="logout.php" style="display:block; text-align:center;">Logout</a>

<!-- 🔔 NOTIFICATIONS -->
<h2>Notifications</h2>
<?php
if($notifications->num_rows > 0){
    while($n = $notifications->fetch_assoc()){
        echo "<div style='background:#fff3cd; padding:10px; margin:10px auto; width:80%; border:1px solid #ffeeba;'>
            🔔 ".$n['message']."<br>
            <small>".$n['created_at']."</small>
        </div>";
    }
} else {
    echo "<p style='text-align:center;'>No new notifications</p>";
}
?>

<!-- Customers -->
<h2>Customers</h2>
<table>
<tr><th>ID</th><th>First</th><th>Last</th><th>Email</th><th>Phone</th><th>Action</th></tr>
<?php
$result = $conn->query("SELECT * FROM customer");
while($row = $result->fetch_assoc()){
    echo "<tr><form action='update_customer.php' method='POST'>";
    echo "<td>".$row['customer_id']."<input type='hidden' name='customer_id' value='".$row['customer_id']."'></td>";
    echo "<td><input name='first_name' value='".$row['first_name']."'></td>";
    echo "<td><input name='last_name' value='".$row['last_name']."'></td>";
    echo "<td><input name='email' value='".$row['email']."'></td>";
    echo "<td><input name='phone' value='".$row['phone']."'></td>";
    echo "<td><button>Update</button> | 
          <a href='delete_customer.php?id=".$row['customer_id']."' onclick=\"return confirm('Delete?');\">Delete</a></td>";
    echo "</form></tr>";
}
?>
</table>

<!-- Cars -->
<h2>Cars</h2>
<table>
<tr><th>ID</th><th>Customer</th><th>Make</th><th>Model</th><th>Year</th><th>Plate</th><th>Action</th></tr>
<?php
$result = $conn->query("SELECT * FROM car");
while($row = $result->fetch_assoc()){
    echo "<tr><form action='update_car.php' method='POST'>";
    echo "<td>".$row['car_id']."<input type='hidden' name='car_id'></td>";
    echo "<td><input name='customer_id' value='".$row['customer_id']."'></td>";
    echo "<td><input name='make' value='".$row['make']."'></td>";
    echo "<td><input name='model' value='".$row['model']."'></td>";
    echo "<td><input name='car_year' value='".$row['car_year']."'></td>";
    echo "<td><input name='license_plate' value='".$row['license_plate']."'></td>";
    echo "<td><button>Update</button> | 
          <a href='delete_car.php?id=".$row['car_id']."'>Delete</a></td>";
    echo "</form></tr>";
}
?>
</table>

<!-- Appointments -->
<h2>Appointments</h2>
<table>
<tr>
<th>ID</th><th>Car</th><th>Date</th><th>Time</th><th>Status</th>
<th>Complete Date</th><th>Complete Time</th><th>Labor</th><th>Total</th><th>Action</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM appointment");
while($row = $result->fetch_assoc()){
    echo "<tr><form action='update_appointment.php' method='POST'>";
    echo "<td>".$row['appointment_id']."<input type='hidden' name='appointment_id' value='".$row['appointment_id']."'></td>";
    echo "<td>".$row['car_id']."</td>";
    echo "<td>".$row['appointment_date']."</td>";
    echo "<td>".date("h:i A", strtotime($row['appointment_time']))."</td>";

    echo "<td>
    <select name='car_status'>
        <option ".($row['car_status']=="Pending"?"selected":"").">Pending</option>
        <option ".($row['car_status']=="In Progress"?"selected":"").">In Progress</option>
        <option ".($row['car_status']=="Completed"?"selected":"").">Completed</option>
        <option ".($row['car_status']=="Cancelled"?"selected":"").">Cancelled</option>
    </select></td>";

    echo "<td><input type='date' name='completion_date' value='".$row['completion_date']."'></td>";
    echo "<td><input type='time' name='completion_time' value='".$row['completion_time']."'></td>";
    echo "<td><input name='labor_cost' value='".$row['labor_cost']."'></td>";
    echo "<td>".$row['total_cost']."</td>";
    echo "<td><button>Update</button></td>";
    echo "</form></tr>";
}
?>
</table>

<!-- Add Service -->
<h2>Add Service</h2>
<form action="add_service.php" method="POST" style="text-align:center;">
Appointment ID: <input name="appointment_id" required>
Service Name: <input name="service_name" required>
Time: <input name="time_to_complete">
Description: <input name="service_description">
<button>Add</button>
</form>

<!-- Services -->
<h2>Services</h2>
<table>
<tr><th>ID</th><th>Customer</th><th>Car</th><th>Service</th><th>Time</th><th>Desc</th><th>Action</th></tr>

<?php
$services = $conn->query("
SELECT s.*, c.first_name, c.last_name, car.make, car.model
FROM services s
JOIN appointment a ON s.appointment_id = a.appointment_id
JOIN car ON a.car_id = car.car_id
JOIN customer c ON car.customer_id = c.customer_id
");

while($row = $services->fetch_assoc()){
    echo "<tr><form action='update_service.php' method='POST'>";
    echo "<td>".$row['service_id']."<input type='hidden' name='service_id'></td>";
    echo "<td>".$row['first_name']." ".$row['last_name']."</td>";
    echo "<td>".$row['make']." ".$row['model']."</td>";
    echo "<td><input name='service_name' value='".$row['service_name']."'></td>";
    echo "<td><input name='time_to_complete' value='".$row['time_to_complete']."'></td>";
    echo "<td><input name='service_description' value='".$row['service_description']."'></td>";
    echo "<td><button>Update</button> | 
          <a href='delete_service.php?id=".$row['service_id']."'>Delete</a></td>";
    echo "</form></tr>";
}
?>
</table>

<!-- Assign Parts -->
<h2>Assign Part</h2>
<form action="assign_part.php" method="POST" style="text-align:center;">
Appointment ID: <input name="appointment_id" required>

<select name="part_id">
<?php
$parts = $conn->query("SELECT * FROM part");
while($row = $parts->fetch_assoc()){
    echo "<option value='".$row['part_id']."'>".$row['part_name']."</option>";
}
?>
</select>

Qty: <input name="quantity" type="number">
<button>Assign</button>
</form>

<!-- Parts Used -->
<h2>Parts Used</h2>
<table>
<tr><th>Appt</th><th>Part</th><th>Cost</th><th>Qty</th><th>Total</th></tr>

<?php
$result = $conn->query("
SELECT ap.*, p.part_name, p.part_cost 
FROM appointment_part ap
JOIN part p ON ap.part_id = p.part_id
");

while($row = $result->fetch_assoc()){
    $total = $row['part_cost'] * $row['quantity'];
    echo "<tr>
        <td>".$row['appointment_id']."</td>
        <td>".$row['part_name']."</td>
        <td>".$row['part_cost']."</td>
        <td>".$row['quantity']."</td>
        <td>$".$total."</td>
    </tr>";
}
?>
</table>

</body>
</html>