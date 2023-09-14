<?php
    session_start();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $ID_Frais=htmlentities($_POST['ID_Frais']);
    $annee=$pdo->query("SELECT * FROM annee WHERE Encours=1");
    $annees=$annee->fetch();
    $Ecole=htmlentities($_POST['ID_Etablissement']);
    $Type_frais=htmlentities($_POST['type_frais']);
    $Check_all_options=htmlentities($_POST['check_all_options']);
    if($Check_all_options==0){
        $Option=htmlentities($_POST['option']);
    }
    $Check_all_classes=htmlentities($_POST['check_all_classes']);
    if($Check_all_classes==0){
        $Niveau=htmlentities($_POST['niveau']);
    }
    $Check_all_categories=htmlentities($_POST['check_all_categories']);
    if($Check_all_categories==0){
        $Categorie=htmlentities($_POST['categorie']);
    }
    $Devise=htmlentities($_POST['devise']);
    $Montant=htmlentities($_POST['montant']);
    if($ID_Frais==''){
        if($Token==$_SESSION['user_eteelo_app']['token']){
            $insert_frais=$pdo->query("INSERT INTO frais SET ID_Type_Frais=".$Type_frais.", ID_Annee=".$annees['ID_Annee'].", ID_Taux=".$Devise.", Montant_Frais=".$Montant.", ID_Utilisateur=".$_SESSION['user_eteelo_app']['ID_Utilisateur']);
            $rech=$pdo->query("SELECT * FROM frais WHERE ID_Type_Frais=".$Type_frais." AND ID_Annee=".$annees['ID_Annee']." AND ID_Taux=".$Devise." AND Montant_Frais=".$Montant);
            $rechs=$rech->fetch();
            $ID_Frais=$rechs['ID_Frais'];
        }
    }
    if($Token==$_SESSION['user_eteelo_app']['token']){
        if($Check_all_classes==0 && $Check_all_categories==0 && $Check_all_options==0){
            $rech_frais_classe=$pdo->query("SELECT * FROM classe_frais WHERE ID_Frais=".$ID_Frais." AND ID_Cat_Eleve=".$Categorie." AND ID_Niveau=".$Niveau." AND ID_Option=".$Option);
            if(!$rech_frais_classes=$rech_frais_classe->fetch()){
                $insert_frais_classe=$pdo->query("INSERT INTO classe_frais SET ID_Frais=".$ID_Frais.", ID_Cat_Eleve=".$Categorie.", ID_Niveau=".$Niveau.", ID_Option=".$Option);
            }
        }else if($Check_all_categories==1 && $Check_all_classes==0 && $Check_all_options==0){
            $select_categorie=$pdo->query("SELECT * FROM categorie_eleve WHERE ID_Etablissement=".$Ecole);
            while($select_categories=$select_categorie->fetch()){
                $rech_frais_classe=$pdo->query("SELECT * FROM classe_frais WHERE ID_Frais=".$ID_Frais." AND ID_Cat_Eleve=".$select_categories['ID_Categorie']." AND ID_Niveau=".$Niveau." AND ID_Option=".$Option);
                if(!$rech_frais_classes=$rech_frais_classe->fetch()){
                    $insert_frais_classe=$pdo->query("INSERT INTO classe_frais SET ID_Frais=".$ID_Frais.", ID_Cat_Eleve=".$select_categories['ID_Categorie'].", ID_Niveau=".$Niveau.", ID_Option=".$Option);
                }
            }
        }else if($Check_all_classes==1 && $Check_all_categories==0  && $Check_all_options==0){
            $select_classe=$pdo->query("SELECT niveau.ID_Niveau FROM niveau INNER JOIN classe ON niveau.ID_Niveau=classe.ID_Niveau INNER JOIN table_option ON classe.ID_Option=table_option.ID_Option INNER JOIN section ON table_option.ID_Section=section.ID_Section WHERE section.ID_Etablissement=".$Ecole." AND table_option.ID_Option=".$Option." ORDER BY niveau.ID_Niveau");
            $classe="";
            while($select_classes=$select_classe->fetch()){
                if($classe!=$select_classes['ID_Niveau']){
                    $classe=$select_classes['ID_Niveau'];
                    $rech_frais_classe=$pdo->query("SELECT * FROM classe_frais WHERE ID_Frais=".$ID_Frais." AND ID_Cat_Eleve=".$Categorie." AND ID_Niveau=".$classe." AND ID_Option=".$Option);
                    if(!$rech_frais_classes=$rech_frais_classe->fetch()){
                        $insert_frais_classe=$pdo->query("INSERT INTO classe_frais SET ID_Frais=".$ID_Frais.", ID_Cat_Eleve=".$Categorie.", ID_Niveau=".$classe.", ID_Option=".$Option);
                    }
                }
            }
        }else if($Check_all_options==1 && $Check_all_classes==0 && $Check_all_categories==0){
            $select_option=$pdo->query("SELECT * FROM table_option INNER JOIN section ON table_option.ID_Section=section.ID_Section WHERE section.ID_Etablissement=".$Ecole." ORDER BY table_option.ID_Option");
            $option="";
            while($select_options=$select_option->fetch()){
                if($option!=$select_options['ID_Option']){
                    $option=$select_options['ID_Option'];
                    $rech_frais_classe=$pdo->query("SELECT * FROM classe_frais WHERE ID_Frais=".$ID_Frais." AND ID_Cat_Eleve=".$Categorie." AND ID_Niveau=".$Niveau." AND ID_Option=".$option);
                    if(!$rech_frais_classes=$rech_frais_classe->fetch()){
                        $insert_frais_classe=$pdo->query("INSERT INTO classe_frais SET ID_Frais=".$ID_Frais.", ID_Cat_Eleve=".$Categorie.", ID_Niveau=".$Niveau.", ID_Option=".$option);
                    }
                }
            }
        }else if($Check_all_categories==1 && $Check_all_classes==1 && $Check_all_options==0){
            $select_categorie=$pdo->query("SELECT * FROM categorie_eleve WHERE ID_Etablissement=".$Ecole);
            while($select_categories=$select_categorie->fetch()){
                $select_classe=$pdo->query("SELECT niveau.ID_Niveau FROM niveau INNER JOIN classe ON niveau.ID_Niveau=classe.ID_Niveau INNER JOIN table_option ON classe.ID_Option=table_option.ID_Option INNER JOIN section ON table_option.ID_Section=section.ID_Section WHERE section.ID_Etablissement=".$Ecole." AND table_option.ID_Option=".$Option." ORDER BY niveau.ID_Niveau");
                $classe="";
                while($select_classes=$select_classe->fetch()){
                    if($classe!=$select_classes['ID_Niveau']){
                        $classe=$select_classes['ID_Niveau'];
                        $rech_frais_classe=$pdo->query("SELECT * FROM classe_frais WHERE ID_Frais=".$ID_Frais." AND ID_Cat_Eleve=".$select_categories['ID_Categorie']." AND ID_Niveau=".$classe." AND ID_Option=".$Option);
                        if(!$rech_frais_classes=$rech_frais_classe->fetch()){
                            $insert_frais_classe=$pdo->query("INSERT INTO classe_frais SET ID_Frais=".$ID_Frais.", ID_Cat_Eleve=".$select_categories['ID_Categorie'].", ID_Niveau=".$classe.", ID_Option=".$Option);
                        }
                    }
                }
            }
        }else if($Check_all_categories==1 && $Check_all_options==1 && $Check_all_classes==0){
            $select_categorie=$pdo->query("SELECT * FROM categorie_eleve WHERE ID_Etablissement=".$Ecole);
            while($select_categories=$select_categorie->fetch()){
                $select_option=$pdo->query("SELECT * FROM table_option INNER JOIN section ON table_option.ID_Section=section.ID_Section WHERE section.ID_Etablissement=".$Ecole." ORDER BY table_option.ID_Option");
                $option="";
                while($select_options=$select_option->fetch()){
                    if($option!=$select_options['ID_Option']){
                        $option=$select_options['ID_Option'];
                        $rech_frais_classe=$pdo->query("SELECT * FROM classe_frais WHERE ID_Frais=".$ID_Frais." AND ID_Cat_Eleve=".$select_categories['ID_Categorie']." AND ID_Niveau=".$Niveau." AND ID_Option=".$option);
                        if(!$rech_frais_classes=$rech_frais_classe->fetch()){
                            $insert_frais_classe=$pdo->query("INSERT INTO classe_frais SET ID_Frais=".$ID_Frais.", ID_Cat_Eleve=".$select_categories['ID_Categorie'].", ID_Niveau=".$Niveau.", ID_Option=".$option);
                        }
                    }
                }
            }
        }else if($Check_all_options==1 && $Check_all_classes==1 && $Check_all_categories==0){
            $select_option=$pdo->query("SELECT * FROM table_option INNER JOIN section ON table_option.ID_Section=section.ID_Section WHERE section.ID_Etablissement=".$Ecole." ORDER BY table_option.ID_Option");
            $option="";
            while($select_options=$select_option->fetch()){
                if($option!=$select_options['ID_Option']){
                    $option=$select_options['ID_Option'];
                    $select_classe=$pdo->query("SELECT niveau.ID_Niveau FROM niveau INNER JOIN classe ON niveau.ID_Niveau=classe.ID_Niveau INNER JOIN table_option ON classe.ID_Option=table_option.ID_Option INNER JOIN section ON table_option.ID_Section=section.ID_Section WHERE section.ID_Etablissement=".$Ecole." AND table_option.ID_Option=".$option." ORDER BY niveau.ID_Niveau");
                    $classe="";
                    while($select_classes=$select_classe->fetch()){
                        if($classe!=$select_classes['ID_Niveau']){
                            $classe=$select_classes['ID_Niveau'];
                            $rech_frais_classe=$pdo->query("SELECT * FROM classe_frais WHERE ID_Frais=".$ID_Frais." AND ID_Cat_Eleve=".$Categorie." AND ID_Niveau=".$classe." AND ID_Option=".$option);
                            if(!$rech_frais_classes=$rech_frais_classe->fetch()){
                                $insert_frais_classe=$pdo->query("INSERT INTO classe_frais SET ID_Frais=".$ID_Frais.", ID_Cat_Eleve=".$Categorie.", ID_Niveau=".$classe.", ID_Option=".$option);
                            }
                        }
                    }
                }
            }
        }else{
            $select_option=$pdo->query("SELECT * FROM table_option INNER JOIN section ON table_option.ID_Section=section.ID_Section WHERE section.ID_Etablissement=".$Ecole." ORDER BY table_option.ID_Option");
            $option="";
            while($select_options=$select_option->fetch()){
                if($option!=$select_options['ID_Option']){
                    $option=$select_options['ID_Option'];
                    $select_classe=$pdo->query("SELECT niveau.ID_Niveau FROM niveau INNER JOIN classe ON niveau.ID_Niveau=classe.ID_Niveau INNER JOIN table_option ON classe.ID_Option=table_option.ID_Option INNER JOIN section ON table_option.ID_Section=section.ID_Section WHERE section.ID_Etablissement=".$Ecole." AND table_option.ID_Option=".$option." ORDER BY niveau.ID_Niveau");
                    $classe="";
                    while($select_classes=$select_classe->fetch()){
                        if($classe!=$select_classes['ID_Niveau']){
                            $classe=$select_classes['ID_Niveau'];
                            $select_categorie=$pdo->query("SELECT * FROM categorie_eleve WHERE ID_Etablissement=".$Ecole);
                            while($select_categories=$select_categorie->fetch()){
                                $rech_frais_classe=$pdo->query("SELECT * FROM classe_frais WHERE ID_Frais=".$ID_Frais." AND ID_Cat_Eleve=".$select_categories['ID_Categorie']." AND ID_Niveau=".$classe." AND ID_Option=".$option);
                                if(!$rech_frais_classes=$rech_frais_classe->fetch()){
                                    $insert_frais_classe=$pdo->query("INSERT INTO classe_frais SET ID_Frais=".$ID_Frais.", ID_Cat_Eleve=".$select_categories['ID_Categorie'].", ID_Niveau=".$classe.", ID_Option=".$option);
                                }
                            }
                        }
                    }
                }
            }
        }
        echo '1';
    }
?>