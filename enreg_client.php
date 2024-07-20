<?php
session_start();
$_SESSION['last_activity'] = time();
require_once ("connexion.php");
$Token = $_POST['tok'];
$Design = Securite::bdd($_POST['Design']);
$Description = Securite::bdd($_POST['Description']);
$Image = basename($_FILES['mimg']['name']);
$dossier_image = 'images/client/';
if (!is_dir($dossier_image)) {
    mkdir($dossier_image);
}
if ($Image != '') {
    $extensions_img = array('.JPG', '.JPEG', '.PNG');
    $extension_img = strrchr($_FILES['mimg']['name'], '.');
    $extension_img_maj = strtoupper($extension_img);
    if (!in_array($extension_img_maj, $extensions_img)) {
        echo "2";
    } else {
        $Time = time() . rand(0, 9);
        $Time = substr($Time, 3, 8);
        $Image = 'IMG_CLIENT_' . $Time . $extension_img_maj;
        if (move_uploaded_file($_FILES['mimg']['tmp_name'], $dossier_image . $Image)) //Si la fonction renvoie TRUE, c'est
        {
            if ($Token == $_SESSION['user_eteelo_app']['token']) {
                $rs = $pdo->prepare("INSERT INTO client (Design_Client, Description, Logo, ID_Utilisateur) VALUES (?,?,?,?)");
                $params = array($Design, $Description, $Image, $_SESSION['user_eteelo_app']['ID_Utilisateur']);
                $rs->execute($params);
                echo "1";
            }
        } else {
            echo "3";
        }
    }
}
?>