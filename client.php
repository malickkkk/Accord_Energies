<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord client</title>
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-4">
    <h1 class="text-3xl font-bold mb-4">Tableau de bord client</h1>
    <h2 class="text-xl font-semibold mb-2">Création de ticket</h2>
    <form method="post" action="client_source.php" class="mb-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="date_probleme" class="block text-sm font-medium text-gray-700">Date de l'intervention :</label>
                <input type="date" name="date_probleme" id="date_probleme" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
            <div>
                <label for="description_probleme" class="block text-sm font-medium text-gray-700">Description du problème :</label>
                <textarea name="description_probleme" id="description_probleme" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
            </div>
            <div>
                <label for="type_probleme" class="block text-sm font-medium text-gray-700">Type de Problème :</label>
                <select id="type_probleme" name="type_probleme" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="panne">Panne</option>
                    <option value="autre">Autre</option>
                </select>
            </div>
        </div>
        <button type="submit" name="creer_ticket" class="inline-block mt-4 px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 cursor-pointer">Créer ticket</button>
    </form>

    <h2 class="text-xl font-semibold mb-2">Mes interventions</h2>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Date de l'intervention
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Statut
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Commentaire
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php if (isset($resultat_intervention) && !empty($resultat_intervention)) : ?>
                <?php foreach ($resultat_intervention as $row) : ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900"><?php echo $row["DateIntervention"]; ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo ($row["statut_suivi"] == "Terminé") ? "bg-green-100 text-green-800" : "bg-yellow-100 text-yellow-800"; ?>">
                            <?php echo $row["statut_suivi"]; ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <form method="post" action="client_source.php">
                            <input type="hidden" name="id_intervention" value="<?php echo $row["InterventionID"]; ?>">
                            <textarea name="commentaire" rows="3" cols="30" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"><?php echo htmlspecialchars($row["commentaire"] ?? ""); ?></textarea>
                            <input type="submit" name="ajouter_commentaire" value="Ajouter commentaire" class="inline-block px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 cursor-pointer">
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Aucune intervention trouvée.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
