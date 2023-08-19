<?php
    session_start();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $Design=Securite::bdd($_POST['Design']);
    $Ecole=htmlentities($_POST['Ecole']);
    $rech=$pdo->query("SELECT * FROM categorie_eleve WHERE UCASE(Design_Categorie)='".strtoupper($Design)."' AND ID_Etablissement=".$Ecole);
    if($rechs=$rech->fetch()){
        echo "2";
    }else{
        if($Token==$_SESSION['user_eteelo_app']['token']){
            $rs=$pdo->prepare("INSERT INTO categorie_eleve(Design_Categorie, ID_Etablissement, ID_Utilisateur) VALUES (?,?,?)");
            $params=array($Design, $Ecole, $_SESSION['user_eteelo_app']['ID_Utilisateur']);
            $rs->execute($params);
            echo "1";
        }
    }
?>