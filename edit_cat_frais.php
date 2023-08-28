<?php
    session_start();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $Design=Securite::bdd($_POST['Design']);
    $ID_Type_Frais=htmlentities($_POST['ID_Type_Frais']);
    $Compte_Debit=htmlentities($_POST['Compte_Debit']);
    $Compte_Credit=htmlentities($_POST['Compte_Credit']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("UPDATE type_frais SET Libelle_Type_Frais=?, ID_Compte_D=?, ID_Compte_C=? WHERE ID_Type_Frais=?");
        $params=array($Design, $Compte_Debit, $Compte_Credit, $ID_Type_Frais);
        $rs->execute($params);
        echo "1";
    }
?>