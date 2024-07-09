<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connection");
    }
    require_once('connexion.php');
    $ID=$_GET["ID"];
    $rapport=$pdo->query("SELECT * FROM table_rapport_janitorial INNER JOIN site ON table_rapport_janitorial.ID_Site=site.ID_Site INNER JOIN province ON site.ID_Prov=province.ID_Prov INNER JOIN type_site ON table_rapport_janitorial.ID_Type=type_site.ID_Type WHERE table_rapport_janitorial.ID_Rapport=".$ID);
    $rapports=$rapport->fetch();

    $province=$pdo->query("SELECT * FROM province INNER JOIN site ON province.ID_Prov=site.ID_Prov ORDER BY Design_Prov");
    $type_site=$pdo->query("SELECT * FROM type_site");
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
    <title>Edit Janitorials, Facilities & Alarms Checklist | <?php echo $app_infos['Design_App']; ?></title>
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
            <input type="hidden" name="SiteType" id="SiteType" value="<?php if(isset($_GET['SiteType']) && $_GET['SiteType']!=''){echo $_GET['SiteType']; } ?>">
            <input type="hidden" name="siteId" id="siteId" value="<?php if(isset($_GET['siteId']) && $_GET['siteId']!=''){echo $_GET['siteId']; } ?>">
            <input type="hidden" name="dateRapport" id="dateRapport" value="<?php if(isset($_GET['dateRapport']) && $_GET['dateRapport']!=''){echo $_GET['dateRapport']; } ?>">
          <!-- <div class="page-header d-print-none">
            <div class="row g-2 align-items-center">

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
                                          <label for="num_work_order" class="control-label col-lg-12" style="text-align: left;">Work Order No *</label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="num_work_order" type="text" name="num_work_order" value="<?php echo stripslashes($rapports['Num_Work_Order']) ?>">
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
                                          <label for="type_site" class="control-label col-lg-12" style="text-align: left;">Type of site *</label>
                                          <div class="col-lg-12">
                                            <select name="type_site" id="type_site" class="form-control">
                                                <option value="">--</option>
                                                <?php while($type_sites=$type_site->fetch()){ ?>
                                                <option value="<?php echo($type_sites['ID_Type']); ?>" <?php if($type_sites['ID_Type']==$rapports['ID_Type']){echo 'selected';} ?>><?php echo strtoupper($type_sites['Design_Type']); ?></option>
                                                <?php } ?>
                                            </select>
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
                                <span style="font-weight: bold; margin-bottom: 10px">1.1 Circle fence type - Palisade, wire mesh, brick wall, no fence</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <?php $detail=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$ID." AND Indice=1");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="test_result_1" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result_1" type="text" name="test_result_1" value="<?php echo stripslashes($details['Test_Results']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pass_fail_1" class="control-label col-lg-12" style="text-align: left;">Pass / Fail </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="pass_fail_1" name="pass_fail_1">
                                                <option value="">--</option>
                                                <?php if($details['Pass']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">N/A</option>
                                                <?php }else if($details['Pass']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>N/A</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">N/A</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_1" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_1" type="text" name="remark_1" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">1.2 Status of gate lock and hinges</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$ID." AND Indice=2");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="test_result_2" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result_2" type="text" name="test_result_2" value="<?php echo stripslashes($details['Test_Results']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pass_fail_2" class="control-label col-lg-12" style="text-align: left;">Pass / Fail </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="pass_fail_2" name="pass_fail_2">
                                                <option value="">--</option>
                                                <?php if($details['Pass']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">N/A</option>
                                                <?php }else if($details['Pass']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>N/A</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">N/A</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_2" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_2" type="text" name="remark_2" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>

                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">1.3 Check and report corrosion on fence</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$ID." AND Indice=3");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="test_result_3" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result_3" type="text" name="test_result_3" value="<?php echo stripslashes($details['Test_Results']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pass_fail_3" class="control-label col-lg-12" style="text-align: left;">Pass / Fail </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="pass_fail_3" name="pass_fail_3">
                                                <option value="">--</option>
                                                <?php if($details['Pass']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">N/A</option>
                                                <?php }else if($details['Pass']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>N/A</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">N/A</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_3" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_3" type="text" name="remark_3" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>

                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">1.4 Check and report any damage on fence</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$ID." AND Indice=4");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="test_result_4" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result_4" type="text" name="test_result_4" value="<?php echo stripslashes($details['Test_Results']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pass_fail_4" class="control-label col-lg-12" style="text-align: left;">Pass / Fail </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="pass_fail_4" name="pass_fail_4">
                                                <option value="">--</option>
                                                <?php if($details['Pass']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">N/A</option>
                                                <?php }else if($details['Pass']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>N/A</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">N/A</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_4" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_4" type="text" name="remark_4" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">1.5 Check razor wire and tensioning in wire</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$ID." AND Indice=5");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="test_result_5" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result_5" type="text" name="test_result_5" value="<?php echo stripslashes($details['Test_Results']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pass_fail_5" class="control-label col-lg-12" style="text-align: left;">Pass / Fail </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="pass_fail_5" name="pass_fail_5">
                                                <option value="">--</option>
                                                <?php if($details['Pass']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">N/A</option>
                                                <?php }else if($details['Pass']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>N/A</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">N/A</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_5" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_5" type="text" name="remark_5" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">2.1 Status of shelter lock</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$ID." AND Indice=6");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="test_result_6" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result_6" type="text" name="test_result_6" value="<?php echo stripslashes($details['Test_Results']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pass_fail_6" class="control-label col-lg-12" style="text-align: left;">Pass / Fail </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="pass_fail_6" name="pass_fail_6">
                                                <option value="">--</option>
                                                <?php if($details['Pass']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">N/A</option>
                                                <?php }else if($details['Pass']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>N/A</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">N/A</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_6" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_6" type="text" name="remark_6" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">2.2 Check for signs of ingress of water</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$ID." AND Indice=7");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="test_result_7" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result_7" type="text" name="test_result_7" value="<?php echo stripslashes($details['Test_Results']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pass_fail_7" class="control-label col-lg-12" style="text-align: left;">Pass / Fail </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="pass_fail_7" name="pass_fail_7">
                                                <option value="">--</option>
                                                <?php if($details['Pass']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">N/A</option>
                                                <?php }else if($details['Pass']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>N/A</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">N/A</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_7" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_7" type="text" name="remark_7" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>


                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">2.3 Does shelter need painting/washing ? </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$ID." AND Indice=8");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="test_result_8" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result_8" type="text" name="test_result_8" value="<?php echo stripslashes($details['Test_Results']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pass_fail_8" class="control-label col-lg-12" style="text-align: left;">Pass / Fail </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="pass_fail_8" name="pass_fail_8">
                                                <option value="">--</option>
                                                <?php if($details['Pass']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">N/A</option>
                                                <?php }else if($details['Pass']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>N/A</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">N/A</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_8" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_8" type="text" name="remark_8" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">2.4 What is the general condition of shelter structure ?</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$ID." AND Indice=9");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="test_result_9" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result_9" type="text" name="test_result_9" value="<?php echo stripslashes($details['Test_Results']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pass_fail_9" class="control-label col-lg-12" style="text-align: left;">Pass / Fail </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="pass_fail_9" name="pass_fail_9">
                                                <option value="">--</option>
                                                <?php if($details['Pass']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">N/A</option>
                                                <?php }else if($details['Pass']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>N/A</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">N/A</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_9" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_9" type="text" name="remark_9" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">2.5 Is interior of shelter clean ?</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$ID." AND Indice=10");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="test_result_10" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result_10" type="text" name="test_result_10" value="<?php echo stripslashes($details['Test_Results']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pass_fail_10" class="control-label col-lg-12" style="text-align: left;">Pass / Fail </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="pass_fail_10" name="pass_fail_10">
                                                <option value="">--</option>
                                                <?php if($details['Pass']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">N/A</option>
                                                <?php }else if($details['Pass']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>N/A</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">N/A</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_10" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_10" type="text" name="remark_10" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">2.6 What is the state of lighting in the shelter ?</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$ID." AND Indice=11");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="test_result_11" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result_11" type="text" name="test_result_11" value="<?php echo stripslashes($details['Test_Results']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pass_fail_11" class="control-label col-lg-12" style="text-align: left;">Pass / Fail </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="pass_fail_11" name="pass_fail_11">
                                                <option value="">--</option>
                                                <?php if($details['Pass']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">N/A</option>
                                                <?php }else if($details['Pass']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>N/A</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">N/A</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_11" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_11" type="text" name="remark_11" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">3.1 Are all signages present and well installed ?</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$ID." AND Indice=12");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="test_result_12" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result_12" type="text" name="test_result_12" value="<?php echo stripslashes($details['Test_Results']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pass_fail_12" class="control-label col-lg-12" style="text-align: left;">Pass / Fail </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="pass_fail_12" name="pass_fail_12">
                                                <option value="">--</option>
                                                <?php if($details['Pass']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">N/A</option>
                                                <?php }else if($details['Pass']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>N/A</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">N/A</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_12" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_12" type="text" name="remark_12" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">3.2 What is the condition of road to the site ?</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$ID." AND Indice=13");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="test_result_13" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result_13" type="text" name="test_result_13" value="<?php echo stripslashes($details['Test_Results']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pass_fail_13" class="control-label col-lg-12" style="text-align: left;">Pass / Fail </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="pass_fail_13" name="pass_fail_13">
                                                <option value="">--</option>
                                                <?php if($details['Pass']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">N/A</option>
                                                <?php }else if($details['Pass']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>N/A</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">N/A</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_13" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_13" type="text" name="remark_13" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">3.3 Is site weedy ?</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$ID." AND Indice=14");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="test_result_14" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result_14" type="text" name="test_result_14" value="<?php echo stripslashes($details['Test_Results']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pass_fail_14" class="control-label col-lg-12" style="text-align: left;">Pass / Fail </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="pass_fail_14" name="pass_fail_14">
                                                <option value="">--</option>
                                                <?php if($details['Pass']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">N/A</option>
                                                <?php }else if($details['Pass']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>N/A</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">N/A</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_14" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_14" type="text" name="remark_14" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">3.4 What is the general condition of security booth ?</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$ID." AND Indice=15");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="test_result_15" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result_15" type="text" name="test_result_15" value="<?php echo stripslashes($details['Test_Results']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pass_fail_15" class="control-label col-lg-12" style="text-align: left;">Pass / Fail </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="pass_fail_15" name="pass_fail_15">
                                                <option value="">--</option>
                                                <?php if($details['Pass']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">N/A</option>
                                                <?php }else if($details['Pass']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>N/A</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">N/A</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_15" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_15" type="text" name="remark_15" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">3.5 Are all security lights functioning ?</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$ID." AND Indice=16");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="test_result_16" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result_16" type="text" name="test_result_16" value="<?php echo stripslashes($details['Test_Results']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pass_fail_16" class="control-label col-lg-12" style="text-align: left;">Pass / Fail </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="pass_fail_16" name="pass_fail_16">
                                                <option value="">--</option>
                                                <?php if($details['Pass']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">N/A</option>
                                                <?php }else if($details['Pass']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>N/A</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">N/A</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_16" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_16" type="text" name="remark_16" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">3.6 Is site clean ?</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$ID." AND Indice=17");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="test_result_17" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result_17" type="text" name="test_result_17" value="<?php echo stripslashes($details['Test_Results']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pass_fail_17" class="control-label col-lg-12" style="text-align: left;">Pass / Fail </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="pass_fail_17" name="pass_fail_17">
                                                <option value="">--</option>
                                                <?php if($details['Pass']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">N/A</option>
                                                <?php }else if($details['Pass']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>N/A</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">N/A</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_17" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_17" type="text" name="remark_17" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">3.7 Are there signs of pest on site ?</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$ID." AND Indice=18");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="test_result_18" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result_18" type="text" name="test_result_18" value="<?php echo stripslashes($details['Test_Results']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pass_fail_18" class="control-label col-lg-12" style="text-align: left;">Pass / Fail </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="pass_fail_18" name="pass_fail_18">
                                                <option value="">--</option>
                                                <?php if($details['Pass']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">N/A</option>
                                                <?php }else if($details['Pass']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>N/A</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">N/A</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_18" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_18" type="text" name="remark_18" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">4.1 Gate alarm </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$ID." AND Indice=19");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="test_result_19" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result_19" type="text" name="test_result_19" value="<?php echo stripslashes($details['Test_Results']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pass_fail_19" class="control-label col-lg-12" style="text-align: left;">Pass / Fail </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="pass_fail_19" name="pass_fail_19">
                                                <option value="">--</option>
                                                <?php if($details['Pass']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">N/A</option>
                                                <?php }else if($details['Pass']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>N/A</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">N/A</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_19" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_19" type="text" name="remark_19" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">4.2 Door alarm </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$ID." AND Indice=20");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="test_result_20" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result_20" type="text" name="test_result_20" value="<?php echo stripslashes($details['Test_Results']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pass_fail_20" class="control-label col-lg-12" style="text-align: left;">Pass / Fail </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="pass_fail_20" name="pass_fail_20">
                                                <option value="">--</option>
                                                <?php if($details['Pass']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">N/A</option>
                                                <?php }else if($details['Pass']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>N/A</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">N/A</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_20" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_20" type="text" name="remark_20" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">4.3 Motion alarm </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$ID." AND Indice=21");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="test_result_21" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result_21" type="text" name="test_result_21" value="<?php echo stripslashes($details['Test_Results']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pass_fail_21" class="control-label col-lg-12" style="text-align: left;">Pass / Fail </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="pass_fail_21" name="pass_fail_21">
                                                <option value="">--</option>
                                                <?php if($details['Pass']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">N/A</option>
                                                <?php }else if($details['Pass']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>N/A</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">N/A</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_21" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_21" type="text" name="remark_21" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">4.4 Mains failure alarm </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$ID." AND Indice=22");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="test_result_22" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result_22" type="text" name="test_result_22" value="<?php echo stripslashes($details['Test_Results']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pass_fail_22" class="control-label col-lg-12" style="text-align: left;">Pass / Fail </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="pass_fail_22" name="pass_fail_22">
                                                <option value="">--</option>
                                                <?php if($details['Pass']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">N/A</option>
                                                <?php }else if($details['Pass']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>N/A</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">N/A</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_22" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_22" type="text" name="remark_22" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">4.5 Generator failure alarm </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$ID." AND Indice=23");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="test_result_23" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result_23" type="text" name="test_result_23" value="<?php echo stripslashes($details['Test_Results']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pass_fail_23" class="control-label col-lg-12" style="text-align: left;">Pass / Fail </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="pass_fail_23" name="pass_fail_23">
                                                <option value="">--</option>
                                                <?php if($details['Pass']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">N/A</option>
                                                <?php }else if($details['Pass']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>N/A</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">N/A</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_23" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_23" type="text" name="remark_23" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">4.6 Rectifier failure alarm </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$ID." AND Indice=24");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="test_result_24" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result_24" type="text" name="test_result_24" value="<?php echo stripslashes($details['Test_Results']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pass_fail_24" class="control-label col-lg-12" style="text-align: left;">Pass / Fail </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="pass_fail_24" name="pass_fail_24">
                                                <option value="">--</option>
                                                <?php if($details['Pass']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">N/A</option>
                                                <?php }else if($details['Pass']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>N/A</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">N/A</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_24" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_24" type="text" name="remark_24" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">4.7 Deep battery discharge alarm </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$ID." AND Indice=25");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="test_result_25" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result_25" type="text" name="test_result_25" value="<?php echo stripslashes($details['Test_Results']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pass_fail_25" class="control-label col-lg-12" style="text-align: left;">Pass / Fail </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="pass_fail_25" name="pass_fail_25">
                                                <option value="">--</option>
                                                <?php if($details['Pass']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">N/A</option>
                                                <?php }else if($details['Pass']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>N/A</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">N/A</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_25" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_25" type="text" name="remark_25" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">4.8 Smoke alarm </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$ID." AND Indice=26");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="test_result_26" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result_26" type="text" name="test_result_26" value="<?php echo stripslashes($details['Test_Results']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pass_fail_26" class="control-label col-lg-12" style="text-align: left;">Pass / Fail </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="pass_fail_26" name="pass_fail_26">
                                                <option value="">--</option>
                                                <?php if($details['Pass']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">N/A</option>
                                                <?php }else if($details['Pass']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>N/A</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">N/A</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_26" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_26" type="text" name="remark_26" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">4.9 Low fuel level alarm </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$ID." AND Indice=27");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="test_result_27" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result_27" type="text" name="test_result_27" value="<?php echo stripslashes($details['Test_Results']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pass_fail_27" class="control-label col-lg-12" style="text-align: left;">Pass / Fail </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="pass_fail_27" name="pass_fail_27">
                                                <option value="">--</option>
                                                <?php if($details['Pass']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">N/A</option>
                                                <?php }else if($details['Pass']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>N/A</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">N/A</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_27" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_27" type="text" name="remark_27" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">4.10 Room temperature alarm </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$ID." AND Indice=28");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="test_result_28" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result_28" type="text" name="test_result_28" value="<?php echo stripslashes($details['Test_Results']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pass_fail_28" class="control-label col-lg-12" style="text-align: left;">Pass / Fail </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="pass_fail_28" name="pass_fail_28">
                                                <option value="">--</option>
                                                <?php if($details['Pass']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">N/A</option>
                                                <?php }else if($details['Pass']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>N/A</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">N/A</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_28" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_28" type="text" name="remark_28" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">4.11 Air condition 1 failure alarm </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$ID." AND Indice=29");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="test_result_29" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result_29" type="text" name="test_result_29" value="<?php echo stripslashes($details['Test_Results']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pass_fail_29" class="control-label col-lg-12" style="text-align: left;">Pass / Fail </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="pass_fail_29" name="pass_fail_29">
                                                <option value="">--</option>
                                                <?php if($details['Pass']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">N/A</option>
                                                <?php }else if($details['Pass']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>N/A</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">N/A</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_29" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_29" type="text" name="remark_29" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: center; border: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold; margin-bottom: 10px">4.12 Air condition 2 failure alarm </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$ID." AND Indice=30");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="test_result_30" class="control-label col-lg-12" style="text-align: left;">Test Results </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="test_result_30" type="text" name="test_result_30" value="<?php echo stripslashes($details['Test_Results']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="pass_fail_30" class="control-label col-lg-12" style="text-align: left;">Pass / Fail </label>
                                          <div class="col-lg-12">
                                            <select class="form-control" id="pass_fail_30" name="pass_fail_30">
                                                <option value="">--</option>
                                                <?php if($details['Pass']==1){ ?>
                                                <option value="1" selected>Ok</option>
                                                <option value="2">N/A</option>
                                                <?php }else if($details['Pass']==2){ ?>
                                                <option value="1">Ok</option>
                                                <option value="2" selected>N/A</option>
                                                <?php }else{ ?>
                                                <option value="1">Ok</option>
                                                <option value="2">N/A</option>
                                                <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_30" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_30" type="text" name="remark_30" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-12" style="text-align: center; border-top: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold">5. Comments</span>
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


    $('#type_site').change(function(){
         $('#btn_next').focus();
    })

    $(document).ready(function(){
        recheche_site();
    })
    $('#btn_next').click(function(){
        if($('#province').val()=='' ||  $('#site').val()=='' || $('#num_work_order').val()=='' || $('#date_rapport').val()=='' || $('#time_in').val()=='' || $('#time_out').val()=='' || $('#type_site').val()==''){
          alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez remplir tous les champs obligatoires svp!', function(){$('#libelle').focus();});
        }else{
                let daterapport = $('#date_rapport').val();
                daterap = daterapport.replace(/\//g, "-");
                $('#daterap').val(daterap);
                $.ajax({
                    url:'edit_rapport_janitorial.php',
                    type:'post',
                    dataType:'text', 
                    data:{ID_Rapport:$('#ID_Rapport').val(), Province:$('#province').val(), Site:$('#ID_Site').val(), Num_Work:$('#num_work_order').val(), Daterap:$('#daterap').val(), Time_in:$('#time_in').val(), Time_out:$('#time_out').val(), Site_Type:$('#type_site').val(), token:$('#token').val()},
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
            $('#num_work_order').focus();
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
                    url:'edit_details_rapport_janitorial.php',
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
                                  title: 'Enregistré'
                            })
                            let dateRapport = $('#dateRapport').val();
                            dateRap = dateRapport.replace(/\//g, "-");
                            window.location.replace('table_janitorial.php?User='+$('#User').val()+'&siteId='+$('#siteId').val()+'&SiteType='+$('#SiteType').val()+'&dateRapport='+dateRap);
                        }else{
                            alertify.alert('<?php echo $app_infos['Design_App']; ?>', retour);
                        }
                    }
                });
          })

  })

    $('#retour_table').click(function(e){
        e.preventDefault();
        let dateRapport = $('#dateRapport').val();
        dateRap = dateRapport.replace(/\//g, "-");
        window.location.replace('table_janitorial.php?User='+$('#User').val()+'&siteId='+$('#siteId').val()+'&SiteType='+$('#SiteType').val()+'&dateRapport='+dateRap);
    })
    $('#btn_annuler').click(function(){
        let dateRapport = $('#dateRapport').val();
        dateRap = dateRapport.replace(/\//g, "-");
        window.location.replace('table_janitorial.php?User='+$('#User').val()+'&siteId='+$('#siteId').val()+'&SiteType='+$('#SiteType').val()+'&dateRapport='+dateRap);
    });
    $('#btn_annuler_tout').click(function(){
        let dateRapport = $('#dateRapport').val();
        dateRap = dateRapport.replace(/\//g, "-");
        window.location.replace('table_janitorial.php?User='+$('#User').val()+'&siteId='+$('#siteId').val()+'&SiteType='+$('#SiteType').val()+'&dateRapport='+dateRap);
    })
    $(function(){
        $(".date").datepicker({closeText:'fermer',prevText:'&#x3c;Préc',nextText:'Suiv&#x3e;',currentText:'Courant',dateFormat:"dd/mm/yy", minDate: "01/01/1990",monthNames:["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aoùt","Septembre","Octobre","Novembre","Décembre"],monthNamesShort:["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"],dayNamesMin:["Dim","Lun","Mar","Mer","Jeu","Ven","Sam"], changeMonth: true, changeYear: true,onSelect: function(value, date) {
            date.dpDiv.find('.ui-datepicker-current-day a')
            .css('background-color', '#FE5000').css({"z-index":99999999999999});}
        });
    });
    </script>
</body>