<?php
    session_start();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $Design=Securite::bdd($_POST['Design']);
    $Ecole=htmlentities($_POST['Ecole']);
    $Nombre=htmlentities($_POST['Nombre']);
    $rech=$pdo->query("SELECT * FROM table_discipline WHERE UCASE(Design_Discipline)='".strtoupper($Design)."' AND ID_Etablissement=".$Ecole);
    if($rechs=$rech->fetch()){
        echo "2";
    }else{
        if($Token==$_SESSION['user_eteelo_app']['token']){
            $rs=$pdo->prepare("INSERT INTO table_discipline(Design_Discipline, Nombre_Point, ID_Etablissement, ID_Utilisateur) VALUES (?,?,?,?)");
            $params=array($Design, $Nombre, $Ecole, $_SESSION['user_eteelo_app']['ID_Utilisateur']);
            $rs->execute($params);
            echo "1";
        }
    }
?>