<?php
/**
 * Fonction errSQL
 * Auteur : P21
 * Date   : 
 * But    : afficher le message d'erreur de la dernière "query" SQL 
 * Arguments en entrée : $conn = contexte de connexion
 * Valeurs de retour   : aucune
 */
function errSQL($conn) {
    ?>
    <p>Erreur de requête : <?php echo mysqli_errno($conn)." – ".mysqli_error($conn) ?></p> 
    <?php 
}
/**
 * Fonction sqlControlerUtilisateur
 * Auteur : Guillaumee

 * Date   : 
 * But    : contrôler l'authentification de l'utilisateur dans la table utilisateurs
 * Arguments en entrée : $conn = contexte de connexion
 *                       $identifiant
 *                       $mot_de_passe
 * Valeurs de retour   : 1 si utilisateur avec $identifiant et $mot_de_passe trouvé 
 */
function sqlControlerUtilisateur($conn, $identifiant, $mot_de_passe) {
    $req = "SELECT * FROM utilisateurs
            WHERE utilisateur_nom=? AND utilisateur_mot_passe = SHA2(?, 256)";
    $stmt= mysqli_prepare($conn, $req);
    mysqli_stmt_bind_param($stmt, "ss", $identifiant, $mot_de_passe);
    if(mysqli_stmt_execute($stmt)){
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_num_rows($result);
    } else {
        errSQL($conn);
        exit;
    }
}
/**
 * Fonction sqlLireUser
 * Auteur : Guillaumee

 * Date   : 
 * But    : contrôler l'authentification de l'utilisateur dans la table utilisateurs
 * Arguments en entrée : $conn = contexte de connexion
 *                       $identifiant
 *                       $mot_de_passe
 * Valeurs de retour   : 1 si utilisateur avec $identifiant et $mot_de_passe trouvé 
 */
function sqlLireUser($conn, $identifiant) {
    $req = "SELECT utilisateur_type FROM utilisateurs
            WHERE utilisateur_nom=?";
    $stmt= mysqli_prepare($conn, $req);
    mysqli_stmt_bind_param($stmt, "s", $identifiant);
    if(mysqli_stmt_execute($stmt)){
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_array($result);
    } else {
        errSQL($conn);
        exit;
    }
}
/*-------------------------------------GESTION DES PRODUITS------------------------------------------*/
/**
* Fonction sqlLireCatalogue
* Auteur : Guillaume
* Date :
* But : Récupérer les produits  
* Arguments en entrée : $conn = contexte de connexion
* $id = clé primaire
* Valeurs de retour : $row = ligne correspondant à la clé primaire
* tableau vide si non trouvée
*/
function sqlListerCatalogue($conn) {
    $req = "SELECT 
P.produit_id,
P.produit_nom,
P.produit_desc,
P.produit_prix,
P.produit_qty,
C.categorie_nom
FROM produits AS P 
INNER JOIN categories AS C ON P.produit_fk_categories=C.categorie_id";
    
    if ($result = mysqli_query($conn, $req, MYSQLI_STORE_RESULT)) {
        $nbResult = mysqli_num_rows($result);
        $liste = array();
        if ($nbResult) {
            
            $produit_id= "";
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                
                if ($produit_id != $row['produit_id']) {
                    
                    if ($produit_id !== "") {
                        $liste [] = array(
                                    'produit_id'                 => $produit_id,
                                    'produit_nom'               => $produit_nom,
                                    'produit_desc'              => $produit_desc,
                                    'produit_prix'              => $produit_prix,
                                    'produit_qty'               => $produit_qty,
                                    'categorie_nom'                => $categorie_nom
                                    );
                    }
                    $produit_id                 = $row['produit_id'];
                    $produit_nom                = $row['produit_nom'];
                    $produit_desc               = $row['produit_desc'];
                    $produit_prix               = $row['produit_prix'];
                    $produit_qty                = $row['produit_qty'];
                    $categorie_nom              =  $row['categorie_nom'];
                }
            }
            $liste [] = array(
                                    'produit_id'                 => $produit_id,
                                    'produit_nom'               => $produit_nom,
                                    'produit_desc'              => $produit_desc,
                                    'produit_prix'              => $produit_prix,
                                    'produit_qty'               => $produit_qty,
                                    'categorie_nom'             => $categorie_nom);
        }
        mysqli_free_result($result);
        return $liste;
    } else {
        errSQL($conn);
        exit;
    }
}
/**
 * Fonction sqlLireProduit
 * Auteur : Guillaume
 * Date   : 
 * But    : Récupérer le produit par son identifiant clé primaire 
 * Arguments en entrée : $conn = contexte de connexion
 *                       $id   = clé primaire
 * Valeurs de retour   : $row  = ligne correspondant à la clé primaire
 *                               tableau vide si non trouvée     
 */
