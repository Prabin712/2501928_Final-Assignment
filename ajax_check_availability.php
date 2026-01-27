<?php
require 'db.php';

$vehicle_id = $_GET['vehicle_id'];
$start = $_GET['start'];
$end = $_GET['end'];

$stmt = $pdo->prepare(
    "SELECT * FROM bookings WHERE vehicle_id=? AND (start_date<=? AND end_date>=?)"
);
$stmt->execute([$vehicle_id, $end, $start]);

if ($stmt->rowCount() == 0) {
    echo "Available";
} else {
    echo "Not Available";
}
?>
