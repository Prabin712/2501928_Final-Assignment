<?php
require 'db.php';
require 'functions.php';

// Check if query exists
if (!isset($_GET['q'])) {
    echo "";
    exit;
}

$query = $_GET['q'];

// Search vehicles by name, type, or status
$stmt = $pdo->prepare("
    SELECT * FROM vehicles 
    WHERE vehicle_name LIKE ? 
    OR vehicle_type LIKE ? 
    OR status LIKE ? 
    ORDER BY id DESC
");
$searchTerm = "%$query%";
$stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
$vehicles = $stmt->fetchAll();

// No results
if (!$vehicles) {
    echo "<p>No vehicles found matching '<b>" . htmlspecialchars($query) . "</b>'</p>";
    exit;
}

// Display results in table
echo "<table border='1' cellpadding='5'>
<tr>
    <th>Name</th>
    <th>Type</th>
    <th>Price/Day</th>
    <th>Status</th>
    <th>Actions</th>
</tr>";

foreach ($vehicles as $v) {
    echo "<tr>";
    echo "<td>" . escape($v['vehicle_name']) . "</td>";
    echo "<td>" . escape($v['vehicle_type']) . "</td>";
    echo "<td>$" . escape($v['price_per_day']) . "</td>";
    echo "<td>" . escape($v['status']) . "</td>";
    echo "<td>";
    echo "<a href='edit.php?id=" . $v['id'] . "'>Edit</a> | ";
    echo "<a href='delete.php?id=" . $v['id'] . "' onclick=\"return confirm('Delete vehicle?')\">Delete</a> | ";
    if ($v['status'] == 'Available') {
        echo "<a href='book.php?vehicle_id=" . $v['id'] . "'>Book</a>";
    } else {
        echo "<a href='return.php?id=" . $v['id'] . "'>Return</a>";
    }
    echo "</td>";
    echo "</tr>";
}

echo "</table>";
