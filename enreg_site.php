<?php
    session_start();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $Province=htmlentities($_POST['Province']);
    $ID_Agent=htmlentities($_POST['ID_Agent']);
    $Site_Name=Securite::bdd($_POST['Site_Name']);
    $Site_ID=htmlentities($_POST['Site_ID']);
    $Agent=Securite::bdd($_POST['Agent']);
    $Localisation=htmlentities($_POST['Localisation']);
    $rech=$pdo->query("SELECT * FROM site WHERE Site_ID='".$Site_ID."' AND Site_Name='".$Site_Name."' AND Site_ID='".$Site_ID."' AND ID_Prov=".$Province);
    if($rechs=$rech->fetch()){
        echo "2";
    }else{
        if($Token==$_SESSION['user_eteelo_app']['token']){
            if($ID_Agent=='' && $Agent!=''){
                $insert_agent=$pdo->query("INSERT INTO agent SET Nom_Agent='".$Agent."'");
                $select=$pdo->query("SELECT MAX(ID_Agent) AS ID_Agent FROM agent");
                $selects=$select->fetch();
                $ID_Agent=$selects['ID_Agent'];
            }
            $rs=$pdo->prepare("INSERT INTO site(ID_Prov, ID_Agent, Site_ID, Site_Name, Localisation, ID_Utilisateur) VALUES (?,?,?,?,?,?)");
            $params=array($Province, $ID_Agent, $Site_ID, $Site_Name, $Localisation, $_SESSION['user_eteelo_app']['ID_Utilisateur']);
            $rs->execute($params);
            echo "1";
        }
    }
?>