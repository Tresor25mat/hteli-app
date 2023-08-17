<?php
    session_start();
    $_SESSION['last_activity'] = time();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $ID=Securite::bdd($_POST['id_user']);
    $Image=basename($_FILES['mimg']['name']);
    $dossier_image = 'images/profil/';
    if(!is_dir($dossier_image)){
        mkdir($dossier_image);
    }
    if($Image!=''){
        $extensions_img = array('.JPG', '.JPEG', '.PNG');
        $extension_img = strrchr($_FILES['mimg']['name'], '.');
        $extension_img_maj=strtoupper($extension_img);
        if(!in_array($extension_img_maj, $extensions_img))
        {
            echo "2";
        }else{
            $Time = time().rand(0,9);
            $Time = substr($Time, 3, 8);
            $Image = 'IMG_UTILISATEUR_' . $Time . $extension_img_maj;
            if(move_uploaded_file($_FILES['mimg']['tmp_name'], $dossier_image . $Image)) //Si la fonction renvoie TRUE, c'est
            {
                if($Token==$_SESSION['user_eteelo_app']['token']){
                    $rs=$pdo->prepare("UPDATE utilisateur SET Photo=? WHERE ID_Utilisateur=?");
                    $params=array($Image, $ID);
                    $rs->execute($params);
                    echo "1";
                }
            }else{
                echo "3";
            }
        }
    }
?>