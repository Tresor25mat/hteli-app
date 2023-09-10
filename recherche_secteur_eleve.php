<?php
    require_once ("connexion.php");
    $Eleve=$_POST['ID_Eleve'];
    $info=$pdo->query("SELECT * FROM eleve WHERE ID_Eleve='".$Eleve."'");
    $infos=$info->fetch();
    $origine=$pdo->query("SELECT * FROM commune INNER JOIN ville ON commune.ID_Ville=ville.ID_Ville INNER JOIN province ON ville.ID_Prov=province.ID_Prov WHERE commune.ID_Commune=".$infos['ID_Commune_Orig']);
    $origines=$origine->fetch();
    $rech=$pdo->query("SELECT * FROM commune WHERE ID_Ville=".$origines['ID_Ville']." ORDER BY Design_Commune");
    $list="";
    while ($rechs=$rech->fetch()){
        if($rechs['ID_Commune']==$origines['ID_Commune']){
            $list.='<option value="'.$rechs['ID_Commune'].'" selected>'.stripslashes($rechs['Design_Commune']).'</option>'; 
        }else{
            $list.='<option value="'.$rechs['ID_Commune'].'">'.stripslashes($rechs['Design_Commune']).'</option>'; 
        }
    }
    echo ($list);
?>