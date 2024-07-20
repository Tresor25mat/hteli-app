<?php
session_start();
$_SESSION['last_activity'] = time();
require_once ("connexion.php");
$Token = $_POST['tok_mod'];
$ID_Cient=$_POST['ID_Cient'];
$Design = Securite::bdd($_POST['Design_mod']);
$Description = Securite::bdd($_POST['Description_mod']);
$Image = basename($_FILES['mimg_mod']['name']);
$dossier_image = 'images/client/';
if (!is_dir($dossier_image)) {
    mkdir($dossier_image);
}
if ($Image != '') {
    $extensions_img = array('.JPG', '.JPEG', '.PNG');
    $extension_img = strrchr($_FILES['mimg_mod']['name'], '.');
    $extension_img_maj = strtoupper($extension_img);
    if (!in_array($extension_img_maj, $extensions_img)) {
        echo "2";
    } else {
        $Time = time() . rand(0, 9);
        $Time = substr($Time, 3, 8);
        $Image = 'IMG_CLIENT_' . $Time . $extension_img_maj;
        if (move_uploaded_file($_FILES['mimg_mod']['tmp_name'], $dossier_image . $Image)) //Si la fonction renvoie TRUE, c'est
        {
            if ($Token == $_SESSION['user_eteelo_app']['token']) {
                $rs = $pdo->prepare("UPDATE client SET Design_Client=?, Description=?, Logo=? WHERE ID_Cient=?");
                $params = array($Design, $Description, $Image, $ID_Cient);
                $rs->execute($params);
                echo "1";
            }
        } else {
            echo "3";
        }
    }
}else{
    if ($Token == $_SESSION['user_eteelo_app']['token']) {
        $rs = $pdo->prepare("UPDATE client SET Design_Client=?, Description=? WHERE ID_Cient=?");
        $params = array($Design, $Description, $ID_Cient);
        $rs->execute($params);
        echo "1";
    }
}
?>