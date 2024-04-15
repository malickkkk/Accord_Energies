<?php

require_once 'connexion.php';

session_start();
if (!isset($_SESSION['IntervenantId'])) {
    
    header("Location: connexion.php");
    exit;
}

try {
    // Récupérer les interventions de l'intervenant
    $intervenant_id = $_SESSION['IntervenantId'];
    $requete_interventions = $pdo->prepare("SELECT * FROM interventions WHERE IntervenantId = :intervenant_id");
    $requete_interventions->bindParam(":intervenant_id", $intervenant_id);
    $requete_interventions->execute();
    $resultat_intervention = $requete_interventions->fetchAll(PDO::FETCH_ASSOC);

    
    if (!$resultat_intervention) {
        $resultat_intervention = [];
    }
} catch (PDOException $e) {
    // Gérer les erreurs de connexion à la base de données
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    exit;
}