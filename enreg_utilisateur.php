<?php
    session_start();
    $_SESSION['last_activity'] = time();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $Prenom=Securite::bdd($_POST['prenom']);
    $Nom=Securite::bdd($_POST['nom']);
    $Tel=htmlentities($_POST['tel']);
    $Mail=Securite::bdd($_POST['mail']);
    $Statut=Securite::bdd($_POST['statut']);
    $Login=Securite::bdd($_POST['login']);
    $Profil=htmlentities($_POST['profil']);
    if(isset($_POST['agence'])){
        $Agence=htmlentities($_POST['agence']);
    }else{
        $Agence="";
    }
    $Password=sha1($_POST['password']);
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
                if($Token==$_SESSION['user_slj_wings']['token']){
                    $rs=$pdo->prepare("INSERT INTO utilisateur(Prenom, Nom, ID_Profil, ID_Agence, Tel, Email, Login, Password, Photo, Statut, Active) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
                    $params=array($Prenom, $Nom, $Profil, $Agence, $Tel, $Mail, $Login, $Password, $Image, $Statut, 1);
                    $rs->execute($params);
                    echo "1";
                }
            }else{
                echo "3";
            }
        }
    }else{
        if($Token==$_SESSION['user_slj_wings']['token']){
            $rs=$pdo->prepare("INSERT INTO utilisateur(Prenom, Nom, ID_Profil, ID_Agence, Tel, Email, Login, Password, Statut, Active) VALUES (?,?,?,?,?,?,?,?,?,?)");
            $params=array($Prenom, $Nom, $Profil, $Agence, $Tel, $Mail, $Login, $Password, $Statut, 1);
            $rs->execute($params);
            echo "1";
        }
    }
?>