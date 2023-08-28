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
            echo "1";
        }
    }
?>