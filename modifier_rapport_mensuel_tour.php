<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connection");
    }
    require_once('connexion.php');
    $ID=$_GET["ID"];
    $rapport=$pdo->query("SELECT * FROM table_rapport_mensuel_tour INNER JOIN site ON table_rapport_mensuel_tour.ID_Site=site.ID_Site WHERE table_rapport_mensuel_tour.ID_Rapport=".$ID);
    $rapports=$rapport->fetch();
    
    $detail=$pdo->query("SELECT * FROM questionnaire_rapport_tour WHERE ID_Rapport=".$ID);
    $details=$detail->fetch();

    $province=$pdo->query("SELECT * FROM province INNER JOIN site ON province.ID_Prov=site.ID_Prov ORDER BY Design_Prov");
    $tower_type=$pdo->query("SELECT * FROM table_tower_type");
    $app_info=$pdo->query("SELECT * FROM app_infos");
    $app_infos=$app_info->fetch();
    $prov="";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Edit Monthly Tower Inspection | <?php echo $app_infos['Design_App']; ?></title>
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
          <input type="hidden" name="User" id="User" value="<?php if(isset($_GET['User']) && $_GET['User']!=''){echo $_GET['User']; } ?>">
            <input type="hidden" name="TowerType" id="TowerType" value="<?php if(isset($_GET['TowerType']) && $_GET['TowerType']!=''){echo $_GET['TowerType']; } ?>">
            <input type="hidden" name="siteId" id="siteId" value="<?php if(isset($_GET['siteId']) && $_GET['siteId']!=''){echo $_GET['siteId']; } ?>">
            <input type="hidden" name="dateRapport" id="dateRapport" value="<?php if(isset($_GET['dateRapport']) && $_GET['dateRapport']!=''){echo $_GET['dateRapport']; } ?>">
          <!-- <div class="page-header d-print-none">
            <div class="row g-2 align-items-center">
              <div class="col">
                Page pre-title
                <div class="page-pretitle">
                  
                </div>
                <h2 class="page-title">
                Edit Monthly Tower Inspection
                </h2>
              </div>
              Page title actions
              <div class="col-12 col-md-auto ms-auto d-print-none">
                <div class="btn-list">
                </div>
              </div>
            </div>
          </div> -->
        </div>
        <div class="page-body">
          <div class="container-xl">
            <div class="row row-cards">
              <div class="col-md-12">
                <div class="card">
                  <ul class="nav nav-tabs l0" data-bs-toggle="tabs" style="display: none">
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
                      <form id="RapportForm" method="post" action="" enctype="multipart/form-data">
                          <div class="row" style="margin-bottom: 5px; border-bottom: 1px solid #EEEEEE;">
                                <div class="col-md-12" style="margin-bottom: 5px">
                                    <div class="row">
                                      <div class="col-md-4" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                          <label for="province" class="control-label col-lg-12" style="text-align: left;">Province *</label>
                                          <div class="col-lg-12">
                                            <input id="token" type="hidden" name="token" value="<?php echo($_SESSION['user_eteelo_app']['token']); ?>">
                                            <select name="province" id="province" class="form-control ">
                                              <option value="">--</option>
                                              <?php while($provinces=$province->fetch()){ 
                                                if($prov!=$provinces['ID_Prov']){ 
                                                    $prov=$provinces['ID_Prov'];
                                              ?>
                                              <option value="<?php echo($provinces['ID_Prov']); ?>" <?php if($provinces['ID_Prov']==$rapports['ID_Prov']){echo "selected";} ?>><?php echo strtoupper($provinces['Design_Prov']); ?></option>
                                              <?php }} ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                            <label for="site" class="control-label col-lg-12" style="text-align: left;">Site ID & Name *</label>
                                            <input type="text" name="site" id="site" class="form-control" value="<?php echo strtoupper(stripslashes($rapports['Site_ID'].' - '.$rapports['Site_Name'])); ?>">
                                            <input type="hidden" name="ID_Site" id="ID_Site" value="<?php echo($rapports['ID_Site']) ?>">
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pm_ref" class="control-label col-lg-12" style="text-align: left;">PM Ref *</label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="pm_ref" type="text" name="pm_ref" value="<?php echo stripslashes($rapports['PM_Ref']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="history_card_ref" class="control-label col-lg-12" style="text-align: left;">History Card Ref</label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="history_card_ref" type="text" name="history_card_ref" value="<?php echo stripslashes($rapports['History_Card_Ref']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="date_rapport" class="control-label col-lg-12" style="text-align: left;">Date *</label>
                                          <div class="col-lg-12">
                                            <input class="form-control date" id="date_rapport" type="text" name="date_rapport" value="<?= date('d/m/Y', strtotime($rapports['Date_Rapport'])); ?>">
                                            <input type="hidden" name="daterap" id="daterap" value="<?= date('Y-m-d', strtotime($rapports['Date_Rapport'])); ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="time_in" class="control-label col-lg-12" style="text-align: left;">Time In *</label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="time_in" type="time" name="time_in" value="<?= date('H:i', strtotime($rapports['Time_In'])); ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="time_out" class="control-label col-lg-12" style="text-align: left;">Time Out *</label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="time_out" type="time" name="time_out" value="<?= date('H:i', strtotime($rapports['Time_Out'])); ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="tower_type" class="control-label col-lg-12" style="text-align: left;">Tower Type *</label>
                                          <div class="col-lg-12">
                                            <select name="tower_type" id="tower_type" class="form-control">
                                                <option value="">--</option>
                                                <?php while($tower_types=$tower_type->fetch()){ ?>
                                                <option value="<?php echo($tower_types['ID_Tower_Type']); ?>" <?php if($tower_types['ID_Tower_Type']==$rapports['ID_Tower_Type']){echo "selected";} ?>><?php echo strtoupper($tower_types['Design_Tower_Type']); ?></option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 10px">
                                        <div class="form-group ">
                                          <label for="tower_ht" class="control-label col-lg-12" style="text-align: left;">Tower Ht *</label>
                                          <div class="col-lg-12">
                                              <div class="input-group">
                                                <input class="form-control " id="tower_ht" type="number" name="tower_ht" min="0" style="border-top-right-radius: 0; border-bottom-right-radius: 0" value="<?php echo($rapports['Tower_Ht']) ?>">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text" style="border-top-left-radius: 0; border-bottom-left-radius: 0; border-left: none; height: 38px">Meters</span>
                                                </div>
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
                                                  <button class="btn btn-primary" type="button" id="btn_next">Suivant</button>
                                                  <button class="btn btn-danger" type="button" id="btn_annuler">Annuler</button>
                                              </div>
                                            </div>
                                        </div>
                          </form>
                      </div>
                      <div class="tab-pane" id="tabs-home-13">
                      <form id="DetailsForm" method="post" action="" enctype="multipart/form-data">
                         <div class="row">
                            <input type="hidden" name="ID_Rapport" id="ID_Rapport" value="<?php echo $rapports['ID_Rapport']; ?>">
                            <input id="token_key" type="hidden" name="token_key" value="<?php echo($_SESSION['user_eteelo_app']['token']); ?>">
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">1. Check verticality of tower</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="test_result1" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result1" type="text" name="test_result1" value="<?php echo stripslashes($details['Test_Results_1']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="ok_nok1" class="control-label col-lg-12" style="text-align: left;">Ok / Nok </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="ok_nok1" name="ok_nok1">
                                                <option value="">--</option>
                                                <?php if($details['Etat_1']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">Nok</option>
                                                <?php }else if($details['Etat_2']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>Nok</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">Nok</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="ncr_if_any1" class="control-label col-lg-12" style="text-align: left;">NCR if any </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="ncr_if_any1" type="text" name="ncr_if_any1" value="<?php echo stripslashes($details['Ncr_If_Any_1']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">2. Check tower for rust</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="test_result2" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result2" type="text" name="test_result2" value="<?php echo stripslashes($details['Test_Results_2']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="ok_nok2" class="control-label col-lg-12" style="text-align: left;">Ok / Nok </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="ok_nok2" name="ok_nok2">
                                                <option value="">--</option>
                                                <?php if($details['Etat_2']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">Nok</option>
                                                <?php }else if($details['Etat_2']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>Nok</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">Nok</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="ncr_if_any2" class="control-label col-lg-12" style="text-align: left;">NCR if any </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="ncr_if_any2" type="text" name="ncr_if_any2" value="<?php echo stripslashes($details['Ncr_If_Any_2']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">3. Check painting on tower</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="test_result3" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result3" type="text" name="test_result3" value="<?php echo stripslashes($details['Test_Results_3']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="ok_nok3" class="control-label col-lg-12" style="text-align: left;">Ok / Nok </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="ok_nok3" name="ok_nok3">
                                                <option value="">--</option>
                                                <?php if($details['Etat_3']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">Nok</option>
                                                <?php }else if($details['Etat_3']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>Nok</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">Nok</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="ncr_if_any3" class="control-label col-lg-12" style="text-align: left;">NCR if any </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="ncr_if_any3" type="text" name="ncr_if_any3" value="<?php echo stripslashes($details['Ncr_If_Any_3']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">4. Are all bolt and nuts intact on tower ?</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="test_result4" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result4" type="text" name="test_result4" value="<?php echo stripslashes($details['Test_Results_4']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="ok_nok4" class="control-label col-lg-12" style="text-align: left;">Ok / Nok </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="ok_nok4" name="ok_nok4">
                                                <option value="">--</option>
                                                <?php if($details['Etat_4']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">Nok</option>
                                                <?php }else if($details['Etat_4']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>Nok</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">Nok</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="ncr_if_any4" class="control-label col-lg-12" style="text-align: left;">NCR if any </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="ncr_if_any4" type="text" name="ncr_if_any4" value="<?php echo stripslashes($details['Ncr_If_Any_4']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">5. Is tower earthed ?</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="test_result5" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result5" type="text" name="test_result5" value="<?php echo stripslashes($details['Test_Results_5']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="ok_nok5" class="control-label col-lg-12" style="text-align: left;">Ok / Nok </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="ok_nok5" name="ok_nok5">
                                                <option value="">--</option>
                                                <?php if($details['Etat_5']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">Nok</option>
                                                <?php }else if($details['Etat_5']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>Nok</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">Nok</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="ncr_if_any5" class="control-label col-lg-12" style="text-align: left;">NCR if any </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="ncr_if_any5" type="text" name="ncr_if_any5" value="<?php echo stripslashes($details['Ncr_If_Any_5']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">6. Is there a lighting spike on the tower ?</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="test_result6" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result6" type="text" name="test_result6" value="<?php echo stripslashes($details['Test_Results_6']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="ok_nok6" class="control-label col-lg-12" style="text-align: left;">Ok / Nok </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="ok_nok6" name="ok_nok6">
                                                <option value="">--</option>
                                                <?php if($details['Etat_6']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">Nok</option>
                                                <?php }else if($details['Etat_6']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>Nok</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">Nok</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="ncr_if_any6" class="control-label col-lg-12" style="text-align: left;">NCR if any </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="ncr_if_any6" type="text" name="ncr_if_any6" value="<?php echo stripslashes($details['Ncr_If_Any_6']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">7. Is lighting spike earthed ?</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="test_result7" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result7" type="text" name="test_result7" value="<?php echo stripslashes($details['Test_Results_7']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="ok_nok7" class="control-label col-lg-12" style="text-align: left;">Ok / Nok </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="ok_nok7" name="ok_nok7">
                                                <option value="">--</option>
                                                <?php if($details['Etat_7']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">Nok</option>
                                                <?php }else if($details['Etat_7']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>Nok</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">Nok</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="ncr_if_any7" class="control-label col-lg-12" style="text-align: left;">NCR if any </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="ncr_if_any7" type="text" name="ncr_if_any7" value="<?php echo stripslashes($details['Ncr_If_Any_7']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">8. Is AWL functioning ?</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="test_result8" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result8" type="text" name="test_result8" value="<?php echo stripslashes($details['Test_Results_8']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="ok_nok8" class="control-label col-lg-12" style="text-align: left;">Ok / Nok </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="ok_nok8" name="ok_nok8">
                                                <option value="">--</option>
                                                <?php if($details['Etat_8']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">Nok</option>
                                                <?php }else if($details['Etat_8']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>Nok</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">Nok</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="ncr_if_any8" class="control-label col-lg-12" style="text-align: left;">NCR if any </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="ncr_if_any8" type="text" name="ncr_if_any8" value="<?php echo stripslashes($details['Ncr_If_Any_8']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">9. Check tower foundation for cracks and other defects</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="test_result9" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result9" type="text" name="test_result9" value="<?php echo stripslashes($details['Test_Results_9']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="ok_nok9" class="control-label col-lg-12" style="text-align: left;">Ok / Nok </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="ok_nok9" name="ok_nok9">
                                                <option value="">--</option>
                                                <?php if($details['Etat_9']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">Nok</option>
                                                <?php }else if($details['Etat_9']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>Nok</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">Nok</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="ncr_if_any9" class="control-label col-lg-12" style="text-align: left;">NCR if any </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="ncr_if_any9" type="text" name="ncr_if_any9" value="<?php echo stripslashes($details['Ncr_If_Any_9']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">10. Check condition/state of Fall Arrest System (FAS)</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="test_result10" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result10" type="text" name="test_result10" value="<?php echo stripslashes($details['Test_Results_10']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="ok_nok10" class="control-label col-lg-12" style="text-align: left;">Ok / Nok </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="ok_nok10" name="ok_nok10">
                                                <option value="">--</option>
                                                <?php if($details['Etat_10']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">Nok</option>
                                                <?php }else if($details['Etat_10']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>Nok</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">Nok</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="ncr_if_any10" class="control-label col-lg-12" style="text-align: left;">NCR if any </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="ncr_if_any10" type="text" name="ncr_if_any10" value="<?php echo stripslashes($details['Ncr_If_Any_10']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-12" style="text-align: center; border-top: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold">11. Comments</span>
                                <div class="row">
                                    <div class="col-12" style="text-align: center; border-top: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                        <textarea name="description" class="form-control" id="description" cols="30" rows="6"><?php echo stripslashes($rapports['Description']) ?></textarea>
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

    listSites=[];
    function recheche_site(){
        $.ajax({
          url:"recherche_site.php",
          type:'post',
          dataType:"json",
          data:{Province:$('#province').val()},
          success:function(donnee){
            listSites.length=0;
              $.map(donnee,function(objet){
                listSites.push({
                      value:objet.Design,
                      desc:objet.ID_Site
                  });
              });
          }
        });
    }


    $('#tower_type').change(function(){
         $('#tower_ht').focus();
    })

    $(document).ready(function(){
        recheche_site();
    })
    $('#btn_next').click(function(){
        if($('#province').val()=='' ||  $('#site').val()=='' || $('#pm_ref').val()=='' || $('#date_rapport').val()=='' || $('#time_in').val()=='' || $('#time_out').val()=='' || $('#tower_type').val()=='' || $('#tower_ht').val()==''){
          alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez remplir tous les champs obligatoires svp!', function(){$('#libelle').focus();});
        }else{
                let daterapport = $('#date_rapport').val();
                daterap = daterapport.replace(/\//g, "-");
                $('#daterap').val(daterap);
                $.ajax({
                    url:'edit_rapport_mensuel.php',
                    type:'post',
                    dataType:'text', 
                    data:{ID_Rapport:$('#ID_Rapport').val(), Province:$('#province').val(), Site:$('#ID_Site').val(), PM_Ref:$('#pm_ref').val(), Daterap:$('#daterap').val(), Time_in:$('#time_in').val(), Time_out:$('#time_out').val(), Tower_type:$('#tower_type').val(), Tower_ht:$('#tower_ht').val(), History_card_ref:$('#history_card_ref').val(), token:$('#token').val()},
                    success:function(ret){
                        // $('#ID_Rapport').val(ret);
                        $('.l1').removeClass('disabled').addClass('Active');
                        $('#a1').tab('show');
                    }
                });
                // $('.l1').removeClass('disabled').addClass('Active');
                // $('#a1').tab('show');
        }
    })
    $('#site').autocomplete({source:function(request,response){
        var resultat=$.ui.autocomplete.filter(listSites,request.term);
        response(resultat.slice(0,15));
        },
        select:function(event,ui){
            $('#ID_Site').val(ui.item.desc);
            $('#pm_ref').focus();
        }
    });


    $('#province').change(function(){
        if($('#province').val()!=''){
            recheche_site();
            $('#site').val('').focus();
        }
    })


    $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    });


    $('#DetailsForm').submit(function(e){
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                    url:'edit_details_rapport.php',
                    type:'post',
                    beforeSend:function(){
                        waitingDialog.show('Veuillez patienter svp!');
                    },
                    dataType:'text',
                    data: formData,
                    processData: false,
                    cache: false,
                    contentType: false,
                    success:function(retour){
                        waitingDialog.hide();
                        if(retour==1){
                            Toast.fire({
                                  icon: 'success',
                                  title: 'Modification éffectuée'
                            })
                            let dateRapport = $('#dateRapport').val();
                            dateRap = dateRapport.replace(/\//g, "-");
                            window.location.replace('table_rapport_mensuel_tour.php?User='+$('#User').val()+'&siteId='+$('#siteId').val()+'&TowerType='+$('#TowerType').val()+'&dateRapport='+dateRap);
                        }else{
                            alertify.alert('<?php echo $app_infos['Design_App']; ?>', retour);
                        }
                    }
                });
          })

  })

    $('#btn_annuler').click(function(){
        let dateRapport = $('#dateRapport').val();
        dateRap = dateRapport.replace(/\//g, "-");
        window.location.replace('table_rapport_mensuel_tour.php?User='+$('#User').val()+'&siteId='+$('#siteId').val()+'&TowerType='+$('#TowerType').val()+'&dateRapport='+dateRap);
    });
    $('#btn_annuler_tout').click(function(){
        let dateRapport = $('#dateRapport').val();
        dateRap = dateRapport.replace(/\//g, "-");
        window.location.replace('table_rapport_mensuel_tour.php?User='+$('#User').val()+'&siteId='+$('#siteId').val()+'&TowerType='+$('#TowerType').val()+'&dateRapport='+dateRap);
    })
    $(function(){
        $(".date").datepicker({closeText:'fermer',prevText:'&#x3c;Préc',nextText:'Suiv&#x3e;',currentText:'Courant',dateFormat:"dd/mm/yy", minDate: "01/01/1990",monthNames:["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aoùt","Septembre","Octobre","Novembre","Décembre"],monthNamesShort:["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"],dayNamesMin:["Dim","Lun","Mar","Mer","Jeu","Ven","Sam"], changeMonth: true, changeYear: true,onSelect: function(value, date) {
            date.dpDiv.find('.ui-datepicker-current-day a')
            .css('background-color', '#FE5000').css({"z-index":99999999999999});}
        });
    });
    </script>
</body>