<?php
    session_start();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $ID_Compte=$_POST['ID_Compte'];
    $Categorie=htmlentities($_POST['Categorie']);
    $Numero=htmlentities($_POST['Numero']);
    $Design=Securite::bdd($_POST['Design']);
    $Nature=htmlentities($_POST['Nature']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("UPDATE compte SET ID_Nature=?, Cod_Compte=?, ID_Categorie=?, Design_Compte=? WHERE ID_Compte=?");
        $params=array($Nature, $Numero, $Categorie, $Design, $ID_Compte);
        $rs->execute($params);
        $update=$pdo->query("UPDATE type_frais SET Libelle_Type_Frais='".$Design."' WHERE ID_Compte=".$ID_Compte);
        echo "1";
    }
?>