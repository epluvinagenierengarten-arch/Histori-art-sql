<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['utilisateur_id'])) {
    http_response_code(401);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$utilisateur_id = $_SESSION['utilisateur_id'];
$carte_id = $data['carte_id'];
$action = $data['action'];
$pdo = new PDO('mysql:host=localhost;dbname=historiart', 'root', '');

if ($action === 'add') {
    $stmt = $pdo->prepare("INSERT IGNORE INTO favoris (utilisateur_id, carte_id) VALUES (?, ?)");
} else {
    $stmt = $pdo->prepare("DELETE FROM favoris WHERE utilisateur_id = ? AND carte_id = ?");
}
$stmt->execute([$utilisateur_id, $carte_id]);