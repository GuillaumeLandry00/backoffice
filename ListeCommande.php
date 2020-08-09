<?php
require_once("inc/sessionUtilisateur.php");
require_once("inc/connectDB.php");
require_once("inc/sql.php");

$nom_client_recherche = isset($_POST['recherche']) ? trim($_POST['nom_client_recherche']) : "";


//Pagination

//Determine le nombre de résultat par page
$resultPage = 10;

//Permet de donner le nombre de rows
$nbResult=sqlNumRows($conn, "commandes");

//Permet de determiner le nombre de page arrondi
$nbPages=ceil($nbResult/$resultPage);

//Déterminer quelle page est l'usager

if(!isset($_GET['page'])){
    $page=1;
}else{
    $page=$_GET['page'];
}

//Determine le premier resultat de la page 

$premierResult = ($page-1)*$resultPage;

//DEBUG
//echo "OFFSET: ". $premierResult ." LIMIT: ".$resultPage;
   
$liste = sqlListerCommande($conn,$premierResult,$resultPage, $nom_client_recherche); // fonction dans sql.php 

mysqli_close($conn);
?>


<head>

    <meta charset="UTF-8">
    <meta name="description" content="Liste des commandes">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liste des commandes</title>
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
        <fieldset class="recherche">
            <form id="recherche" action="ListeCommande.php" method="post">
                <label>Client</label>
                <input type="text" name="nom_client_recherche" value="<?php echo $nom_client_recherche ?>" placeholder="Recherche par nom">
                <input type="submit" name="recherche" value="Recherchez">
            </form>
        </fieldset>
        <h1>Liste des commandes</h1>
        <div id="conteneur">
            <table>
                <tr>
                    <th>Commande id</th>
                    <th>Prenom client</th>
                    <th>Nom client</th>
                    <th>commande_adresse</th>
                    <th>commande date</th>
                    <th>commande_etat</th>
                    <th>commentaire</th>
                    <th>Nom Produit</th>
                    <th>Qty commandé</th>
                    <th>Prix unitaire</th>
                    <th>Total avec Taxe</th>
                    <th>Action</th>
                </tr>

                <?php foreach ($liste as $commande) : 
                ?>
                <tr>

                    <?php 
                if(!isset($last)){
                    $last=0;
                }
                if($commande['commande_id']!=$last):
              
                ?>
                    <td><?php echo $commande['commande_id']?></td>
                    <td><?php echo $commande['client_prenom'] ?></td>
                    <td><?php echo $commande['client_nom'] ?></td>
                    <td><?php echo $commande['commande_adresse']?></td>
                    <td><?php echo $commande['commande_date']?></td>
                    <td><?php echo $commande['commande_etat']?></td>
                    <td><?php echo $commande['commande_desc']?></td>
                    <?php else: ?>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>ITEM SUIVANT DE COMMANDE <?php echo $commande['commande_id'] ?></td>
                    <?php endif; ?>
                    <td><?php echo implode("<br>", $commande['produits']) ?></td>
                    <td><?php echo implode("<br>", $commande['commandes_produits']) ?></td>
                    <td><?php echo implode("<br>", $commande['prix']) ?> $</td>
                    <td><?php  echo round($commande['TTC'], 2) ?> $</td>

                    <td>
                        <?php if($commande['commande_id']!=$last): 
                    $last=$commande['commande_id'];?>
                        <a href="<?php echo 'ModificationCommande.php?id='.$commande['commande_id']?>">Modification</a>
                        <br>
                        <a href="<?php echo 'SuppressionCommande.php?id='.$commande['commande_id']?>">Suppression</a>
                    </td>
                    <?php endif ?>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <span class="pagination">
            <?php 
        //Permet d'afficher les liens entre chaque page
        for($page=1;$page<$nbPages;$page++){
            echo '<a href="ListeCommande.php?page=' . $page . '">'." " . $page . '</a>';
        }
        
        ?>
        </span>

    </main>
    <footer>
    
    </footer>
</body>
