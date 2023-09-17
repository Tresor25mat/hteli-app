<?php
    session_start();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $Ecole=htmlentities($_POST['ID_Etablissement']);
    $Classe=htmlentities($_POST['classe']);
    $Annee=htmlentities($_POST['annee']);
    $ID_Eleve=htmlentities($_POST['ID_Eleve']);
    $ID_Inscription=htmlentities($_POST['ID_Inscription']);
    $Matri=htmlentities($_POST['matricule']);
    $Prenom=Securite::bdd($_POST['prenom']);
    $Nom=Securite::bdd($_POST['nom']);
    $Pnom=Securite::bdd($_POST['pnom']);
    $Sexe=Securite::bdd($_POST['sexe']);
    $ID_Ecole_Provenance=htmlentities($_POST['ID_Ecole_Provenance']);
    $Provenance=Securite::bdd($_POST['provenance']);
    $Lieu="";
    if(isset($_POST['lieu_naiss'])){
        $Lieu=htmlentities($_POST['lieu_naiss']);
    }
    $DateN=date('Y-m-d', strtotime(htmlentities($_POST['daten'])));
    $Adresse=Securite::bdd($_POST['adresse']);
    $Commune="";
    if(isset($_POST['commune'])){
        $Commune=htmlentities($_POST['commune']);
    }
    $Categorie=htmlentities($_POST['categorie']);
    $Secteur=htmlentities($_POST['secteur']);
    $ID_Responsable=htmlentities($_POST['ID_Responsable']);
    $Prenom_responsable=Securite::bdd($_POST['prenom_responsable']);
    $Nom_responsable=Securite::bdd($_POST['nom_responsable']);
    $Pnom_responsable=Securite::bdd($_POST['pnom_responsable']);
    $Sexe_responsable=Securite::bdd($_POST['sexe_responsable']);
    $Tel_responsable=htmlentities($_POST['tel_responsable']);
    $Lien_responsable=htmlentities($_POST['lien_responsable']);
    $val1=rand();
    $val2=rand();
    $chaine=sha1($val1.$val2);
    $Image=basename($_FILES['mimg']['name']);
    $dossier_image = 'images/eleves/';
    if($ID_Ecole_Provenance==''){
        if($Provenance!=''){
            $req=$pdo->query("INSERT INTO ecole_provenance(Design_Ecole_Provenance) VALUES ('".$Provenance."')");
            $max=$pdo->query("SELECT MAX(ID_Ecole_Provenance) AS ID_Ecole_Provenance FROM ecole_provenance");
            $maxi=$max->fetch();
            $ID_Ecole_Provenance=$maxi['ID_Ecole_Provenance'];
        }
    }
    if($ID_Responsable=='' && $Prenom_responsable!=''){
        $rs=$pdo->prepare("INSERT INTO responsable(ID_Etablissement, ID_Responsable, Prenom_Responsable, Nom_Responsable, Pnom_Responsable, Sexe, Tel, ID_Utilisateur) VALUES (?,?,?,?,?,?,?,?)");
        $params=array($_SESSION['user_eteelo_app']['ID_Etablissement'], $chaine, $Prenom_responsable, $Nom_responsable, $Pnom_responsable, $Sexe_responsable, $Tel_responsable, $_SESSION['user_eteelo_app']['ID_Utilisateur']);
        $rs->execute($params);
        $ID_Responsable=$chaine;
    }
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
            $Image = 'IMG_ELEVE_' . $Time . $extension_img_maj;
            if(move_uploaded_file($_FILES['mimg']['tmp_name'], $dossier_image . $Image)) //Si la fonction renvoie TRUE, c'est
            {
                if($Token==$_SESSION['user_eteelo_app']['token']){
                    if($ID_Eleve==''){
                        $rech=$pdo->query("SELECT * FROM eleve WHERE Matricule='".$Matri."' AND ID_Etablissement=".$Ecole);
                        if($rechs=$rech->fetch() && $Matri!=''){
                            echo "4";
                        }else{
                            $rech=$pdo->query("SELECT * FROM eleve WHERE Matricule='".$Matri."' AND Prenom_Eleve='".$Prenom."' AND Nom_Eleve='".$Nom."' AND Pnom_Eleve='".$Pnom."'");
                            if($rechs=$rech->fetch()){
                                echo "5";
                            }else{
                                if($Token==$_SESSION['user_eteelo_app']['token']){
                                    $rs=$pdo->prepare("INSERT INTO eleve(ID_Eleve, ID_Lieu_Naiss, ID_Commune, ID_Etablissement, Matricule, Prenom_Eleve, Nom_Eleve, Pnom_Eleve, Sexe, Date_Naissance, Adresse, ID_Utilisateur, ID_Ecole_Provenance, ID_Commune_Orig, Photo) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                                    $params=array($chaine, $Lieu, $Commune, $Ecole, $Matri, $Prenom, $Nom, $Pnom, $Sexe, $DateN, $Adresse, $_SESSION['user_eteelo_app']['ID_Utilisateur'], $ID_Ecole_Provenance, $Secteur, $Image);
                                    $rs->execute($params);
                                    $ID_Eleve=$chaine;
                                    if($ID_Responsable!=''){
                                        $res=$pdo->prepare("INSERT INTO eleve_responsable(ID_Enreg, ID_Eleve, ID_Responsable, ID_Degre, ID_Utilisateur) VALUES (?,?,?,?,?)");
                                        $param=array($chaine, $ID_Eleve, $ID_Responsable, $Lien_responsable, $_SESSION['user_eteelo_app']['ID_Utilisateur']);
                                        $res->execute($param);
                                    }
                                    $res=$pdo->prepare("UPDATE inscription SET ID_Eleve=?, ID_Classe=?, ID_Annee=?, ID_Cat_Eleve=?, UpdatedBy=? WHERE ID_Inscription=?");
                                    $param=array($ID_Eleve, $Classe, $Annee, $Categorie, $_SESSION['user_eteelo_app']['ID_Utilisateur'], $ID_Inscription);
                                    $res->execute($param);
                                    echo "1";
                                } 
                            }
                        }
                    }else{
                        if($Token==$_SESSION['user_eteelo_app']['token']){
                            $rs=$pdo->prepare("UPDATE eleve SET ID_Lieu_Naiss=?, ID_Commune=?, Matricule=?, Prenom_Eleve=?, Nom_Eleve=?, Pnom_Eleve=?, Sexe=?, Date_Naissance=?, Adresse=?, ID_Ecole_Provenance=?, ID_Commune_Orig=?, Photo=?, UpdatedBy=? WHERE ID_Eleve=?");
                            $params=array($Lieu, $Commune, $Matri, $Prenom, $Nom, $Pnom, $Sexe, $DateN, $Adresse, $ID_Ecole_Provenance, $Secteur, $Image, $_SESSION['user_eteelo_app']['ID_Utilisateur'], $ID_Eleve);
                            $rs->execute($params);
                            if($ID_Responsable!=''){
                                $rech_eleve_resp=$pdo->query("SELECT * FROM eleve_responsable WHERE ID_Eleve='".$ID_Eleve."' AND ID_Responsable='".$ID_Responsable."'");
                                if(!$rech_eleve_resps=$rech_eleve_resp->fetch()) {
                                    $res=$pdo->prepare("INSERT INTO eleve_responsable(ID_Enreg, ID_Eleve, ID_Responsable, ID_Degre, ID_Utilisateur) VALUES (?,?,?,?,?)");
                                    $param=array($chaine, $ID_Eleve, $ID_Responsable, $Lien_responsable, $_SESSION['user_eteelo_app']['ID_Utilisateur']);
                                    $res->execute($param);
                                }else{
                                    $res=$pdo->query("UPDATE eleve_responsable ID_Degre=".$Lien_responsable." WHERE ID_Eleve='".$ID_Eleve."' AND ID_Responsable='".$ID_Responsable."'");
                                }
                            }
                            $res=$pdo->prepare("UPDATE inscription SET ID_Eleve=?, ID_Classe=?, ID_Annee=?, ID_Cat_Eleve=?, UpdatedBy=? WHERE ID_Inscription=?");
                            $param=array($ID_Eleve, $Classe, $Annee, $Categorie, $_SESSION['user_eteelo_app']['ID_Utilisateur'], $ID_Inscription);
                            $res->execute($param); 
                            echo "1";
                        } 
                    }
                }
            }else{
                echo "3";
            }
        }
    }else{
        if($Token==$_SESSION['user_eteelo_app']['token']){
            if($ID_Eleve==''){
                $rech=$pdo->query("SELECT * FROM eleve WHERE Matricule='".$Matri."' AND ID_Etablissement=".$Ecole);
                if($rechs=$rech->fetch() && $Matri!=''){
                    echo "4";
                }else{
                    $rech=$pdo->query("SELECT * FROM eleve WHERE Matricule='".$Matri."' AND Prenom_Eleve='".$Prenom."' AND Nom_Eleve='".$Nom."' AND Pnom_Eleve='".$Pnom."'");
                    if($rechs=$rech->fetch()){
                        echo "5";
                    }else{
                        if($Token==$_SESSION['user_eteelo_app']['token']){
                            $rs=$pdo->prepare("INSERT INTO eleve(ID_Eleve, ID_Lieu_Naiss, ID_Commune, ID_Etablissement, Matricule, Prenom_Eleve, Nom_Eleve, Pnom_Eleve, Sexe, Date_Naissance, Adresse, ID_Utilisateur, ID_Ecole_Provenance, ID_Commune_Orig) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                            $params=array($chaine, $Lieu, $Commune, $Ecole, $Matri, $Prenom, $Nom, $Pnom, $Sexe, $DateN, $Adresse, $_SESSION['user_eteelo_app']['ID_Utilisateur'], $ID_Ecole_Provenance, $Secteur);
                            $rs->execute($params);
                            $ID_Eleve=$chaine;
                            if($ID_Responsable!=''){
                                $res=$pdo->prepare("INSERT INTO eleve_responsable(ID_Enreg, ID_Eleve, ID_Responsable, ID_Degre, ID_Utilisateur) VALUES (?,?,?,?,?)");
                                $param=array($chaine, $ID_Eleve, $ID_Responsable, $Lien_responsable, $_SESSION['user_eteelo_app']['ID_Utilisateur']);
                                $res->execute($param);
                            }
                            $res=$pdo->prepare("UPDATE inscription SET ID_Eleve=?, ID_Classe=?, ID_Annee=?, ID_Cat_Eleve=?, UpdatedBy=? WHERE ID_Inscription=?");
                            $param=array($ID_Eleve, $Classe, $Annee, $Categorie, $_SESSION['user_eteelo_app']['ID_Utilisateur'], $ID_Inscription);
                            $res->execute($param); 
                            echo "1";
                        } 
                    }
                }
            }else{
                if($Token==$_SESSION['user_eteelo_app']['token']){
                    $rs=$pdo->prepare("UPDATE eleve SET ID_Lieu_Naiss=?, ID_Commune=?, Matricule=?, Prenom_Eleve=?, Nom_Eleve=?, Pnom_Eleve=?, Sexe=?, Date_Naissance=?, Adresse=?, ID_Ecole_Provenance=?, ID_Commune_Orig=?, UpdatedBy=? WHERE ID_Eleve=?");
                    $params=array($Lieu, $Commune, $Matri, $Prenom, $Nom, $Pnom, $Sexe, $DateN, $Adresse, $ID_Ecole_Provenance, $Secteur, $_SESSION['user_eteelo_app']['ID_Utilisateur'], $ID_Eleve);
                    $rs->execute($params);
                    if($ID_Responsable!=''){
                        $rech_eleve_resp=$pdo->query("SELECT * FROM eleve_responsable WHERE ID_Eleve='".$ID_Eleve."' AND ID_Responsable='".$ID_Responsable."'");
                        if(!$rech_eleve_resps=$rech_eleve_resp->fetch()) {
                            $res=$pdo->prepare("INSERT INTO eleve_responsable(ID_Enreg, ID_Eleve, ID_Responsable, ID_Degre, ID_Utilisateur) VALUES (?,?,?,?,?)");
                            $param=array($chaine, $ID_Eleve, $ID_Responsable, $Lien_responsable, $_SESSION['user_eteelo_app']['ID_Utilisateur']);
                            $res->execute($param);
                        }else{
                            $res=$pdo->query("UPDATE eleve_responsable ID_Degre=".$Lien_responsable." WHERE ID_Eleve='".$ID_Eleve."' AND ID_Responsable='".$ID_Responsable."'");
                        }
                    }
                    $res=$pdo->prepare("UPDATE inscription SET ID_Eleve=?, ID_Classe=?, ID_Annee=?, ID_Cat_Eleve=?, UpdatedBy=? WHERE ID_Inscription=?");
                    $param=array($ID_Eleve, $Classe, $Annee, $Categorie, $_SESSION['user_eteelo_app']['ID_Utilisateur'], $ID_Inscription);
                    $res->execute($param); 
                    echo "1";
                } 
            }
        }
    }
?>