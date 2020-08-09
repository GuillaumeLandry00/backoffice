<?php
require_once("inc/sessionUtilisateur.php");
require_once("inc/connectDB.php");
require_once("inc/sql.php");

if (isset($_POST['envoi'])) {
    
    // contrôles des champs saisis
    // ---------------------------
 
     $erreurs = array();
    $row['utilisateur_id'] = $_POST['utilisateur_id']; // récupération clé primaire dans un champ caché
       
    $row['utilisateur_nom'] = trim($_POST['utilisateur_nom']);
    if (!preg_match('/^[a-zàéèêôâ]+$/i',  $row['utilisateur_nom'])) {
        $erreurs['utilisateur_nom'] = "Nom incorrect.";
    }
    $row['utilisateur_type']=$_POST['leSelect'];
    
    $row['utilisateur_mot_passe'] = trim($_POST['utilisateur_mot_passe']);
    if (!preg_match('/^[a-zàéèêôâ]+$/i', $row['utilisateur_mot_passe'])) {
        $erreurs['utilisateur_mot_passe'] = "Mot passe incorrect.";
    }
    
    
    // insertion dans la table joueurs si aucune erreur
    // -----------------------------------------------
    
    if (count($erreurs) === 0) {
     if (sqlModifierUtilisateur($conn, $row['utilisateur_id'], $row['utilisateur_nom'], $row['utilisateur_type'], $row['utilisateur_mot_passe']) === 1) {
 
         $retSQL="Modification effectuée.";
 
     } else {
 
         $retSQL ="Modification non effectuée.";
    }
}
} else {

 $id = isset($_GET['id']) ? $_GET['id'] : "";
 $row = array();
 if ( $id !== "" ) $row = sqlLireUtilisateur($conn, $id);
}


?>

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ajout d'un client">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modification d'un utilisateur</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
 <header>
     <span class="deconnexion">
        <?php
                if (isset($_SESSION['identifiant_utilisateur'])) {
                    echo "<a href='deconnexion.php'>Déconnexion</a>"." de " . $_SESSION['identifiant_utilisateur'];
                }?>
    </span>
      <a href="ListeUtilisateur.php">HOME</a>
 </header>
<body>

    <main>
        <h1>Modification d'un utilisateur</h1>
        <p><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></p>
        <div id="pageAjout">
        <?php if (count($row) > 0) : ?>
        
        <form action="ModificationUtilisateur.php" method="post">
            <label>Username</label>
            <input type="text" name="utilisateur_nom" value="<?php echo $row['utilisateur_nom'] ?>" required>
            <span><?php echo isset($erreurs['utilisateur_nom']) ? $erreurs['utilisateur_nom'] : "&nbsp;"  ?></span>

            <label>Mot de passe</label>
            <input type="text" name="utilisateur_mot_passe" value="<?php echo  $row['utilisateur_mot_passe'] ?>" required>
            <span><?php echo isset($erreurs['utilisateur_mot_passe']) ? $erreurs['utilisateur_mot_passe'] : "&nbsp;"  ?></span>

            <label>Type d'utilisateur</label>
            <select name="leSelect" id="">
                <!-- le if permet de selectionner un select par défaut -->
                <option <?php if ($row['utilisateur_type'] == "V" ) echo 'selected' ; ?> value="V">Vendeur</option>
                <option <?php if ($row['utilisateur_type'] == "G" ) echo 'selected' ; ?> value="G">Gestionnaire</option>
                <option <?php if ($row['utilisateur_type'] == "A" ) echo 'selected' ; ?> value="A">Administateur</option>
            </select>
            <input type="hidden" name="utilisateur_id" value="<?php echo $row['utilisateur_id'] ?>">
            <input type="submit" name="envoi" value="Envoyez">
        </form>
         <?php else:?>
        <p >Aucun produit pour cet identifiant</p>
        <?php endif; ?>
        </div>
    </main>
    <footer></footer>
</body>
