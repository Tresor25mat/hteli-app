<?php
    session_start(); 
    require_once("connexion.php");
    $Token=$_POST['token'];
    $Province=htmlentities($_POST['Province']);
    $Site=htmlentities($_POST['Site']);
    $Num_Work=Securite::bdd($_POST['Num_Work']);
    $Daterap=date('Y-m-d', strtotime($_POST['Daterap']));
    $Time_in=date('H:i', strtotime($_POST['Time_in']));
    $Time_out=date('H:i', strtotime($_POST['Time_out']));
    $Site_Type=htmlentities($_POST['Site_Type']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("INSERT INTO table_rapport_janitorial (ID_Site, ID_Type, Date_Rapport, Num_Work_Order, Time_In, Time_Out, ID_Utilisateur) VALUES (?,?,?,?,?,?,?)");
        $params=array($Site, $Site_Type, $Daterap, $Num_Work, $Time_in, $Time_out, $_SESSION['user_eteelo_app']['ID_Utilisateur']);
        $rs->execute($params);
        $select=$pdo->query("SELECT MAX(ID_Rapport) AS ID_Rapport FROM table_rapport_janitorial");
        $selects=$select->fetch();
        echo $selects['ID_Rapport'];
    }
?>