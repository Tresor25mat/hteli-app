<?php
    session_start(); 
    require_once("connexion.php");
    $Token=$_POST['token'];
    $Design=Securite::bdd($_POST['Design']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rech=$pdo->query("SELECT * FROM table_rectifier_model WHERE UPPER(Design_Rectifier_Model)='".strtoupper($Design)."'");
        if($rechs=$rech->fetch()){
            echo "2";
        }else{
            $rs=$pdo->prepare("INSERT INTO table_rectifier_model (Design_Rectifier_Model) VALUES (?)");
            $params=array($Design);
            $rs->execute($params);
            $select_max=$pdo->query("SELECT MAX(ID_Rectifier_Model) AS ID_Rectifier_Model FROM table_rectifier_model");
            $select_maxs=$select_max->fetch();
            $rech=$pdo->query("SELECT * FROM table_rectifier_model ORDER BY Design_Rectifier_Model");
            $list="";
            while ($rechs=$rech->fetch()){
                if($select_maxs['ID_Rectifier_Model']==$rechs['ID_Rectifier_Model']){
                    $list.='<option value="'.$rechs['ID_Rectifier_Model'].'" selected>'.stripslashes($rechs['Design_Rectifier_Model']).'</option>';
                }else{
                    $list.='<option value="'.$rechs['ID_Rectifier_Model'].'">'.stripslashes($rechs['Design_Rectifier_Model']).'</option>';
                } 
            }
            echo ($list);
        }
    }
?>