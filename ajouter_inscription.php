<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connection");
    }
    require_once('connexion.php');
    $profil=$pdo->query("SELECT * FROM profil ORDER BY ID_Profil");
    $ecole=$pdo->query("SELECT * FROM etablissement ORDER BY Design_Etablissement");
    $liste_ecole=$pdo->query("SELECT * FROM etablissement ORDER BY Design_Etablissement");
    $liste_ecole=$pdo->query("SELECT * FROM etablissement ORDER BY Design_Etablissement");
    $lieu=$pdo->query("SELECT * FROM lieu ORDER BY Design_Lieu");
    $commune=$pdo->query("SELECT * FROM commune WHERE ID_Ville=1 ORDER BY Design_Commune");
    $annee=$pdo->query("SELECT * FROM annee ORDER BY ID_Annee");
    $anneee=$pdo->query("SELECT * FROM annee ORDER BY ID_Annee");
    $degre=$pdo->query("SELECT * FROM degre ORDER BY Design_Degre");
    $province=$pdo->query("SELECT * FROM province ORDER BY Design_Prov");
    $app_info=$pdo->query("SELECT * FROM app_infos");
    $app_infos=$app_info->fetch();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Ajouter des élèves | <?php echo $app_infos['Design_App']; ?></title>
    <!-- CSS files -->
    <!-- DataTables CSS -->
    <link href="vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
    <!-- <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="./dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-flags.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-payments.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-vendors.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link href="notifica/css/alertify.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="vendor/jquery/jquery-ui.min.css" />
    <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
    <link href="./dist/css/demo.min.css" rel="stylesheet"/>
    <link href="images/icon.png" rel="icon">
    <link href="images/icon.png" rel="apple-touch-icon">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <style>
      .mylink:hover{
          font-weight: bold;
          text-decoration: none;
      }
      .alertify .ajs-dialog {
        top: 17%;
        transform: translateY(-50%);
        margin: auto;
    }
    .ui-autocomplete{
        background-color:#CCC ! important;
        z-index: 10000;
        width: 200px
      }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed" style="overflow-x: hidden;">
    <div class="page">
      <div class="page-wrapper">
        <div class="container-xl">
          <!-- Page title -->
          <input type="hidden" name="ID_Etab" id="ID_Etab" value="<?php if(isset($_GET['Ecole']) && $_GET['Ecole']!=''){echo $_GET['Ecole']; } ?>">
          <input type="hidden" name="Liste_Annee" id="Liste_Annee" value="<?php if(isset($_GET['Annee']) && $_GET['Annee']!=''){echo $_GET['Annee']; } ?>">
          <input type="hidden" name="Liste_Classe" id="Liste_Classe" value="<?php if(isset($_GET['Classe']) && $_GET['Classe']!=''){echo $_GET['Classe']; } ?>">
          <input type="hidden" name="txt_Eleve" id="txt_Eleve" value="<?php if(isset($_GET['Eleve']) && $_GET['Eleve']!=''){echo $_GET['Eleve']; } ?>">
          <div class="page-header d-print-none">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                  
                </div>
                <h2 class="page-title">
                Ajouter des élèves
                </h2>
              </div>
              <!-- Page title actions -->
              <div class="col-12 col-md-auto ms-auto d-print-none">
                <div class="btn-list">
<!--                   <span class="d-none d-sm-inline">
                    <a href="#" class="btn btn-white">
                      New view
                    </a>
                  </span> -->
                  <a href="#" id="retour_table" class="btn btn-primary d-sm-inline-block" title="Retour">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-reply" viewBox="0 0 16 16">
                      <path d="M6.598 5.013a.144.144 0 0 1 .202.134V6.3a.5.5 0 0 0 .5.5c.667 0 2.013.005 3.3.822.984.624 1.99 1.76 2.595 3.876-1.02-.983-2.185-1.516-3.205-1.799a8.74 8.74 0 0 0-1.921-.306 7.404 7.404 0 0 0-.798.008h-.013l-.005.001h-.001L7.3 9.9l-.05-.498a.5.5 0 0 0-.45.498v1.153c0 .108-.11.176-.202.134L2.614 8.254a.503.503 0 0 0-.042-.028.147.147 0 0 1 0-.252.499.499 0 0 0 .042-.028l3.984-2.933zM7.8 10.386c.068 0 .143.003.223.006.434.02 1.034.086 1.7.271 1.326.368 2.896 1.202 3.94 3.08a.5.5 0 0 0 .933-.305c-.464-3.71-1.886-5.662-3.46-6.66-1.245-.79-2.527-.942-3.336-.971v-.66a1.144 1.144 0 0 0-1.767-.96l-3.994 2.94a1.147 1.147 0 0 0 0 1.946l3.994 2.94a1.144 1.144 0 0 0 1.767-.96v-.667z"/>
                    </svg>
                    Retour
                  </a>
