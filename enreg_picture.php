<?php
    session_start();
    $_SESSION['last_activity'] = time();
    require_once ("connexion.php");
    $i=htmlentities($_POST['Indice']);
    $Token=$_POST['token_'.$i];
    $ID_Rapport=htmlentities($_POST['ID_Rapport_'.$i]);
    $dossier_image = 'images/rapports/';
    if(!is_dir($dossier_image)){
        mkdir($dossier_image);
    }
    if($_FILES['fichier_image_'.$i]['name']!=''){
        $Image=basename($_FILES['fichier_image_'.$i]['name']);
        $extensions_img = array('.JPG', '.JPEG', '.PNG');
        $extension_img = strrchr($_FILES['fichier_image_'.$i]['name'], '.');
        $extension_img_maj=strtoupper($extension_img);
        $ID_Titre=htmlentities($_POST['ID_Titre_'.$i]);
        if(!in_array($extension_img_maj, $extensions_img))
        {
            echo "2";
        }else{
            $Time = substr(time().rand(0,9), 3, 6);
            $Time = $Time.$i;
            $Image = 'IMG_RAPPORT_' . $Time . $extension_img_maj;
            if(move_uploaded_file($_FILES['fichier_image_'.$i]['tmp_name'], $dossier_image . $Image)) //Si la fonction renvoie TRUE, c'est
            {
                if($Token==$_SESSION['user_eteelo_app']['token']){
                    $recherche=$pdo->query("SELECT * FROM table_titre_rapport WHERE ID_Rapport=".$ID_Rapport." AND ID_Sous_Titre=".$ID_Titre);
                    if(!$recherches=$recherche->fetch()){
                        $insert=$pdo->query("INSERT INTO table_titre_rapport SET ID_Rapport=".$ID_Rapport.", ID_Sous_Titre=".$ID_Titre);
                        $selection=$pdo->query("SELECT MAX(ID_Titre_Rapport) AS ID_Titre_Rapport FROM table_titre_rapport");
                        $selections=$selection->fetch();
                        $ID_Titre_Rapport=$selections['ID_Titre_Rapport'];
                    }else{
                        $ID_Titre_Rapport=$recherches['ID_Titre_Rapport'];
                    }
                    $rech=$pdo->query("SELECT * FROM table_photo_rapport WHERE ID_Titre_Rapport=".$ID_Titre_Rapport." AND Indice_Photo=".$i);
                    if($rechs=$rech->fetch()){
                        $rs=$pdo->prepare("UPDATE table_photo_rapport SET Photo=? WHERE ID_Titre_Rapport=? AND Indice_Photo=?");
                        $params=array($Image, $ID_Titre_Rapport, $i);
                        $rs->execute($params);
                    }else{
                        $rs=$pdo->prepare("INSERT INTO table_photo_rapport SET ID_Titre_Rapport=?, Indice_Photo=?, Photo=?");
                        $params=array($ID_Titre_Rapport, $i, $Image);
                        $rs->execute($params);
                    }
                    echo "1";
                }
            }else{
                echo "3";
            }
        }
    }
?>