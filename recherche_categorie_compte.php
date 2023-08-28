<?php
    require_once ("connexion.php");
    $Ecole=$_POST['Ecole'];
    $rech=$pdo->query("SELECT * FROM categorie_compte WHERE ID_Etablissement=".$Ecole." ORDER BY Cod_Categorie");
    $list="";
    while ($rechs=$rech->fetch()){
        $list.='<option value="'.$rechs['ID_Categorie'].'">'.stripslashes($rechs['Cod_Categorie'].' '.$rechs['Design_Categorie']).'</option>'; 
    }
    echo ($list);
?>