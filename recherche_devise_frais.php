<?php
    require_once ("connexion.php");
    $Frais=$_POST['Frais'];
    $Annee=$_POST['Annee'];
    $rech=$pdo->query("SELECT * FROM frais INNER JOIN taux_change ON frais.ID_Taux=taux_change.ID_Taux WHERE frais.ID_Type_Frais=".$Frais." AND frais.ID_Annee=".$Annee);
    $rechs=$rech->fetch();
    echo $rechs['Devise'];
?>