<?php
    session_start();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $Design=Securite::bdd($_POST['Design']);
    $ID_Discipline=htmlentities($_POST['ID_Discipline']);
    $Nombre=htmlentities($_POST['Nombre']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("UPDATE table_discipline SET Design_Discipline=?, Nombre_Point=? WHERE ID_Discipline=?");
        $params=array($Design, $Nombre, $ID_Discipline);
        $rs->execute($params);
        echo "1";
    }
?>