function sqlLireProduit($conn, $id) {

    $req = "SELECT 
                P.produit_id,
                P.produit_nom,
                P.produit_desc,
                P.produit_prix,
                P.produit_qty,
                P.produit_fk_categories,
                C.categorie_nom
            FROM produits AS P 
                INNER JOIN categories AS C ON P.produit_fk_categories=C.categorie_id
            WHERE P.produit_id=?";
    
   $stmt= mysqli_prepare($conn, $req);
     mysqli_stmt_bind_param($stmt, "s", $id);
    if(mysqli_stmt_execute($stmt)){
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_array($result);
    } else {
        errSQL($conn);
        exit;
    }
}
/**
* Fonction sqlModifierProduit
* Auteur : Guillaume
* Date :
* But : modifier une ligne dans la table produits
* Arguments en entrée : $conn = contexte de connexion
* $id = clé primaire du produit à modifier
* 
* Valeurs de retour : 1 si modification effectuée
* 0 si aucune modification
*/
function sqlModifierProduit($conn, $id, $produit_nom, $produit_desc, $produit_prix, $produit_quantite, $categorie) {

    $req = "UPDATE produits 
            SET 
            produit_nom=?,
            produit_desc=?,
            produit_prix=?,
            produit_qty=?,
            produit_fk_categories=?
            WHERE produit_id =?";
    $stmt = mysqli_prepare($conn, $req);
    mysqli_stmt_bind_param($stmt, "ssssss", $produit_nom, $produit_desc, $produit_prix, $produit_quantite,$categorie,$id);
   if (mysqli_stmt_execute($stmt)) {
        return mysqli_stmt_affected_rows($stmt);
    } else {
        errSQL($conn);
        exit;
    }
}
/**
* Fonction sqlSuppressionProduit
* Auteur : Guillaume
* Date :
* But : modifier une ligne dans la table produits
* Arguments en entrée : $conn = contexte de connexion
* $id = clé primaire du produit à modifier
* 
* Valeurs de retour : 1 si modification effectuée
* 0 si aucune modification
*/
function sqlSuppressionProduit($conn, $id) {

    $req = "DELETE FROM produits WHERE produit_id=?";
    $stmt = mysqli_prepare($conn, $req);
        mysqli_stmt_bind_param($stmt, "s", $id);
    if (mysqli_stmt_execute($stmt)) {
 
        return mysqli_stmt_affected_rows($stmt);
 
    } else {
 
        errSQL($conn);
 
        exit;
 
    }
}
/**
* Fonction sqlAjoutProduit
* Auteur : Guillaume
* Date :
* But : Ajouter une ligne dans la table produits
* Arguments en entrée : $conn = contexte de connexion
* $id = clé primaire du produit à modifier
* 
* Valeurs de retour : 1 si modification effectuée
* 0 si aucune modification
*/
function sqlAjoutProduit($conn, $produit_nom, $produit_desc, $produit_prix, $produit_qty, $produit_categorie) {

    $req = "INSERT INTO produits (produit_nom, produit_desc, produit_prix, produit_qty, produit_fk_categories)
VALUES (?, ?, ?, ?, ?); ";
    $stmt = mysqli_prepare($conn, $req);
    mysqli_stmt_bind_param($stmt, "sssss", $produit_nom, $produit_desc, $produit_prix, $produit_qty,$produit_categorie);
   if (mysqli_stmt_execute($stmt)) {
        return mysqli_stmt_affected_rows($stmt);
    } else {
        errSQL($conn);
        exit;
    }
}
/**
 * Fonction sqlLireProduitFk
 * Auteur : Guillaume
 * Date   : 
 * But    : Récupérer le produit par son identifiant clé primaire 
 * Arguments en entrée : $conn = contexte de connexion
 *                       $id   = clé primaire
 * Valeurs de retour   : $row  = ligne correspondant à la clé primaire
 *                               tableau vide si non trouvée     
 */
