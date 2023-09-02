<?php
    session_start();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $Design=Securite::bdd($_POST['Design']);
    $Ecole=htmlentities($_POST['Ecole']);
    $Compte_Debit=htmlentities($_POST['Compte_Debit']);
    $Compte_Credit=htmlentities($_POST['Compte_Credit']);
    $rech=$pdo->query("SELECT * FROM type_frais WHERE UCASE(Libelle_Type_Frais)='".strtoupper($Design)."' AND ID_Etablissement=".$Ecole);
    if($rechs=$rech->fetch()){
        echo "2";
    }else{
        if($Token==$_SESSION['user_eteelo_app']['token']){
            $rs=$pdo->prepare("INSERT INTO type_frais(Libelle_Type_Frais, ID_Compte_D, ID_Compte_C, ID_Etablissement) VALUES (?,?,?,?)");
            $params=array($Design, $Compte_Debit, $Compte_Credit, $Ecole);
            $rs->execute($params);
            $last=$pdo->query("SELECT MAX(ID_Type_Frais) AS Identifiant FROM type_frais");
            $max=$last->fetch();
            $rech=$pdo->query("SELECT * FROM type_frais WHERE ID_Etablissement=".$Ecole." ORDER BY Libelle_Type_Frais");
            $list="";
            while ($rechs=$rech->fetch()){
                if($rechs['ID_Type_Frais']==$max['Identifiant']){
                    $list.='<option value="'.$rechs['ID_Type_Frais'].'" selected>'.stripslashes($rechs['Libelle_Type_Frais']).'</option>'; 
                }else{
                    $list.='<option value="'.$rechs['ID_Type_Frais'].'">'.stripslashes($rechs['Libelle_Type_Frais']).'</option>'; 
                }
            }
            echo ($list);
        }
    }
?>