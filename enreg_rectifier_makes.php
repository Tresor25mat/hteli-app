<?php
    session_start(); 
    require_once("connexion.php");
    $Token=$_POST['token'];
    $Design=Securite::bdd($_POST['Design']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rech=$pdo->query("SELECT * FROM table_rectifier_make WHERE UPPER(Design_Rectifier_Make)='".strtoupper($Design)."'");
        if($rechs=$rech->fetch()){
            echo "2";
        }else{
            $rs=$pdo->prepare("INSERT INTO table_rectifier_make (Design_Rectifier_Make) VALUES (?)");
            $params=array($Design);
            $rs->execute($params);
            $select_max=$pdo->query("SELECT MAX(ID_Rectifier_Make) AS ID_Rectifier_Make FROM table_rectifier_make");
            $select_maxs=$select_max->fetch();
            $rech=$pdo->query("SELECT * FROM table_rectifier_make ORDER BY Design_Rectifier_Make");
            $list="";
            while ($rechs=$rech->fetch()){
                if($select_maxs['ID_Rectifier_Make']==$rechs['ID_Rectifier_Make']){
                    $list.='<option value="'.$rechs['ID_Rectifier_Make'].'" selected>'.stripslashes($rechs['Design_Rectifier_Make']).'</option>';
                }else{
                    $list.='<option value="'.$rechs['ID_Rectifier_Make'].'">'.stripslashes($rechs['Design_Rectifier_Make']).'</option>';
                } 
            }
            echo ($list);
        }
    }
?>