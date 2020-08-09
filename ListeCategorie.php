<?php
require_once("inc/sessionUtilisateur.php");
require_once("inc/connectDB.php");
require_once("inc/sql.php");
$liste = sqlListerCategorie($conn); // fonction dans sql.php 
mysqli_close($conn);?>

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Liste client">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liste des categories</title>
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
        <a class="ajout" href="AjoutCategorie.php">Ajout d'une categorie</a>
        <h1>Liste des categories</h1>
        <div id="conteneur">
        <table>
            <tr>
                <th>Id</th>
                <th>Nom</th>
                <th>Action</th>

            </tr>
            <?php foreach ($liste as $row) : 
                ?>
            <tr>
                <td><?php echo $row['categorie_id'] ?></td>
                <td><?php echo $row['categorie_nom'] ?></td>

                <td><a href="<?php echo 'ModificationCategorie.php?id='.$row['categorie_id']?>">Modifier</a> | <a href="<?php echo 'SuppressionCategorie.php?id='.$row['categorie_id']?>">Suppression</a></td>
            </tr>
            <?php endforeach;?>
        </table>
        </div>
    </main>
    <footer>

    </footer>
</body>
