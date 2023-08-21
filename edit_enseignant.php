<?php
    session_start();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $Nom=Securite::bdd($_POST['Nom']);
    $Pnom=Securite::bdd($_POST['Pnom']);
    $Prenom=Securite::bdd($_POST['Prenom']);
    $Sexe=Securite::bdd($_POST['Sexe']);
    $Tel=htmlentities($_POST['Tel']);
    $ID_Enseignant=htmlentities($_POST['ID_Enseignant']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("UPDATE enseignant SET Prenom_Enseignant=?, Nom_Enseignant=?, Pnom_Enseignant=?, Sexe=?, Tel=? WHERE ID_Enseignant=?");
        $params=array($Prenom, $Nom, $Pnom, $Sexe, $Tel, $ID_Enseignant);
        $rs->execute($params);
        echo "1";
    }
?>