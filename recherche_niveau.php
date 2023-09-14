<?php
    require_once ("connexion.php");
    if(isset($_POST['Option']) && $_POST['Option']!=''){
        $Option=$_POST['Option'];
        $rech=$pdo->query("SELECT * FROM niveau INNER JOIN classe ON niveau.ID_Niveau=classe.ID_Niveau WHERE classe.ID_Option=".$Option." ORDER BY niveau.ID_Niveau");
    }else{
        $rech=$pdo->query("SELECT * FROM niveau INNER JOIN classe ON niveau.ID_Niveau=classe.ID_Niveau ORDER BY niveau.ID_Niveau");
    }
    $list="";
    $classe="";
    while($rechs=$rech->fetch()){
        if($classe!=$rechs['ID_Niveau']){
            $classe=$rechs['ID_Niveau'];
            $list.='<option value="'.$rechs['ID_Niveau'].'">'.stripslashes($rechs['Design_Niveau']).'</option>';
        }
    }
    echo ($list);
?>