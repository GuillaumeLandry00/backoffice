<?php
require_once("inc/sessionUtilisateur.php");
require_once("inc/connectDB.php");
require_once("inc/sql.php");

// test retour de saisie du formulaire
// -----------------------------------        

if (isset($_POST['envoi'])) {
    
    // contrôles des champs saisis
    // ---------------------------
 
    $erreurs = array();
   
    $client_nom = trim($_POST['client_nom']);
    if (!preg_match('/^[a-zàéèêôâ]+$/i', $client_nom)) {
        $erreurs['client_nom'] = "Nom incorrect.";
    }
    
    $client_prenom = trim($_POST['client_prenom']);
    if (!preg_match('/^[a-zàéèêôâ]+$/i', $client_prenom)) {
        $erreurs['client_prenom'] = "Prenom incorrect.";
    }
    
    $client_adresse = trim($_POST['client_adresse']);
    if (!preg_match('/^[\da-z àéèêôâ]+$/i', $client_adresse)) {
        $erreurs['client_adresse'] = "Adresse incorrect.";
    }
    
    $client_telephone = trim($_POST['client_telephone']);
    if (!preg_match('/^(438|514)-\d{3}-\d{4}$/i', $client_telephone)) {
        $erreurs['client_telephone'] = "Telephone incorrect doit être un 438 ou 514 et respecter le format suivant 514-000-0000";
    }
    
    // insertion dans la table joueurs si aucune erreur
    // -----------------------------------------------
    
    if (count($erreurs) === 0) {

     if (sqlAjoutClient($conn,$client_nom, $client_prenom, $client_adresse, $client_telephone)=== 1) {
 
         $retSQL="Ajout effectuée.";
 
     } else {
 
         $retSQL ="Ajout non effectuée.";
    }
}
} 
 


?>

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ajout d'un client">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajout d'un client</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
   
    <header>
        <span class="deconnexion">
            <?php
                if (isset($_SESSION['identifiant_utilisateur'])) {
                    echo "<a href='deconnexion.php'>Déconnexion</a>"." de " . $_SESSION['identifiant_utilisateur'];
                }?>
        </span>
        <a href="PageListeClients.php">HOME</a>
    </header>
    <main>
        <h1>Ajout d'un client</h1>
        <p><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></p>
        <div id="pageAjout">
            <form action="AjoutClient.php" method="post">
                <label>Nom du client</label>
                <input type="text" name="client_nom" value="<?php echo isset($client_nom) ? $client_nom : ""  ?>" required>
                <span><?php echo isset($erreurs['client_nom']) ? $erreurs['client_nom'] : ""  ?></span>

                <label>Prenom du client</label>
                <input type="text" name="client_prenom" value="<?php echo isset($client_prenom) ? $client_prenom : ""  ?>" required>
                <span><?php echo isset($erreurs['client_prenom']) ? $erreurs['client_prenom'] : ""  ?></span>

                <label>Adresse</label>
                <input type="text" name="client_adresse" value="<?php echo isset($client_adresse) ? $client_adresse : ""  ?>" required>
                <span><?php echo isset($erreurs['client_adresse']) ? $erreurs['client_adresse'] : ""  ?></span>

                <label>Téléphone</label>
                <input type="text" name="client_telephone" value="<?php echo isset($client_telephone) ? $client_telephone : ""  ?>" required>
                <span><?php echo isset($erreurs['client_telephone']) ? $erreurs['client_telephone'] : ""  ?></span>
                <input type="submit" name="envoi" value="Envoyez">
            </form>
        </div>
    </main>
     <footer>

    </footer>
</body>

</html>
