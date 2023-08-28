<?php
    session_start();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $Ecole=htmlentities($_POST['Ecole']);
    $Type=htmlentities($_POST['Type']);
    $Code=htmlentities($_POST['Code']);
    $Design=Securite::bdd($_POST['Design']);
    $rech=$pdo->query("SELECT * FROM table_journal WHERE Code_Journal='".$Code."' AND ID_Etablissement=".$Ecole);
    if($rechs=$rech->fetch()){
        echo "2";
    }else{
        if($Token==$_SESSION['user_eteelo_app']['token']){
            $rs=$pdo->prepare("INSERT INTO table_journal(ID_Etablissement, ID_Type_Journal, Code_Journal, Design_Journal) VALUES (?,?,?,?)");
            $params=array($Ecole, $Type, $Code, $Design);
            $rs->execute($params);
            echo "1";
        }
    }
?>