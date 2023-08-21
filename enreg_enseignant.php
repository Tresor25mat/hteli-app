<?php
    session_start();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $Nom=Securite::bdd($_POST['Nom']);
    $Pnom=Securite::bdd($_POST['Pnom']);
    $Prenom=Securite::bdd($_POST['Prenom']);
    $Sexe=Securite::bdd($_POST['Sexe']);
    $Tel=htmlentities($_POST['Tel']);
    $Ecole=htmlentities($_POST['Ecole']);
    $rech=$pdo->query("SELECT * FROM enseignant WHERE UCASE(Prenom_Enseignant)='".strtoupper($Prenom)."' AND UCASE(Nom_Enseignant)='".strtoupper($Nom)."' AND UCASE(Pnom_Enseignant)='".strtoupper($Pnom)."' AND ID_Etablissement=".$Ecole);
    if($rechs=$rech->fetch()){
        echo "2";
    }else{
        if($Token==$_SESSION['user_eteelo_app']['token']){
            $rs=$pdo->prepare("INSERT INTO enseignant(Prenom_Enseignant, Nom_Enseignant, Pnom_Enseignant, Sexe, Tel, ID_Etablissement, ID_Utilisateur) VALUES (?,?,?,?,?,?,?)");
            $params=array($Prenom, $Nom, $Pnom, $Sexe, $Tel, $Ecole, $_SESSION['user_eteelo_app']['ID_Utilisateur']);
            $rs->execute($params);
            echo "1";
        }
    }
?>