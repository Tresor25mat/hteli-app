<?php
    session_start(); 
    require_once("connexion.php");
    $Token=$_POST['token'];
    $Province=htmlentities($_POST['Province']);
    $Site=htmlentities($_POST['Site']);
    $Rectifier_Make=htmlentities($_POST['Rectifier_Make']);
    $Rectifier_Model=htmlentities($_POST['Rectifier_Model']);
    $Batterie_Make=htmlentities($_POST['Batterie_Make']);
    $Num_Bat=Securite::bdd($_POST['Num_Bat']);
    $Num_Work_Order=Securite::bdd($_POST['Num_Work_Order']);
    $Num_Serial=Securite::bdd($_POST['Num_Serial']);
    $History_Card_Ref=Securite::bdd($_POST['History_Card_Ref']);
    $Rectifier_Capacity=htmlentities($_POST['Rectifier_Capacity']);
    $Number_Bat=htmlentities($_POST['Number_Bat']);
    $Daterap=date('Y-m-d', strtotime($_POST['Daterap']));
    $Time_in=date('H:i', strtotime($_POST['Time_in']));
    $Time_out=date('H:i', strtotime($_POST['Time_out']));
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("INSERT INTO table_rapport_rectifier (ID_Site, ID_Rectifier_Make, ID_Rectifier_Model, ID_Make_Batterie, Number_Bat_By_bank, Date_Rapport, Num_Work_Order, History_Card_Ref, Num_Serial, Rectifier_Capacity, Number_Bat_banks, Time_In, Time_Out, ID_Utilisateur) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $params=array($Site, $Rectifier_Make, $Rectifier_Model, $Batterie_Make, $Num_Bat, $Daterap, $Num_Work_Order, $History_Card_Ref, $Num_Serial, $Rectifier_Capacity, $Number_Bat, $Time_in, $Time_out, $_SESSION['user_eteelo_app']['ID_Utilisateur']);
        $rs->execute($params);
        $select=$pdo->query("SELECT MAX(ID_Rapport) AS ID_Rapport FROM table_rapport_rectifier");
        $selects=$select->fetch();
        echo $selects['ID_Rapport'];
    }
?>