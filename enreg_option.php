<?php
    session_start();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $Ecole=htmlentities($_POST['Ecole']);
    $Section=htmlentities($_POST['Section']);
    $Design=Securite::bdd($_POST['Design']);
    $rech=$pdo->query("SELECT * FROM table_option INNER JOIN section ON table_option.ID_Section=section.ID_Section WHERE table_option.Design_Option='".$Design."' AND section.ID_Etablissement=".$Ecole);
    if($rechs=$rech->fetch()){
        echo "2";
    }else{
        if($Token==$_SESSION['user_eteelo_app']['token']){
            $rs=$pdo->prepare("INSERT INTO table_option(Design_Option, ID_Section) VALUES (?,?)");
            $params=array($Design, $Section);
            $rs->execute($params);
            echo "1";
        }
    }
?>