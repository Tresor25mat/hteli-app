<?php
session_start();
require_once ("connexion.php");
$Token = $_POST['token'];
$Design = Securite::bdd($_POST['Design']);
$Pays = htmlentities($_POST['Pays']);
$ID = htmlentities($_POST['ID']);
if ($Token == $_SESSION['user_eteelo_app']['token']) {
    $rs = $pdo->prepare("UPDATE province SET Design_Prov=?, ID_Pays=? WHERE ID_Prov=?");
    $params = array($Design, $Pays, $ID);
    $rs->execute($params);
    echo "1";
}
?>