function sqlLireProduitFk($conn, $id) {

    $req = "SELECT 
            cp_fk_commandes,cp_fk_produits,qty_produit
            FROM commandes_produits
            WHERE cp_fk_produits=?";
    
     $stmt = mysqli_prepare($conn, $req);
    mysqli_stmt_bind_param($stmt, "s", $id);
  if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $nbResult = mysqli_num_rows($result);
        $row = array();
        if ($nbResult) {
            mysqli_data_seek($result, 0);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        }
        mysqli_free_result($result);
        return $row;
    } else {
        errSQL($conn);
        exit;
    }
}


/*-------------------------------------GESTION DES CLIENTS------------------------------------------*/
/**
* Fonction sqlListerClient
* Auteur : Guillaume
* Date :
* But : Récupérer les produits  
* Arguments en entrée : $conn = contexte de connexion
* $id = clé primaire
* Valeurs de retour : $row = ligne correspondant à la clé primaire
* tableau vide si non trouvée
*/
function sqlListerClient($conn, $recherche = "") {
    $req = "SELECT client_id, client_nom,client_prenom,client_adresse,client_telephone FROM clients
    WHERE client_nom LIKE '%$recherche%'";
    if ($result = mysqli_query($conn, $req, MYSQLI_STORE_RESULT)) {
        $nbResult = mysqli_num_rows($result);
        $liste = array();
        if ($nbResult) {
            
            $client_id= "";
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                
                if ($client_id != $row['client_id']) {
                    
                    if ($client_id !== "") {
                        $liste [] = array(
                                    'client_id'                 => $client_id,
                                    'client_nom'               => $client_nom,
                                    'client_prenom'              => $client_prenom,
                                    'client_adresse'              => $client_adresse,
                                    'client_telephone'               => $client_telephone
                                    );
                    }
                    $client_id                 = $row['client_id'];
                    $client_nom                = $row['client_nom'];
                    $client_prenom               = $row['client_prenom'];
                    $client_adresse               = $row['client_adresse'];
                    $client_telephone                = $row['client_telephone'];
                  
                }
            }
            $liste [] = array(
                                    'client_id'                  => $client_id,
                                    'client_nom'                 => $client_nom,
                                    'client_prenom'              => $client_prenom,
                                    'client_adresse'             => $client_adresse,
                                    'client_telephone'           => $client_telephone);
        }
        mysqli_free_result($result);
        return $liste;
    } else {
        errSQL($conn);
        exit;
    }
}
/**
 * Fonction sqlLireClient
 * Auteur : Guillaume
 * Date   : 
 * But    : Récupérer le produit par son identifiant clé primaire 
 * Arguments en entrée : $conn = contexte de connexion
 *                       $id   = clé primaire
 * Valeurs de retour   : $row  = ligne correspondant à la clé primaire
 *                               tableau vide si non trouvée     
 */
function sqlLireClient($conn, $id) {

    $req = "SELECT client_id, client_nom,client_prenom,client_adresse,client_telephone FROM clients
            WHERE client_id=?";
    
    $stmt = mysqli_prepare($conn, $req);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $nbResult = mysqli_num_rows($result);
        $row = array();
        if ($nbResult) {
            mysqli_data_seek($result, 0);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        }
        mysqli_free_result($result);
        return $row;
    } else {
        errSQL($conn);
        exit;
    }
}

