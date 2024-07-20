<?php
session_start();
$_SESSION['last_activity'] = time();
require_once ("connexion.php");
$token = $_GET['token'];
$ID = Securite::bdd($_GET['ID']);
$IMG = Securite::bdd($_GET['IMG']);
$IMG = 'images/client/' . $IMG;
if ($token == $_SESSION['user_eteelo_app']['token']) {
    $rs = $pdo->prepare("DELETE FROM client WHERE `ID_Cient`=?");
    $params = array($ID);
    $rs->execute($params);
    @unlink($IMG);
    header("location:table_client.php");

}
?>