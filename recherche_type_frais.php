<?php
    require_once ("connexion.php");
    $Ecole=$_POST['Ecole'];
    $rech=$pdo->query("SELECT * FROM type_frais WHERE ID_Etablissement=".$Ecole." ORDER BY Libelle_Type_Frais");
    $list="";
    while ($rechs=$rech->fetch()){
        if(isset($_POST['ID_Type']) && $_POST['ID_Type']!='' && $_POST['ID_Type']==$rechs['ID_Type_Frais']){
            $list.='<option value="'.$rechs['ID_Type_Frais'].'" selected>'.stripslashes($rechs['Libelle_Type_Frais']).'</option>'; 
        }else{
            $list.='<option value="'.$rechs['ID_Type_Frais'].'">'.stripslashes($rechs['Libelle_Type_Frais']).'</option>'; 
        }
    }
    echo ($list);
?>