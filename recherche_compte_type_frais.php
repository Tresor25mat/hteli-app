<?php
    require_once ("connexion.php");
    $Frais=$_POST['Frais'];
    $rech=$pdo->query("SELECT * FROM type_frais INNER JOIN compte ON type_frais.ID_Compte_C=compte.ID_Compte WHERE type_frais.ID_Type_Frais=".$Frais);
    $rechs=$rech->fetch();
    echo ($rechs['ID_Compte'].','.$rechs['ID_Nature']);
?>