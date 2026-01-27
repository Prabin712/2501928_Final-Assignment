<?php
require 'db.php';
include 'header.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM vehicles WHERE id = ?");
$stmt->execute([$id]);
$vehicle = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $update = $pdo->prepare("UPDATE vehicles SET vehicle_name=?, vehicle_type=?, price_per_day=? WHERE id=?");
    $update->execute([$_POST['name'], $_POST['type'], $_POST['price'], $id]);
    header('Location: index.php');
}
?>

<h3>Edit Vehicle</h3>
<form method="post">
    Name: <input type="text" name="name" value="<?= escape($vehicle['vehicle_name']) ?>" required><br><br>
    Type: <input type="text" name="type" value="<?= escape($vehicle['vehicle_type']) ?>"><br><br>
    Price per Day: <input type="number" name="price" step="0.01" value="<?= escape($vehicle['price_per_day']) ?>"><br><br>
    <button type="submit">Update Vehicle</button>
</form>

<?php include 'footer.php'; ?>
