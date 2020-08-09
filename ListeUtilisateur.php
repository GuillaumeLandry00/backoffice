<?php
require_once("inc/sessionUtilisateur.php");
require_once("inc/connectDB.php");
require_once("inc/sql.php");
$liste = sqlListerUtilisateur($conn); // fonction dans sql.php 
mysqli_close($conn);?>

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Liste client">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liste des utilisateurs</title>
</head>

<body>

    <main>
         <header>
         <span class="deconnexion">
                <?php
                if (isset($_SESSION['identifiant_utilisateur'])) {
                    echo "<a href='deconnexion.php'>Déconnexion</a>"." de " . $_SESSION['identifiant_utilisateur'];
                }
        ?>
            </span>
       <?php //echo $_SESSION['utilisateur_type'][0]?>
        <nav>
           <a href="CatalogueVendeur.php">Passer commande</a>
           <a href="ListeCommande.php">Liste des commandes</a>
           <a href="PageListeClients.php">Liste des Clients</a>
           <?php if($_SESSION['utilisateur_type'][0]=="G"):?>
                <a href="Catalogues.php">Liste des produits</a>
                <a href="ListeCategorie.php">Liste des categories</a>
           <?php endif; ?>
           <?php if($_SESSION['utilisateur_type'][0]=="A"):?>
                <a href="Catalogues.php">Liste des produits</a>
                <a href="ListeCategorie.php">Liste des categories</a>
                <a href="ListeUtilisateur.php">Liste des utilisateurs</a>
            <?php endif; ?>
        </nav>
        </header>
        <a class="ajout" href="AjoutUtilisateur.php">Ajout d'un Utilisateur</a>
        <h1>Liste des utilisateurs</h1>
        <div id="conteneur">
        <table>
            <tr>
                <th>Id</th>
                <th>Type</th>
                <th>Username</th>
                <th>Mot de passe</th>
                <th>Actions</th>

            </tr>
            <?php foreach ($liste as $row) : 
                ?>
            <tr>
                <td><?php echo $row['utilisateur_id'] ?></td>
                <td><?php echo $row['utilisateur_type'] ?></td>
                <td><?php echo $row['utilisateur_nom'] ?></td>
                <td><?php echo $row['utilisateur_mot_passe'] ?></td>

                <td><a href="<?php echo 'ModificationUtilisateur.php?id='.$row['utilisateur_id']?>">Modifier</a> | <a href="<?php echo 'SuppressionUtilisateur.php?id='.$row['utilisateur_id']?>">Suppression</a></td>
            </tr>
            <?php endforeach;?>
        </table>
        </div>
    </main>
    <footer>
            
    </footer>
</body>

