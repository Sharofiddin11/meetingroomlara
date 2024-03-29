<?php
require_once '_db.php';

$stmt = $db->prepare("UPDATE rooms SET name = :name, capacity = :capacity WHERE id = :id");
$stmt->bindParam(':id', $_POST['id']);
$stmt->bindParam(':name', $_POST['name']);
$stmt->bindParam(':capacity', $_POST['capacity']);
$stmt->execute();

class Result {}

$response = new Result();
$response->result = 'OK';
$response->message = 'Update successful';

header('Content-Type: application/json');
echo json_encode($response);

?>
