<?php
    session_start(); 
    require_once("connexion.php");
    $Token=$_POST['token'];
    $ID_Make_Batterie=$_POST['ID'];
    $Design=Securite::bdd($_POST['Design']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("UPDATE table_make_batterie SET Design_Make_Batterie=? WHERE ID_Make_Batterie=?");
        $params=array($Design, $ID_Make_Batterie);
        $rs->execute($params);
        echo "1";
    }
?>