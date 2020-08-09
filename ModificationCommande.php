<?php
require_once("inc/sessionUtilisateur.php");
require_once("inc/connectDB.php");
require_once("inc/sql.php");
$liste = sqlListerClient($conn);

    
   
if (isset($_POST['envoi'])) {
    
    // contrôles des champs saisis
    // ---------------------------
     //Permet d'aller chercher les infos du client selectionné
    if(isset($_POST['select'])){ 
        $infoClient=$_POST['select'];
        $rowClient = sqlLireClient($conn, $infoClient);
    }

    $erreurs = array();
    
    $row['commande_id'] = $_POST['commande_id']; // récupération clé primaire dans un champ caché

    $row['commande_adresse'] = trim($_POST['commande_adresse']);
    if (!preg_match('/^[\da-z àéèêôâ]+$/i', $row['commande_adresse'])) {
        $erreurs['commande_adresse'] = "Adresse incorrect.";
    }
    //Permet aller chercher état de la commande
    $row['commande_etat'] = trim($_POST['leRadio']);
    //Permet d'aller chercher la description
    $row['commande_desc'] = trim($_POST['commande_desc']);
    if (count($erreurs) === 0) {
        if (sqlModifierCommande($conn, $row['commande_id'], $row['commande_etat'], $row['commande_adresse'], $rowClient['client_id'],                     $row['commande_desc']) === 1) {
 
            $retSQL="Modification effectuée.";
 
        }
        else {
 
            $retSQL ="Modification non effectuée.";
        }
    }
} else {

 // lecture de la comande à modifier, à la première ouverture de la page
 // ---------------------------------------------------------------
 $id = isset($_GET['id']) ? $_GET['id'] : "";
 $row = array();
 if ( $id !== "" ) $row = sqlLireCommande($conn, $id);
}
mysqli_close($conn);
?>

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Suppression d'un client">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modification d'une commande</title>
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
            <a href="ListeCommande.php">HOME</a>
        </header>
        <h1>Modification d'une commande</h1>

        <p><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></p>
        <div id="pageAjout">
            <form action="" method="post">
                <!-- Select permetant de choisir le client -->
                <label>Veuillez choisir un client</label>
                <select name="select">
                    <?php 
                //Permet d'éviter un erreur de undefined index
                if(isset($row['commande_fk_client'])){
                    $last=$row['commande_fk_client'];
                }else{
                    $last=$rowClient['client_id'];
                }
                foreach ($liste as $client):?>
                    <option <?php if ($client['client_id'] == $last ) echo 'selected' ; ?> value="<?php echo $client['client_id']?>"><?php echo $client['client_prenom'] . "  " .  $client['client_nom']?>
                    </option>
                    <?php endforeach;?>
                </select>
                <label>Adresse</label>
                <input type="text" name="commande_adresse" value="<?php echo $row['commande_adresse'] ?>" required>
                <span><?php echo isset($erreurs['commande_adresse']) ? $erreurs['commande_adresse'] : "&nbsp;"  ?></span>
                <label for="leRadio">État de la commande</label>
                En cours
                <input type="radio" name="leRadio" value="En cours" checked="checked">
                En attente
                <input type="radio" name="leRadio" value="En attente">
                Annulé
                <input type="radio" name="leRadio" value="Annulé">
                <label for="commande_desc">Ajouter commentaire? UwU</label>
                <input type="text" name="commande_desc" value="<?php  echo isset($row['commande_desc']) ? $row['commande_desc'] : "&nbsp;"  ?>">
                <span><?php echo isset($erreurs['commande_desc']) ? $erreurs['commande_desc'] : "&nbsp;"  ?></span>
                <input type="hidden" name="commande_id" value="<?php echo $row['commande_id'] ?>">
                <input type="submit" name="envoi" value="Envoyez">
            </form>
        </div>
    </main>
    <footer></footer>
</body>
