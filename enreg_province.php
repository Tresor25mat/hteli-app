<?php
session_start();
require_once ("connexion.php");
$Token = $_POST['token'];
$Design = Securite::bdd($_POST['Design']);
$Pays = htmlentities($_POST['Pays']);
if ($Token == $_SESSION['user_eteelo_app']['token']) {
    $rech = $pdo->query("SELECT * FROM province WHERE UPPER(Design_Prov)='" . strtoupper($Design) . "'");
    if ($rechs = $rech->fetch()) {
        echo "2";
    } else {
        $rs = $pdo->prepare("INSERT INTO province (Design_Prov, ID_Pays) VALUES (?, ?)");
        $params = array($Design, $Pays);
        $rs->execute($params);
        echo "1";
    }
}
?>