<?php
session_start();

try {
    $pdo = new PDO('mysql:host=localhost;dbname=historiart', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

if (!isset($_SESSION['utilisateur_id'])) {
    header('Location: login.php');
    exit();
}

$id = $_SESSION['utilisateur_id'];

$stmt = $pdo->prepare("DELETE FROM utilisateurs WHERE id = :id");
$stmt->execute(['id' => $id]);

session_destroy();
header('Location: index.php');
exit();
?>