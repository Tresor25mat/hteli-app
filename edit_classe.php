<?php
    session_start();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $Niveau=htmlentities($_POST['Niveau']);
    $Option=htmlentities($_POST['Option']);
    $Design=Securite::bdd($_POST['Design']);
    $ID_Classe=htmlentities($_POST['ID_Classe']);
    $Titulaire=htmlentities($_POST['Titulaire']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("UPDATE classe SET Design_Classe=?, ID_Option=?, ID_Niveau=?, ID_Enseignant=? WHERE ID_Classe=?");
        $params=array($Design, $Option, $Niveau, $Titulaire, $ID_Classe);
        $rs->execute($params);
        echo "1";
    }
?>