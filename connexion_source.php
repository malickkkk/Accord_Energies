<?php
session_start(); // Démarrer la session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        try {
            $pdo = new PDO("mysql:host=localhost;port=3309;dbname=accord__energies", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Stocker l'ID du client dans la session
                $_SESSION['UtilisateurID'] = $user['UtilisateurID'];


                switch ($user['role']) {
                    case 'admin':
                        header("Location: admin.php");
                        exit("<script>alert('Connexion réussie !');</script>");
                    case 'standardiste':
                        header("Location: standardiste.php");
                        exit("<script>alert('Connexion réussie !');</script>");
                    case 'client':
                        header("Location: client.php");
                        exit("<script>alert('Connexion réussie !');</script>");
                    case 'intervenant':
                        header("Location: intervenant.php");
                        exit("<script>alert('Connexion réussie !');</script>");
                    default:
                        header("Location: homepage.php");
                        exit("<script>alert('Connexion réussie !');</script>");
                }
            } else {
                echo "<script>alert('Email ou mot de passe incorrect');</script>";
            }
        } catch(PDOException $e) {
            die("<p class='text-red-500 font-bold'>Erreur lors de la connexion : " . $e->getMessage() . "</p>");
        }
    } else {
        echo "<p class='text-red-500 font-bold'>Tous les champs doivent être remplis.</p>";
    }
} else {
    echo "<p class='text-red-500 font-bold'>Méthode de requête non prise en charge.</p>";
}
?>
