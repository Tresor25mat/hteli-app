<?php
    session_start();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $Province=htmlentities($_POST['Province']);
    $ID_Site=htmlentities($_POST['ID_Site']);
    $ID_Agent=htmlentities($_POST['ID_Agent']);
    $Client=htmlentities($_POST['Client']);
    $Site_Name=Securite::bdd($_POST['Site_Name']);
    $Site_ID=htmlentities($_POST['Site_ID']);
    $Agent=Securite::bdd($_POST['Agent']);
    $Localisation=htmlentities($_POST['Localisation']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        if($ID_Agent=='' && $Agent!=''){
            $insert_agent=$pdo->query("INSERT INTO agent SET Nom_Agent='".$Agent."'");
            $select=$pdo->query("SELECT MAX(ID_Agent) AS ID_Agent FROM agent");
            $selects=$select->fetch();
            $ID_Agent=$selects['ID_Agent'];
        }
        $rs=$pdo->prepare("UPDATE site SET ID_Prov=?, ID_Agent=?, ID_Cient=?, Site_ID=?, Site_Name=?, Localisation=? WHERE ID_Site=?");
        $params=array($Province, $ID_Agent, $Client, $Site_ID, $Site_Name, $Localisation, $ID_Site);
        $rs->execute($params);
        echo "1";
    }
?>