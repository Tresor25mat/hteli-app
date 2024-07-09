<?php
    session_start(); 
    require_once("connexion.php");
    $Token=$_POST['token'];
    $ID_Rectifier_Model=$_POST['ID'];
    $Design=Securite::bdd($_POST['Design']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("UPDATE table_rectifier_model SET Design_Rectifier_Model=? WHERE ID_Rectifier_Model=?");
        $params=array($Design, $ID_Rectifier_Model);
        $rs->execute($params);
        echo "1";
    }
?>