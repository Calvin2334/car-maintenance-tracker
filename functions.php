<?php

function calculateTotalCost($conn, $appointment_id){

    $appointment_id = (int)$appointment_id;

    // Get labor cost
    $app = $conn->query("SELECT labor_cost FROM appointment WHERE appointment_id=$appointment_id");

    if(!$app || $app->num_rows == 0){
        return 0;
    }

    $appointment = $app->fetch_assoc();
    $labor = (float)$appointment['labor_cost'];

    // Get parts total
    $parts = $conn->query("
        SELECT ap.quantity, p.part_cost
        FROM appointment_part ap
        JOIN part p ON ap.part_id = p.part_id
        WHERE ap.appointment_id = $appointment_id
    ");

    $parts_total = 0;

    if($parts){
        while($row = $parts->fetch_assoc()){
            $parts_total += $row['part_cost'] * $row['quantity'];
        }
    }

    return $labor + $parts_total;
}