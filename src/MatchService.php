<?php
require_once '../db/db.php';

class MatchService {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getMatchScore($matchId) {
        $query = "SELECT home_score, away_score FROM matches WHERE match_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $matchId);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['home_score'] . " - " . $row['away_score'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $server = new SoapServer("http://localhost/football-scores/wsdl/service.wsdl");
    $server->setClass("MatchService");
    $server->handle();
}