<?php
require_once("inc/sessionUtilisateur.php");
require_once("inc/connectDB.php");
require_once("inc/sql.php");

// retour du formulaire de confirmation
// ------------------------------------
        
$confirme = isset($_POST['confirme']) ? $_POST['confirme'] : "";

if ($confirme !== "") {

    if ($confirme === "OUI") {
        $id = $_POST['commande_id'];
        $codRet = sqlSuppressionCommande($conn, $id);
        if      ($codRet === 1)  $message = "Suppression effectuée.";
        elseif  ($codRet === 0)  $message = "Aucune supression.";
    } else {
        $message = "Suppression non effectuée.";
    }

} else {
    
    // lecture du produit à supprimer
    // ----------------------------

    $id = isset($_GET['id']) ? $_GET['id'] : "";                
    $produit = array();
    if ( $id !== "" ) $commande = sqlLireCommande($conn, $id);
}

mysqli_close($conn);

?>

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Suppression d'une commande">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Suppression d'une commande</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <main> 
    <header>
        <span class="deconnexion">
            <?php
                    if (isset($_SESSION['identifiant_utilisateur'])) {
                        echo "<a href='deconnexion.php'>Déconnexion</a>"." de " . $_SESSION['identifiant_utilisateur'];
                    }?>
        </span>
       <a href="ListeCommande.php">Retour à la liste</a>
    </header>
        <h1>Suppression d'une commande</h1>

        <p><?php echo isset($message) ? $message : "&nbsp;" ?></p>
        <div id="pageAjout">
            <?php if (isset($commande)) : ?>
                <?php if (count($commande) > 0) : ?>
                    <section>
                        <p>Confirmez la suppression de la commande #<?php echo $commande['commande_id']?></p>
                        <form class="form-suppression" action="SuppressionCommande.php" method="post"> 
                            <input type="hidden" name="commande_id" value="<?php echo $id ?>">
                            <input type="submit" name="confirme" value="OUI"> 
                            <input type="submit" name="confirme" value="NON">
                        </form>
                    </section>
                <?php else : ?>
                    <p>Il n'y a pas de commande pour cet identifiant.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </main>
    <footer></footer>
</body>
