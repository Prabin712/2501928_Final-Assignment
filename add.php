<?php
require 'db.php';
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Simple validation for price
    $price = floatval($_POST['price']);

    $stmt = $pdo->prepare("INSERT INTO vehicles (vehicle_name, vehicle_type, price_per_day, status) VALUES (?, ?, ?, 'Available')");
    $stmt->execute([$_POST['name'], $_POST['type'], $price]);

    header('Location: index.php');
}
?>

<h3>Add Vehicle</h3>
<form method="post">
    Name: <input type="text" name="name" required><br><br>
    Type: <input type="text" name="type"><br><br>
    Price per Day: <input type="number" name="price" step="0.01" required><br><br>
    <button type="submit">Add Vehicle</button>
</form>

<?php include 'footer.php'; ?>
