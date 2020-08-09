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
    
    $row['categorie_id'] = $_POST['categorie_id']; // récupération clé primaire dans un champ caché
       
    $row['categorie_nom'] = trim($_POST['categorie_nom']);
    if (!preg_match('/^[a-zàéèêôâ]+$/i', $row['categorie_nom'])) {
        $erreurs['categorie_nom'] = "Nom incorrect.";
    }
    
    if (count($erreurs) === 0) {
     if (sqlModifierCategorie($conn,  $row['categorie_id'] ,$row['categorie_nom'])=== 1) {
 
         $retSQL="Modification effectuée.";
 
     } else {
 
         $retSQL ="Modification non effectuée.";
    }
}
} else {

 // lecture du client à modifier, à la première ouverture de la page
 // ---------------------------------------------------------------
 $id = isset($_GET['id']) ? $_GET['id'] : "";
 $row = array();
 if ( $id !== "" ) $row = sqlLireCategorie($conn, $id);
}

 


?>

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Modification d'un client">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modification d'une categorie</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<header>
    <span class="deconnexion">
        <?php
                if (isset($_SESSION['identifiant_utilisateur'])) {
                    echo "<a href='deconnexion.php'>Déconnexion</a>"." de " . $_SESSION['identifiant_utilisateur'];
                }?>
    </span>
    <a href="ListeCategorie.php">HOME</a>
</header>

<body>

    <main>
        <?php// echo var_dump($listeCategorie)?>
        <h1>Modification d'une categorie</h1>
        <p><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></p>
        <div id="pageAjout">
            <?php if (count($row) > 0) : ?>

            <form action="ModificationCategorie.php" method="post">
                <label>Nom de la categorie</label>
                <input type="text" name="categorie_nom" value="<?php echo $row['categorie_nom'] ?>" required>
                <span><?php echo isset($erreurs['categorie_nom']) ? $erreurs['categorie_nom'] : "&nbsp;"  ?></span>
                <input type="hidden" name="categorie_id" value="<?php echo $row['categorie_id'] ?>">
                <input type="submit" name="envoi" value="Envoyez">
            </form>
            <?php else:?>
            <p>Aucune categorie pour cet identifiant</p>
            <?php endif; ?>
        </div>
    </main>
    <footer></footer>
</body>
