<?php
    require_once ("connexion.php");
    $Ecole=$_POST['Ecole'];
    $rech=$pdo->query("SELECT * FROM taux_change INNER JOIN table_taux ON taux_change.ID_Taux=table_taux.ID_Taux WHERE table_taux.ID_Etablissement=".$Ecole." ORDER BY taux_change.Devise");
    $list="";
    while ($rechs=$rech->fetch()){
        $list.='<option value="'.$rechs['ID_Taux'].'">'.stripslashes($rechs['Devise']).'</option>'; 
    }
    echo ($list);
?>