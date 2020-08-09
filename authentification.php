<?php
require_once("inc/connectDB.php");
require_once("inc/sql.php");
// test retour de saisie du formulaire
// -----------------------------------
if (isset($_POST['envoi'])) {
    $identifiant = trim($_POST['identifiant']);
    $mot_de_passe = trim($_POST['mot_de_passe']);


    if (sqlControlerUtilisateur($conn, $identifiant, $mot_de_passe) === 1) {
        // authentification réussie
        session_start();
        $_SESSION['identifiant_utilisateur'] = $identifiant;
        $_SESSION['utilisateur_type'] =sqlLireUser($conn, $_SESSION['identifiant_utilisateur']);
        header('Location: ListeCommande.php'); 
    }else {
        $erreur = "Identifiant ou mot de passe incorrect.";
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Authentification">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Authentification</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<style>
    body{
        padding: 0px;
    }    
</style>

<body>

    <main class="login">
        <header>
        </header>
        <h1>Authentification</h1>
    
        <img src="img/imgLogIn.png" alt="image user">
        <form id="authentification" action="authentification.php" method="post">
            <section>
                <label>Identifiant</label>
                <input type="text" name="identifiant" value="" required>
                <label>Mot de passe</label>
                <input type="password" name="mot_de_passe" value="" required>
                <input type="submit" name="envoi" value="LOG IN">
                <p><?php echo isset($erreur) ? $erreur : "&nbsp;" ?></p>
            </section>
        </form>
    </main>
       <footer>

        </footer>
</body>

