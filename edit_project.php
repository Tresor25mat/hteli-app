<?php
session_start();
require_once ("connexion.php");
$Token = $_POST['token'];
$ID_Project = $_POST['ID'];
$Design = Securite::bdd($_POST['Design']);
$Nombre = htmlentities($_POST['Nombre']);
if ($Token == $_SESSION['user_eteelo_app']['token']) {
    $rs = $pdo->prepare("UPDATE table_project SET Design_Project=?, Nombre_Photo=? WHERE ID_Project=?");
    $params = array($Design, $Nombre, $ID_Project);
    $rs->execute($params);
    echo "1";
}
?>