<?php
    session_start();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $Design=Securite::bdd($_POST['Design']);
    $ID_Categorie=htmlentities($_POST['ID_Categorie']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("UPDATE categorie_eleve SET Design_Categorie=? WHERE ID_Categorie=?");
        $params=array($Design, $ID_Categorie);
        $rs->execute($params);
        echo "1";
    }
?>