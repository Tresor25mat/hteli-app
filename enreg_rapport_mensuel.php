<?php
    session_start(); 
    require_once("connexion.php");
    $Token=$_POST['token'];
    $Province=htmlentities($_POST['province']);
    $Site=htmlentities($_POST['ID_Site']);
    $PM_Ref=Securite::bdd($_POST['pm_ref']);
    $Daterap=date('Y-m-d', strtotime($_POST['daterap']));
    $Time_in=date('H:i', strtotime($_POST['time_in']));
    $Time_out=date('H:i', strtotime($_POST['time_out']));
    $Tower_type=htmlentities($_POST['tower_type']);
    $Tower_ht=htmlentities($_POST['tower_ht']);
    $History_card_ref=Securite::bdd($_POST['history_card_ref']);
    $Fichier=basename($_FILES['fichier']['name']);
    $dossier_fichier = 'documents/';
    if(!is_dir($dossier_fichier)){
        mkdir($dossier_fichier);
    }
    if($Fichier!=''){
        $extensions = array('.JPG', '.JPEG', '.PNG', '.XLS', '.XLSX', '.PDF', '.DOC', '.DOCX', '.PPT', '.PPTX');
        $extension = strrchr($_FILES['fichier']['name'], '.');
        $extension_maj=strtoupper($extension);
        if(!in_array($extension_maj, $extensions))
        {
            echo "2";
        }else{
            $Time = time().rand(0,9);
            $Time = substr($Time, 3, 8);
            $Fichier = 'FICHIER_' . $Time . $extension_maj;
            if(move_uploaded_file($_FILES['fichier']['tmp_name'], $dossier_fichier . $Fichier)) //Si la fonction renvoie TRUE, c'est
            {
                if($Token==$_SESSION['user_eteelo_app']['token']){
                    $rs=$pdo->prepare("INSERT INTO table_rapport_mensuel_tour (ID_Site, ID_Tower_Type, History_Card_Ref, Date_Rapport, PM_Ref, Time_In, Time_Out, Tower_Ht, Fichier, ID_Utilisateur) VALUES (?,?,?,?,?,?,?,?,?,?)");
                    $params=array($Site, $Tower_type, $History_card_ref, $Daterap, $PM_Ref, $Time_in, $Time_out, $Tower_ht, $Fichier, $_SESSION['user_eteelo_app']['ID_Utilisateur']);
                    $rs->execute($params);
                    $select=$pdo->query("SELECT MAX(ID_Rapport) AS ID_Rapport FROM table_rapport_mensuel_tour");
                    $selects=$select->fetch();
                    echo "1,".$selects['ID_Rapport'];
                }
            }else{
                echo "3";
            }
        }
    }else{
        if($Token==$_SESSION['user_eteelo_app']['token']){
            $rs=$pdo->prepare("INSERT INTO table_rapport_mensuel_tour (ID_Site, ID_Tower_Type, History_Card_Ref, Date_Rapport, PM_Ref, Time_In, Time_Out, Tower_Ht, ID_Utilisateur) VALUES (?,?,?,?,?,?,?,?,?)");
            $params=array($Site, $Tower_type, $History_card_ref, $Daterap, $PM_Ref, $Time_in, $Time_out, $Tower_ht, $_SESSION['user_eteelo_app']['ID_Utilisateur']);
            $rs->execute($params);
            $select=$pdo->query("SELECT MAX(ID_Rapport) AS ID_Rapport FROM table_rapport_mensuel_tour");
            $selects=$select->fetch();
            echo "1,".$selects['ID_Rapport'];
        }
    }
?>