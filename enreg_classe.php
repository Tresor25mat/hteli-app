<?php
    session_start();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $Niveau=htmlentities($_POST['Niveau']);
    $Option=htmlentities($_POST['Option']);
    $Design=Securite::bdd($_POST['Design']);
    $Ecole=htmlentities($_POST['Ecole']);
    $Titulaire=htmlentities($_POST['Titulaire']);
    $rech=$pdo->query("SELECT * FROM classe INNER JOIN table_option ON classe.ID_Option=table_option.ID_Option INNER JOIN section ON table_option.ID_Section=section.ID_Section WHERE classe.Design_Classe='".$Design."' AND section.ID_Etablissement=".$Ecole);
    if($rechs=$rech->fetch()){
        echo "2";
    }else{
        if($Token==$_SESSION['user_eteelo_app']['token']){
            $rs=$pdo->prepare("INSERT INTO classe(Design_Classe, ID_Option, ID_Niveau, ID_Enseignant) VALUES (?,?,?,?)");
            $params=array($Design, $Option, $Niveau, $Titulaire);
            $rs->execute($params);
            echo "1";
        }
    }
?>