<!--                   <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Create new report">
                    Download SVG icon from http://tabler-icons.io/i/plus
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                  </a> -->
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="page-body">
          <div class="container-xl">
            <div class="row row-cards">
              <div class="col-md-12">
                <div class="card">
                  <ul class="nav nav-tabs l0" data-bs-toggle="tabs">
                    <li class="nav-item">
                      <a href="#tabs-home-12" id="a0" class="nav-link active" data-bs-toggle="tab">Saisie d'un élève</a>
                    </li>
                    <li class="nav-item l1 disabled">
                      <a href="#tabs-home-13" class="nav-link " id="a1" data-bs-toggle="tab">Importation</a>
                    </li>
                    <!-- <li class="nav-item ms-auto">
                      <a href="#tabs-settings-7" class="nav-link" title="Settings" data-bs-toggle="tab">Download SVG icon from http://tabler-icons.io/i/settings
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" /><circle cx="12" cy="12" r="3" /></svg>
                      </a>
                    </li> -->
                  </ul>
                  <div class="card-body">
                    <div class="tab-content">
                      <div class="tab-pane active show" id="tabs-home-12">
                      <form id="EleveForm" method="post" action="" enctype="multipart/form-data">
                          <div class="row" style="margin-bottom: 5px; border-bottom: 1px solid #EEEEEE;">
                                <div class="col-md-10" style="margin-bottom: 5px">
                                    <div class="row">
                                      <div class="col-md-4" style="margin-bottom: 5px; <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){echo 'display: none';} ?>">
                                        <div class="form-group ">
                                          <label for="ecole" class="control-label col-lg-12" style="text-align: left;">Ecole *</label>
                                          <div class="col-lg-12">
                                            <select name="ecole" id="ecole" class="form-control " <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){ echo 'disabled';} ?>>
                                              <option value="">--</option>
                                              <?php while($ecoles=$ecole->fetch()){ ?>
                                              <option value="<?php echo($ecoles['ID_Etablissement'])?>" <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1 && $ecoles['ID_Etablissement']==$_SESSION['user_eteelo_app']['ID_Etablissement']){ echo 'selected';} ?>><?php echo strtoupper($ecoles['Design_Etablissement']); ?></option>
                                              <?php } ?>
                                            </select>
                                            <input id="ID_Etablissement" type="hidden" name="ID_Etablissement" value="<?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){ echo $_SESSION['user_eteelo_app']['ID_Etablissement'];} ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="classe" class="control-label col-lg-12" style="text-align: left;">Classe *</label>
                                          <div class="col-lg-12">
                                            <select name="classe" class="form-control" id="classe">
                                                <option value="" id="add_classe">--</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                            <label for="annee" class="control-label col-lg-12" style="text-align: left;">Année scolaire *</label>
                                            <select name="annee" class="form-control" id="annee">
                                                <option value="">--</option>
                                                <?php while($annees=$annee->fetch()){ ?>
                                                <option value="<?php echo($annees['ID_Annee']) ?>" <?php if($annees['Encours']==1){echo 'selected';} ?>><?php echo(stripslashes($annees['Libelle_Annee'])) ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                <div class="col-md-2" style="margin-bottom: 5px">
                              </div>
                          </div>
                          <div class="row" style="margin-bottom: 5px; border-bottom: 1px solid #EEEEEE">
                              <div class="col-md-10" style="margin-bottom: 5px">
                                  <div class="row">
                                    <div class="col-md-12" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                          <label for="ancien_eleve" class="control-label col-lg-12" style="text-align: left;">Ancien élève </label>
                                          <div class="col-lg-12">
                                          <input type="text" class="form-control" id="ancien_eleve" name="ancien_eleve">
                                          <input type="hidden" name="ID_Eleve" id="ID_Eleve">
                                          </div>
                                        </div>
                                      </div>
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="matricule" class="control-label col-lg-12" style="text-align: left;">Matricule </label>
                                          <div class="col-lg-12">
                                            <input id="token" type="hidden" name="token" value="<?php echo($_SESSION['user_eteelo_app']['token']); ?>">
                                            <input class="form-control " id="matricule" type="text" name="matricule" autofocus="autofocus">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="prenom" class="control-label col-lg-12" style="text-align: left;">Prenom *</label>
                                          <div class="col-lg-12">
                                            <input class="form-control " id="prenom" type="text" name="prenom">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="nom" class="control-label col-lg-12" style="text-align: left;">Nom *</label>
                                          <div class="col-lg-12">
                                            <input class="form-control " id="nom" type="text" name="nom">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pnom" class="control-label col-lg-12" style="text-align: left;">Post-nom </label>
                                          <div class="col-lg-12">
                                            <input class="form-control " id="pnom" type="text" name="pnom">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="sexe" class="control-label col-lg-12" style="text-align: left;">Sexe *</label>
                                          <div class="col-lg-12">
                                            <select name="sexe" id="sexe" class="form-control ">
                                              <option value="">--</option>
                                              <option value="M">Masculin</option>
                                              <option value="F">Féminin</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="adresse" class="control-label col-lg-12" style="text-align: left;">Adresse </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="adresse" type="text" name="adresse">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="commune" class="control-label col-lg-12" style="text-align: left;">Commune </label>
                                          <div class="col-lg-12">
                                            <select name="commune" id="commune" class="form-control ">
                                              <option value="">--</option>
                                              <?php while ($communes=$commune->fetch()){ ?>
                                              <option value="<?php echo($communes['ID_Commune']); ?>"><?php echo(stripslashes($communes['Design_Commune'])); ?></option>
                                              <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="lieu_naiss" class="control-label col-lg-12" style="text-align: left;">Lieu de naissance </label>
                                          <div class="col-lg-12">
                                              <div class="input-group">
                                                <select name="lieu_naiss" class="form-control" id="lieu_naiss">
                                                    <option value="" id="addlieu">--</option>
                                                    <?php while ($lieus=$lieu->fetch()){ ?>
                                                    <option value="<?php echo($lieus['ID_Lieu']); ?>"><?php echo(stripslashes(strtoupper($lieus['Design_Lieu']))); ?></option>
                                                    <?php } ?>
                                                </select>
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-primary" id="ajouter_ville" style="height: 38px; border-top-left-radius: 0; border-bottom-left-radius: 0"><i class="fa fa-plus"></i></button>
                                                </div>
                                              </div> 
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="datenaiss" class="control-label col-lg-12" style="text-align: left;">Date de naissance </label>
                                          <div class="col-lg-12">
                                            <input class="form-control date" id="datenaiss" type="text" name="datenaiss">
                                            <input type="hidden" name="daten" id="daten">
                                          </div>
                                        </div>
                                      </div>
                                      </div>
                                      </div>
                                      <div class="col-md-2" style="margin-bottom: 5px">
                                    <div class="form-group ">
                                      <label for="miamge" class="control-label col-lg-12" style="text-align: left;">Picture</label>
                                      <div class="col-lg-12">
                                        <input class="form-control " id="mimg" type="file" name="mimg" style="display: none;" accept=".jpg, .jpeg, .png">
                                        <a href="#" id="mapercu" title="Choisir l'image">
                                        <img src="images/photo.jpg" style="width: 150px; height: 157px; border: 2px solid RGB(234,234,234); border-radius: 0" id="miamge" class="miamge">
                                        </a>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 5px; border-bottom: 1px solid #EEEEEE;">
                                <div class="col-md-10" style="margin-bottom: 5px">
                                    <div class="row">
                                      <div class="col-md-4" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                          <label for="categorie" class="control-label col-lg-12" style="text-align: left;">Catégorie *</label>
                                          <div class="col-lg-12">
                                            <select name="categorie" id="categorie" class="form-control ">
                                              <option value="" id="add_categorie">--</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                          <label for="provenance" class="control-label col-lg-12" style="text-align: left;">Ecole de provenance </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="provenance" type="text" name="provenance">
                                            <input id="ID_Ecole_Provenance" type="hidden" name="ID_Ecole_Provenance">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                          <label for="prenom" class="control-label col-lg-12" style="text-align: left;"> </label>
                                          <div class="col-lg-12" style="border: 1px solid #D9DBDE; border-radius: 4px; height: 38px; font-size: 11px; padding-left: 5px; padding-right: 5px" id="mydiv">
                                          </div>
                                        </div>
                                      </div>
                                      </div>
                                      </div>
                                      <div class="col-md-2" style="margin-bottom: 5px">
                                  </div>
                              </div>
                              <div class="row" style="marging-bottom: 20px; border-bottom: 1px solid #EEEEEE">
                                        <div class="form-group col-4" style="padding-top: 5px">
                                            <div class="col-4">
                                                <input type="checkbox" name="btn_check_informations" style="border-radius: 0; width:17px; height:17px; " id="btn_check_informations" value="0">
                                            </div>
                                            <label for="btn_check_informations" class="control-label" style="text-align: left; margin-bottom: 5px">Autres informations </label>
                                        </div>
                              </div>
                              <div style="display: none" id="autres_info">
                                <div class="row" style="margin-bottom: 20px; border-bottom: 1px solid #EEEEEE;">
                                  <div class="col-md-10" style="margin-bottom: 5px">
                                    <div class="row" style="padding-top: 5px">
                                      <div class="col-md-4" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                          <label for="province" class="control-label col-lg-12" style="text-align: left;">Province d'origine </label>
                                          <div class="col-lg-12">
                                            <select name="province" id="province" class="form-control ">
                                              <option value="" id="addprovince">--</option>
                                               <?php while ($provinces=$province->fetch()){ ?>
                                                <option value="<?php echo($provinces['ID_Prov']); ?>"><?php echo(stripslashes(strtoupper($provinces['Design_Prov']))); ?></option>
                                               <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                          <label for="territoire" class="control-label col-lg-12" style="text-align: left;">Territoire / Ville </label>
                                          <div class="col-lg-12">
                                            <div class="input-group">
                                                <select name="territoire" id="territoire" class="form-control ">
                                                <option value="" id="addterritoire">--</option>
                                                </select>
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-primary" id="ajouter_territoire" style="height: 38px; border-top-left-radius: 0; border-bottom-left-radius: 0"><i class="fa fa-plus"></i></button>
                                                </div>
                                              </div> 
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                          <label for="secteur" class="control-label col-lg-12" style="text-align: left;">Secteur / Commune </label>
                                          <div class="col-lg-12">
                                            <div class="input-group">
                                                <select name="secteur" id="secteur" class="form-control ">
                                                <option value="" id="addsecteur">--</option>
                                                </select>
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-primary" id="ajouter_secteur" style="height: 38px; border-top-left-radius: 0; border-bottom-left-radius: 0"><i class="fa fa-plus"></i></button>
                                                </div>
                                              </div> 
                                          </div>
                                        </div>
                                      </div>
                                      </div>
                                      </div>
                                      <div class="col-md-2" style="margin-bottom: 5px">
                                    </div>
                              </div>
                              <div class="row" style="margin-bottom: 20px; border-bottom: 1px solid #EEEEEE;">
                                  <div class="col-md-10" style="margin-bottom: 5px">
                                    <div class="row" style="padding-top: 5px">
                                      <div class="col-md-12" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                          <label for="noms" class="control-label col-lg-12" style="text-align: left;">Responsable </label>
                                          <div class="col-lg-12">
                                          <input type="text" class="form-control" id="noms" name="noms">
                                          <input type="hidden" name="ID_Responsable" id="ID_Responsable">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                          <label for="prenom_responsable" class="control-label col-lg-12" style="text-align: left;">Prénom </label>
                                          <div class="col-lg-12">
                                          <input type="text" class="form-control" id="prenom_responsable" name="prenom_responsable"> 
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                          <label for="nom_responsable" class="control-label col-lg-12" style="text-align: left;">Nom </label>
                                          <div class="col-lg-12">
                                          <input type="text" class="form-control" id="nom_responsable" name="nom_responsable"> 
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                          <label for="pnom_responsable" class="control-label col-lg-12" style="text-align: left;">Post-nom </label>
                                          <div class="col-lg-12">
                                          <input type="text" class="form-control" id="pnom_responsable" name="pnom_responsable"> 
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                          <label for="sexe_responsable" class="control-label col-lg-12" style="text-align: left;">Sexe </label>
                                          <div class="col-lg-12">
                                            <select name="sexe_responsable" class="form-control" id="sexe_responsable">
                                                  <option value="">--</option>
                                                  <option value="M">Masculin</option>
                                                  <option value="F">Féminin</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                          <label for="tel_responsable" class="control-label col-lg-12" style="text-align: left;">Téléphone </label>
                                          <div class="col-lg-12">
                                          <input type="text" class="form-control" id="tel_responsable" name="tel_responsable"> 
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                            <label for="lien_responsable" class="control-label col-lg-12" style="text-align: left;">Lien de parenté *</label>
                                            <select name="lien_responsable" class="form-control" id="lien_responsable">
                                                <option value="">--</option>
                                                <?php while ($degres=$degre->fetch()){ ?>
                                                    <option value="<?php echo($degres['ID_Degre']); ?>"><?php echo(stripslashes($degres['Design_Degre'])); ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                      </div>
                                      </div>
                                      </div>
                                      <div class="col-md-2" style="margin-bottom: 5px">
                                  </div>
                              </div>
                            </div>
                                    <div class="row" style="margin-top: 10px; padding-bottom: 10px">
                                            <div class="col-lg-12">
                                              <div class="pull-right">
                                                  <button class="btn btn-primary" type="submit" id="btn_enregistrer">Enregistrer</button>
                                                  <button class="btn btn-danger" type="button" id="btn_annuler_tout">Annuler</button>
                                              </div>
                                            </div>
                                        </div>
                          </form>
                      </div>
                      <div class="tab-pane" id="tabs-home-13">
                        <form class="cmxform form-horizontal style-form" id="ImportForm" method="post" action="" enctype="multipart/form-data">
                            <div class="row" style="margin-bottom: 5px; border-bottom: 1px solid #EEEEEE;">
                                    <div class="col-md-10" style="margin-bottom: 5px">
                                    <div class="row">
                                      <div class="col-md-4" style="margin-bottom: 5px; <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){echo 'display: none';} ?>">
                                        <div class="form-group ">
                                          <label for="list_ecole" class="control-label col-lg-12" style="text-align: left;">Ecole *</label>
                                          <div class="col-lg-12">
                                            <select name="list_ecole" id="list_ecole" class="form-control " <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){ echo 'disabled';} ?>>
                                              <option value="">--</option>
                                              <?php while($liste_ecoles=$liste_ecole->fetch()){ ?>
                                              <option value="<?php echo($liste_ecoles['ID_Etablissement'])?>" <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1 && $liste_ecoles['ID_Etablissement']==$_SESSION['user_eteelo_app']['ID_Etablissement']){ echo 'selected';} ?>><?php echo strtoupper($liste_ecoles['Design_Etablissement']); ?></option>
                                              <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="list_classe" class="control-label col-lg-12" style="text-align: left;">Classe *</label>
                                          <div class="col-lg-12">
                                            <select name="list_classe" class="form-control" id="list_classe">
                                                <option value="" id="addclasse">--</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                            <label for="anneee" class="control-label col-lg-12" style="text-align: left;">Année scolaire *</label>
                                            <select name="anneee" class="form-control" id="anneee">
                                                <option value="">--</option>
                                                <?php while($anneees=$anneee->fetch()){ ?>
                                                <option value="<?php echo($anneees['ID_Annee']) ?>" <?php if($anneees['Encours']==1){echo 'selected';} ?>><?php echo(stripslashes($anneees['Libelle_Annee'])) ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                      </div>
                                      </div>
                                      </div>
                                      <div class="col-md-2" style="margin-bottom: 5px">
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 5px; border-bottom: 1px solid #EEEEEE">
                              <div class="col-md-10" style="margin-bottom: 5px">
                                  <div class="row">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="matricule" class="control-label col-lg-12" style="text-align: left;">Ficiher excel *</label>
                                          <div class="col-lg-12">
                                          <input type="file" name="classeur" id="classeur" class="form-control" accept=".xls, .xlsx, .xlsm, .csv" title="Sélectionner un fichier excel">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="prenom" class="control-label col-lg-12" style="text-align: left;">Feuille de calcul *</label>
                                          <div class="col-lg-12">
                                              <select name="feuille_calcul" id="feuille_calcul" class="form-control" disabled="disabled">
                                                  <option value="" id="add_feuille">--</option>
                                              </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <a href="Modeles/Modele_Grille_Importations.xlsx" class="btn btn-primary" style="margin-top: 19px; width: 100%"><i class="fa fa-download" style="margin-right: 7px"></i>Télécharger le modèle</a>
                                        </div>
                                      </div>
                                      </div>
                                      </div>

                              </div>

                              <div class="row" style="margin-top: 10px; padding-bottom: 10px">
                                            <div class="col-lg-12">
                                              <div class="pull-right">
                                                  <button class="btn btn-primary" type="button" id="btn_importer">Importer</button>
                                                  <button class="btn btn-primary" type="submit" id="btn_transfert" style="display: none;"></button>
                                                  <button class="btn btn-danger" type="button" id="btn_annuler">Annuler</button>
                                              </div>
                                            </div>
                                        </div>
                          </form>
                      </div>
                      <div class="form-panel" style="border-top: solid 1px RGB(231,231,231);">
                          <iframe src="" style="width: 100%; height: 1000px;border: 1px solid #E6E7E9; margin-top: 20px; padding: 7px; background: #F5F7FB" id="iframe"></iframe>  
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="ModalAjoutLieuNaiss" class="modal fade" data-backdrop="static" style="margin-top: 200px">
        <div class="modal-dialog modal-sm" style="border: 1px solid #E6E7E9">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ajout d'une ville</h4>
                    <!-- <button type="button" class="close" datadismiss="modal" ariahidden="true" onclick="fermerDialogueEcole()">&times;</button> -->
                </div>
                <div class="modal-body">
                   <form method="post" action="">
                    <div class="row">
                        <div class="col-12">
                            <div class="col-lg-12">Désignation *</div>
                            <div class="col-lg-12"><input type="text" name="design_ville" id="design_ville" class="form-control" style="margin-top: 1%;" value="" required></div>
                        </div>
                    </div>
                    </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="enregistrer_lieu">Enregistrer</button>
                <button  class="btn btn-danger" onclick="fermerDialogueLieuNaiss()">Annuler</button>
            </div>
            </div>
        </div>
    </div>
    <div id="ModalAjoutTerritoire" class="modal fade" data-backdrop="static" style="margin-top: 300px">
        <div class="modal-dialog modal-sm" style="border: 1px solid #E6E7E9">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ajout d'un territoire</h4>
                    <!-- <button type="button" class="close" datadismiss="modal" ariahidden="true" onclick="fermerDialogueEcole()">&times;</button> -->
                </div>
                <div class="modal-body">
                   <form method="post" action="">
                    <div class="row">
                        <div class="col-12">
                            <div class="col-lg-12">Désignation *</div>
                            <div class="col-lg-12"><input type="text" name="design_territoire" id="design_territoire" class="form-control" style="margin-top: 1%;" value="" required></div>
                        </div>
                    </div>
                    </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="enregistrer_territoire">Enregistrer</button>
                <button  class="btn btn-danger" onclick="fermerDialogueTerritoire()">Annuler</button>
            </div>
            </div>
        </div>
    </div>
    <div id="ModalAjoutSecteur" class="modal fade" data-backdrop="static" style="margin-top: 300px">
        <div class="modal-dialog modal-sm" style="border: 1px solid #E6E7E9">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ajout d'un secteur</h4>
                    <!-- <button type="button" class="close" datadismiss="modal" ariahidden="true" onclick="fermerDialogueEcole()">&times;</button> -->
                </div>
                <div class="modal-body">
                   <form method="post" action="">
                    <div class="row">
                        <div class="col-12">
                            <div class="col-lg-12">Désignation *</div>
                            <div class="col-lg-12"><input type="text" name="design_secteur" id="design_secteur" class="form-control" style="margin-top: 1%;" value="" required></div>
                        </div>
                    </div>
                    </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="enregistrer_secteur">Enregistrer</button>
                <button  class="btn btn-danger" onclick="fermerDialogueSecteur()">Annuler</button>
            </div>
            </div>
        </div>
    </div>
    <script src="./dist/libs/apexcharts/dist/apexcharts.min.js" defer></script>
    <script src="./dist/libs/jsvectormap/dist/js/jsvectormap.min.js" defer></script>
    <script src="./dist/libs/jsvectormap/dist/maps/world.js" defer></script>
    <script src="./dist/libs/jsvectormap/dist/maps/world-merc.js" defer></script>
    <script src="plugins/toastr/toastr.min.js"></script>
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="vendor/jquery/jquery-ui.min.js"></script>
    <script type="text/javascript" src="notifica/alertify.min.js"></script>
    <!-- Tabler Core -->
    <script src="./dist/js/tabler.min.js" defer></script>
    <script src="./dist/js/demo.min.js" defer></script>
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="vendor/datatables-responsive/dataTables.responsive.js"></script>

    <script>
    var waitingDialog = waitingDialog || (function ($) {
    'use strict';

    // Creating modal dialog's DOM
    var $dialog = $(
        '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
        '<div class="modal-dialog modal-m">' +
        '<div class="modal-content">' +
            '<div class="modal-header"><h3 style="margin:0;"></h3></div>' +
            '<div class="modal-body">' +
                '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%; background: #0189BD"></div></div>' +
            '</div>' +
        '</div></div></div>');

    return {
        /**
         * Opens our dialog
         * @param message Custom message
         * @param options Custom options:
         *                options.dialogSize - bootstrap postfix for dialog size, e.g. "sm", "m";
         *                options.progressType - bootstrap postfix for progress bar type, e.g. "success", "warning".
         */
        show: function (message, options) {
            // Assigning defaults
            if (typeof options === 'undefined') {
                options = {};
            }
            if (typeof message === 'undefined') {
                message = 'Loading';
            }
            var settings = $.extend({
                dialogSize: 'm',
                progressType: '',
                onHide: null // This callback runs after the dialog was hidden
            }, options);

            // Configuring dialog
            $dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);
            $dialog.find('.progress-bar').attr('class', 'progress-bar');
            if (settings.progressType) {
                $dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType);
            }
            $dialog.find('h3').text(message);
            // Adding callbacks
            if (typeof settings.onHide === 'function') {
                $dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) {
                    settings.onHide.call($dialog);
                });
            }
            // Opening dialog
            $dialog.modal();
        },
        /**
         * Closes dialog
         */
        hide: function () {
            $dialog.modal('hide');
        }
    };

    })(jQuery);

    listeref=[];
    function recheche_provenance(){
        $.ajax({
          url:"recherche_provenance.php",
          dataType:"json",
          success:function(donnee){
              listeref.length=0;
              $.map(donnee,function(objet){
                  listeref.push({
                      value:objet.Design,
                      desc:objet.ID_Ecole_Provenance
                  });
              });
          }
        });
    }
    listeleve=[]; 
    function recheche_eleve(){
        $.ajax({
          url:"recherche_eleve.php",
          type:'post',
          dataType:"json",
          data:{Ecole:$('#ecole').val()},
          success:function(donnee){
              listeleve.length=0;
              $.map(donnee,function(objet){
                  listeleve.push({
                      value:objet.Nom,
                      desc:objet.ID_Eleve
                  });
              });
          }
        });
    }
    $('#datenaiss').change(function(){
        if($('#datenaiss').val()==''){
          let date_naiss = $('#datenaiss').val();
          date_naissance = date_naiss.replace(/\//g, "-");
          alertify.alert('Salut', date_naissance);
          // $('#daten').val(date_naissance);
        }
    })
    $('#provenance').autocomplete({source:function(request,response){
        var resultat=$.ui.autocomplete.filter(listeref,request.term);
        response(resultat.slice(0,15));
        },
        select:function(event,ui){
            $('#ID_Ecole_Provenance').val(ui.item.desc);
            $('#btn_enregistrer').focus();
        }
    
    });

    listerefe=[]; 
    function recheche_responsable(){
        $.ajax({
          url:"recherche_responsable.php",
          type:'post',
          dataType:"json",
          data:{Ecole:$('#ecole').val()},
          success:function(donnee){
              listerefe.length=0;
              $.map(donnee,function(objet){
                  listerefe.push({
                      value:objet.Nom,
                      desc:objet.ID_Responsable
                  });
              });
          }
        });
    }
    $(document).ready(function(){
        recheche_responsable();
        recheche_provenance();
        recheche_eleve();
        $.ajax({
                url:'recherche_classe.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#ecole').val()},
                success:function(ret){
                    $('#add_classe').nextAll().remove();
                    $('#add_classe').after(ret);
                    $('#addclasse').nextAll().remove();
                    $('#addclasse').after(ret);
                }
            });
            $.ajax({
                url:'recherche_cat_eleves.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#ecole').val()},
                success:function(ret){
                    $('#add_categorie').nextAll().remove();
                    $('#add_categorie').after(ret);
                }
            });
            $('#iframe').attr('src','table_inscription_today.php?Ecole='+$('#ID_Etab').val()+'&Annee='+$('#Liste_Annee').val()+'&Classe='+$('#Liste_Classe').val()+'&Eleve='+$('#txt_Eleve').val());
    })
    $('#noms').autocomplete({source:function(request,response){
        var resultat=$.ui.autocomplete.filter(listerefe,request.term);
        response(resultat.slice(0,15));
        },
        select:function(event,ui){
            $('#ID_Responsable').val(ui.item.desc);

              $.ajax({
                  url:"recherche_responsables.php",
                  type:"post",
                  // beforeSend:function(){
                  //       waitingDialog.show('Veuillez patienter svp!');
                  // },
                  dataType:"json",
                  data:{ID_Responsable:$('#ID_Responsable').val()},
                  success:function(donnee){
                      $.map(donnee,function(objet){
                            $('#prenom_responsable').val(objet.Prenom);
                            $('#nom_responsable').val(objet.Nom);
                            $('#pnom_responsable').val(objet.Pnom);
                            $('#sexe_responsable').val(objet.Sexe);
                            $('#tel_responsable').val(objet.Tel);
                            $('#lien_responsable').focus();
                      })
                  }
              })
        }
    });
    $('#ancien_eleve').autocomplete({source:function(request,response){
        var resultat=$.ui.autocomplete.filter(listeleve,request.term);
        response(resultat.slice(0,15));
        },
        select:function(event,ui){
            $('#ID_Eleve').val(ui.item.desc);

              $.ajax({
                  url:"recherche_details_eleve.php",
                  type:"post",
                  dataType:"json",
                  data:{ID_Eleve:$('#ID_Eleve').val()},
                  success:function(donnee){
                      $.map(donnee,function(objet){
                        $('#prenom').val(objet.Prenom);
                        $('#nom').val(objet.Nom);
                        $('#pnom').val(objet.Pnom);
                        $('#matricule').val(objet.Matricule);
                        $('#sexe').val(objet.Sexe);
                        $('#adresse').val(objet.Adresse);
                        $('#commune').val(objet.Commune);
                        $('#lieu_naiss').val(objet.Lieu);
                        if(objet.Date_Naissance!='01/01/1970'){
                            $('#datenaiss').val(objet.Date_Naissance);
                            $('#daten').val(objet.Date_N);
                        }
                        $('#categorie').val(objet.Categorie);
                        $('#provenance').val(objet.Provenance);
                        $('#ID_Ecole_Provenance').val(objet.ID_Provenance);
                        if(objet.Photo!=''){
                            $('#miamge').attr('src','images/eleves/'+objet.Photo);
                        }else{
                            if(objet.Sexe=='F'){
                                $('#miamge').attr('src', 'images/photo_femme.jpg');
                            }else{
                                $('#miamge').attr('src', 'images/photo.jpg');
                            }
                        }
                        $('#matricule').focus();
                        $('#btn_check_informations').click();
                      })
                  }
              })
        }
    });
    function fermerDialogueLieuNaiss(){
        $("#ModalAjoutLieuNaiss").modal('hide');
    }
    function fermerDialogueTerritoire(){
        $("#ModalAjoutTerritoire").modal('hide');
    }
    function fermerDialogueSecteur(){
        $("#ModalAjoutSecteur").modal('hide');
    }
    $('#ajouter_ville').click(function(){
      $("#ModalAjoutLieuNaiss").modal('show');
      $('#design_ville').val('');
      $('#design_ville').focus();
    })
    $('#ajouter_territoire').click(function(){
      if($('#province').val()==''){
          alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez selectionner une province svp!', function(){$('#province').focus();});
      }else{
          $("#ModalAjoutTerritoire").modal('show');
          $('#design_territoire').val('');
          $('#design_territoire').focus();
      }
    })
    $('#ajouter_secteur').click(function(){
      if($('#province').val()=='' || $('#territoire').val()==''){
          alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez selectionner une province et un territoire svp!', function(){$('#province').focus();});
      }else{
          $("#ModalAjoutSecteur").modal('show');
          $('#design_secteur').val('');
          $('#design_secteur').focus();
      }
    })
    $('#ecole').change(function(){
        if($('#ecole').val()!=''){
            $.ajax({
                url:'recherche_classe.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#ecole').val()},
                success:function(ret){
                    $('#add_classe').nextAll().remove();
                    $('#add_classe').after(ret);
                    $('#classe').focus();
                }
            });
            $.ajax({
                url:'recherche_cat_eleves.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#ecole').val()},
                success:function(ret){
                    $('#add_categorie').nextAll().remove();
                    $('#add_categorie').after(ret);
                }
            });
            recheche_responsable();
            recheche_provenance();
            recheche_eleve();
            $('#ID_Etablissement').val($('#ecole').val());
        }
    })
    $('#list_ecole').change(function(){
        if($('#list_ecole').val()!=''){
            $.ajax({
                url:'recherche_classe.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#list_ecole').val()},
                success:function(ret){
                    $('#addclasse').nextAll().remove();
                    $('#addclasse').after(ret);
                    $('#list_classe').focus();
                }
            });
            // $.ajax({
            //     url:'recherche_cat_eleves.php',
            //     type:'post',
            //     dataType:'html', 
            //     data:{Ecole:$('#ecole').val()},
            //     success:function(ret){
            //         $('#add_categorie').nextAll().remove();
            //         $('#add_categorie').after(ret);
            //     }
            // });
        }
    })
    $('#classe').change(function(){
        if($('#classe').val()!=''){
            $('#matricule').focus();
        }
    })
    $('#province').change(function(){
        $('#territoire').val('');
        $('#secteur').val('');
        if ($('#province').val()!=""){
            $.ajax({
                url:'recharge_list.php',
                type:'post',
                dataType:'html', 
                data:{province:$('#province').val(), liste:"province"},
                success:function(ret){
                    $('#addterritoire').nextAll().remove();
                    $('#addterritoire').after(ret);
                    $('#territoire').focus();
                    }
            });
        }
    });
    $('#territoire').change(function(){  
        $('#secteur').val('');
        if ($(this).val()!=""){   
            $.ajax({
                url:'recharge_list.php',
                type:'post',
                dataType:'html', 
                data:{ville:$('#territoire').val(), liste:"ville"},
                success:function(ret){
                    $('#addsecteur').nextAll().remove();
                    $('#addsecteur').after(ret);
                    $('#secteur').focus();
                }
            });   
        }
    });
    $('#secteur').change(function(){  
        $('#noms').focus();
    });
    $('#sexe_responsable').change(function(){
        if($('#sexe_responsable').val()!=''){
            $('#tel_responsable').focus();
        }
    });
    $('#lien_responsable').change(function(){
        if($('#lien_responsable').val()!=''){
            $('#btn_enregistrer').focus();
        }
    });
    $('#btn_check_informations').click(function(){
        if($('#btn_check_informations').val()==0){
            $('#autres_info').slideDown('slow', function(){
                if($('#ID_Eleve').val()!=''){
                      $.ajax({
                      url:"recherche_responsable_eleve.php",
                      type:"post",
                      dataType:"json",
                      data:{ID_Eleve:$('#ID_Eleve').val()},
                      success:function(donnee){
                          $.map(donnee,function(objet){
                              $('#prenom_responsable').val(objet.Prenom);
                              $('#nom_responsable').val(objet.Nom);
                              $('#pnom_responsable').val(objet.Pnom);
                              $('#sexe_responsable').val(objet.Sexe);
                              $('#tel_responsable').val(objet.Tel);
                              $('#lien_responsable').val(objet.Lien);
                              $('#ID_Responsable').val(objet.Responsable);
                          })
                      }
                  })
                  $.ajax({
                        url:'recherche_province_eleve.php',
                        type:'post',
                        dataType:'text',
                        data: {ID_Eleve:$('#ID_Eleve').val()},
                        success:function(ret){
                            $('#addprovince').nextAll().remove();
                            $('#addprovince').after(ret);
                        }
                    });
                    $.ajax({
                        url:'recherche_ville_eleve.php',
                        type:'post',
                        dataType:'text',
                        data: {ID_Eleve:$('#ID_Eleve').val()},
                        success:function(ret){
                            $('#addterritoire').nextAll().remove();
                            $('#addterritoire').after(ret);
                        }
                    });
                    $.ajax({
                        url:'recherche_secteur_eleve.php',
                        type:'post',
                        dataType:'text',
                        data: {ID_Eleve:$('#ID_Eleve').val()},
                        success:function(ret){
                            $('#addsecteur').nextAll().remove();
                            $('#addsecteur').after(ret);
                        }
                    });
                }
            });
            $('#btn_check_informations').val(1);
        }else{
            $('#autres_info').slideUp('slow', function(){
                $('#province').val('');
                $('#territoire').val('');
                $('#secteur').val('');
                $('#prenom_responsable').val('');
                $('#nom_responsable').val('');
                $('#pnom_responsable').val('');
                $('#sexe_responsable').val('');
                $('#tel_responsable').val('');
                $('#lien_responsable').val('');
                $('#noms').val('');
                $('#ID_Responsable').val('');
            });
            $('#btn_check_informations').val(0);
        }
    })
    $('#annee').change(function(){
        if($('#annee').val()!=''){
            $('#matricule').focus();
        }
    })
        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }

        async function demo() {
            await sleep(2000);
            $('#miamge').attr('src', images);
        }

         function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    $('#miamge').attr('src', 'images/loading.gif');
                    images = e.target.result;
                    demo()
                }
                reader.readAsDataURL(input.files[0]);
            }
        }


          $('#sexe').change(function(){
            $('#adresse').focus();
            if($('#mimg').val()==''){
              if($('#sexe').val()=='F'){
                  $('#miamge').attr('src', 'images/photo_femme.jpg');
              }else{
                  $('#miamge').attr('src', 'images/photo.jpg');
              }
            }
          })
          $('#commune').change(function(){
            if($('#commune').val()!=''){
                $('#lieu_naiss').focus();
            }
          })
          $('#lieu_naiss').change(function(){
            if($('#lieu_naiss').val()!=''){
                $('#datenaiss').focus();
            }
          })
          $('#categorie').change(function(){
            if($('#categorie').val()!=''){
                $('#provenance').focus();
            }
          })
    $('#mapercu').click(function(e){
        e.preventDefault();
        $('#mimg').click();
    })
    $('#mimg').change(function(){
         readURL(this);
    })


  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    });


    $('#enregistrer_lieu').click(function(){
        if($('#design_ville').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez saisir une désignation svp!');
                $('#design_ville').focus();
        }else{
                $.ajax({
                        url:'enreg_lieu.php',
                        type:'post',
                        beforeSend:function(){
                        },
                        dataType:'text',
                        data: {Design:$('#design_ville').val()},
                        success:function(ret){
                            if(ret==2){
                                alertify.alert('<?php echo $app_infos['Design_App']; ?>', 'Cette désignation existe déjà'); 
                            }else{
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Enregistrement éffectué'
                                })
                                $('#addlieu').nextAll().remove();
                                $('#addlieu').after(ret);
                                $('#datenaiss').focus();    
                                fermerDialogueLieuNaiss();
                            }
                        }
                    });
        }
    });
    $('#btn_annuler').click(function(){
        reinitialiser();
    })
    function reinitialiser(){
        $('#feuille_calcul').val('');
        $('#classeur').val('');
        $('#feuille_calcul').prop("disabled",true);
        // $('#list_classe').val('');
        // $('#anneee').val('');
        $('#classeur').focus();
    }
    $('#classeur').change(function(){
            $('#btn_transfert').click();
    })
    $('#list_classe').change(function(){
        $('#classeur').focus();
    })
    $('#anneee').change(function(){
        $('#btn_importer').focus();
    })
    $('#ImportForm').submit(function(e){
            e.preventDefault();
            var formData = new FormData(this);
                    $.ajax({
                        url:'select_classeur.php',
                        type:'post',
                        beforeSend:function(){
                            waitingDialog.show('Veuillez patienter svp!');
                        },
                        dataType:'html', 
                        data: formData,
                        processData: false,
                        cache: false,
                        contentType: false,

                        success:function(ret){
                            // alertify.alert(ret);
                            waitingDialog.hide();
                            const str = ret;
                            const valeur = str.split(',');
                            if(valeur[0]==1){
                                $('#add_feuille').nextAll().remove();
                                $('#add_feuille').after(ret);
                                $('#classe').focus();
                            }else if(ret==2){
                                alertify.alert('<?php echo $app_infos['Design_App']; ?>',"Le fichier sélectionné ne dispose d'aucune donnée!",function(){
                                    $('#btn_parcourir').focus();
                                })
                            }else if(ret==3){
                                alertify.alert('<?php echo $app_infos['Design_App']; ?>',"L'extension du fichier sélectionné ne correspond pas à un fichier Excel/CSV!",function(){
                                    $('#classeur').focus();
                                })
                            }else if(ret==4){
                                alertify.alert('<?php echo $app_infos['Design_App']; ?>',"Veuillez sélectionner un fichier Excel/CSV svp!",function(){
                                    $('#classeur').focus();
                                })
                            }else{
                                // alertify.alert(ret);
                                $('#add_feuille').nextAll().remove();
                                $('#add_feuille').after(ret);
                                $('#feuille_calcul').prop("disabled",false);
                                $('#feuille_calcul').focus();
                            }

                        }
                    });

          })
    $('#feuille_calcul').change(function(){
        $('#btn_importer').focus();
    });
        $('#btn_importer').click(function(){
            if($('#feuille_calcul').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>',"Veuillez sélectionner une feuille svp!",function(){
                  $('#feuille_calcul').focus();
                  })
            }else if($('#list_classe').val()=='' || $('#anneee').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>',"Veuillez sélectionner une classe et une année svp!",function(){
                  $('#feuille_calcul').focus();
                  })
            }else{
              // alertify.alert($('#feuille_calcul').val());
                  const str_classeur = $('#feuille_calcul').val();
                  const classeur = str_classeur.split(',');
                            $.ajax({
                              url:'importer_eleve.php',
                              type:'post',
                              beforeSend:function(){
                                  waitingDialog.show('Veuillez patienter svp!');
                              },
                              dataType:'html', 
                              data:{classeur:classeur[0], feuille:classeur[1], classe:$('#list_classe').val(), annee:$('#anneee').val(), Ecole:$('#list_ecole').val()},
                              success:function(ret){
                                  alertify.alert('<?php echo $app_infos['Design_App']; ?>', ret);
                                  waitingDialog.hide();
                                  const str_feuille = ret;
                                  const valeur_ret = str_feuille.split(',');
                                  if(valeur_ret[0]==1){
                                      alertify.alert('<?php echo $app_infos['Design_App']; ?>',"Importation réussie, vous avez enregistré "+valeur_ret[1]+" élèves, le nombre des doublons est "+valeur_ret[2],function(){
                                            reinitialiser();
                                            Toast.fire({
                                                  icon: 'success',
                                                  title: 'Importation réussie'
                                              })
                                        })
                                        $('#iframe').attr('src','table_inscription_today.php?Ecole='+$('#ID_Etab').val());
                                  }else if(ret==2){
                                      alertify.alert('<?php echo $app_infos['Design_App']; ?>',"La feuille sélectionnée ne dispose d'aucune donnée!",function(){
                                        $('#feuille_calcul').focus();
                                        reinitialiser();
                                      })
                                  }else{
                                      alertify.alert('<?php echo $app_infos['Design_App']; ?>', ret);
                                      reinitialiser();
                                  }
                              }
                          });
            }
        })
    $('#enregistrer_territoire').click(function(){
        if($('#design_territoire').val()=='' || $('#province').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Vous devez selectionner une province et saisir une désignation svp!');
                $('#design_territoire').focus();
        }else{
                $.ajax({
                        url:'recharge_list.php',
                        type:'post',
                        beforeSend:function(){
                        },
                        dataType:'text',
                        data: {province:$('#province').val(),designville:$('#design_territoire').val(),liste:"ajoutville"},
                        success:function(ret){
                            if(ret==2){
                                alertify.alert('<?php echo $app_infos['Design_App']; ?>', 'Cette désignation existe déjà'); 
                            }else{
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Enregistrement éffectué'
                                })
                                $('#addterritoire').nextAll().remove();
                                $('#addterritoire').after(ret);
                                $('#secteur').focus();    
                                fermerDialogueTerritoire();
                            }
                        }
                    });
        }
    });

    $('#enregistrer_secteur').click(function(){
        if($('#design_secteur').val()=='' || $('#province').val()=='' || $('#territoire').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Vous devez selectionner une province, un territoire et saisir une désignation svp!');
                $('#design_secteur').focus();
        }else{
                $.ajax({
                        url:'recharge_list.php',
                        type:'post',
                        beforeSend:function(){
                        },
                        dataType:'text',
                        data: {ville:$('#territoire').val(),designsecteur:$('#design_secteur').val(),liste:"ajoutsecteur"},
                        success:function(ret){
                            if(ret==2){
                                alertify.alert('<?php echo $app_infos['Design_App']; ?>', 'Cette désignation existe déjà'); 
                            }else{
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Enregistrement éffectué'
                                })
                                $('#addsecteur').nextAll().remove();
                                $('#addsecteur').after(ret);
                                $('#noms').focus();    
                                fermerDialogueSecteur();
                            }
                        }
                    });
        }
    });

        $('#EleveForm').submit(function(e){
            e.preventDefault();
            let date_naiss = $('#datenaiss').val();
            date_naissance = date_naiss.replace(/\//g, "-");
            $('#daten').val(date_naissance);
            var formData = new FormData(this);
            if($('#prenom').val()=='' || $('#nom').val()=='' || $('#sexe').val()=='' || $('#categorie').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez remplir tous les champs obligatoires svp!', function(){$('#prenom').focus();});
            }else if($('#classe').val()=='' || $('#annee').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez séléctionner la classe et l\'année svp!', function(){$('#classe').focus();});
            }else{
                $.ajax({
                    url:'enreg_eleve.php',
                    type:'post',
                    beforeSend:function(){
                      waitingDialog.show('Veuillez patienter...');
                    },
                    dataType:'text',
                    data: formData,
                    processData: false,
                    cache: false,
                    contentType: false,
                    success:function(ret){
                         waitingDialog.hide();
                         if(ret==2){
                             alertify.alert('<?php echo $app_infos['Design_App']; ?>',"Image extension does not match an image!");
                         }else if(ret==3){
                             alertify.alert('<?php echo $app_infos['Design_App']; ?>',"Image upload failed!");
                         }else if(ret==1){
                             Toast.fire({
                                icon: 'success',
                                title: 'Enregistré'
                             })
                             $('#iframe').attr('src','table_inscription_today.php?Ecole='+$('#ID_Etab').val()+'&Annee='+$('#Liste_Annee').val()+'&Classe='+$('#Liste_Classe').val()+'&Eleve='+$('#txt_Eleve').val());
                             $('#btn_annuler_tout').click();
                         }else{
                            alertify.alert(ret);
                         }
                    }
                });
            }
          })
  })

    $('#retour_table').click(function(e){
        e.preventDefault();
        window.location.replace('afficher_table_inscription.php?Ecole='+$('#ID_Etab').val()+'&Annee='+$('#Liste_Annee').val()+'&Classe='+$('#Liste_Classe').val()+'&Eleve='+$('#txt_Eleve').val());
    })
    $('#btn_annuler_tout').click(function(){
        $('#prenom').val('');
        $('#nom').val('');
        $('#pnom').val('');
        $('#matricule').val('');
        $('#mimg').val('');
        $('#sexe').val('');
        $('#adresse').val('');
        $('#commune').val('');
        $('#ancien_eleve').val('');
        $('#ID_Eleve').val('');
        $('#lieu_naiss').val('');
        $('#datenaiss').val('');
        $('#daten').val('');
        // $('#categorie').val('');
        $('#provenance').val('');
        $('#ID_Ecole_Provenance').val('');
        $('#miamge').attr('src','images/photo.jpg');
        $('#matricule').focus();
        if($('#btn_check_informations').is(':checked')){
            $('#btn_check_informations').click();
        }
        recheche_responsable();
        recheche_provenance();
        recheche_eleve();
    })
    $(function(){
        $(".date").datepicker({closeText:'fermer',prevText:'&#x3c;Préc',nextText:'Suiv&#x3e;',currentText:'Courant',dateFormat:"dd/mm/yy", minDate: "01/01/1990",monthNames:["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aoùt","Septembre","Octobre","Novembre","Décembre"],monthNamesShort:["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"],dayNamesMin:["Dim","Lun","Mar","Mer","Jeu","Ven","Sam"], changeMonth: true, changeYear: true,onSelect: function(value, date) {
            date.dpDiv.find('.ui-datepicker-current-day a')
            .css('background-color', '#FE5000').css({"z-index":99999999999999});}
        });
    });
    </script>
</body>