/**
* Fonction sqlModifierClient
* Auteur : Guillaume
* Date :
* But : modifier une ligne dans la table produits
* Arguments en entrée : $conn = contexte de connexion
* $id = clé primaire du produit à modifier
* 
* Valeurs de retour : 1 si modification effectuée
* 0 si aucune modification
*/
function sqlModifierClient($conn, $id, $client_nom, $client_prenom, $client_adresse, $client_telephone) {

    $req = "UPDATE clients 
            SET 
            client_nom='$client_nom',
            client_prenom='$client_prenom',
            client_adresse='$client_adresse',
            client_telephone='$client_telephone'
            WHERE client_id = ".$id;

    if (mysqli_query($conn, $req)) {
 
        return mysqli_affected_rows($conn);
 
    } else {
 
        errSQL($conn);
 
        exit;
 
    }
}
/**
 * Fonction sqlAjoutClient
 * Auteur : Guillaume
 * Date   : 
 * But    : Récupérer le produit par son identifiant clé primaire 
 * Arguments en entrée : $conn = contexte de connexion
 *                       $id   = clé primaire
 * Valeurs de retour   : $row  = ligne correspondant à la clé primaire
 *                               tableau vide si non trouvée     
 */
function sqlAjoutClient($conn, $client_nom, $client_prenom, $client_adresse, $client_telephone) {

    $req = "INSERT INTO clients (client_nom, client_prenom, client_adresse, client_telephone)
    VALUES ('$client_nom', '$client_prenom', '$client_adresse', '$client_telephone')";
   if (mysqli_query($conn, $req)) {
 
        return mysqli_affected_rows($conn);
 
    } else {
 
        errSQL($conn);
 
        exit;
 
    }

}
/**
* Fonction sqlSuppressionClient
* Auteur : Guillaume
* Date :
* But : modifier une ligne dans la table client
* Arguments en entrée : $conn = contexte de connexion
* $id = clé primaire du produit à modifier
* 
* Valeurs de retour : 1 si modification effectuée
* 0 si aucune modification
*/
function sqlSuppressionClient($conn, $id, $boo) {

    $req1 = "DELETE FROM clients WHERE client_id = ".$id;

    if (mysqli_query($conn, $req1)) {
        return mysqli_affected_rows($conn);
    } else {
 
        errSQL($conn);
 
        exit;
 
    }
}
/*-------------------------------------GESTION DES CATEGORIE------------------------------------------*/
/**
 * Fonction sqlListerCategorie
 * Auteur : Guillaume
 * Date   : 
 * But    : Récupérer les categories  
 * Arguments en entrée : $conn = contexte de connexion
 *                     
 * Valeurs de retour   : $row  = ligne correspondant à la clé primaire
 *                               tableau vide si non trouvée   
 *Dans une boucle, car sinon vas seulemennt retourner une seul col
 */
function sqlListerCategorie($conn) {

    $req = "SELECT categorie_id, categorie_nom FROM categories";
    
     if ($result = mysqli_query($conn, $req, MYSQLI_STORE_RESULT)) {
        $nbResult = mysqli_num_rows($result);
        $liste = array();
        if ($nbResult) {
            
            $categorie_id= "";
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                
                if ($categorie_id != $row['categorie_id']) {
                    
                    if ($categorie_id !== "") {
                        $liste [] = array(
                                    'categorie_id'                 => $categorie_id,
                                    'categorie_nom'               => $categorie_nom,
                                    );
                    }
                    $categorie_id                 = $row['categorie_id'];
                    $categorie_nom                = $row['categorie_nom'];
                }
            }
            $liste [] = array(
                                    'categorie_id'                 => $categorie_id,
                                    'categorie_nom'               => $categorie_nom,
            );
        }
        mysqli_free_result($result);
        return $liste;
    } else {
        errSQL($conn);
        exit;
    }
}
/**
 * Fonction sqlAjoutCategorie
 * Auteur : Guillaume
 * Date   : 
 * But    : Récupérer le produit par son identifiant clé primaire 
 * Arguments en entrée : $conn = contexte de connexion
 *                       $id   = clé primaire
 * Valeurs de retour   : $row  = ligne correspondant à la clé primaire
 *                               tableau vide si non trouvée     
 */
function sqlAjoutCategorie($conn, $categorie_nom) {

    $req = "INSERT INTO categories (categorie_nom)
    VALUES ('$categorie_nom')";
   if (mysqli_query($conn, $req)) {
 
        return mysqli_affected_rows($conn);
 
    } else {
 
        errSQL($conn);
 
        exit;
 
    }

}
/**
 * Fonction sqlLireCategorie
 * Auteur : Guillaume
 * Date   : 
 * But    : Récupérer le produit par son identifiant clé primaire 
 * Arguments en entrée : $conn = contexte de connexion
 *                       $id   = clé primaire
 * Valeurs de retour   : $row  = ligne correspondant à la clé primaire
 *                               tableau vide si non trouvée     
 */
