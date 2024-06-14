<?php
// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

    // Récupérer les données JSON
    $data = json_decode(file_get_contents('php://input'), true);

    // Vérifier si les données sont valides
    if (isset($data['home_team']) && isset($data['away_team']) && isset($data['home_score']) && isset($data['away_score']) && isset($data['match_date'])) {
        // Préparer et exécuter la requête d'insertion
        $stmt = $conn->prepare("INSERT INTO matches (home_team, away_team, home_score, away_score, match_date) VALUES (:home_team, :away_team, :home_score, :away_score, :match_date)");
        $stmt->bindParam(':home_team', $data['home_team']);
        $stmt->bindParam(':away_team', $data['away_team']);
        $stmt->bindParam(':home_score', $data['home_score']);
        $stmt->bindParam(':away_score', $data['away_score']);
        $stmt->bindParam(':match_date', $data['match_date']);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to execute statement.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
    }
} catch(PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
