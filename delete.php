<?php
require 'db.php';
$id = $_GET['id'];

$pdo->prepare("DELETE FROM vehicles WHERE id=?")->execute([$id]);

header('Location: index.php');
?>
