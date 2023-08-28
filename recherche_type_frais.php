<?php
    require_once ("connexion.php");
    $Ecole=$_POST['Ecole'];
    $rech=$pdo->query("SELECT * FROM type_frais WHERE ID_Etablissement=".$Ecole." ORDER BY Libelle_Type_Frais");
    $list="";
    while ($rechs=$rech->fetch()){
        $list.='<option value="'.$rechs['ID_Type_Frais'].'">'.stripslashes($rechs['Libelle_Type_Frais']).'</option>'; 
    }
    echo ($list);
?>