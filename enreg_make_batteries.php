<?php
    session_start(); 
    require_once("connexion.php");
    $Token=$_POST['token'];
    $Design=Securite::bdd($_POST['Design']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rech=$pdo->query("SELECT * FROM table_make_batterie WHERE UPPER(Design_Make_Batterie)='".strtoupper($Design)."'");
        if($rechs=$rech->fetch()){
            echo "2";
        }else{
            $rs=$pdo->prepare("INSERT INTO table_make_batterie (Design_Make_Batterie) VALUES (?)");
            $params=array($Design);
            $rs->execute($params);
            $select_max=$pdo->query("SELECT MAX(ID_Make_Batterie) AS ID_Make_Batterie FROM table_make_batterie");
            $select_maxs=$select_max->fetch();
            $rech=$pdo->query("SELECT * FROM table_make_batterie ORDER BY Design_Make_Batterie");
            $list="";
            while ($rechs=$rech->fetch()){
                if($select_maxs['ID_Make_Batterie']==$rechs['ID_Make_Batterie']){
                    $list.='<option value="'.$rechs['ID_Make_Batterie'].'" selected>'.stripslashes($rechs['Design_Make_Batterie']).'</option>';
                }else{
                    $list.='<option value="'.$rechs['ID_Make_Batterie'].'">'.stripslashes($rechs['Design_Make_Batterie']).'</option>';
                } 
            }
            echo ($list);
        }
    }
?>