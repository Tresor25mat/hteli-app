<?php
    session_start();
    require_once ("connexion.php");
    $token=$_GET['token'];
    $Ecole=$_GET['Ecole'];
    $Annee=$_GET['Annee'];
    $Classe=$_GET['Classe'];
    $Eleve=$_GET['Eleve'];
    $ID = Securite::bdd($_GET['ID']);
    $paiement=$pdo->query("SELECT * FROM paiement WHERE ID_Paiement='".$ID."'");
    $paiements=$paiement->fetch();
    if($token==$_SESSION['user_eteelo_app']['token']){
        $delete_operation=$pdo->query("DELETE FROM operation WHERE ID_Operation=".$paiements['ID_Operation']);
        $delete_operations=$pdo->query("DELETE FROM operation_compte WHERE ID_Operation=".$paiements['ID_Operation']);
        $rs=$pdo->prepare("DELETE FROM paiement WHERE `ID_Paiement`=?");
        $params=array($ID);
        $rs->execute($params);
        header("location:table_paiement.php?Ecole=".$Ecole."&Annee=".$Annee."&Classe".$Classe."&Eleve".$Eleve); 
    }
?>