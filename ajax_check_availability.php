<?php
require 'db.php';
header('Content-Type: text/plain');

if(!isset($_GET['vehicle_id'], $_GET['start'], $_GET['end'])) exit('Invalid request');

$vehicle_id = $_GET['vehicle_id'];
$start = $_GET['start'];
$end = $_GET['end'];

$stmt = $pdo->prepare("SELECT id FROM bookings WHERE vehicle_id=? AND NOT (end_date < ? OR start_date > ?)");
$stmt->execute([$vehicle_id, $start, $end]);

echo ($stmt->rowCount() == 0) ? "Available" : "Not Available";
?>
