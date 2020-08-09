<?php
require_once("inc/sessionUtilisateur.php");
require_once("inc/connectDB.php");
require_once("inc/sql.php");
$liste = sqlListerClient($conn); // fonction dans sql.php 
mysqli_close($conn);?>


<head>
    <meta charset="UTF-8">
    <meta name="description" content="Liste client">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Liste des clients</title>
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
        <a class="ajout" href="AjoutClient.php">Ajout d'un client</a>
        <h1>Liste des clients</h1>
        <div id="conteneur">
            <table>
                <tr>
                    <th>Id</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Adresse</th>
                    <th>Téléphone</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($liste as $client) : 
                ?>
                <tr>
                    <td><?php echo $client['client_id'] ?></td>
                    <td><?php echo $client['client_nom'] ?></td>
                    <td><?php echo $client['client_prenom'] ?></td>
                    <td><?php echo $client['client_adresse'] ?></td>
                    <td><?php echo $client['client_telephone'] ?></td>
                    <td><a href="<?php echo 'ModificationClient.php?id='.$client['client_id']?>">Modifier</a> | <a href="<?php echo 'SuppressionClient.php?id='.$client['client_id']?>">Suppression</a></td>
                </tr>
                <?php endforeach;?>
            </table>
        </div>
    </main>
    <footer>

    </footer>
</body>

