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
       
   $produit_nom = trim($_POST['produit_nom']);
    if (!preg_match('/^[a-z àéèêôâ]+$/i', $produit_nom)) {
        $erreurs['produit_nom'] = "Nom incorrect.";
    }
    
    $produit_desc = trim($_POST['produit_desc']);
    if (!preg_match('/^[a-z àéèêôâ]+$/i',$produit_desc)) {
        $erreurs['produit_desc'] = "Description incorrect.";
    }
    
   $produit_prix = trim($_POST['produit_prix']);
    if (!preg_match('/^\d+(.\d{2})?$/i', $produit_prix)) {
        $erreurs['produit_prix'] = "Prix incorrect.";
    }
    
    $produit_qty = trim($_POST['produit_qty']);
    if (!preg_match('/^\d+$/i', $produit_qty)) {
        $erreurs['produit_qty'] = "Quantité incorrect.";
    }
    
    $produit_categorie = $_POST['produit_fk_categorie_id'];
   
    
    
    // insertion dans la table joueurs si aucune erreur
    // -----------------------------------------------
    
    if (count($erreurs) === 0) {
     if (sqlAjoutProduit($conn, $produit_nom, $produit_desc, $produit_prix, $produit_qty, $produit_categorie) === 1) {
 
         $retSQL="Ajout effectuée.";
 
     } else {
 
         $retSQL ="Ajout non effectuée.";
    }
}
}

 


?>

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Modification d'un produit">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajout d'un produit</title>
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
        <a href="Catalogues.php">HOME</a>
    </header>
    <main>
        <?php// echo var_dump($listeCategorie)?>
        <h1>Ajout d'un produit</h1>
        <p><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></p>
        <div id="pageAjout">
            <form action="AjoutProduit.php" method="post">
                <label>Nom du produit</label>
                <input type="text" name="produit_nom" required>
                <span><?php echo isset($erreurs['produit_nom']) ? $erreurs['produit_nom'] : "&nbsp;"  ?></span>

                <label>Description du produit</label>
                <input type="text" name="produit_desc" required>
                <span><?php echo isset($erreurs['produit_desc']) ? $erreurs['produit_desc'] : "&nbsp;"  ?></span>

                <label>Prix</label>
                <input type="number" name="produit_prix" step="any" required>
                <span><?php echo isset($erreurs['produit_prix']) ? $erreurs['produit_prix'] : "&nbsp;"  ?></span>

                <label>Quantité</label>
                <input type="number" name="produit_qty" required>
                <span><?php echo isset($erreurs['produit_qty']) ? $erreurs['produit_qty'] : "&nbsp;"  ?></span>

                <label>Catégorie</label>
                <select name="produit_fk_categorie_id" id="">
                    <?php foreach ($listeCategorie as $categorie):?>
                    <option value="<?php echo $categorie['categorie_id']?>"><?php echo $categorie['categorie_nom']?></option>
                    <?php endforeach;?>
                </select>
                <input type="submit" name="envoi" value="Envoyez">
            </form>
        </div>

    </main>
    <footer>

    </footer>
</body>
