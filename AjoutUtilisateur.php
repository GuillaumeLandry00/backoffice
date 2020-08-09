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
   
    $utilisateur_nom = trim($_POST['utilisateur_nom']);
    if (!preg_match('/^[a-zàéèêôâ]+$/i', $utilisateur_nom)) {
        $erreurs['utilisateur_nom'] = "Nom incorrect.";
    }
    $utilisateur_type=$_POST['leSelect'];
    
    $utilisateur_mot_passe = trim($_POST['utilisateur_mot_passe']);
    if (!preg_match('/^[a-zàéèêôâ\d]+$/i', $utilisateur_mot_passe)) {
        $erreurs['utilisateur_mot_passe'] = "Mot passe incorrect.";
    }
    
    // insertion dans la table joueurs si aucune erreur
    // -----------------------------------------------
    
    if (count($erreurs) === 0) {

     if (sqlAjoutUtilisateur($conn,$utilisateur_nom, $utilisateur_type, $utilisateur_mot_passe)=== 1) {
 
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
    <title>Ajout d'un utilisateur</title>
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
        <a href="ListeUtilisateur.php">Retour à la liste</a>
    </header>
    <main>
        <h1>Ajout d'un utilisateur</h1>
        <p><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></p>
        <div id="pageAjout">
            <form action="AjoutUtilisateur.php" method="post">
                <label>Username</label>
                <input type="text" name="utilisateur_nom" value="<?php echo isset($utilisateur_nom) ? $utilisateur_nom : "&nbsp;"  ?>" required>
                <span><?php echo isset($erreurs['utilisateur_nom']) ? $erreurs['utilisateur_nom'] : "&nbsp;"  ?></span>

                <label>Mot de passe</label>
                <input type="text" name="utilisateur_mot_passe" value="<?php echo isset($utilisateur_mot_passe) ? $utilisateur_mot_passe : "&nbsp;"  ?>" required>
                <span><?php echo isset($erreurs['utilisateur_mot_passe']) ? $erreurs['utilisateur_mot_passe'] : "&nbsp;"  ?></span>

                <label>Type d'utilisateur</label>
                <select name="leSelect" id="">
                    <option value="V">Vendeur</option>
                    <option value="G">Gestionnaire</option>
                    <option value="A">Administateur</option>
                </select>
                <input type="submit" name="envoi" value="Envoyez">
            </form>
        </div>
    </main>
     <footer>

    </footer>
</body>

</html>
