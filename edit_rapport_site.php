<?php
    session_start(); 
    require_once("connexion.php");
    $Token=$_POST['token'];
    $ID_Rapport=htmlentities($_POST['ID_Rapport']);
    $Province=htmlentities($_POST['Province']);
    $Site=htmlentities($_POST['Site']);
    $Num_Ref=Securite::bdd($_POST['Num_Ref']);
    $Daterap=date('Y-m-d', strtotime($_POST['Daterap']));
    $Time_in=date('H:i', strtotime($_POST['Time_in']));
    $Time_out=date('H:i', strtotime($_POST['Time_out']));
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("UPDATE table_rapport_mensuel_site SET ID_Site=?, Date_Rapport=?, Num_Ref=?, Time_In=?, Time_Out=?, Updated_By=? WHERE ID_Rapport=?");
        $params=array($Site, $Daterap, $Num_Ref, $Time_in, $Time_out, $_SESSION['user_eteelo_app']['ID_Utilisateur'], $ID_Rapport);
        $rs->execute($params);
    }
?>