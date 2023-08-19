<?php
    session_start(); 
    require_once("connexion.php");
    $Token=$_POST['token'];
    $Devise=htmlentities($_POST['Devise']);
    $Ecole=htmlentities($_POST['Ecole']);
    $Montant=htmlentities($_POST['Montant']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rech=$pdo->query("SELECT * FROM table_taux WHERE ID_Taux=".$Devise." AND ID_Etablissement=".$Ecole);
        if($rechs=$rech->fetch()){
            echo "2";
        }else{
            $rs=$pdo->prepare("INSERT INTO table_taux (ID_Etablissement, ID_Taux, Montant, ID_Utilisateur) VALUES (?,?,?,?)");
            $params=array($Ecole, $Devise, $Montant, $_SESSION['user_eteelo_app']['ID_Utilisateur']);
            $rs->execute($params);
            echo "1";
        }
    }
?>