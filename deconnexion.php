<?php
session_start();
unset($_SESSION['identifiant_utilisateur']); // ou session_unset()
session_destroy();
header('Location: authentification.php'); 
?>