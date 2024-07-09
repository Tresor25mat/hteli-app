<?php
    session_start(); 
    require_once("connexion.php");
    $Token=$_POST['token'];
    $Design=Securite::bdd($_POST['Design']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rech=$pdo->query("SELECT * FROM table_rectifier_model WHERE UPPER(Design_Rectifier_Model)='".strtoupper($Design)."'");
        if($rechs=$rech->fetch()){
            echo "2";
        }else{
            $rs=$pdo->prepare("INSERT INTO table_rectifier_model (Design_Rectifier_Model) VALUES (?)");
            $params=array($Design);
            $rs->execute($params);
            echo "1";
        }
    }
?>