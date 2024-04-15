<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen flex flex-col justify-center items-center">
    <h1 class="text-3xl font-bold mb-8">Page Admin</h1>

    <!-- Formulaire pour créer un utilisateur -->
    <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-xl font-semibold mb-4">Créer un utilisateur</h2>
        <form action="admin_source.php" method="post">
            <div class="mb-4">
                <label for="nom" class="block">Nom :</label>
                <input type="text" id="nom" name="nom" required class="w-full border border-gray-300 rounded-md px-4 py-2">
            </div>
            <div class="mb-4">
                <label for="prenom" class="block">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required class="w-full border border-gray-300 rounded-md px-4 py-2">
            </div>
            <div class="mb-4">
                <label for="email" class="block">Email :</label>
                <input type="email" id="email" name="email" required class="w-full border border-gray-300 rounded-md px-4 py-2">
            </div>
            <div class="mb-4">
                <label for="password" class="block">Mot de passe :</label>
                <input type="password" id="password" name="password" required class="w-full border border-gray-300 rounded-md px-4 py-2">
            </div>
            <div class="mb-4">
                <label for="role" class="block">Rôle :</label>
                <select id="role" name="role" required class="w-full border border-gray-300 rounded-md px-4 py-2">
                    <option value="standardiste">Standardiste</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div>
                <button type="submit" name="creer_utilisateur" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Créer l'utilisateur</button>
            </div>
        </form>
    </div>

    <!-- Formulaire pour modifier un utilisateur -->
    <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-xl font-semibold mb-4">Modifier un utilisateur</h2>
        <form action="admin_source.php" method="post">
            <!-- Champs de formulaire pour la modification de l'utilisateur -->
        </form>
    </div>

    <!-- Formulaire pour créer une intervention -->
    <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-xl font-semibold mb-4">Créer une intervention</h2>
        <form action="admin_source.php" method="post">
            <!-- Champs de formulaire pour la création d'une intervention -->
        </form>
    </div>

    <!-- Formulaire pour modifier une intervention -->
    <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-xl font-semibold mb-4">Modifier une intervention</h2>
        <form action="admin_source.php" method="post">
            <!-- Champs de formulaire pour la modification d'une intervention -->
        </form>
    </div>

    <!-- Liste des interventions -->
    <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">Liste des interventions</h2>
        <ul>
            <?php foreach ($resultat_intervention as $intervention): ?>
            <li class="mb-2">
                ID de l'intervention : <?= htmlspecialchars($intervention['InterventionID']) ?>,
                Date de l'intervention : <?= htmlspecialchars($intervention['DateIntervention']) ?>,
                Statut de suivi : <?= htmlspecialchars($intervention['statut_suivi']) ?>,
                Commentaire : <?= htmlspecialchars($intervention['Commentaire']) ?>,
                Nom du client : <?= htmlspecialchars($intervention['client_nom']) ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>

</html>
