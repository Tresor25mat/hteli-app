<?php
    session_start(); 
    require_once("connexion.php");
    $Token=$_POST['token'];
    $Client=htmlentities($_POST['Client']);
    $Design=Securite::bdd($_POST['Design']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rech=$pdo->query("SELECT * FROM table_titre WHERE UPPER(Design_Titre)='".strtoupper($Design)."' AND ID_Cient=".$Client);
        if($rechs=$rech->fetch()){
            echo "2";
        }else{
            $select=$pdo->query("SELECT COUNT(*) AS Nombre FROM table_titre WHERE ID_Cient=".$Client);
            $selects=$select->fetch();
            $Code=$selects['Nombre']+1;
            $rs=$pdo->prepare("INSERT INTO table_titre (ID_Cient, Code_Titre, Design_Titre) VALUES (?,?,?)");
            $params=array($Client, $Code, $Design);
            $rs->execute($params);
            echo "1";
        }
    }
?>