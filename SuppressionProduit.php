<?php
require_once("inc/sessionUtilisateur.php");
require_once("inc/connectDB.php");
require_once("inc/sql.php");

// retour du formulaire de confirmation
// ------------------------------------
        
$confirme = isset($_POST['confirme']) ? $_POST['confirme'] : "";

if ($confirme !== ""):
    if ($confirme === "OUI") {
        $id = $_POST['produit_id'];
        $codRet = sqlSuppressionProduit($conn, $id);
        if      ($codRet === 1)  $message = "Suppression effectuée.";
        elseif  ($codRet === 0)  $message = "Aucune supression.";
    } 
    else {
        $message = "Suppression non effectuée.";
    }
else:
    
    // lecture du produit à supprimer
    // ----------------------------

    $id = isset($_GET['id']) ? $_GET['id'] : "";                
    $produit = array();
    if ( $id !== "" ) $produit = sqlLireProduit($conn, $id);
    if ( $id !== "" ) $avertisement = sqlLireProduitFk($conn, $id);
endif;

mysqli_close($conn);

?>

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Suppression d'un produit"><meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Suppression d'un produit</title>
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
       <a href="Catalogues.php">Retour à la liste</a>
    </header>
        <h1>Suppression du produit</h1>
        <div id="pageAjout">
            <p><?php echo isset($message) ? $message : "&nbsp;" ?></p>
            <?php if(isset($avertisement)):?>
                <?php if (count($avertisement) > 0) : ?>
                <p>*AVERTISEMENT: ce produit est lié a des commandes, vous devez supprimer les commandes liés à ce produit</p>
                <?php else: ?>


                        <?php if (count($produit) > 0) : ?>
                            <section>
                                <p>Confirmez la suppression du produit <?php echo $produit['produit_nom']?></p>
                                <form class="form-suppression" action="SuppressionProduit.php" method="post"> 
                                    <input type="hidden" name="produit_id" value="<?php echo $id ?>">
                                    <input type="submit" name="confirme" value="OUI"> 
                                    <input type="submit" name="confirme" value="NON">
                                </form>
                            </section>
                        <?php else : ?>
                            <p>Il n'y a pas de produit pour cet identifiant.</p>
                        <?php endif; ?>
                        
                <?php endif;?>
            <?php endif;?>
        </div>
    </main>
    <footer></footer>
</body>