function sqlLireCategorie($conn, $id) {

    $req = "SELECT categorie_id, categorie_nom FROM categories
            WHERE categorie_id=".$id;
    
    if ($result = mysqli_query($conn, $req)) {
        $nbResult = mysqli_num_rows($result);
        $row = array();
        if ($nbResult) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        }
        mysqli_free_result($result);
        return $row;
    } else {
        errSQL($conn);
        exit;
    }
}
/**
* Fonction sqlModifierCategorie
* Auteur : Guillaume
* Date :
* But : modifier une ligne dans la table produits
* Arguments en entrée : $conn = contexte de connexion
* $id = clé primaire du produit à modifier
* 
* Valeurs de retour : 1 si modification effectuée
* 0 si aucune modification
*/
function sqlModifierCategorie($conn, $id, $categorie_nom) {

    $req = "UPDATE categories 
            SET 
            categorie_nom='$categorie_nom'
            WHERE categorie_id = ".$id;

    if (mysqli_query($conn, $req)) {
 
        return mysqli_affected_rows($conn);
 
    } else {
 
        errSQL($conn);
 
        exit;
 
    }
}
/*-------------------------------------GESTION DE LA COMMANDE------------------------------------------*/

/**
* Fonction sqlAchatProduits
* Auteur : Guillaume
* Date :
* But : Enregistrer la commande 
* Arguments en entrée : $conn = contexte de connexion
* 
* Valeurs de retour : $row = ligne correspondant à la clé primaire
* tableau vide si non trouvée
*/
function sqlAchatProduits($conn, $produits, $clientId, $client_adresse, $commande_etat, $commande_com="") {

    // mise-à-jour de la quantité des produits
    try {
        // Début de la transaction
        $conn->begin_transaction();

        foreach($produits as $produitId => $quantiteAchat) {
            
            // UPDATE quantité disponible du produit
            $stmt = $conn->prepare("UPDATE produits SET produit_qty = produit_qty - ? WHERE produit_id = ?");
            $stmt->bind_param('ii', $quantiteAchat, $produitId);
            $stmt->execute();
            
        }  
    } catch (Exception $e) {
        
        $conn->rollback();
    }
    
    // création de la commande
    $sql = "INSERT INTO commandes (commande_adresse,commande_desc,commande_etat,commande_date, commande_fk_client) VALUES ('$client_adresse','$commande_com','$commande_etat',NOW(), $clientId)";
    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        /*
        $sql = "UPDATE commandes SET commande_numero = $last_id WHERE commande_id = $last_id";
        $conn->query($sql);
        */
        // ajout des lignes de commandes
        try {
            // Début de la transaction
            

            foreach($produits as $produitId => $quantiteAchat) {

                // UPDATE quantité disponible du produit
                $stmt = $conn->prepare("INSERT INTO commandes_produits (cp_fk_commandes, cp_fk_produits, qty_produit) VALUES (?, ?, ?)");
                $stmt->bind_param('iii', $last_id, $produitId, $quantiteAchat);
                $stmt->execute();

            }

            $conn->commit();

        } catch (Exception $e) {
            
            $conn->rollback();
        }
        
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}
/**
 * Fonction sqlListerCommande
 * Auteur : Guillaume
 * Date   : 
 * But    : Récupérer les commandes 
 * Arguments en entrée : $conn = contexte de connexion
 * Valeurs de retour   : $liste = tableau des commandes
 */
