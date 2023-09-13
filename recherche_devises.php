<?php
    require_once ("connexion.php");
    $Ecole=$_POST['Ecole'];
    $rech=$pdo->query("SELECT * FROM taux_change INNER JOIN table_taux ON taux_change.ID_Taux=table_taux.ID_Taux WHERE table_taux.ID_Etablissement=".$Ecole." ORDER BY taux_change.Devise");
    $list="";
    while ($rechs=$rech->fetch()){
        if(isset($_POST['ID_Taux']) && $_POST['ID_Taux']!='' && $_POST['ID_Taux']==$rechs['ID_Taux']){
            $list.='<option value="'.$rechs['ID_Taux'].'" selected>'.stripslashes($rechs['Devise']).'</option>';
        }else if($rechs['Active']==1){
            $list.='<option value="'.$rechs['ID_Taux'].'" selected>'.stripslashes($rechs['Devise']).'</option>';
        }else{
            $list.='<option value="'.$rechs['ID_Taux'].'">'.stripslashes($rechs['Devise']).'</option>';  
        }
    }
    echo ($list);
?>