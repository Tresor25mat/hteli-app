<?php
    session_start();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $Ecole=htmlentities($_POST['Ecole']);
    $Code=htmlentities($_POST['Code']);
    $Design=Securite::bdd($_POST['Design']);
    $rech=$pdo->query("SELECT * FROM categorie_compte WHERE Cod_Categorie='".$Code."' AND ID_Etablissement=".$Ecole);
    if($rechs=$rech->fetch()){
        echo "2";
    }else{
        if($Token==$_SESSION['user_eteelo_app']['token']){
            $rs=$pdo->prepare("INSERT INTO categorie_compte(Cod_Categorie, Design_Categorie, ID_Etablissement, ID_Utilisateur) VALUES (?,?,?,?)");
            $params=array($Code, $Design, $Ecole, $_SESSION['user_eteelo_app']['ID_Utilisateur']);
            $rs->execute($params);
            $max=$pdo->query("SELECT MAX(ID_Categorie) AS ID_Categorie FROM categorie_compte WHERE ID_Etablissement=".$Ecole." ORDER BY Cod_Categorie");
            $maxid=$max->fetch();
            $rech=$pdo->query("SELECT * FROM categorie_compte WHERE ID_Etablissement=".$Ecole." ORDER BY Cod_Categorie");
            $list="";
            while ($rechs=$rech->fetch()){
                if($rechs['ID_Categorie']==$maxid['ID_Categorie']){
                    $list.='<option value="'.$rechs['ID_Categorie'].'" selected>'.$rechs['Cod_Categorie'].' '.stripslashes($rechs['Design_Categorie']).'</option>';
                }else{
                    $list.='<option value="'.$rechs['ID_Categorie'].'">'.$rechs['Cod_Categorie'].' '.stripslashes($rechs['Design_Categorie']).'</option>';
                }
            }
            echo ($list);
        }
    }
?>