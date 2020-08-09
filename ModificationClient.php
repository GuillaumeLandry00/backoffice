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
    
    $row['client_id'] = $_POST['client_id']; // récupération clé primaire dans un champ caché
       
    $row['client_nom'] = trim($_POST['client_nom']);
    if (!preg_match('/^[a-zàéèêôâ]+$/i', $row['client_nom'])) {
        $erreurs['client_nom'] = "Nom incorrect.";
    }
    
    $row['client_prenom'] = trim($_POST['client_prenom']);
    if (!preg_match('/^[a-zàéèêôâ]+$/i', $row['client_prenom'])) {
        $erreurs['client_prenom'] = "Prenom incorrect.";
    }
    
    $row['client_adresse'] = trim($_POST['client_adresse']);
    if (!preg_match('/^[\da-z àéèêôâ]+$/i', $row['client_adresse'])) {
        $erreurs['client_adresse'] = "Adresse incorrect.";
    }
    
    $row['client_telephone'] = trim($_POST['client_telephone']);
    if (!preg_match('/^(438|514)-\d{3}-\d{4}$/i', $row['client_telephone'])) {
        $erreurs['client_telephone'] = "Telephone incorrect doit être un 438 ou 514 et respecter le format suivant 514-000-0000";
    }
    
    // insertion dans la table joueurs si aucune erreur
    // -----------------------------------------------
    
    if (count($erreurs) === 0) {
        if (sqlModifierClient($conn, $row['client_id'], $row['client_nom'], $row['client_prenom'], $row['client_adresse'],                     $row['client_telephone']) === 1) {
 
            $retSQL="Modification effectuée.";
 
        }
        else {
 
            $retSQL ="Modification non effectuée.";
        }
    }
} else {

 // lecture du client à modifier, à la première ouverture de la page
 // ---------------------------------------------------------------
 $id = isset($_GET['id']) ? $_GET['id'] : "";
 $row = array();
 if ( $id !== "" ) $row = sqlLireClient($conn, $id);
}

 


?>


<head>
    <meta charset="UTF-8">
    <meta name="description" content="Modification d'un client">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modification d'un client</title>
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
        <a href="PageListeClients.php">HOME</a>
    </header>
    <main>
        <?php// echo var_dump($listeCategorie)?>
        <h1>Modification d'un client</h1>
        <p><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></p>
        <div id="pageAjout">
            <?php if (count($row) > 0) : ?>

            <form action="ModificationClient.php" method="post">
                <label>Nom du client</label>
                <input type="text" name="client_nom" value="<?php echo $row['client_nom'] ?>" required>
                <span><?php echo isset($erreurs['client_nom']) ? $erreurs['client_nom'] : "&nbsp;"  ?></span>

                <label>Prenom du client</label>
                <input type="text" name="client_prenom" value="<?php echo $row['client_prenom'] ?>" required>
                <span><?php echo isset($erreurs['client_prenom']) ? $erreurs['client_prenom'] : "&nbsp;"  ?></span>

                <label>Adresse</label>
                <input type="text" name="client_adresse" value="<?php echo $row['client_adresse'] ?>" required>
                <span><?php echo isset($erreurs['client_adresse']) ? $erreurs['client_adresse'] : "&nbsp;"  ?></span>

                <label>Téléphone</label>
                <input type="text" name="client_telephone" value="<?php echo $row['client_telephone'] ?>" required>
                <span><?php echo isset($erreurs['client_telephone']) ? $erreurs['client_telephone'] : "&nbsp;"  ?></span>

                <input type="hidden" name="client_id" value="<?php echo $row['client_id'] ?>">
                <input type="submit" name="envoi" value="Envoyez">
            </form>
            <?php else:?>
            <p>Aucun client pour cet identifiant</p>
            <?php endif; ?>
        </div>
    </main>
    <footer></footer>
</body>