function sqlListerCommande($conn, $premierResult,$limit, $recherche = "") {

    $req = "SELECT C.commande_id,CL.client_nom,CL.client_prenom,C.commande_adresse,C.commande_date, CP.cp_fk_commandes,C.commande_desc, P.produit_id,C.commande_etat,CP.cp_fk_produits, C.commande_date,P.produit_nom,P.produit_prix,CP.qty_produit,
    (P.produit_prix * CP.qty_produit) + (15 * (P.produit_prix * CP.qty_produit)/100 ) AS TTC
    FROM commandes AS C
    INNER JOIN commandes_produits AS CP ON CP.cp_fk_commandes=C.commande_id
    INNER JOIN produits AS P ON CP.cp_fk_produits=P.produit_id
    INNER JOIN clients AS CL ON C.commande_fk_client=CL.client_id
    WHERE client_nom LIKE \"%$recherche%\"
    ORDER BY C.commande_id
    LIMIT $premierResult, $limit";
    
    if ($result = mysqli_query($conn, $req, MYSQLI_STORE_RESULT)) {
        $nbResult = mysqli_num_rows($result);
        $liste = array();
        if ($nbResult) {

        
            $commande_id = "";
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                //if ($commande_id != $row['commande_id']) {
                    if ($commande_id !== "") {
                        $liste [] = array(
                                    'commande_id'       => $commande_id,
                                    'TTC'               =>$ttc,
                                    'client_nom'            => $client_nom,
                                    'client_prenom'         => $client_prenom,
                                    'commande_adresse'      => $commande_adresse,
                                    'commande_date'      => $commande_date,
                                    'commande_desc'         => $commande_desc,
                                    'commande_etat'         => $commande_etat,
                                    'produits'              =>  $produits,
                                    'prix'                  =>$prix,
                                    'commandes_produits'    => $commandes_produits
                                    );
                    }
                    $commande_id         =$row['commande_id'];
                    $ttc                 =$row['TTC'];
                    $client_nom          = $row['client_nom'];
                    $client_prenom       = $row['client_prenom'];
                    $commande_adresse    = $row['commande_adresse'];
                    $commande_desc       = $row['commande_desc'];
                    $commande_date       = $row['commande_date'];
                    $commande_etat       = $row['commande_etat'];
                    $produits            = [];
                    $prix                = [];
                    $commandes_produits  = [];
                    
               // }
                $produits           [$row['produit_id']] = $row['produit_nom'];
                $commandes_produits [$row['cp_fk_produits']] = $row['qty_produit'];
                $prix               [$row['produit_id']] = $row['produit_prix'];
            }
            $liste [] = array(

                                'commande_id'           => $commande_id,
                                'TTC'                   =>$ttc,
                                'client_nom'            => $client_nom,
                                'client_prenom'         => $client_prenom,
                                'commande_adresse'      => $commande_adresse,
                                'commande_desc'         => $commande_desc,
                                'commande_date'         => $commande_date,
                                'commande_etat'         => $commande_etat,
                                'produits'              =>  $produits,
                                'prix'                  =>$prix,
                                'commandes_produits'    => $commandes_produits
                        );
        }
        mysqli_free_result($result);
        return $liste;
    } else {
        errSQL($conn);
        exit;
    }
}
/**
 * Fonction sqlNumRows
 * Auteur : Guillaume
 * Date   : 
 * But    : Récupérer le produit par son identifiant clé primaire 
 * Arguments en entrée : $conn = contexte de connexion
 *                       $id   = clé primaire
 * Valeurs de retour   : $row  = ligne correspondant à la clé primaire
 *                               tableau vide si non trouvée     
 */
function sqlNumRows($conn, $table) {

    $req = "SELECT * FROM $table";
    
    if ($result = mysqli_query($conn, $req)) {
        $nbResult = mysqli_num_rows($result);
        return $nbResult;
    } else {
        errSQL($conn);
        exit;
    }
}
/**
 * Fonction sqlLireCommande
 * Auteur : Guillaume
 * Date   : 
 * But    : Récupérer le produit par son identifiant clé primaire 
 * Arguments en entrée : $conn = contexte de connexion
 *                       $id   = clé primaire
 * Valeurs de retour   : $row  = ligne correspondant à la clé primaire
 *                               tableau vide si non trouvée     
 */
