<?php
require 'db.php';
require 'functions.php';
include 'header.php';

if(!isset($_GET['vehicle_id'])) die("Vehicle ID not provided");

$vehicle_id = $_GET['vehicle_id'];

// Fetch vehicle details
$stmt = $pdo->prepare("SELECT * FROM vehicles WHERE id=?");
$stmt->execute([$vehicle_id]);
$vehicle = $stmt->fetch();
if(!$vehicle) die("Vehicle not found");

// Handle booking
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    if ($end_date < $start_date) {
        echo "<p style='color:red'>End date cannot be before start date</p>";
    } else {
        // Check availability
        $check = $pdo->prepare("SELECT * FROM bookings WHERE vehicle_id=? AND NOT (end_date < ? OR start_date > ?)");
        $check->execute([$vehicle_id, $start_date, $end_date]);

        if ($check->rowCount() > 0) {
            echo "<p style='color:red'>Vehicle not available for selected dates</p>";
        } else {
            // Insert booking
            $pdo->prepare("INSERT INTO bookings (vehicle_id, start_date, end_date) VALUES (?, ?, ?)")
                ->execute([$vehicle_id, $start_date, $end_date]);

            // Update status
            $pdo->prepare("UPDATE vehicles SET status='Rented' WHERE id=?")->execute([$vehicle_id]);
            echo "<p style='color:green'>Booking successful!</p>";
        }
    }
}
?>

<h2>Book Vehicle</h2>
<p>
<b>Name:</b> <?= escape($vehicle['vehicle_name']) ?><br>
<b>Type:</b> <?= escape($vehicle['vehicle_type']) ?><br>
<b>Price/Day:</b> $<?= escape($vehicle['price_per_day']) ?>
</p>

<form method="POST">
    <label>Start Date:</label><br>
    <input type="date" name="start_date" id="start" required><br><br>

    <label>End Date:</label><br>
    <input type="date" name="end_date" id="end" required><br><br>

    <button type="submit">Confirm Booking</button>
</form>
<div id="availability"></div>

<?php include 'footer.php'; 
?>