<?php
require 'db.php';
$vehicle_id = $_GET['id'];

// Update vehicle status
$pdo->prepare("UPDATE vehicles SET status='Available' WHERE id=?")->execute([$vehicle_id]);

header('Location: index.php');
?>
