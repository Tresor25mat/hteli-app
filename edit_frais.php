<?php
    session_start();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $ID_Frais=htmlentities($_POST['ID_Frais']);
    $annee=$pdo->query("SELECT * FROM annee WHERE Encours=1");
    $annees=$annee->fetch();
    $Ecole=htmlentities($_POST['ID_Etablissement']);
    $Type_frais=htmlentities($_POST['type_frais']);
    $Devise=htmlentities($_POST['devise']);
    $Montant=htmlentities($_POST['montant']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $update_frais=$pdo->query("UPDATE frais SET ID_Type_Frais=".$Type_frais.", ID_Annee=".$annees['ID_Annee'].", ID_Taux=".$Devise.", Montant_Frais=".$Montant." WHERE ID_Frais=".$ID_Frais);
        echo "1";
    }
?>