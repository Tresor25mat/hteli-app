<?php
    session_start(); 
    require_once("connexion.php");
    $Token=$_POST['token'];
    $ID_Rapport=htmlentities($_POST['ID_Rapport']);
    $Province=htmlentities($_POST['Province']);
    $Site=htmlentities($_POST['Site']);
    $PM_Ref=Securite::bdd($_POST['PM_Ref']);
    $Daterap=date('Y-m-d', strtotime($_POST['Daterap']));
    $Time_in=date('H:i', strtotime($_POST['Time_in']));
    $Time_out=date('H:i', strtotime($_POST['Time_out']));
    $Tower_type=htmlentities($_POST['Tower_type']);
    $Tower_ht=htmlentities($_POST['Tower_ht']);
    $History_card_ref=Securite::bdd($_POST['History_card_ref']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("UPDATE table_rapport_mensuel_tour SET ID_Site=?, ID_Tower_Type=?, History_Card_Ref=?, Date_Rapport=?, PM_Ref=?, Time_In=?, Time_Out=?, Tower_Ht=?, Updated_By=? WHERE ID_Rapport=?");
        $params=array($Site, $Tower_type, $History_card_ref, $Daterap, $PM_Ref, $Time_in, $Time_out, $Tower_ht, $_SESSION['user_eteelo_app']['ID_Utilisateur'], $ID_Rapport);
        $rs->execute($params);
    }
?>