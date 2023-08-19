<?php
    require_once ("connexion.php");
    $Ecole=$_POST['Ecole'];
    $rech=$pdo->query("SELECT * FROM section WHERE ID_Etablissement=".$Ecole." ORDER BY Design_Section");
    $list="";
    while ($rechs=$rech->fetch()){
        $list.='<option value="'.$rechs['ID_Section'].'">'.stripslashes($rechs['Design_Section']).'</option>'; 
    }
    echo ($list);
?>