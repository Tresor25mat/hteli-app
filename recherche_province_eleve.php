<?php
    require_once ("connexion.php");
    $Eleve=$_POST['ID_Eleve'];
    $info=$pdo->query("SELECT * FROM eleve WHERE ID_Eleve='".$Eleve."'");
    $infos=$info->fetch();
    $origine=$pdo->query("SELECT * FROM commune INNER JOIN ville ON commune.ID_Ville=ville.ID_Ville INNER JOIN province ON ville.ID_Prov=province.ID_Prov WHERE commune.ID_Commune=".$infos['ID_Commune_Orig']);
    $origines=$origine->fetch();
    $rech=$pdo->query("SELECT * FROM province ORDER BY Design_Prov");
    $list="";
    while ($rechs=$rech->fetch()){
        if($rechs['ID_Prov']==$origines['ID_Prov']){
            $list.='<option value="'.$rechs['ID_Prov'].'" selected>'.stripslashes($rechs['Design_Prov']).'</option>'; 
        }else{
            $list.='<option value="'.$rechs['ID_Prov'].'">'.stripslashes($rechs['Design_Prov']).'</option>'; 
        }
    }
    echo ($list);
?>