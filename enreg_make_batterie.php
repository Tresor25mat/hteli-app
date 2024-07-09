<?php
    session_start(); 
    require_once("connexion.php");
    $Token=$_POST['token'];
    $Design=Securite::bdd($_POST['Design']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rech=$pdo->query("SELECT * FROM table_make_batterie WHERE UPPER(Design_Make_Batterie)='".strtoupper($Design)."'");
        if($rechs=$rech->fetch()){
            echo "2";
        }else{
            $rs=$pdo->prepare("INSERT INTO table_make_batterie (Design_Make_Batterie) VALUES (?)");
            $params=array($Design);
            $rs->execute($params);
            echo "1";
        }
    }
?>