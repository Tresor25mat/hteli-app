<?php
    session_start(); 
    require_once("connexion.php");
    $Token=$_POST['token'];
    $Province=htmlentities($_POST['province']);
    $Site=htmlentities($_POST['ID_Site']);
    $Rectifier_Make=htmlentities($_POST['rectifier_make']);
    $Rectifier_Model=htmlentities($_POST['rectifier_model']);
    $Batterie_Make=htmlentities($_POST['batterie_make']);
    $Num_Bat=Securite::bdd($_POST['num_bat']);
    $Num_Work_Order=Securite::bdd($_POST['num_work_order']);
    $Num_Serial=Securite::bdd($_POST['num_serial']);
    $History_Card_Ref=Securite::bdd($_POST['history_card_ref']);
    $Rectifier_Capacity=htmlentities($_POST['rectifier_capacity']);
    $Number_Bat=htmlentities($_POST['number_bat']);
    $Daterap=date('Y-m-d', strtotime($_POST['daterap']));
    $Time_in=date('H:i', strtotime($_POST['time_in']));
    $Time_out=date('H:i', strtotime($_POST['time_out']));
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
                    $rs=$pdo->prepare("INSERT INTO table_rapport_rectifier (ID_Site, ID_Rectifier_Make, ID_Rectifier_Model, ID_Make_Batterie, Number_Bat_By_bank, Date_Rapport, Num_Work_Order, History_Card_Ref, Num_Serial, Rectifier_Capacity, Number_Bat_banks, Time_In, Time_Out, Fichier, ID_Utilisateur) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $params=array($Site, $Rectifier_Make, $Rectifier_Model, $Batterie_Make, $Num_Bat, $Daterap, $Num_Work_Order, $History_Card_Ref, $Num_Serial, $Rectifier_Capacity, $Number_Bat, $Time_in, $Time_out, $Fichier, $_SESSION['user_eteelo_app']['ID_Utilisateur']);
                    $rs->execute($params);
                    $select=$pdo->query("SELECT MAX(ID_Rapport) AS ID_Rapport FROM table_rapport_rectifier");
                    $selects=$select->fetch();
                    echo "1,".$selects['ID_Rapport'];
                }
            }else{
                echo "3";
            }
        }
    }else{
        if($Token==$_SESSION['user_eteelo_app']['token']){
            $rs=$pdo->prepare("INSERT INTO table_rapport_rectifier (ID_Site, ID_Rectifier_Make, ID_Rectifier_Model, ID_Make_Batterie, Number_Bat_By_bank, Date_Rapport, Num_Work_Order, History_Card_Ref, Num_Serial, Rectifier_Capacity, Number_Bat_banks, Time_In, Time_Out, ID_Utilisateur) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $params=array($Site, $Rectifier_Make, $Rectifier_Model, $Batterie_Make, $Num_Bat, $Daterap, $Num_Work_Order, $History_Card_Ref, $Num_Serial, $Rectifier_Capacity, $Number_Bat, $Time_in, $Time_out, $_SESSION['user_eteelo_app']['ID_Utilisateur']);
            $rs->execute($params);
            $select=$pdo->query("SELECT MAX(ID_Rapport) AS ID_Rapport FROM table_rapport_rectifier");
            $selects=$select->fetch();
            echo "1,".$selects['ID_Rapport'];
        }
    }
?>