function sqlLireCommande($conn, $id) {

    $req = "SELECT 
            commande_id,commande_fk_client,commande_etat,commande_desc,commande_adresse,commande_date
            FROM commandes
            WHERE commande_id=".$id;
    
    if ($result = mysqli_query($conn, $req)) {
        $nbResult = mysqli_num_rows($result);
        $row = array();
        if ($nbResult) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        }
        mysqli_free_result($result);
        return $row;
    } else {
        errSQL($conn);
        exit;
    }
}
/**
 * Fonction sqlLireCommandeFk
 * Auteur : Guillaume
 * Date   : 
 * But    : Récupérer le produit par son identifiant clé primaire 
 * Arguments en entrée : $conn = contexte de connexion
 *                       $id   = clé primaire
 * Valeurs de retour   : $row  = ligne correspondant à la clé primaire
 *                               tableau vide si non trouvée     
 */
function sqlLireCommandeFk($conn, $id) {

    $req = "SELECT 
            commande_id,commande_fk_client
            FROM commandes
            WHERE commande_fk_client=".$id;
    
    if ($result = mysqli_query($conn, $req)) {
        $nbResult = mysqli_num_rows($result);
        $row = array();
        if ($nbResult) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        }
        mysqli_free_result($result);
        return $row;
    } else {
        errSQL($conn);
        exit;
    }
}
/**
* Fonction sqlSuppressionCommande
* Auteur : Guillaume
* Date :
* But : modifier une ligne dans la table client
* Arguments en entrée : $conn = contexte de connexion
* $id = clé primaire du produit à modifier
* 
* Valeurs de retour : 1 si modification effectuée
* 0 si aucune modification
*/
function sqlSuppressionCommande($conn, $id) {

    $req1 = "DELETE FROM commandes_produits WHERE cp_fk_commandes = ".$id;
    $req2 = "DELETE FROM commandes WHERE commande_id = ".$id;
    if (mysqli_query($conn, $req1)) {
 
         if (mysqli_query($conn, $req2)) {
 
        return mysqli_affected_rows($conn);
 
        } else {
 
            errSQL($conn);
 
            exit;
 
        }
 
    } else {
 
        errSQL($conn);
 
        exit;
 
    }
}
/**
* Fonction sqlModifierCommande
* Auteur : Guillaume
* Date :
* But : modifier une ligne dans la table produits
* Arguments en entrée : $conn = contexte de connexion
* $id = clé primaire du produit à modifier
* 
* Valeurs de retour : 1 si modification effectuée
* 0 si aucune modification
*/
function sqlModifierCommande($conn, $id, $commande_etat, $commande_adresse, $commande_fk_client, $commande_desc="") {

    $req = "UPDATE commandes 
            SET 
            commande_etat='$commande_etat',
            commande_adresse='$commande_adresse',
            commande_fk_client='$commande_fk_client',
            commande_desc='$commande_desc'
            WHERE commande_id = $id";

    if (mysqli_query($conn, $req)) {
 
        return mysqli_affected_rows($conn);
 
    } else {
 
        errSQL($conn);
 
        exit;
 
    }
}
/*-------------------------------------GESTION DE L'UTILISATEUR------------------------------------------*/
/**
* Fonction sqlListerUtilisateur
* Auteur : Guillaume
* Date :
* But : Récupérer les produits  
* Arguments en entrée : $conn = contexte de connexion
* $id = clé primaire
* Valeurs de retour : $row = ligne correspondant à la clé primaire
* tableau vide si non trouvée
*/
function sqlListerUtilisateur($conn, $recherche = "") {
    $req = "SELECT utilisateur_id,utilisateur_type ,utilisateur_nom,utilisateur_mot_passe FROM utilisateurs";
    if ($result = mysqli_query($conn, $req, MYSQLI_STORE_RESULT)) {
        $nbResult = mysqli_num_rows($result);
        $liste = array();
        if ($nbResult) {
            
            $utilisateur_id= "";
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                
                if ($utilisateur_id != $row['utilisateur_id']) {
                    
                    if ($utilisateur_id !== "") {
                        $liste [] = array(
                                    'utilisateur_id'                 => $utilisateur_id,
                                    'utilisateur_type'               => $utilisateur_type,
                                    'utilisateur_nom'              => $utilisateur_nom,
                                    'utilisateur_mot_passe'              => $utilisateur_mot_passe
                                    );
                    }
                    $utilisateur_id                 = $row['utilisateur_id'];
                    $utilisateur_type                = $row['utilisateur_type'];
                    $utilisateur_nom               = $row['utilisateur_nom'];
                    $utilisateur_mot_passe               = $row['utilisateur_mot_passe'];
                  
                }
            }
            $liste [] = array(
                                    'utilisateur_id'                 => $utilisateur_id,
                                    'utilisateur_type'               => $utilisateur_type,
                                    'utilisateur_nom'              => $utilisateur_nom,
                                    'utilisateur_mot_passe'              => $utilisateur_mot_passe);
        }
        mysqli_free_result($result);
        return $liste;
    } else {
        errSQL($conn);
        exit;
    }
}
/**
 * Fonction sqlAjoutUtilisateur
 * Auteur : Guillaume
 * Date   : 
 * But    : Récupérer le produit par son identifiant clé primaire 
 * Arguments en entrée : $conn = contexte de connexion
 *                       $id   = clé primaire
 * Valeurs de retour   : $row  = ligne correspondant à la clé primaire
 *                               tableau vide si non trouvée     
 */
