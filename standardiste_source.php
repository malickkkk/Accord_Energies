<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['UtilisateurID']) || $_SESSION['Role'] !== 'standardiste') {
    header("Location: connexion.php");
    exit();
}

try {
    $pdo = new PDO("mysql:host=localhost;port=3309;dbname=accord__energies", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération et affichage de la liste des clients
    $requete = $pdo->prepare("SELECT * FROM clients ");
    $requete->execute();
    $resultat_clients = $requete->fetchAll(PDO::FETCH_ASSOC);
   
    // Traitement de la soumission du formulaire
if (isset($_POST['creer_intervention'])) {
    // Récupérer les données du formulaire
    $dateIntervention = $_POST['DateIntervention'];
    $statutSuivi = $_POST['statut_suivi'];
    $commentaire = $_POST['Commentaire'];
    $clientID = $_POST['clientID'];
    $utilisateurID = $_SESSION['UtilisateurID'];

    // Insérer une nouvelle intervention dans la base de données
    $requete = $pdo->prepare("INSERT INTO interventions (DateIntervention, statut_suivi, Commentaire, clientID, UtilisateurID) VALUES (:dateIntervention, :statutSuivi, :commentaire, :clientID, :utilisateurID)");
    $requete->bindParam(":dateIntervention", $dateIntervention);
    $requete->bindParam(":statutSuivi", $statutSuivi);
    $requete->bindParam(":commentaire", $commentaire);
    $requete->bindParam(":clientID", $clientID);
    $requete->bindParam(":utilisateurID", $utilisateurID);
    $requete->execute();
}

    

    if (isset($_POST['creer_intervention'])) {
        $dateIntervention = $_POST['DateIntervention'];
        $statutSuivi = $_POST['statut_suivi'];
        $commentaire = $_POST['Commentaire'];
        $clientID = $_POST['clientID'];
        $utilisateurID = $_SESSION['UtilisateurID'];

        

        $requete = $pdo->prepare("INSERT INTO interventions (DateIntervention, statut_suivi, Commentaire, clientID, UtilisateurID) VALUES (:dateIntervention, :statutSuivi, :commentaire, :clientID, :utilisateurID)");
        $requete->bindParam(":dateIntervention", $dateIntervention);
        $requete->bindParam(":statutSuivi", $statutSuivi);
        $requete->bindParam(":commentaire", $commentaire);
        $requete->bindParam(":clientID", $clientID);
        $requete->bindParam(":utilisateurID", $utilisateurID);
        $requete->execute();
    }


    if (isset($_POST['modifier_intervention'])) {
        $interventionID = $_POST['InterventionID'];
        $dateIntervention = $_POST['DateIntervention'];
        $statutSuivi = $_POST['statut_suivi'];
        $commentaire = $_POST['Commentaire'];
        $clientID = $_POST['clientID'];


        $requete = $pdo->prepare("SELECT * FROM interventions WHERE InterventionID = :interventionID AND utilisateurID = :utilisateurID");
        $requete->bindParam(":interventionID", $interventionID);
        $requete->bindParam(":utilisateurID", $_SESSION['UtilisateurID']);
        $requete->execute();
        $intervention = $requete->fetch(PDO::FETCH_ASSOC);

        if ($intervention) {
            $requete = $pdo->prepare("UPDATE interventions SET DateIntervention = :dateIntervention, statut_suivi = :statutSuivi, Commentaire = :commentaire, clientID = :clientID WHERE InterventionID = :interventionID");
            $requete->bindParam(":interventionID", $interventionID);
            $requete->bindParam(":dateIntervention", $dateIntervention);
            $requete->bindParam(":statutSuivi", $statutSuivi);
            $requete->bindParam(":commentaire", $commentaire);
            $requete->bindParam(":clientID", $clientID);
            $requete->execute();
        }
    }

    if (isset($_POST['annuler_intervention'])) {
        $interventionID = $_POST['InterventionID'];


        $requete = $pdo->prepare("SELECT * FROM interventions WHERE InterventionID = :interventionID AND utilisateurID = :utilisateurID");
        $requete->bindParam(":interventionID", $interventionID);
        $requete->bindParam(":utilisateurID", $_SESSION['UtilisateurID']);
        $requete->execute();
        $intervention = $requete->fetch(PDO::FETCH_ASSOC);

        if ($intervention) {
            $requete = $pdo->prepare("UPDATE interventions SET statut_suivi = 'Annulé' WHERE InterventionID = :interventionID");
            $requete->bindParam(":interventionID", $interventionID);
            $requete->execute();
        }
    }

if (isset($_POST['cloturer_intervention'])) {
        $interventionID = $_POST['InterventionID'];


        $requete = $pdo->prepare("SELECT * FROM interventions WHERE InterventionID = :interventionID AND utilisateurID = :utilisateurID");
        $requete->bindParam(":interventionID", $interventionID);
        $requete->bindParam(":utilisateurID", $_SESSION['UtilisateurID']);
        $requete->execute();
        $intervention = $requete->fetch(PDO::FETCH_ASSOC);

        if ($intervention) {
            $requete = $pdo->prepare("UPDATE interventions SET statut_suivi = 'Clôturé' WHERE InterventionID = :interventionID");
            $requete->bindParam(":interventionID", $interventionID);
            $requete->execute();
        }
    }

    // Récupération et affichage de la liste des interventions
    $requete = $pdo->prepare("SELECT i.InterventionID, i.DateIntervention, i.statut_suivi, i.Commentaire, i.clientID, c.nom AS client_nom FROM interventions i INNER JOIN clients c ON i.clientID = c.clientID WHERE utilisateurID = :utilisateurID ORDER BY i.DateIntervention DESC");
    $requete->bindParam(":utilisateurID", $_SESSION['UtilisateurID']);
    $requete->execute();
    $resultat_intervention = $requete->fetchAll(PDO::FETCH_ASSOC);

    if (isset($resultat_intervention) && !empty($resultat_intervention)) {
        echo "<h2>Liste des interventions</h2>";
        echo "<ul>";
        foreach ($resultat_intervention as $intervention) {
            echo "<li>";
            echo "ID de l'intervention : " . $intervention['InterventionID'] . ", ";
            echo "Date de l'intervention : " . $intervention['DateIntervention'] . ", ";
            echo "Statut de suivi : " . $intervention['statut_suivi'] . ", ";
            echo "Commentaire : " . $intervention['Commentaire'] . ", ";
            echo "Nom du client : " . $intervention['client_nom'];
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "Aucune intervention trouvée.";
    }

} catch(PDOException $e) {
    die("Échec de la connexion à la base de données : " . $e->getMessage());
}
