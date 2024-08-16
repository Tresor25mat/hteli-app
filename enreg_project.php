<?php
session_start();
require_once ("connexion.php");
$Token = $_POST['token'];
$Design = Securite::bdd($_POST['Design']);
$Nombre = htmlentities($_POST['Nombre']);
if ($Token == $_SESSION['user_eteelo_app']['token']) {
    $rech = $pdo->query("SELECT * FROM table_project WHERE UPPER(Design_Project)='" . strtoupper($Design) . "'");
    if ($rechs = $rech->fetch()) {
        echo "2";
    } else {
        $rs = $pdo->prepare("INSERT INTO table_project (Design_Project, Nombre_Photo) VALUES (?,?)");
        $params = array($Design, $Nombre);
        $rs->execute($params);
        echo "1";
    }
}
?>