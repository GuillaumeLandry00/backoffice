<?php
  
session_start();
if (!isset($_SESSION['identifiant_utilisateur'])) {
    // redirection vers la page authentification.php
    // pour la saisie de l'identifiant et du mot de passe 
    header('Location: authentification.php'); }

?>