<?php
    session_start(); 
    require_once("connexion.php");
    $Token=$_POST['token'];
    $Design=Securite::bdd($_POST['Design']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rech=$pdo->query("SELECT * FROM etablissement WHERE UPPER(Design_Etablissement)='".strtoupper($Design)."'");
        if($rechs=$rech->fetch()){
            echo "2";
        }else{
            $rs=$pdo->prepare("INSERT INTO etablissement (Design_Etablissement) VALUES (?)");
            $params=array($Design);
            $rs->execute($params);
            echo "1";
        }
    }
?>