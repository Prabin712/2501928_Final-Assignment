<?php
// Include database connection and helper functions
require 'db.php';
require 'functions.php';

// Include header
include 'header.php';

// Check if vehicle_id is provided in URL
if (!isset($_GET['vehicle_id'])) {
    die("Vehicle ID not provided"); // Stop execution if missing
}

$vehicle_id = $_GET['vehicle_id'];

// Fetch vehicle details from database
$stmt = $pdo->prepare("SELECT * FROM vehicles WHERE id = ?");
$stmt->execute([$vehicle_id]);
$vehicle = $stmt->fetch();

// Stop if vehicle does not exist
if (!$vehicle) {
    die("Vehicle not found");
}

// Handle booking form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get start and end dates from form
    $start_date = $_POST['start_date'];
    $end_date   = $_POST['end_date'];

    // Simple availability check
    $check = $pdo->prepare("
        SELECT * FROM bookings 
        WHERE vehicle_id = ? 
        AND NOT (end_date < ? OR start_date > ?)
    ");
    $check->execute([$vehicle_id, $start_date, $end_date]);

    // If vehicle is already booked in this range
    if ($check->rowCount() > 0) {
        echo "<p style='color:red'>Vehicle not available for selected dates</p>"; // Show message
    } else {
        // Insert new booking into bookings table
        $insert = $pdo->prepare("
            INSERT INTO bookings (vehicle_id, start_date, end_date)
            VALUES (?, ?, ?)
        ");
        $insert->execute([$vehicle_id, $start_date, $end_date]);

        // Update vehicle status to "Rented"
        $update = $pdo->prepare("
            UPDATE vehicles SET status = 'Rented' WHERE id = ?
        ");
        $update->execute([$vehicle_id]);

        // Success message
        echo "<p style='color:green'>Booking successful!</p>";
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
    <input type="date" name="start_date" required><br><br>

    <label>End Date:</label><br>
    <input type="date" name="end_date" required><br><br>

    <button type="submit">Confirm Booking</button>
</form>

<?php include 'footer.php'; // Include footer 
?>