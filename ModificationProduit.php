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
    
    $row['produit_id'] = $_POST['produit_id']; // récupération clé primaire dans un champ caché
       
    $row['produit_nom'] = trim($_POST['produit_nom']);
    if (!preg_match('/^[a-z àéèêôâ]+$/i', $row['produit_nom'])) {
        $erreurs['produit_nom'] = "Nom incorrect.";
    }
    
    $row['produit_desc'] = trim($_POST['produit_desc']);
    if (!preg_match('/^[a-z àéèêôâ]+$/i', $row['produit_desc'])) {
        $erreurs['produit_desc'] = "Description incorrect.";
    }
    
    $row['produit_prix'] = trim($_POST['produit_prix']);
    if (!preg_match('/^\d+(.\d{2})?$/i', $row['produit_prix'])) {
        $erreurs['produit_prix'] = "Prix incorrect.";
    }
    
    $row['produit_qty'] = trim($_POST['produit_qty']);
    if (!preg_match('/^\d+$/i', $row['produit_qty'])) {
        $erreurs['produit_qty'] = "Quantité incorrect.";
    }
    
    $row['produit_fk_categorie_id'] = $_POST['produit_fk_categorie_id'];
   
    
    
    // insertion dans la table joueurs si aucune erreur
    // -----------------------------------------------
    
    if (count($erreurs) === 0) {
     if (sqlModifierProduit($conn, $row['produit_id'], $row['produit_nom'], $row['produit_desc'], $row['produit_prix'], $row['produit_qty'], $row['produit_fk_categorie_id']) === 1) {
 
         $retSQL="Modification effectuée.";
 
     } else {
 
         $retSQL ="Modification non effectuée.";
    }
}
} else {

 // lecture du produit à modifier, à la première ouverture de la page
 // ---------------------------------------------------------------
 $id = isset($_GET['id']) ? $_GET['id'] : "";
 $row = array();
 if ( $id !== "" ) $row = sqlLireProduit($conn, $id);
}

 


?>

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Modification d'un produit">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modification d'un produit</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<header>
    <span class="deconnexion">
        <?php
                if (isset($_SESSION['identifiant_utilisateur'])) {
                    echo "<a href='deconnexion.php'>Déconnexion</a>"." de " . $_SESSION['identifiant_utilisateur'];
                }?>
    </span>
    <a href="Catalogues.php">HOME</a>
</header>

<body>
    <main>
        <?php// echo var_dump($listeCategorie)?>
        <h1>Modification d'un produit</h1>
        <p><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></p>
        <div id="pageAjout">
            <?php if (count($row) > 0) : ?>

            <form action="ModificationProduit.php" method="post">
                <label>Nom du produit</label>
                <input type="text" name="produit_nom" value="<?php echo $row['produit_nom'] ?>" required>
                <span><?php echo isset($erreurs['produit_nom']) ? $erreurs['produit_nom'] : "&nbsp;"  ?></span>

                <label>Description du produit</label>
                <input type="text" name="produit_desc" value="<?php echo $row['produit_desc'] ?>" required>
                <span><?php echo isset($erreurs['produit_desc']) ? $erreurs['produit_desc'] : "&nbsp;"  ?></span>

                <label>Prix</label>
                <input type="number" name="produit_prix" step="any" value="<?php echo $row['produit_prix'] ?>" required>
                <span><?php echo isset($erreurs['produit_prix']) ? $erreurs['produit_prix'] : "&nbsp;"  ?></span>

                <label>Quantité</label>
                <input type="number" name="produit_qty" value="<?php echo $row['produit_qty'] ?>" required>
                <span><?php echo isset($erreurs['produit_qty']) ? $erreurs['produit_qty'] : "&nbsp;"  ?></span>

                <label>Catégorie</label>
                <select name="produit_fk_categorie_id" id="">
                    <?php foreach ($listeCategorie as $categorie):?>
                    <option <?php if ($categorie['categorie_id'] == $row['produit_fk_categories'] ) echo 'selected' ; ?> value="<?php echo $categorie['categorie_id']?>"><?php echo $categorie['categorie_nom']?></option>
                    <?php endforeach;?>
                </select>
                <input type="hidden" name="produit_id" value="<?php echo $row['produit_id'] ?>">
                <input type="submit" name="envoi" value="Envoyez">
            </form>
            <?php else:?>
            <p>Aucun produit pour cet identifiant</p>
            <?php endif; ?>
        </div>
    </main>
    <footer></footer>
</body>
