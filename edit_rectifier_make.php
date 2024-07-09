<?php
    session_start(); 
    require_once("connexion.php");
    $Token=$_POST['token'];
    $ID_Rectifier_Make=$_POST['ID'];
    $Design=Securite::bdd($_POST['Design']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("UPDATE table_rectifier_make SET Design_Rectifier_Make=? WHERE ID_Rectifier_Make=?");
        $params=array($Design, $ID_Rectifier_Make);
        $rs->execute($params);
        echo "1";
    }
?>