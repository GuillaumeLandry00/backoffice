<?php
require_once("inc/sessionUtilisateur.php");
require_once("inc/connectDB.php");
require_once("inc/sql.php");

// retour du formulaire de confirmation
// ------------------------------------
        
$confirme = isset($_POST['confirme']) ? $_POST['confirme'] : "";

if ($confirme !== ""):
    if ($confirme === "OUI") {
        $id = $_POST['categorie_id'];
        $codRet = sqlSuppressionCategorie($conn, $id);
        if      ($codRet === 1)  $message = "Suppression effectuée.";
        elseif  ($codRet === 0)  $message = "Aucune supression.";
    } 
    else {
        $message = "Suppression non effectuée.";
    }
else:
    
    // lecture du categorie à supprimer
    // ----------------------------

    $id = isset($_GET['id']) ? $_GET['id'] : "";                
    $produit = array();
    if ( $id !== "" ) $categorie = sqlLireCategorie($conn, $id);
    if ( $id !== "" ) $avertisement = sqlLireCategorieFk($conn, $id);
endif;

mysqli_close($conn);

?>

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Suppression d'une categorie">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Suppression d'une categorie</title>
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
        <a href="ListeCategorie.php">Retour à la liste</a>
        </header>
        <h1>Suppression d'une categorie</h1>
        <div id="pageAjout">
            <?php if(isset($avertisement)):?>
                <?php if (count($avertisement) > 0) : ?>
            <?php endif;?>
                <p>*AVERTISEMENT: cette categorie est lié a des produits, vous devez supprimer les produits liés à cette categorie</p>
                <?php else: ?>

                        <?php if(isset($categorie)):?>
                            <?php if (count($categorie) > 0) : ?>
                        <?php endif;?>
                            <section>
                                <p>Confirmez la suppression du produit <?php echo $categorie['categorie_nom']?></p>
                                <form class="form-suppression" action="SuppressionCategorie.php" method="post"> 
                                    <input type="hidden" name="categorie_id" value="<?php echo $id ?>">
                                    <input type="submit" name="confirme" value="OUI"> 
                                    <input type="submit" name="confirme" value="NON">
                                </form>
                            </section>
                        <?php else : ?>
                            <p><?php echo isset($message) ? $message : "Il n'y a pas de client pour cet identifiant." ?></p>
                        <?php endif; ?>
                        
                <?php endif;?>
        </div>
    </main>
    <footer></footer>
</body>

