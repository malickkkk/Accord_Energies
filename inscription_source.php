<?php
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "POST") {

    $champs_requis = array("prenom", "nom", "email", "password", "tel", "ville");
    $champs_valides = true;
    foreach ($champs_requis as $champ) {
        if (!isset($_POST[$champ]) || empty($_POST[$champ])) {
            echo "<p class='text-red-500 font-bold'>Le champ $champ est requis.</p>";
            $champs_valides = false;
        }
    }

    if ($champs_valides) {
        // Récupérer les données du formulaire
        $prenom = $_POST["prenom"];
        $nom = $_POST["nom"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $telephone = $_POST["tel"];
        $ville = $_POST["ville"];

        try {
            $pdo = new PDO("mysql:host=localhost;port=3309;dbname=accord__energies", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Insertion dans la table Utilisateurs
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, email, password, telephone, ville, Role) VALUES (?, ?, ?, ?, ?, ?, 'client')");
            $stmt->execute([$nom, $prenom, $email, $password_hashed, $telephone, $ville]);

            // Récupérer l'utilisateurId généré
            $utilisateurId = $pdo->lastInsertId();

            // Insérer une entrée dans la table clients avec l'utilisateurId, prénom et nom
            $stmt = $pdo->prepare("INSERT INTO clients (utilisateurId, nom, prenom, email) VALUES (?, ?, ?, ?)");
            $stmt->execute([$utilisateurId, $nom, $prenom, $email]);

            // Redirection vers l'interface client
            header("Location: client.php");
            exit; 
        } catch(PDOException $e) {
            die("<p class='text-red-500 font-bold'>Erreur lors de l'inscription : " . $e->getMessage() . "</p>");
        }
    }
} else {
    echo "<p class='text-red-500 font-bold'>Méthode de requête non prise en charge.</p>";
}

?>
