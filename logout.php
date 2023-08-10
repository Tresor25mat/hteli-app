<?php
/*// On démarre la session
session_start ();
// On détruit les variables de notre session
session_unset ();
// On détruit notre session
session_destroy ();
// On redirige le visiteur vers la page d'accueil
*/
session_start();
require_once('connexion.php');
$rec=$pdo->query("UPDATE utilisateur SET Etat=0 WHERE ID_Utilisateur=".$_SESSION['user_slj_wings']['ID_Utilisateur']);
unset($_SESSION);
unset($_COOKIE);
session_destroy();
header ('location: connexion');
?>