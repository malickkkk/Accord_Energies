<?php
try {
    $pdo = new PDO("mysql:host=localhost;port=3309;dbname=accord__energies", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération et affichage de la liste des clients
    $requete = $pdo->prepare("SELECT * FROM clients ");
    $requete->execute();
    $resultat_clients = $requete->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Échec de la connexion à la base de données : " . $e->getMessage());
}

// Récupération et affichage de la liste des interventions
$requete = $pdo->prepare("SELECT * FROM interventions WHERE utilisateurID = :utilisateurID ORDER BY DateIntervention DESC");
$requete->bindParam(":utilisateurID", $_SESSION['UtilisateurID']);
$requete->execute();
$resultat_intervention = $requete->fetchAll(PDO::FETCH_ASSOC);

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

    

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord standardiste</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-4">Tableau de bord standardiste</h1>

        <form action="standardiste_source.php" method="post">

            <h2 class="text-2xl font-semibold mb-2">Créer une intervention</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="dateIntervention" class="block text-sm font-medium text-gray-700">Date d'intervention</label>
                    <input type="date" name="dateIntervention" id="dateIntervention" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                </div>
                <div>
                    <label for="statut_suivi" class="block text-sm font-medium text-gray-700">Statut</label>
                    <select name="statut_suivi" id="statut_suivi" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        <option value="">-- Choisir un statut --</option>
                        <option value="en_cours">En cours</option>
                        <option value="annulé">Annulé</option>
                        <option value="cloturé">Clôturé</option>
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <label for="commentaire" class="block text-sm font-medium text-gray-700">Commentaire</label>
                <textarea name="commentaire" id="commentaire" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
            </div>
            <div class="mt-4">
                <label for="clientID" class="block text-sm font-medium text-gray-700">Client</label>
                <select name="clientID" id="clientID" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    <?php
                    if (isset($resultat_clients) && is_array($resultat_clients) && count($resultat_clients) > 0) {
                        foreach ($resultat_clients as $client) {
                            echo "<option value=\"{$client['clientID']}\">{$client['nom']} {$client['prenom']}</option>";  // code pour afficher les clients
                        }
                    } else {
                        echo "<option value=\"\">Aucun client trouvé.</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mt-4">
                <button type="submit" name="creer_intervention" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded">Créer l'intervention</button>
            </div>
        </form>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date d'intervention</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commentaire</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (!empty($resultat_intervention)): ?>
                    <?php foreach ($resultat_intervention as $intervention): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo $intervention['InterventionID']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo $intervention['DateIntervention']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo $intervention['statut_suivi']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo $intervention['Commentaire']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                $clientID = $intervention['clientID'];
                                $client = array_filter($resultat_clients, function ($client) use ($clientID) {
                                    return $client['clientID'] == $clientID;
                                });
                                echo $client[0]['prenom'] . ' ' . $client[0]['nom'];
                                ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-2">Modifier</a>
                                <a href="#" class="text-red-600 hover:text-red-900 mr-2">Annuler</a>
                                <a href="#" class="text-green-600 hover:text-green-900">Clôturer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="px-6 py-4 whitespace-nowrap">Aucune intervention trouvée.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
