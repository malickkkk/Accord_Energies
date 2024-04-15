
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord intervenant</title>
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">
    <h1 class="text-3xl font-bold mb-4">Tableau de bord intervenant</h1>
    <h2 class="text-xl font-semibold mb-2">Mes interventions</h2>

    <?php if (!empty($resultat_intervention)) : ?>
        <div class="overflow-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date de l'intervention</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($resultat_intervention as $intervention) : ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo $intervention['DateIntervention']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo $intervention['Statut']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="intervenant_source.php?id=<?php echo $intervention['InterventionId']; ?>" class="text-blue-500 hover:text-blue-700">Modifier</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <p class="text-gray-500">Aucune intervention à afficher.</p>
    <?php endif; ?>
</body>
</html>