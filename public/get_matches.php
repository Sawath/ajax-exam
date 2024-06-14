<?php
header('Content-Type: application/json');

// Paramètres de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "football_scores";

try {
    // Connexion à la base de données
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les matchs
    $stmt = $conn->prepare("SELECT * FROM matches");
    $stmt->execute();

    // Renvoyer les matchs en JSON
    $matches = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($matches);
} catch(PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

$conn = null;
?>
