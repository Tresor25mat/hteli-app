<?php
    require_once ("connexion.php");
    $Ecole=$_POST['Ecole'];
    $rech=$pdo->query("SELECT * FROM categorie_eleve WHERE ID_Etablissement=".$Ecole." ORDER BY Design_Categorie");
    $list="";
    while ($rechs=$rech->fetch()){
        if(isset($_POST['ID_Cat']) && $_POST['ID_Cat']!='' && $_POST['ID_Cat']==$rechs['ID_Categorie']){
            $list.='<option value="'.$rechs['ID_Categorie'].'" selected>'.stripslashes($rechs['Design_Categorie']).'</option>'; 
        }else{
            $list.='<option value="'.$rechs['ID_Categorie'].'">'.stripslashes($rechs['Design_Categorie']).'</option>'; 
        }
    }
    echo ($list);
?>