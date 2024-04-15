<?php
session_start(); // Démarrer la session
if (!isset($_SESSION['UtilisateurID'])) {
    // Rediriger l'utilisateur vers la page de connexion ou une autre page appropriée
    header("Location: connexion.php");
    exit();
}

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=localhost;port=3309;dbname=accord__energies", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifier si le formulaire a été soumis
    if (isset($_POST['creer_ticket'])) {
        // Récupérer les données du formulaire
        $date_probleme = $_POST['date_probleme'];
        $description_probleme = $_POST['description_probleme'];
        $type_probleme = $_POST['type_probleme'];

        // Récupérer l'ID de l'utilisateur connecté depuis la session
        $utilisateurID = $_SESSION['UtilisateurID'];

        // Récupérer le clientID correspondant à l'utilisateur connecté
        $requete_client = $pdo->prepare("SELECT clientID FROM clients WHERE UtilisateurID = :utilisateurID");
        $requete_client->bindParam(":utilisateurID", $utilisateurID);
        $requete_client->execute();
        $resultat_client = $requete_client->fetch(PDO::FETCH_ASSOC);
        $clientID = $resultat_client['clientID'];

        // Insérer les données dans la table Interventions
        $requete = $pdo->prepare("INSERT INTO interventions (UtilisateurID, clientID, DateProbleme, DescriptionProbleme, TypeProbleme) VALUES (:utilisateurID, :clientID, :date_probleme, :description_probleme, :type_probleme)");
        $requete->bindParam(":utilisateurID", $utilisateurID);
        $requete->bindParam(":clientID", $clientID);
        $requete->bindParam(":date_probleme", $date_probleme);
        $requete->bindParam(":description_probleme", $description_probleme);
        $requete->bindParam(":type_probleme", $type_probleme);
        $requete->execute();

        // Rediriger l'utilisateur vers la même page avec un message de confirmation
        header("Location: client.php?confirmation=Ticket créé avec succès");
        exit();
    }

    // Récupérer les interventions de l'utilisateur connecté
    $utilisateurID = $_SESSION['UtilisateurID'];
    $requete = $pdo->prepare("SELECT InterventionID, DateIntervention, statut_suivi FROM interventions WHERE UtilisateurID = :utilisateurID ORDER BY DateIntervention DESC");
    $requete->bindParam(":utilisateurID", $utilisateurID);
    $requete->execute();
    $resultat_intervention = $requete->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Échec de la connexion à la base de données : " . $e->getMessage());
}
?>
