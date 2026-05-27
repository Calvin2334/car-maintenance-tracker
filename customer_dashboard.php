<?php
session_start();

if (!isset($_SESSION['customer_id'])) {
    header("Location: customer_login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "car_maintenance_tracker");

$customer_id = $_SESSION['customer_id'];

$sql = "
SELECT a.*
FROM appointment a
JOIN car c ON a.car_id = c.car_id
WHERE c.customer_id = $customer_id
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Dashboard</title>

    <style>
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th {
            background: #2c7be5;
            color: white;
        }

        .btn {
            padding: 6px 10px;
            background: red;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>

<h2 style="text-align:center;">My Appointments</h2>

<table>
<tr>
    <th>Date</th>
    <th>Time</th>
    <th>Status</th>
    <th>Completion Date</th>
    <th>Completion Time</th>
    <th>Action</th>
</tr>

<?php
while ($row = $result->fetch_assoc()) {
    echo "<tr>";

    echo "<td>".$row['appointment_date']."</td>";

    echo "<td>".date("h:i A", strtotime($row['appointment_time']))."</td>";

    echo "<td><b>".$row['car_status']."</b></td>";

    echo "<td>".$row['completion_date']."</td>";

    echo "<td>".$row['completion_time']."</td>";

    echo "<td>";

    if ($row['car_status'] != "Completed") {
        echo "<form action='cancel_appointment.php' method='POST'>";
        echo "<input type='hidden' name='appointment_id' value='".$row['appointment_id']."'>";
        echo "<button class='btn'>Cancel</button>";
        echo "</form>";
    } else {
        echo "Locked";
    }

    echo "</td>";

    echo "</tr>";
}
?>

</table>

</body>
</html>