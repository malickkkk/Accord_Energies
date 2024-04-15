<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">

<h1 class="text-3xl font-bold mb-4">Inscription</h1>

<form method="post" action="inscription_source.php">

    
    <div class="mb-4">
        <label class="block mb-2" for="prenom">Prénom :</label>
        <input class="w-full px-3 py-2 border rounded-md" type="text" id="prenom" name="prenom" required>
    </div>

    <div class="mb-4">
        <label class="block mb-2" for="nom">Nom :</label>
        <input class="w-full px-3 py-2 border rounded-md" type="text" id="nom" name="nom" required>
    </div>

    <div class="mb-4">
        <label class="block mb-2" for="email">Adresse e-mail :</label>
        <input class="w-full px-3 py-2 border rounded-md" type="email" id="email" name="email" required>
    </div>

    <div class="mb-4">
        <label class="block mb-2" for="password">Mot de passe :</label>
        <input class="w-full px-3 py-2 border rounded-md" type="password" id="password" name="password" required>
    </div>

    <div class="mb-4">
        <label class="block mb-2" for="tel">Téléphone :</label>
        <input class="w-full px-3 py-2 border rounded-md" type="tel" id="tel" name="tel" required>
    </div>

    <div class="mb-4">
        <label class="block mb-2" for="ville">Ville :</label>
        <input class="w-full px-3 py-2 border rounded-md" type="text" id="ville" name="ville" required>
    </div>


  

    <button class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600" type="submit">S'inscrire</button>
</form>

</body>
</html>
