<?php
    session_start(); 
    require_once("connexion.php");
    $Token=$_POST['token'];
    $Province=htmlentities($_POST['province']);
    $Site=htmlentities($_POST['ID_Site']);
    $Noc_ticket=Securite::bdd($_POST['noc_ticket']);
    $Daterap=date('Y-m-d', strtotime($_POST['daterap']));
    $PM_type=Securite::bdd($_POST['pm_type']);
    $Run_hour=Securite::bdd($_POST['run_hour']);
    $DC_load=Securite::bdd($_POST['dc_load']);
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
                    $rs=$pdo->prepare("INSERT INTO table_rapport_journalier (ID_Site, DC_Load, Noc_Ticket, Date_Rapport, PM_Type, Run_Hour, Fichier, ID_Utilisateur) VALUES (?,?,?,?,?,?,?,?)");
                    $params=array($Site, $DC_load, $Noc_ticket, $Daterap, $PM_type, $Run_hour, $Fichier, $_SESSION['user_eteelo_app']['ID_Utilisateur']);
                    $rs->execute($params);
                    $select=$pdo->query("SELECT MAX(ID_Rapport) AS ID_Rapport FROM table_rapport_journalier");
                    $selects=$select->fetch();
                    echo "1,".$selects['ID_Rapport'];
                }
            }else{
                echo "3";
            }
        }
    }else{
        if($Token==$_SESSION['user_eteelo_app']['token']){
            $rs=$pdo->prepare("INSERT INTO table_rapport_journalier (ID_Site, DC_Load, Noc_Ticket, Date_Rapport, PM_Type, Run_Hour, ID_Utilisateur) VALUES (?,?,?,?,?,?,?)");
            $params=array($Site, $DC_load, $Noc_ticket, $Daterap, $PM_type, $Run_hour, $_SESSION['user_eteelo_app']['ID_Utilisateur']);
            $rs->execute($params);
            $select=$pdo->query("SELECT MAX(ID_Rapport) AS ID_Rapport FROM table_rapport_journalier");
            $selects=$select->fetch();
            echo "1,".$selects['ID_Rapport'];
        }
    }
?>