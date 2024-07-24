<?php
    session_start(); 
    require_once("connexion.php");
    $Token=$_POST['token'];
    $Province=htmlentities($_POST['province']);
    $Site=htmlentities($_POST['ID_Site']);
    $Num_Work=Securite::bdd($_POST['num_work_order']);
    $Daterap=date('Y-m-d', strtotime($_POST['daterap']));
    $Time_in=date('H:i', strtotime($_POST['time_in']));
    $Time_out=date('H:i', strtotime($_POST['time_out']));
    $Site_Type=htmlentities($_POST['type_site']);
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
                    $rs=$pdo->prepare("INSERT INTO table_rapport_janitorial (ID_Site, ID_Type, Date_Rapport, Num_Work_Order, Time_In, Time_Out, Fichier, ID_Utilisateur) VALUES (?,?,?,?,?,?,?,?)");
                    $params=array($Site, $Site_Type, $Daterap, $Num_Work, $Time_in, $Time_out, $Fichier, $_SESSION['user_eteelo_app']['ID_Utilisateur']);
                    $rs->execute($params);
                    $select=$pdo->query("SELECT MAX(ID_Rapport) AS ID_Rapport FROM table_rapport_janitorial");
                    $selects=$select->fetch();
                    echo "1,".$selects['ID_Rapport'];
                }
            }else{
                echo "3";
            }
        }
    }else{
        if($Token==$_SESSION['user_eteelo_app']['token']){
            $rs=$pdo->prepare("INSERT INTO table_rapport_janitorial (ID_Site, ID_Type, Date_Rapport, Num_Work_Order, Time_In, Time_Out, ID_Utilisateur) VALUES (?,?,?,?,?,?,?)");
            $params=array($Site, $Site_Type, $Daterap, $Num_Work, $Time_in, $Time_out, $_SESSION['user_eteelo_app']['ID_Utilisateur']);
            $rs->execute($params);
            $select=$pdo->query("SELECT MAX(ID_Rapport) AS ID_Rapport FROM table_rapport_janitorial");
            $selects=$select->fetch();
            echo "1,".$selects['ID_Rapport'];
        }
    }

?>