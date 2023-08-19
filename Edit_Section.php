<?php
    session_start();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $ID_Section=$_POST['ID_Section'];
    $Design=Securite::bdd($_POST['Design']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("UPDATE section SET Design_Section=? WHERE ID_Section=?");
        $params=array($Design, $ID_Section);
        $rs->execute($params);
        echo "1";
    }
?>