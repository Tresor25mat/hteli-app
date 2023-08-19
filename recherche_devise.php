<?php
    require_once ("connexion.php");
    $Ecole=$_POST['Ecole'];
    $rech=$pdo->query("SELECT * FROM taux_change INNER JOIN table_taux ON taux_change.ID_Taux=table_taux.ID_Taux WHERE table_taux.ID_Etablissement=".$Ecole." AND table_taux.Active=1");
    $rechs=$rech->fetch();
    echo "1 ".$rechs['Symbole']." = ";
?>