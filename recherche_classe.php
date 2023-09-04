<?php
    require_once ("connexion.php");
    $Ecole=$_POST['Ecole'];
    $rech=$pdo->query("SELECT * FROM classe INNER JOIN table_option ON classe.ID_Option=table_option.ID_Option INNER JOIN section ON table_option.ID_Section=section.ID_Section WHERE section.ID_Etablissement=".$Ecole." ORDER BY classe.Design_Classe");
    $list="";
    while ($rechs=$rech->fetch()){
        $list.='<option value="'.$rechs['ID_Classe'].'">'.stripslashes($rechs['Design_Classe']).'</option>'; 
    }
    echo ($list);
?>