<?php
require 'db.php';
require 'functions.php';
include 'header.php';

// Get all vehicles
$stmt = $pdo->query("SELECT * FROM vehicles ORDER BY id DESC");
$vehicles = $stmt->fetchAll();
?>

<input type="text" id="search" placeholder="Search vehicle...">
<div id="result"></div>

<table border="1" cellpadding="5">
<tr>
    <th>Name</th>
    <th>Type</th>
    <th>Price/Day</th>
    <th>Status</th>
    <th>Actions</th>
</tr>

<?php foreach ($vehicles as $v): ?>
<tr>
    <td><?= escape($v['vehicle_name']) ?></td>
    <td><?= escape($v['vehicle_type']) ?></td>
    <td>$<?= escape($v['price_per_day']) ?></td>
    <td><?= escape($v['status']) ?></td>
    <td>
        <a href="edit.php?id=<?= $v['id'] ?>">Edit</a> |
        <a href="delete.php?id=<?= $v['id'] ?>" onclick="return confirm('Delete vehicle?')">Delete</a> |
        
        <?php if ($v['status'] == 'Available'): ?>
            <a href="book.php?vehicle_id=<?= $v['id'] ?>">Book</a>
        <?php else: ?>
            <a href="return.php?id=<?= $v['id'] ?>">Return</a>
        <?php endif; ?>
    </td>
</tr>
<?php endforeach; ?>

</table>

<?php include 'footer.php'; ?>