function sqlAjoutUtilisateur($conn, $utilisateur_nom, $utilisateur_type, $utilisateur_mot_passe) {

    $req = "INSERT INTO utilisateurs (utilisateur_nom, utilisateur_type, utilisateur_mot_passe)
    VALUES ('$utilisateur_nom','$utilisateur_type',SHA2('$utilisateur_mot_passe', 256))";
   if (mysqli_query($conn, $req)) {
 
        return mysqli_affected_rows($conn);
 
    } else {
 
        errSQL($conn);
 
        exit;
 
    }

}
/**
 * Fonction sqlLireUtilisateur
 * Auteur : Guillaume
 * Date   : 
 * But    : Récupérer l'utilisateur par son identifiant clé primaire 
 * Arguments en entrée : $conn = contexte de connexion
 *                       $id   = clé primaire
 * Valeurs de retour   : $row  = ligne correspondant à la clé primaire
 *                               tableau vide si non trouvée     
 */
function sqlLireUtilisateur($conn, $id) {

    $req = "SELECT 
            utilisateur_id,utilisateur_nom,utilisateur_type,utilisateur_mot_passe
            FROM utilisateurs
            WHERE utilisateur_id=".$id;
    
    if ($result = mysqli_query($conn, $req)) {
        $nbResult = mysqli_num_rows($result);
        $row = array();
        if ($nbResult) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        }
        mysqli_free_result($result);
        return $row;
    } else {
        errSQL($conn);
        exit;
    }
}
/**
* Fonction sqlSuppressionUtilisateur
* Auteur : Guillaume
* Date :
* But : modifier une ligne dans la table client
* Arguments en entrée : $conn = contexte de connexion
* $id = clé primaire du produit à modifier
* 
* Valeurs de retour : 1 si modification effectuée
* 0 si aucune modification
*/
function sqlSuppressionUtilisateur($conn, $id) {

    $req = "DELETE FROM utilisateurs WHERE utilisateur_id = ".$id;
    if (mysqli_query($conn, $req)) {
        
        return mysqli_affected_rows($conn);
        
    } else {
 
        errSQL($conn);
 
        exit;
 
    }
}
/**
* Fonction sqlModifierUtilisateur
* Auteur : Guillaume
* Date :
* But : modifier une ligne dans la table produits
* Arguments en entrée : $conn = contexte de connexion
* $id = clé primaire du produit à modifier
* 
* Valeurs de retour : 1 si modification effectuée
* 0 si aucune modification
*/
function sqlModifierUtilisateur($conn, $id, $utilisateur_nom, $utilisateur_type, $utilisateur_mot_passe) {

    $req = "UPDATE utilisateurs 
            SET 
            utilisateur_nom='$utilisateur_nom',
            utilisateur_type='$utilisateur_type',
            utilisateur_mot_passe=SHA2('$utilisateur_mot_passe', 256)
            WHERE utilisateur_id = $id";

    if (mysqli_query($conn, $req)) {
 
        return mysqli_affected_rows($conn);
 
    } else {
 
        errSQL($conn);
 
        exit;
 
    }
}
?>