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
    $rs_statut=$pdo->query("SELECT * FROM statut_user WHERE ID_Statut=".$Statut);
    $statuts=$rs_statut->fetch();
    $Login=Securite::bdd($_POST['login']);
    $Profil=htmlentities($_POST['profil']);
    $Type_Photo=htmlentities($_POST['type_photo']);
    $Photo_Data=htmlentities($_POST['photo_data']);
    $Etablissement=1;
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
                if($Token==$_SESSION['user_eteelo_app']['token']){
                    $rs=$pdo->prepare("INSERT INTO utilisateur(Prenom, Nom, ID_Profil, ID_Etablissement, ID_Statut, Tel, Email, Login, Password, Photo, Photo_Type, Statut, Active) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $params=array($Prenom, $Nom, $Profil, $Etablissement, $Statut, $Tel, $Mail, $Login, $Password, $Image, $Type_Photo, $statuts['Design_Statut'], 1);
                    $rs->execute($params);
                    $select=$pdo->query("SELECT MAX(ID_Utilisateur) AS ID_Utilisateur FROM utilisateur");
                    $selects=$select->fetch();
                    if(isset($_POST['liste_sites']) && !empty($_POST['liste_sites'])){
                        $Sites = explode(",", $_POST['liste_sites']);
                        foreach($Sites as $site) {
                            $insert=$pdo->query("INSERT INTO utilisateur_site SET ID_Utilisateur=".$selects['ID_Utilisateur'].", ID_Site=".$site);
                        }
                    }
                    echo "1";
                }
            }else{
                echo "3";
            }
        }
    }else if($Photo_Data!=''){
        if($Token==$_SESSION['user_eteelo_app']['token']){
            $rs=$pdo->prepare("INSERT INTO utilisateur(Prenom, Nom, ID_Profil, ID_Etablissement, ID_Statut, Tel, Email, Login, Password, Photo, Photo_Type, Statut, Active) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $params=array($Prenom, $Nom, $Profil, $Etablissement, $Statut, $Tel, $Mail, $Login, $Password, $Photo_Data, $Type_Photo, $statuts['Design_Statut'], 1);
            $rs->execute($params);
            $select=$pdo->query("SELECT MAX(ID_Utilisateur) AS ID_Utilisateur FROM utilisateur");
            $selects=$select->fetch();
            if(isset($_POST['liste_sites']) && !empty($_POST['liste_sites'])){
                $Sites = explode(",", $_POST['liste_sites']);
                foreach($Sites as $site) {
                    $insert=$pdo->query("INSERT INTO utilisateur_site SET ID_Utilisateur=".$selects['ID_Utilisateur'].", ID_Site=".$site);
                }
            }
            echo "1";
        }
    }else{
        if($Token==$_SESSION['user_eteelo_app']['token']){
            $rs=$pdo->prepare("INSERT INTO utilisateur(Prenom, Nom, ID_Profil, ID_Etablissement, ID_Statut, Tel, Email, Login, Password, Statut, Active) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
            $params=array($Prenom, $Nom, $Profil, $Etablissement, $Statut, $Tel, $Mail, $Login, $Password, $statuts['Design_Statut'], 1);
            $rs->execute($params);
            $select=$pdo->query("SELECT MAX(ID_Utilisateur) AS ID_Utilisateur FROM utilisateur");
            $selects=$select->fetch();
            if(isset($_POST['liste_sites']) && !empty($_POST['liste_sites'])){
                $Sites = explode(",", $_POST['liste_sites']);
                foreach($Sites as $site) {
                    $insert=$pdo->query("INSERT INTO utilisateur_site SET ID_Utilisateur=".$selects['ID_Utilisateur'].", ID_Site=".$site);
                }
            }
            echo "1";
        }
    }
?>