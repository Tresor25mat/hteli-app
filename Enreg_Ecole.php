<?php
    session_start(); 
    require_once("connexion.php");
    $Token=$_POST['token'];
    $Design=Securite::bdd($_POST['Design']);
    $Description=Securite::bdd($_POST['Description']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rech=$pdo->query("SELECT * FROM etablissement WHERE UPPER(Design_Etablissement)='".strtoupper($Design)."'");
        if($rechs=$rech->fetch()){
            echo "2";
        }else{
            $rs=$pdo->prepare("INSERT INTO etablissement (Design_Etablissement, Description_Etablissement) VALUES (?, ?)");
            $params=array($Design, $Description);
            $rs->execute($params);
            echo "1";
        }
    }
?>