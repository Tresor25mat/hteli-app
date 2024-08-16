<?php
session_start();
$_SESSION['last_activity'] = time();
require_once ("connexion.php");
$i = htmlentities($_POST['Indice']);
$Token = $_POST['token_' . $i];
$ID_Rapport = htmlentities($_POST['ID_Rapport_' . $i]);
$Legend = Securite::bdd($_POST['legend_' . $i]);
$dossier_image = 'images/rapports/';
if (!is_dir($dossier_image)) {
    mkdir($dossier_image);
}
if ($_FILES['fichier_image_' . $i]['name'] != '') {
    $Image = basename($_FILES['fichier_image_' . $i]['name']);
    $extensions_img = array('.JPG', '.JPEG', '.PNG');
    $extension_img = strrchr($_FILES['fichier_image_' . $i]['name'], '.');
    $extension_img_maj = strtoupper($extension_img);
    $ID_Titre = htmlentities($_POST['ID_Titre_' . $i]);
    if (!in_array($extension_img_maj, $extensions_img)) {
        echo "2";
    } else {
        $Time = substr(time() . rand(0, 9), 3, 6);
        $Time = $Time . $i;
        $Image = 'IMG_RAPPORT_' . $Time . $extension_img_maj;
        if (move_uploaded_file($_FILES['fichier_image_' . $i]['tmp_name'], $dossier_image . $Image)) //Si la fonction renvoie TRUE, c'est
        {
            if ($Token == $_SESSION['user_eteelo_app']['token']) {
                $rs = $pdo->prepare("INSERT INTO table_photo_quality SET ID_Rapport=?, Legend_Photo=?, Indice=?, Photo=?");
                $params = array($ID_Rapport, $Legend, $i, $Image);
                $rs->execute($params);
                echo "1";
            }
        } else {
            echo "3";
        }
    }
}
?>