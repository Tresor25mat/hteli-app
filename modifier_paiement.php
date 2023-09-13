<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connection");
    }
    require_once('connexion.php');
    $ID=$_GET['ID'];
    $req_paiement=$pdo->query("SELECT eleve.*, paiement.*, annee.*, classe.*, recu.*, utilisateur.*, paiement.Date_Enreg AS Date_Paie, frais.*, paiement.ID_Taux AS Taux_Paiement FROM eleve INNER JOIN inscription ON eleve.ID_Eleve=inscription.ID_Eleve INNER JOIN paiement ON inscription.ID_Inscription=paiement.ID_Inscription INNER JOIN classe ON inscription.ID_Classe=classe.ID_Classe INNER JOIN annee ON inscription.ID_Annee=annee.ID_Annee INNER JOIN table_option ON classe.ID_Option=table_option.ID_Option INNER JOIN section ON table_option.ID_Section=section.ID_Section INNER JOIN recu ON paiement.ID_Paiement=recu.ID_Paiement INNER JOIN utilisateur ON paiement.ID_Utilisateur=utilisateur.ID_Utilisateur INNER JOIN frais ON paiement.ID_Frais=frais.ID_Frais WHERE paiement.ID_Paiement='".$ID."'");
    $paiements=$req_paiement->fetch();
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
    <title>Modification d'un paiement | <?php echo $app_infos['Design_App']; ?></title>
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
        top: 15%;
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
          <input type="hidden" name="txt_Eleve" id="txt_Recu" value="<?php if(isset($_GET['Recu']) && $_GET['Recu']!=''){echo $_GET['Recu']; } ?>">
          <div class="page-header d-print-none">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                  
                </div>
                <h2 class="page-title">
                Modification d'un paiement
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
                  <!-- <a href="#" id="retour_table" class="btn btn-primary d-sm-inline-block" title="Retour">
                    Download SVG icon from http://tabler-icons.io/i/plus
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-reply" viewBox="0 0 16 16">
                      <path d="M6.598 5.013a.144.144 0 0 1 .202.134V6.3a.5.5 0 0 0 .5.5c.667 0 2.013.005 3.3.822.984.624 1.99 1.76 2.595 3.876-1.02-.983-2.185-1.516-3.205-1.799a8.74 8.74 0 0 0-1.921-.306 7.404 7.404 0 0 0-.798.008h-.013l-.005.001h-.001L7.3 9.9l-.05-.498a.5.5 0 0 0-.45.498v1.153c0 .108-.11.176-.202.134L2.614 8.254a.503.503 0 0 0-.042-.028.147.147 0 0 1 0-.252.499.499 0 0 0 .042-.028l3.984-2.933zM7.8 10.386c.068 0 .143.003.223.006.434.02 1.034.086 1.7.271 1.326.368 2.896 1.202 3.94 3.08a.5.5 0 0 0 .933-.305c-.464-3.71-1.886-5.662-3.46-6.66-1.245-.79-2.527-.942-3.336-.971v-.66a1.144 1.144 0 0 0-1.767-.96l-3.994 2.94a1.147 1.147 0 0 0 0 1.946l3.994 2.94a1.144 1.144 0 0 0 1.767-.96v-.667z"/>
                    </svg>
                    Retour
                  </a> -->
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
                  <!-- <ul class="nav nav-tabs l0" data-bs-toggle="tabs"> -->
                    <!-- <li class="nav-item">
                      <a href="#tabs-home-12" id="a0" class="nav-link active" data-bs-toggle="tab">Saisie d'un élève</a>
                    </li>
                    <li class="nav-item l1 disabled">
                      <a href="#tabs-home-13" class="nav-link " id="a1" data-bs-toggle="tab">Importation</a>
                    </li> -->
                    <!-- <li class="nav-item ms-auto">
                      <a href="#tabs-settings-7" class="nav-link" title="Settings" data-bs-toggle="tab">Download SVG icon from http://tabler-icons.io/i/settings
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" /><circle cx="12" cy="12" r="3" /></svg>
                      </a>
                    </li> -->
                  <!-- </ul> -->
                  <div class="card-body">
                    <div class="tab-content">
                      <div class="tab-pane active show" id="tabs-home-12">
                      <form id="PaiementForm" method="post" action="" enctype="multipart/form-data">
                          <div class="row" style="margin-bottom: 5px; border-bottom: 1px solid #EEEEEE;">
                                <div class="col-md-12" style="margin-bottom: 5px">
                                    <div class="row">
                                      <div class="col-md-3" style="margin-bottom: 5px; <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){echo 'display: none';} ?>">
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
                                      <div class="col-md-3" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="frais" class="control-label col-lg-12" style="text-align: left;">Frais *</label>
                                          <div class="col-lg-12">
                                            <input type="hidden" name="ID_Paiement" id="ID_Paiement" value="<?php echo $paiements['ID_Paiement']; ?>">
                                            <input type="hidden" name="ID_Operation" id="ID_Operation" value="<?php echo $paiements['ID_Operation']; ?>">
                                            <input type="hidden" name="ID_Frais" id="ID_Frais" value="<?php echo $paiements['ID_Type_Frais']; ?>">
                                            <select name="frais" class="form-control" id="frais">
                                                <option value="" id="add_frais">--</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-3" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                            <label for="annee" class="control-label col-lg-12" style="text-align: left;">Année scolaire *</label>
                                            <select name="annee" class="form-control" id="annee">
                                                <option value="">--</option>
                                                <?php while($annees=$annee->fetch()){ ?>
                                                <option value="<?php echo($annees['ID_Annee']) ?>" <?php if($annees['ID_Annee']==$paiements['ID_Annee']){echo 'selected';} ?>><?php echo(stripslashes($annees['Libelle_Annee'])) ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                      </div>
                                      <div class="col-md-3" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="datepaiement" class="control-label col-lg-12" style="text-align: left;">Date de paiement </label>
                                          <div class="col-lg-12">
                                            <input class="form-control date" id="datepaiement" type="text" name="datepaiement" value="<?= date('d/m/Y', strtotime($paiements['Date_Paie'])); ?>">
                                            <input type="hidden" name="datepaie" id="datepaie" value="<?= date('Y-m-d', strtotime($paiements['Date_Paie'])); ?>">
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                          </div>
                          <div class="row" style="margin-bottom: 5px; border-bottom: 1px solid #EEEEEE">
                              <div class="col-md-12" style="margin-bottom: 5px">
                                  <div class="row">
                                    <div class="col-md-12" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                          <label for="ancien_eleve" class="control-label col-lg-12" style="text-align: left;">Elève </label>
                                          <div class="col-lg-12">
                                          <input type="text" class="form-control" id="ancien_eleve" name="ancien_eleve" value="<?php echo stripslashes($paiements['Nom_Eleve'].' '.$paiements['Pnom_Eleve'].' '.$paiements['Prenom_Eleve']); ?>" disabled>
                                          <input id="token" type="hidden" name="token" value="<?php echo($_SESSION['user_eteelo_app']['token']); ?>">
                                          <input type="hidden" name="ID_Eleve" id="ID_Eleve" value="<?php echo $paiements['ID_Eleve']; ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-3" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="paiements_effectues" class="control-label col-lg-12" style="text-align: left;">Déjà payé </label>
                                          <div class="col-lg-12">
                                              <div class="input-group">
                                                <input type="text" class="form-control" id="paiements_effectues" name="paiements_effectues" disabled style="border-right: none; text-align: right; font-weight: bold; color: #1E1E1E" value="0,00">
                                                <div class="input-group-apend">
                                                  <span class="input-group-text devise_paiement" style="border-top-left-radius: 0; border-bottom-left-radius: 0; border-left: none; height: 38px; font-weight: bold; color: #1E1E1E">USD</span>
                                                </div>
                                              </div> 
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-3" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="montant_reste" class="control-label col-lg-12" style="text-align: left;">Reste à payer</label>
                                          <div class="col-lg-12">
                                              <div class="input-group">
                                                <input type="text" class="form-control" id="montant_reste" name="montant_reste" disabled style="border-right: none; text-align: right; font-weight: bold; color: #D63939" value="0,00">
                                                <div class="input-group-apend">
                                                  <span class="input-group-text devise_paiement" style="border-top-left-radius: 0; border-bottom-left-radius: 0; border-left: none; height: 38px; font-weight: bold; color: #D63939">USD</span>
                                                </div>
                                              </div> 
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-3" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="devise" class="control-label col-lg-12" style="text-align: left;">Devise *</label>
                                          <div class="col-lg-12">
                                            <input type="hidden" name="ID_Taux" id="ID_Taux" value="<?php echo $paiements['Taux_Paiement']; ?>">
                                            <select name="devise" class="form-control" id="devise" style="color: #1E1E1E; font-weight: bold">
                                                <option value="" id="add_devise" style="color: #1E1E1E; font-weight: bold">--</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-3" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="montant_paiement" class="control-label col-lg-12" style="text-align: left;">Montant *</label>
                                          <div class="col-lg-12">
                                              <div class="input-group">
                                                <input class="form-control " id="montant_paiement" type="number" name="montant_paiement" min="0" step="any" style="border-right: none; text-align: right; font-weight: bold; color: #1E1E1E" value="<?php echo number_format($paiements['Montant_Paie'], 2, '.', ''); ?>">
                                                <div class="input-group-apend">
                                                  <span class="input-group-text devise_paiement" id="afficher_devise_paiement" style="border-top-left-radius: 0; border-bottom-left-radius: 0; border-left: none; height: 38px; background: #FFFFFF; font-weight: bold; color: #1E1E1E">USD</span>
                                                </div>
                                              </div> 
                                          </div>
                                        </div>
                                      </div>

                                      </div>
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
                                <div class="row" style="marging-bottom: 20px;">
                                            <div class="form-group col-3" style="padding-top: 5px">
                                                <div class="col-4">
                                                    <input type="hidden" name="mode_paiement" id="mode_paiement" value="<?php echo $paiements['Mode_Paiement']; ?>">
                                                    <input type="checkbox" name="btn_check_mode_caisse" style="border-radius: 0; width:17px; height:17px; " id="btn_check_mode_caisse" value="0">
                                                </div>
                                                <label for="btn_check_mode_caisse" class="control-label" style="text-align: left; margin-bottom: 5px">En caisse </label>
                                            </div>
                                            <div class="form-group col-3" style="padding-top: 5px">
                                                <div class="col-4">
                                                    <input type="checkbox" name="btn_check_mode_banque" style="border-radius: 0; width:17px; height:17px; " id="btn_check_mode_banque" value="0">
                                                </div>
                                                <label for="btn_check_mode_banque" class="control-label" style="text-align: left; margin-bottom: 5px">En banque </label>
                                            </div>
                                            <div class="form-group col-3" style="padding-top: 5px">
                                                <div class="col-4">
                                                    <input type="checkbox" name="btn_check_mode_proformat" style="border-radius: 0; width:17px; height:17px; " id="btn_check_mode_proformat" value="0">
                                                </div>
                                                <label for="btn_check_mode_proformat" class="control-label" style="text-align: left; margin-bottom: 5px">Pro forma </label>
                                            </div>
                                </div>
                                <div class="row" style="margin-bottom: 20px; border-bottom: 1px solid #EEEEEE;">
                                  <div class="col-md-12" style="margin-bottom: 5px">
                                    <div class="row" style="padding-top: 5px">
                                      <div class="col-md-3" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                          <div class="col-lg-12">
                                            <select name="compte_caisse" id="compte_caisse" class="form-control ">
                                              <option value="" id="add_compte_caisse">--</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-3" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                          <div class="col-lg-12">
                                            <select name="compte_banque" id="compte_banque" class="form-control ">
                                              <option value="" id="add_compte_banque">--</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>

                                      </div>
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

                      </div>
                      <!-- <div class="form-panel" style="border-top: solid 1px RGB(231,231,231);"> -->
                          <!-- <iframe src="" style="width: 100%; height: 1000px;border: 1px solid #E6E7E9; margin-top: 20px; padding: 7px; background: #F5F7FB" id="iframe"></iframe> -->
                          <iframe id="iframe_impression" src="" style="display: none;"></iframe>
                      <!-- </div> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
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

    listeleve=[]; 
    function recheche_eleve(){
        $.ajax({
          url:"recherche_eleve.php",
          type:'post',
          dataType:"json",
          data:{Ecole:$('#ecole').val(), Annee:$('#annee').val()},
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
    $(document).ready(function(){
        recheche_eleve();
        $.ajax({
                url:'recherche_type_frais.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#ecole').val()},
                success:function(ret){
                    $('#add_frais').nextAll().remove();
                    $('#add_frais').after(ret);
                    // alertify.alert($('#ID_Frais').val());
                    $('#frais').val($('#ID_Frais').val());
                    $.ajax({
                        url:'recherche_devise_frais.php',
                        type:'post',
                        dataType:'text',
                        data: {Frais:$('#frais').val(), Annee:$('#annee').val()},
                        success:function(devise_retour){
                            if(devise_retour!=""){
                                $('.devise_paiement').text(devise_retour);
                                $.ajax({
                                    url:'recherche_compte_type_frais.php',
                                    type:'post',
                                    dataType:'text',
                                    data: {Frais:$('#frais').val()},
                                    success:function(retour){
                                        const stret = retour;
                                        const valeuret = stret.split(',');
                                        if($('#mode_paiement').val()==1){
                                            $('#btn_check_mode_caisse').prop('checked', true);
                                            $('#btn_check_mode_banque').prop('checked', false);
                                            $('#btn_check_mode_proformat').prop('checked', false);
                                            $('#compte_banque').val('');
                                        }else if($('#mode_paiement').val()==2){
                                            $('#btn_check_mode_banque').prop('checked', true);
                                            $('#btn_check_mode_caisse').prop('checked', false);
                                            $('#btn_check_mode_proformat').prop('checked', false);
                                            $('#compte_caisse').val('');
                                        }else{
                                            $('#btn_check_mode_banque').prop('checked', false);
                                            $('#btn_check_mode_caisse').prop('checked', false);
                                            $('#btn_check_mode_proformat').prop('checked', true);
                                            $('#compte_banque').val('');
                                            $('#compte_caisse').val('');
                                        }
                                    }
                                });
                            }
                        }
                    });
                    $.ajax({
                        url:"recherche_paiement_eleve.php",
                        type:"post",
                        dataType:"json",
                        data:{ID_Eleve:$('#ID_Eleve').val(), Annee:$('#annee').val(), Frais:$('#frais').val(), Paiement:$('#ID_Paiement').val()},
                        success:function(donnee){
                            // alertify.alert(donnee);
                            $.map(donnee,function(objet){
                                    $('#paiements_effectues').val(objet.Montant_paye);
                                    $('#montant_reste').val(objet.Montant_reste);
                            })
                        }
                    })
                }
            });
            $.ajax({
                url:'recherche_devises.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#ecole').val()},
                success:function(ret){
                    $('#add_devise').nextAll().remove();
                    $('#add_devise').after(ret);
                    $('#devise').val($('#ID_Taux').val());
                    $.ajax({
                        url:'recherche_code_devise.php',
                        type:'post',
                        dataType:'text',
                        data: {Devise:$('#devise').val()},
                        success:function(ret){
                            $('#afficher_devise_paiement').text(ret);
                        }
                    });
                }
            });
            $.ajax({
                url:'recherche_comptes_caisse.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#ecole').val()},
                success:function(ret){
                    $('#add_compte_caisse').nextAll().remove();
                    $('#add_compte_caisse').after(ret);
                    $.ajax({
                        url:'recherche_operation_paiement.php',
                        type:'post',
                        dataType:'html', 
                        data:{Paiement:$('#ID_Paiement').val()},
                        success:function(ret){
                            $('#compte_caisse').val(ret);
                        }
                    });
                }
            });
            $.ajax({
                url:'recherche_comptes_banque.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#ecole').val()},
                success:function(ret){
                    $('#add_compte_banque').nextAll().remove();
                    $('#add_compte_banque').after(ret);
                    $.ajax({
                        url:'recherche_operation_paiement.php',
                        type:'post',
                        dataType:'html', 
                        data:{Paiement:$('#ID_Paiement').val()},
                        success:function(ret){
                            $('#compte_banque').val(ret);
                        }
                    });
                }
            });
            $('#iframe').attr('src','table_paiement_today.php?Ecole='+$('#ID_Etab').val()+'&Annee='+$('#Liste_Annee').val()+'&Classe='+$('#Liste_Classe').val()+'&Eleve='+$('#txt_Eleve').val()+'&Recu='+$('#txt_Recu').val());
    })

    $('#ancien_eleve').autocomplete({source:function(request,response){
        var resultat=$.ui.autocomplete.filter(listeleve,request.term);
        response(resultat.slice(0,15));
        },
        select:function(event,ui){
            $('#ID_Eleve').val(ui.item.desc);
            if($('#frais').val()!='' && $('#annee').val()!=''){
              $.ajax({
                  url:"recherche_paiement_eleve.php",
                  type:"post",
                  dataType:"json",
                  data:{ID_Eleve:$('#ID_Eleve').val(), Annee:$('#annee').val(), Frais:$('#frais').val()},
                  success:function(donnee){
                    //   alertify.alert(donnee);
                      $.map(donnee,function(objet){
                            $('#paiements_effectues').val(objet.Montant_paye);
                            $('#montant_reste').val(objet.Montant_reste);
                            if(objet.Montant_paye=='0,00' && objet.Montant_reste=='0,00'){
                                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Le montant du frais séléctionné n\'est pas encore configuré!', function(){
                                $('#btn_enregistrer').attr('disabled', true);
                                $('#ID_Eleve').val('');
                                $('#ancien_eleve').val('');
                                $('#frais').focus();
                            })
                            }else{
                                $('#btn_enregistrer').attr('disabled', false);
                                $('#montant_paiement').focus().select();
                            }
                      })
                  }
              })
            }else{
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez séléctionner la frais et l\'année svp!', function(){
                    $('#btn_enregistrer').attr('disabled', true);
                    $('#ID_Eleve').val('');
                    $('#ancien_eleve').val('');
                    $('#frais').focus();
                })
            }
        }
    });
    $('#ecole').change(function(){
        if($('#ecole').val()!=''){
            $.ajax({
                url:'recherche_type_frais.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#ecole').val()},
                success:function(ret){
                    $('#add_frais').nextAll().remove();
                    $('#add_frais').after(ret);
                }
            });
            $.ajax({
                url:'recherche_devises.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#ecole').val()},
                success:function(ret){
                    $('#add_devise').nextAll().remove();
                    $('#add_devise').after(ret);
                }
            });
            $.ajax({
                url:'recherche_comptes_caisse.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#ecole').val()},
                success:function(ret){
                    $('#add_compte_caisse').nextAll().remove();
                    $('#add_compte_caisse').after(ret);
                }
            });
            $.ajax({
                url:'recherche_comptes_banque.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#ecole').val()},
                success:function(ret){
                    $('#add_compte_banque').nextAll().remove();
                    $('#add_compte_banque').after(ret);
                }
            });
            recheche_eleve();
            $('#ID_Etablissement').val($('#ecole').val());
        }
    })


    $('#btn_check_informations').click(function(){
        if($('#btn_check_informations').val()==0){
            $('#autres_info').slideDown('slow', function(){

            });
            $('#btn_check_informations').val(1);
        }else{
            $('#autres_info').slideUp('slow', function(){
                // $('#compte_caisse').val('');
                // $('#compte_banque').val('');
                // $('#btn_check_mode_banque').prop('checked', false);
                // $('#btn_check_mode_caisse').prop('checked', false);
                // $('#btn_check_mode_proformat').prop('checked', false);
            });
            $('#btn_check_informations').val(0);
        }
    })
    $('#btn_check_mode_caisse').click(function(){
        if($(this).is(':checked')){
            $('#btn_check_mode_banque').prop('checked', false);
            $('#btn_check_mode_proformat').prop('checked', false);
            $('#mode_paiement').val('1');
            $('#compte_caisse').val('').focus();
            $('#compte_banque').val('');
            // $('#btn_enregistrer').focus();
        }else{
            $('#mode_paiement').val('');  
        }
    })
    $('#btn_check_mode_banque').click(function(){
        if($(this).is(':checked')){
            $('#btn_check_mode_caisse').prop('checked', false);
            $('#btn_check_mode_proformat').prop('checked', false);
            $('#mode_paiement').val('2');
            $('#compte_banque').val('').focus();
            $('#compte_caisse').val('');
            // $('#btn_enregistrer').focus();
        }else{
            $('#mode_paiement').val('');  
        }
    })
    $('#btn_check_mode_proformat').click(function(){
        if($(this).is(':checked')){
            $('#btn_check_mode_caisse').prop('checked', false);
            $('#btn_check_mode_banque').prop('checked', false);
            $('#mode_paiement').val('3');
            $('#compte_banque').val('');
            $('#compte_caisse').val('');
            $('#btn_enregistrer').focus();
        }else{
            $('#mode_paiement').val('');  
        }
    })
    $('#annee').change(function(){
        if($('#annee').val()!=''){
            $('#datepaiement').focus();
        }
    })
    $('#compte_caisse').change(function(){
        if($('#compte_caisse').val()!=''){
            $('#btn_enregistrer').focus();
        }
    })
    $('#compte_banque').change(function(){
        if($('#compte_banque').val()!=''){
            $('#btn_enregistrer').focus();
        }
    })
    $('#devise').change(function(){
        if($('#devise').val()!=''){
            $.ajax({
                url:'recherche_code_devise.php',
                type:'post',
                dataType:'text',
                data: {Devise:$('#devise').val()},
                success:function(ret){
                    $('#afficher_devise_paiement').text(ret);
                }
            });
            $('#montant_paiement').focus();
        }
    })
    $('#frais').change(function(){
        if($('#frais').val()!=''){
            $.ajax({
                url:'recherche_devise_frais.php',
                type:'post',
                dataType:'text',
                data: {Frais:$('#frais').val(), Annee:$('#annee').val()},
                success:function(devise_retour){
                    if(devise_retour!=""){
                        $('.devise_paiement').text(devise_retour);
                        $('#btn_enregistrer').attr('disabled', false);
                        $('#ancien_eleve').attr('disabled', false);
                        $('#montant_paiement').attr('disabled', false);
                        $('#devise').attr('disabled', false);
                        $('#paiements_effectues').val('0,00');
                        $('#montant_reste').val('0,00');
                        $('#montant_paiement').val('0.00');
                        $('#ID_Eleve').val('');
                        $('#ancien_eleve').val('').focus();
                        $.ajax({
                            url:'recherche_compte_type_frais.php',
                            type:'post',
                            dataType:'text',
                            data: {Frais:$('#frais').val()},
                            success:function(retour){
                                const stret = retour;
                                const valeuret = stret.split(',');
                                if(valeuret[1]==3){
                                    $('#btn_check_mode_caisse').prop('checked', true);
                                    $('#btn_check_mode_banque').prop('checked', false);
                                    $('#btn_check_mode_proformat').prop('checked', false);
                                    $('#mode_paiement').val('1');
                                    $('#compte_caisse').val(valeuret[0]);
                                    $('#compte_banque').val('');
                                }else{
                                    $('#btn_check_mode_banque').prop('checked', true);
                                    $('#btn_check_mode_caisse').prop('checked', false);
                                    $('#btn_check_mode_proformat').prop('checked', false);
                                    $('#mode_paiement').val('2');
                                    $('#compte_banque').val(valeuret[0]);
                                    $('#compte_caisse').val('');
                                }
                            }
                        });
                    }else{
                        alertify.alert('<?php echo $app_infos['Design_App']; ?>','Le frais séléctionné n\'est pas encore configuré!', function(){
                        $('#ancien_eleve').attr('disabled', true);
                        $('#devise').attr('disabled', true);
                        $('#montant_paiement').attr('disabled', true);
                            $('#btn_enregistrer').attr('disabled', true);
                            $('#btn_check_mode_caisse').prop('checked', false);
                            $('#btn_check_mode_banque').prop('checked', false);
                            $('#btn_check_mode_proformat').prop('checked', false);
                            $('#paiements_effectues').val('0,00');
                            $('#montant_reste').val('0,00');
                            $('#montant_paiement').val('0.00');
                            $('#ID_Eleve').val('');
                            $('#ancien_eleve').val('');
                            $('#mode_paiement').val('0');
                            $('#compte_caisse').val('');
                            $('#compte_banque').val('');
                        });
                    }
                }
            }); 
        }
    })

    $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    });

        $('#PaiementForm').submit(function(e){
            e.preventDefault();
            let datepaiement = $('#datepaiement').val();
            datepaie = datepaiement.replace(/\//g, "-");
            $('#datepaie').val(datepaie);
            var formData = new FormData(this);
            if($('#frais').val()=='' || $('#annee').val()=='' || $('#datepaiement').val()=='' || $('#devise').val()=='' || $('#montant_paiement').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez remplir tous les champs obligatoires svp!', function(){$('#frais').focus();});
            }else if($('#ID_Eleve').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez séléctionner un élève dans la liste svp!', function(){$('#ancien_eleve').focus();});
            }else if($('#paiements_effectues').val()=='0,00' && $('#montant_reste').val()=='0,00'){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Le montant du frais séléctionné n\'est pas encore configuré!', function(){$('#ancien_eleve').focus();});
            }else if($('#montant_paiement').val()=='0.00'){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez saisir un montant différent de zéro svp!', function(){$('#montant_paiement').focus().select();});
            }else{
                $.ajax({
                    url:'edit_paiement.php',
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
                         const str_ret = ret;
                         const retour = str_ret.split(',');
                         if(ret==2){
                             alertify.alert('<?php echo $app_infos['Design_App']; ?>',"La somme des montants payés est supérieur au montant du frais!");
                             $('#btn_annuler_tout').click();
                         }else if(ret==3){
                             alertify.alert('<?php echo $app_infos['Design_App']; ?>',"Image upload failed!");
                         }else if(retour[0]==1){
                             Toast.fire({
                                icon: 'success',
                                title: 'Enregistré'
                             })
                             $('#iframe_impression').attr('src', 'imprimer.php?Page=recu.php&Paiement='+retour[1]+'&Ecole='+$('#ID_Etab').val());
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
        window.location.replace('table_paiement.php?Ecole='+$('#ID_Etab').val()+'&Annee='+$('#Liste_Annee').val()+'&Classe='+$('#Liste_Classe').val()+'&Eleve='+$('#txt_Eleve').val()+'&Recu='+$('#txt_Recu').val());
    })
    $('#btn_annuler_tout').click(function(){
        window.location.replace('table_paiement.php?Ecole='+$('#ID_Etab').val()+'&Annee='+$('#Liste_Annee').val()+'&Classe='+$('#Liste_Classe').val()+'&Eleve='+$('#txt_Eleve').val()+'&Recu='+$('#txt_Recu').val());
    })
    $(function(){
        $(".date").datepicker({closeText:'fermer',prevText:'&#x3c;Préc',nextText:'Suiv&#x3e;',currentText:'Courant',dateFormat:"dd/mm/yy", minDate: "01/01/1990",monthNames:["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aoùt","Septembre","Octobre","Novembre","Décembre"],monthNamesShort:["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"],dayNamesMin:["Dim","Lun","Mar","Mer","Jeu","Ven","Sam"], changeMonth: true, changeYear: true,onSelect: function(value, date) {
            date.dpDiv.find('.ui-datepicker-current-day a')
            .css('background-color', '#FE5000').css({"z-index":99999999999999});}
        });
    });
    </script>
</body>