<?php
    session_start();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $ID_Option=$_POST['ID_Option'];
    $Design=Securite::bdd($_POST['Design']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("UPDATE table_option SET Design_Option=? WHERE ID_Option=?");
        $params=array($Design, $ID_Option);
        $rs->execute($params);
        echo "1";
    }
?>