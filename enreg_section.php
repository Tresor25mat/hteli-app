<?php
    session_start();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $Design=Securite::bdd($_POST['Design']);
    $Ecole=htmlentities($_POST['Ecole']);
    $rech=$pdo->query("SELECT * FROM section WHERE UCASE(Design_Section)='".strtoupper($Design)."' AND ID_Etablissement=".$Ecole);
    if($rechs=$rech->fetch()){
        echo "2";
    }else{
        if($Token==$_SESSION['user_eteelo_app']['token']){
            $rs=$pdo->prepare("INSERT INTO section(Design_Section, ID_Etablissement) VALUES (?,?)");
            $params=array($Design, $Ecole);
            $rs->execute($params);
            echo "1";
        }
    }
?>