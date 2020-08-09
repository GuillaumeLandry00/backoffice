<?php
require_once("inc/sessionUtilisateur.php");
require_once("inc/connectDB.php");
require_once("inc/sql.php");

$liste = sqlListerClient($conn); // fonction dans sql.php 
$listeProduit = sqlListerCatalogue($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $produits = array();
        /*------------------------*/
        if(isset($_POST['checkbox'])){
            if(!isset($_SESSION['commande'])){

                //Permet vérifier que aumoins des checkbox sont cochés
                if(isset($_POST['checkbox'])){
                    // parcourir les checkbox cochés
                    foreach ($_POST['checkbox'] as $produitId) {
                        // aller chercher la quantité demandée par l'usager
                        $quantiteAchat = $_POST['quantity_' . $produitId];
                        $produits[$produitId] = $quantiteAchat; 
                    }
                }
                $_SESSION['commande']=$produits;
            }
        }
        //Permet d'aller chercher l'état de la commande
        $etatCommande=$_POST['leRadio'];   
        //Permet d'aller chercher la veleur du select
        $infoClient=$_POST['select'];
        //Permet d'aller chercher si il y a des commentaires
        $comCommande=$_POST['commentaire'];                 
        /*------------------------*/
        if(isset($_POST['commander'])){
            
            //Permet d'aller chercher les infos du client selectionné
            $row = sqlLireClient($conn, $infoClient);
            // procéder à l'achat et permet ajouter commentaire si il y a lieu
            $comCommande=$_POST['commentaire'];
            $listeAchat = sqlAchatProduits($conn, $_SESSION['commande'], $row['client_id'],$row['client_adresse'],$etatCommande,$comCommande);
             unset($_SESSION['commande']);
             $retSql= "Commande effectuée";
            
               
            
        }
    
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Catalogue">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <title>Catalogue</title>
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
        <h1>Catalogue du Vendeur</h1>

        <form action="CatalogueVendeur.php" method="post">
            <div id="conteneur">
                <table>
                    <tr>
                        <th>Catégorie</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Qty en stock</th>
                        <th>Commandé</th>
                        <th>Nombre</th>
                    </tr>
                    <?php  foreach ($listeProduit as $produit) : 
                ?>

                    <tr>
                        <td><?php echo $produit['categorie_nom'] ?></td>
                        <td><?php echo $produit['produit_nom'] ?></td>
                        <td><?php echo $produit['produit_desc'] ?></td>
                        <td><?php echo $produit['produit_prix'] ?>$</td>
                        <td><?php echo $produit['produit_qty'] ?></td>
                        <td><input type="checkbox" name="checkbox[]" value="<?php echo $produit['produit_id'] ?>"></td>
                        <td><input type="number" name="quantity_<?php echo $produit['produit_id'] ?>" min="1" value="1" max="<?php echo $produit['produit_qty']?>"></td>

                    </tr>

                    <?php endforeach;?>
                </table>
            </div>
            <div id="conteneurSec">
                <!-- Select permetant de choisir le client -->

                <label>Veuillez choisir un client</label>
                <select name="select">
                    <?php foreach ($liste as $client):?>
                    <option value="<?php echo $client['client_id']?>" <?php if (isset($infoClient) && $infoClient==$client['client_id']) echo ' selected';?>>
                    <?php echo $client['client_nom'] . "  " .  $client['client_prenom']?></option>
                    <?php endforeach;?>
                </select>


                <!-- Radio pour décider l'état de la commande-->
                <fieldset>
                    <label for="leRadio">État de la commande</label>
                    En cours
                    <input type="radio" name="leRadio" value="En cours" checked="checked">
                    En attente
                    <input type="radio" name="leRadio" value="En attente" <?php if (isset($etatCommande) && $etatCommande=="En attente") echo 'checked="checked"';?>>
                </fieldset>

                <!-- Permet d'ajouter des commentaires -->
                <label for="commentaire">Ajouter des commentaires</label>
                <input type="text" name="commentaire" value="<?php echo isset($comCommande) ? $comCommande : ""  ?>" placeholder="Ajouter des informations">
                <input type="submit" name="commanderpreview" value="commander">
                <p style="color: green;"><?php echo isset($retSql) ? $retSql : "&nbsp;" ?></p>
                <?php if(isset($_POST['commanderpreview'])):?>
                    <div id="">
                        <?php 
                            if(count($produits)>0):
                                //Permet d'initialiser le prix total à zero
                                $prixTotal=0;
                            ?>
                            <h1>Confirmez-vous la commande</h1>
                            <table>
                            <tr>
                                    <th>Produit</th>
                                    <th>Quantité</th>
                                    <th>Prix</th>
                            </tr>
                            <?php foreach($produits as $produitId => $quantiteAchat):
                                $temp= sqlLireProduit($conn, $produitId);
                                $prixUnit=$temp['produit_prix'];
                                $prix= $prixUnit *$quantiteAchat;
                                $prixTotal+=$prix;
                            ?>
                                <tr>
                                    <th><?php echo $temp['produit_nom']?></th>
                                    <th><?php echo $quantiteAchat?></th>
                                    <th><?php echo $prixUnit ?> $</th>
                                </tr>
                            <?php endforeach; 
                             mysqli_close($conn);?>

                            </table>
                            <h4>Prix total avant taxes:  <span><?php echo $prixTotal ?> $</span></h4>
                            <h4>Prix total après  taxes: <span><?php echo round($prixTotal *1.15, 2)?> $</span></h4>
                            <input type="submit" name="commander" value="OUI"> 
                            <button type="button" id="non">NON</button>
                            
                        <?php else: ?>
                            <p>Vous devez au moins en selectionner un produit</p>
                        <?php endif; ?>
                    </div>
                <?php endif;?>
            </div>
        </form>
    </main>
    <footer>

    </footer>
</body>
