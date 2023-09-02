<?php
    require_once ("connexion.php");
    $Ecole=$_POST['Ecole'];
    $rech=$pdo->query("SELECT * FROM table_option INNER JOIN section ON table_option.ID_Section=section.ID_Section WHERE section.ID_Etablissement=".$Ecole." ORDER BY Design_Option");
    $list="";
    while ($rechs=$rech->fetch()){
        if(isset($_POST['ID_Option']) && $_POST['ID_Option']!='' && $_POST['ID_Option']==$rechs['ID_Option']){
            $list.='<option value="'.$rechs['ID_Option'].'" selected>'.stripslashes($rechs['Design_Option']).'</option>'; 
        }else{
            $list.='<option value="'.$rechs['ID_Option'].'">'.stripslashes($rechs['Design_Option']).'</option>'; 
        }
    }
    echo ($list);
?>