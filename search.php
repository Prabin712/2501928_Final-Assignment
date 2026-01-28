<?php
require 'db.php';
require 'functions.php';
include 'header.php';

// Initialize search term
$searchTerm = '';
if (isset($_GET['q'])) {
    $searchTerm = $_GET['q'];
}

// Fetch vehicles based on search term
if ($searchTerm != '') {
    $stmt = $pdo->prepare("
        SELECT * FROM vehicles
        WHERE vehicle_name LIKE ? OR vehicle_type LIKE ? OR status LIKE ?
        ORDER BY id DESC
    ");
    $likeTerm = "%$searchTerm%";
    $stmt->execute([$likeTerm, $likeTerm, $likeTerm]);
    $vehicles = $stmt->fetchAll();
} else {
    // If no search term, show all vehicles
    $stmt = $pdo->query("SELECT * FROM vehicles ORDER BY id DESC");
    $vehicles = $stmt->fetchAll();
}
?>

<h3>Search Vehicles</h3>
<form method="GET">
    <input type="text" name="q" placeholder="Search vehicle by name, type or status" value="<?= escape($searchTerm) ?>">
    <button type="submit">Search</button>
</form>

<table border="1" cellpadding="5">
<tr>
    <th>Name</th>
    <th>Type</th>
    <th>Price/Day</th>
    <th>Status</th>
    <th>Actions</th>
</tr>

<?php if ($vehicles): ?>
    <?php foreach ($vehicles as $v): ?>
        <tr>
            <td><?= escape($v['vehicle_name']) ?></td>
            <td><?= escape($v['vehicle_type']) ?></td>
            <td>$<?= escape($v['price_per_day']) ?></td>
            <td class="status-<?= $v['status'] ?>"><?= escape($v['status']) ?></td>
            <td>
                <a href="edit.php?id=<?= $v['id'] ?>">Edit</a> |
                <a href="delete.php?id=<?= $v['id'] ?>" onclick="return confirm('Delete vehicle?')">Delete</a> |
                <?php if ($v['status']=='Available'): ?>
                    <a href="book.php?vehicle_id=<?= $v['id'] ?>">Book</a>
                <?php else: ?>
                    <a href="return.php?id=<?= $v['id'] ?>">Return</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr><td colspan="5" style="text-align:center;">No vehicles found</td></tr>
<?php endif; ?>
</table>

<?php include 'footer.php'; 
?>