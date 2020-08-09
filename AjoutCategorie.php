<?php
require_once("inc/sessionUtilisateur.php");
require_once("inc/connectDB.php");
require_once("inc/sql.php");
/*Permet d'aller chercher la liste des categories*/
$listeCategorie=sqlListerCategorie($conn);
// test retour de saisie du formulaire
// -----------------------------------        

if (isset($_POST['envoi'])) {
    
    // contrôles des champs saisis
    // ---------------------------
 
    $erreurs = array();
       
   $categorie_nom = trim($_POST['categorie_nom']);
    if (!preg_match('/^[a-zàéèêôâ]+$/i', $categorie_nom)) {
        $erreurs['categorie_nom'] = "Nom incorrect.";
    }
    
    
    // insertion dans la table categories si aucune erreur
    // -----------------------------------------------
    
    if (count($erreurs) === 0) {
     if (sqlAjoutCategorie($conn, $categorie_nom) === 1) {
 
         $retSQL="Ajout effectuée.";
 
     } else {
 
         $retSQL ="Ajout non effectuée.";
    }
}
}

 


?>

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ajout d'une categorie">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajout d'une categorie</title>
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
         <a href="ListeCategorie.php">HOME</a>
    </header>
    <main>
        <?php// echo var_dump($listeCategorie)?>
       
        <h1>Ajout d'une categorie</h1>
        <p><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></p>
        <div id="pageAjout">
            <form action="AjoutCategorie.php" method="post">
                <label>Nom de categorie</label>
                <input type="text" name="categorie_nom" required>
                <span><?php echo isset($erreurs['categorie_nom']) ? $erreurs['categorie_nom'] : "&nbsp;"  ?></span>
                <input type="submit" name="envoi" value="Envoyez">
            </form>
        </div>
    </main>
     <footer>

    </footer>
</body>

</html>
