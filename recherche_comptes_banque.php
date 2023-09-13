<?php
    require_once ("connexion.php");
    $Ecole=$_POST['Ecole'];
    $rech=$pdo->query("SELECT * FROM compte INNER JOIN categorie_compte ON compte.ID_Categorie=categorie_compte.ID_Categorie WHERE compte.ID_Etablissement=".$Ecole." AND compte.ID_Nature=2");
    $list="";
    while ($rechs=$rech->fetch()){
        $list.='<option value="'.$rechs['ID_Compte'].'">'.stripslashes($rechs['Cod_Categorie'].$rechs['Cod_Compte'].' '.$rechs['Design_Compte']).'</option>'; 
    }
    echo ($list);
?>