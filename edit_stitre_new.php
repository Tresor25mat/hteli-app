<?php
session_start();
require_once ("connexion.php");
$Token = $_POST['token'];
$ID_STitre = htmlentities($_POST['ID_STitre']);
$Design = Securite::bdd($_POST['Design']);
$Nombre = htmlentities($_POST['Nombre']);
if ($Token == $_SESSION['user_eteelo_app']['token']) {
    $rs = $pdo->prepare("UPDATE table_sous_titre_new SET Design_Sous_Titre=?, Nombre_Photo=? WHERE ID_Sous_Titre=?");
    $params = array($Design, $Nombre, $ID_STitre);
    $rs->execute($params);
    echo "1";
}
?>