<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connection");
    }
    require_once('connexion.php');
    $ID=$_GET["ID"];
    $rapport=$pdo->query("SELECT * FROM table_rapport_mensuel_site INNER JOIN site ON table_rapport_mensuel_site.ID_Site=site.ID_Site INNER JOIN province ON site.ID_Prov=province.ID_Prov WHERE table_rapport_mensuel_site.ID_Rapport=".$ID);
    $rapports=$rapport->fetch();
    $country=$pdo->query("SELECT * FROM pays ORDER BY Design_Pays");
    $client=$pdo->query("SELECT * FROM client ORDER BY Design_Client");
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
    <title>Edit Monthly Site Inspection | <?php echo $app_infos['Design_App']; ?></title>
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
            <input type="hidden" name="numRef" id="numRef" value="<?php if(isset($_GET['numRef']) && $_GET['numRef']!=''){echo $_GET['numRef']; } ?>">
            <input type="hidden" name="siteId" id="siteId" value="<?php if(isset($_GET['siteId']) && $_GET['siteId']!=''){echo $_GET['siteId']; } ?>">
            <input type="hidden" name="dateRapport" id="dateRapport" value="<?php if(isset($_GET['dateRapport']) && $_GET['dateRapport']!=''){echo $_GET['dateRapport']; } ?>">
          <!-- <div class="page-header d-print-none">
            <div class="row g-2 align-items-center">
              <div class="col">
                Page pre-title
                <div class="page-pretitle">
                  
                </div>
                <h2 class="page-title">
                New Monthly Site Inspection
                </h2>
              </div>
              Page title actions
              <div class="col-12 col-md-auto ms-auto d-print-none">
                <div class="btn-list">
                  <a href="#" id="retour_table" class="btn btn-primary d-sm-inline-block" title="Retour">
                    Download SVG icon from http://tabler-icons.io/i/plus
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-reply" viewBox="0 0 16 16">
                      <path d="M6.598 5.013a.144.144 0 0 1 .202.134V6.3a.5.5 0 0 0 .5.5c.667 0 2.013.005 3.3.822.984.624 1.99 1.76 2.595 3.876-1.02-.983-2.185-1.516-3.205-1.799a8.74 8.74 0 0 0-1.921-.306 7.404 7.404 0 0 0-.798.008h-.013l-.005.001h-.001L7.3 9.9l-.05-.498a.5.5 0 0 0-.45.498v1.153c0 .108-.11.176-.202.134L2.614 8.254a.503.503 0 0 0-.042-.028.147.147 0 0 1 0-.252.499.499 0 0 0 .042-.028l3.984-2.933zM7.8 10.386c.068 0 .143.003.223.006.434.02 1.034.086 1.7.271 1.326.368 2.896 1.202 3.94 3.08a.5.5 0 0 0 .933-.305c-.464-3.71-1.886-5.662-3.46-6.66-1.245-.79-2.527-.942-3.336-.971v-.66a1.144 1.144 0 0 0-1.767-.96l-3.994 2.94a1.147 1.147 0 0 0 0 1.946l3.994 2.94a1.144 1.144 0 0 0 1.767-.96v-.667z"/>
                    </svg>
                    Retour
                  </a>
                  <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Create new report">
                    Download SVG icon from http://tabler-icons.io/i/plus
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                  </a>
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
                                    <div class="col-md-3" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                          <label for="province" class="control-label col-lg-12" style="text-align: left;">Province *</label>
                                          <div class="col-lg-12">
                                            <input id="token" type="hidden" name="token" value="<?php echo($_SESSION['user_eteelo_app']['token']); ?>">
                                            <?php if($_SESSION['user_eteelo_app']['Statut']!='Admin'){ 
                                              $province=$pdo->query("SELECT * FROM province INNER JOIN site ON province.ID_Prov=site.ID_Prov WHERE province.ID_Pays=".$_SESSION['user_eteelo_app']['ID_Pays']." ORDER BY Design_Prov");
                                              ?>
                                            <select name="province" class="form-control" id="province">
                                                <option value="">--</option>
                                                <?php while($provinces=$province->fetch()){ 
                                                    if($prov!=$provinces['ID_Prov']){ 
                                                        $prov=$provinces['ID_Prov'];
                                                  ?>
                                                <option value="<?php echo($provinces['ID_Prov']) ?>" <?php if($provinces['ID_Prov']==$rapports['ID_Prov']){echo "selected";} ?>><?php echo(stripslashes(strtoupper($provinces['Design_Prov']))); ?></option>
                                                <?php }} ?>
                                            </select>
                                            <?php }else{ ?>
                                            <select name="province" class="form-control" id="province">
                                                <option value="">--</option>
                                                <?php while($countries=$country->fetch()){ 
                                                  $province=$pdo->query("SELECT * FROM province INNER JOIN site ON province.ID_Prov=site.ID_Prov WHERE province.ID_Pays=".$countries['ID_Pays']." ORDER BY Design_Prov");
                                                  $Nombre=$province->rowCount();
                                                  if($Nombre!=0){
                                                ?>
                                                <optgroup label="<?php echo(stripslashes($countries['Design_Pays'])); ?>">
                                                <?php }
                                                  while($provinces=$province->fetch()){ 
                                                    if($prov!=$provinces['ID_Prov']){ 
                                                        $prov=$provinces['ID_Prov'];
                                                  ?>
                                                <option value="<?php echo($provinces['ID_Prov']) ?>" <?php if($provinces['ID_Prov']==$rapports['ID_Prov']){echo "selected";} ?>><?php echo(stripslashes(strtoupper($provinces['Design_Prov']))); ?></option>
                                                <?php }} 
                                                if($Nombre!=0){
                                                ?>
                                                </optgroup>
                                                <?php }} ?>
                                            </select>
                                            <?php } ?>

                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-3" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                          <label for="client" class="control-label col-lg-12" style="text-align: left;">Client *</label>
                                          <div class="col-lg-12">
                                            <div class="row">
                                              <div class="col-sm-12">
                                                  <select name="client" class="form-control" id="client">
                                                      <option value="">--</option>
                                                      <?php while($clients=$client->fetch()){ ?>
                                                      <option value="<?php echo($clients['ID_Cient']) ?>" <?php if($clients['ID_Cient']==$rapports['ID_Cient']){echo "selected";} ?>><?php echo(stripslashes(strtoupper($clients['Design_Client']))); ?></option>
                                                      <?php } ?>
                                                  </select>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-3" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                            <label for="site" class="control-label col-lg-12" style="text-align: left;">Site ID & Name *</label>
                                            <input type="text" name="site" id="site" class="form-control" value="<?php echo strtoupper(stripslashes($rapports['Site_ID'].' - '.$rapports['Site_Name'])); ?>">
                                            <input type="hidden" name="ID_Site" id="ID_Site" value="<?php echo($rapports['ID_Site']) ?>">
                                        </div>
                                      </div>
                                      <div class="col-md-3" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="num_ref" class="control-label col-lg-12" style="text-align: left;">Ref. No *</label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="num_ref" type="text" name="num_ref" value="<?php echo stripslashes($rapports['Num_Ref']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-3" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="date_rapport" class="control-label col-lg-12" style="text-align: left;">Date *</label>
                                          <div class="col-lg-12">
                                            <input class="form-control date" id="date_rapport" type="text" name="date_rapport" value="<?= date('d/m/Y', strtotime($rapports['Date_Rapport'])); ?>">
                                            <input type="hidden" name="daterap" id="daterap" value="<?= date('Y-m-d', strtotime($rapports['Date_Rapport'])); ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-3" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="time_in" class="control-label col-lg-12" style="text-align: left;">Time In *</label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="time_in" type="time" name="time_in" value="<?= date('H:i', strtotime($rapports['Time_In'])); ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-3" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="time_out" class="control-label col-lg-12" style="text-align: left;">Time Out *</label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="time_out" type="time" name="time_out" value="<?= date('H:i', strtotime($rapports['Time_Out'])); ?>">
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
                                <span style="font-weight: bold; margin-bottom: 10px">1.1 Measure Mains input Phase Voltages – (L1N; L2N; L3N)</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-6" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rapport_site WHERE ID_Rapport=".$ID." AND Indice=1");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="measured_value_1" class="control-label col-lg-12" style="text-align: left;">Measured Value </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="measured_value_1" type="text" name="measured_value_1" value="<?php echo stripslashes($details['Measured_Value']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6" style="margin-bottom: 5px">
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
                                <span style="font-weight: bold; margin-bottom: 10px">1.2 Measure Mains input Line Voltages – (L1L2; L2L3; L3L1)</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-6" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rapport_site WHERE ID_Rapport=".$ID." AND Indice=2");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="measured_value_2" class="control-label col-lg-12" style="text-align: left;">Measured Value </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="measured_value_2" type="text" name="measured_value_2" value="<?php echo stripslashes($details['Measured_Value']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6" style="margin-bottom: 5px">
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
                                <span style="font-weight: bold; margin-bottom: 10px">1.3 Measure N – E Reading</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-6" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rapport_site WHERE ID_Rapport=".$ID." AND Indice=3");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="measured_value_3" class="control-label col-lg-12" style="text-align: left;">Measured Value </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="measured_value_3" type="text" name="measured_value_3" value="<?php echo stripslashes($details['Measured_Value']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6" style="margin-bottom: 5px">
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
                                <span style="font-weight: bold; margin-bottom: 10px">1.4 Record load(current) Readings – IL1 (A); IL2 (A); IL3 (A)</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-6" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rapport_site WHERE ID_Rapport=".$ID." AND Indice=4");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="measured_value_4" class="control-label col-lg-12" style="text-align: left;">Measured Value </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="measured_value_4" type="text" name="measured_value_4" value="<?php echo stripslashes($details['Measured_Value']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6" style="margin-bottom: 5px">
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
                                <span style="font-weight: bold; margin-bottom: 10px">1.5 Check and tighten all cable terminations in Power Cabinet, ATS and ACPDB to ensure there are no loose contacts</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-6" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rapport_site WHERE ID_Rapport=".$ID." AND Indice=5");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="measured_value_5" class="control-label col-lg-12" style="text-align: left;">Measured Value </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="measured_value_5" type="text" name="measured_value_5" value="<?php echo stripslashes($details['Measured_Value']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6" style="margin-bottom: 5px">
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
                                <span style="font-weight: bold; margin-bottom: 10px">1.6 Inspect Cut-Out Fuses, Breakers and all cables for Overheating and signs of burning</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-6" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rapport_site WHERE ID_Rapport=".$ID." AND Indice=6");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="measured_value_6" class="control-label col-lg-12" style="text-align: left;">Measured Value </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="measured_value_6" type="text" name="measured_value_6" value="<?php echo stripslashes($details['Measured_Value']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6" style="margin-bottom: 5px">
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
                                <span style="font-weight: bold; margin-bottom: 10px">2.1 Observe if Gen/Set is working satisfactorily and can transfer load in Auto Mode</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-6" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rapport_site WHERE ID_Rapport=".$ID." AND Indice=7");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="measured_value_7" class="control-label col-lg-12" style="text-align: left;">Measured Value </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="measured_value_7" type="text" name="measured_value_7" value="<?php echo stripslashes($details['Measured_Value']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6" style="margin-bottom: 5px">
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
                                <span style="font-weight: bold; margin-bottom: 10px">2.2 Check for Oil and Fuel leakages and stop them </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-6" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rapport_site WHERE ID_Rapport=".$ID." AND Indice=8");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="measured_value_8" class="control-label col-lg-12" style="text-align: left;">Measured Value </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="measured_value_8" type="text" name="measured_value_8" value="<?php echo stripslashes($details['Measured_Value']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6" style="margin-bottom: 5px">
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
                                <span style="font-weight: bold; margin-bottom: 10px">2.3 Check if Water, Oil and Fuel are at acceptable levels and top-up if they are low</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-6" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rapport_site WHERE ID_Rapport=".$ID." AND Indice=9");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="measured_value_9" class="control-label col-lg-12" style="text-align: left;">Measured Value </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="measured_value_9" type="text" name="measured_value_9" value="<?php echo stripslashes($details['Measured_Value']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6" style="margin-bottom: 5px">
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
                                <span style="font-weight: bold; margin-bottom: 10px">2.4 Inspect  Deep Sea Control, Trickle Charger, DC Alternator, Starter Battery, Fan Belt, Starter Motor, Fuel Solenoid etc.</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-6" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rapport_site WHERE ID_Rapport=".$ID." AND Indice=10");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="measured_value_10" class="control-label col-lg-12" style="text-align: left;">Measured Value </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="measured_value_10" type="text" name="measured_value_10" value="<?php echo stripslashes($details['Measured_Value']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6" style="margin-bottom: 5px">
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
                                <span style="font-weight: bold; margin-bottom: 10px">3.1 Record Rectifier voltage</span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-6" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rapport_site WHERE ID_Rapport=".$ID." AND Indice=11");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="measured_value_11" class="control-label col-lg-12" style="text-align: left;">Measured Value </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="measured_value_11" type="text" name="measured_value_11" value="<?php echo stripslashes($details['Measured_Value']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6" style="margin-bottom: 5px">
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
                                <span style="font-weight: bold; margin-bottom: 10px">3.2 Record Battery voltages for Bank 1/2 </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-6" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rapport_site WHERE ID_Rapport=".$ID." AND Indice=12");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="measured_value_12" class="control-label col-lg-12" style="text-align: left;">Measured Value </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="measured_value_12" type="text" name="measured_value_12" value="<?php echo stripslashes($details['Measured_Value']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6" style="margin-bottom: 5px">
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
                                <span style="font-weight: bold; margin-bottom: 10px">3.3 Record  individual Battery cell voltages ( in the comment section ) </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-6" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rapport_site WHERE ID_Rapport=".$ID." AND Indice=13");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="measured_value_13" class="control-label col-lg-12" style="text-align: left;">Measured Value </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="measured_value_13" type="text" name="measured_value_13" value="<?php echo stripslashes($details['Measured_Value']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6" style="margin-bottom: 5px">
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
                                <span style="font-weight: bold; margin-bottom: 10px">3.4 Record the DC Load </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-6" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rapport_site WHERE ID_Rapport=".$ID." AND Indice=14");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="measured_value_14" class="control-label col-lg-12" style="text-align: left;">Measured Value </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="measured_value_14" type="text" name="measured_value_14" value="<?php echo stripslashes($details['Measured_Value']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6" style="margin-bottom: 5px">
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
                                <span style="font-weight: bold; margin-bottom: 10px">4.1 Check if PIU is functioning satisfactorily  </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-6" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rapport_site WHERE ID_Rapport=".$ID." AND Indice=15");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="measured_value_15" class="control-label col-lg-12" style="text-align: left;">Measured Value </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="measured_value_15" type="text" name="measured_value_15" value="<?php echo stripslashes($details['Measured_Value']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6" style="margin-bottom: 5px">
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
                                <span style="font-weight: bold; margin-bottom: 10px">4.2 Check for alarms on PIU and rectify any fault </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-6" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rapport_site WHERE ID_Rapport=".$ID." AND Indice=16");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="measured_value_16" class="control-label col-lg-12" style="text-align: left;">Measured Value </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="measured_value_16" type="text" name="measured_value_16" value="<?php echo stripslashes($details['Measured_Value']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6" style="margin-bottom: 5px">
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
                                <span style="font-weight: bold; margin-bottom: 10px">4.3 Check if the normal Air-conditions are working </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-6" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rapport_site WHERE ID_Rapport=".$ID." AND Indice=17");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="measured_value_17" class="control-label col-lg-12" style="text-align: left;">Measured Value </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="measured_value_17" type="text" name="measured_value_17" value="<?php echo stripslashes($details['Measured_Value']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6" style="margin-bottom: 5px">
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
                                <span style="font-weight: bold; margin-bottom: 10px">4.4 Check if the  DC Air-conditioners are working </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-6" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rapport_site WHERE ID_Rapport=".$ID." AND Indice=18");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="measured_value_18" class="control-label col-lg-12" style="text-align: left;">Measured Value </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="measured_value_18" type="text" name="measured_value_18" value="<?php echo stripslashes($details['Measured_Value']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6" style="margin-bottom: 5px">
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
                                <span style="font-weight: bold; margin-bottom: 10px">4.5 Immediately re-fix all minor faults on the Air – Conditioners  </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-6" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rapport_site WHERE ID_Rapport=".$ID." AND Indice=19");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="measured_value_19" class="control-label col-lg-12" style="text-align: left;">Measured Value </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="measured_value_19" type="text" name="measured_value_19" value="<?php echo stripslashes($details['Measured_Value']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6" style="margin-bottom: 5px">
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
                                <span style="font-weight: bold; margin-bottom: 10px">5.1 Check if GTT-3 is functioning </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-6" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rapport_site WHERE ID_Rapport=".$ID." AND Indice=20");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="measured_value_20" class="control-label col-lg-12" style="text-align: left;">Measured Value </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="measured_value_20" type="text" name="measured_value_20" value="<?php echo stripslashes($details['Measured_Value']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6" style="margin-bottom: 5px">
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
                                <span style="font-weight: bold; margin-bottom: 10px">5.2 Check if Master Meter and Tariff Meters are functioning </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-6" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rapport_site WHERE ID_Rapport=".$ID." AND Indice=21");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="measured_value_21" class="control-label col-lg-12" style="text-align: left;">Measured Value </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="measured_value_21" type="text" name="measured_value_21" value="<?php echo stripslashes($details['Measured_Value']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6" style="margin-bottom: 5px">
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
                                <span style="font-weight: bold; margin-bottom: 10px">5.3 Check if PSU is functioning </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-6" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rapport_site WHERE ID_Rapport=".$ID." AND Indice=22");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="measured_value_22" class="control-label col-lg-12" style="text-align: left;">Measured Value </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="measured_value_22" type="text" name="measured_value_22" value="<?php echo stripslashes($details['Measured_Value']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6" style="margin-bottom: 5px">
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
                                <span style="font-weight: bold; margin-bottom: 10px">5.4 Re-fix any minor fault on Telemisis </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-6" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rapport_site WHERE ID_Rapport=".$ID." AND Indice=23");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="measured_value_23" class="control-label col-lg-12" style="text-align: left;">Measured Value </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="measured_value_23" type="text" name="measured_value_23" value="<?php echo stripslashes($details['Measured_Value']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6" style="margin-bottom: 5px">
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
                                <span style="font-weight: bold; margin-bottom: 10px">6.1 Check for shelter leakages </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-6" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rapport_site WHERE ID_Rapport=".$ID." AND Indice=24");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="measured_value_24" class="control-label col-lg-12" style="text-align: left;">Measured Value </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="measured_value_24" type="text" name="measured_value_24" value="<?php echo stripslashes($details['Measured_Value']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6" style="margin-bottom: 5px">
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
                                <span style="font-weight: bold; margin-bottom: 10px">6.2 Check for Shelter Floor breakages or weakness </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-6" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rapport_site WHERE ID_Rapport=".$ID." AND Indice=25");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="measured_value_25" class="control-label col-lg-12" style="text-align: left;">Measured Value </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="measured_value_25" type="text" name="measured_value_25" value="<?php echo stripslashes($details['Measured_Value']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6" style="margin-bottom: 5px">
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
                                <span style="font-weight: bold; margin-bottom: 10px">6.3 Check and seal all holes in the feeder entry  </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-6" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rapport_site WHERE ID_Rapport=".$ID." AND Indice=26");
                                                $details=$detail->fetch();
                                          ?>
                                          <label for="measured_value_26" class="control-label col-lg-12" style="text-align: left;">Measured Value </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="measured_value_26" type="text" name="measured_value_26" value="<?php echo stripslashes($details['Measured_Value']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="remark_26" class="control-label col-lg-12" style="text-align: left;">Remarks </label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="remark_26" type="text" name="remark_26" value="<?php echo stripslashes($details['Remarks']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-12" style="text-align: center; border-top: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold">7. Comments</span>
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
          data:{Province:$('#province').val(), Client:$('#client').val()},
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

    $(document).ready(function(){
        recheche_site();
    })
    $('#btn_next').click(function(){
        if($('#province').val()=='' ||  $('#site').val()=='' || $('#num_ref').val()=='' || $('#date_rapport').val()=='' || $('#time_in').val()=='' || $('#time_out').val()==''){
          alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez remplir tous les champs obligatoires svp!', function(){$('#libelle').focus();});
        }else{
                let daterapport = $('#date_rapport').val();
                daterap = daterapport.replace(/\//g, "-");
                $('#daterap').val(daterap);
                $.ajax({
                    url:'edit_rapport_site.php',
                    type:'post',
                    dataType:'text', 
                    data:{Province:$('#province').val(), Site:$('#ID_Site').val(), Num_Ref:$('#num_ref').val(), Daterap:$('#daterap').val(), Time_in:$('#time_in').val(), Time_out:$('#time_out').val(), token:$('#token').val(), ID_Rapport:$('#ID_Rapport').val()},
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
            $('#num_ref').focus();
        }
    });


    $('#province').change(function(){
        if($('#province').val()!=''){
            $('#client').val('').focus();
        }
    })
    $('#client').change(function(){
        if($('#client').val()!=''){
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
                    url:'edit_details_rapport_site.php',
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
                            window.location.replace('table_rapport_mensuel_site.php?User='+$('#User').val()+'&siteId='+$('#siteId').val()+'&numRef='+$('#numRef').val()+'&dateRapport='+dateRap);
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
        window.location.replace('table_rapport_mensuel_site.php?User='+$('#User').val()+'&siteId='+$('#siteId').val()+'&numRef='+$('#numRef').val()+'&dateRapport='+dateRap);
    })
    $('#btn_annuler').click(function(){
        let dateRapport = $('#dateRapport').val();
        dateRap = dateRapport.replace(/\//g, "-");
        window.location.replace('table_rapport_mensuel_site.php?User='+$('#User').val()+'&siteId='+$('#siteId').val()+'&numRef='+$('#numRef').val()+'&dateRapport='+dateRap);
    });
    $('#btn_annuler_tout').click(function(){
        let dateRapport = $('#dateRapport').val();
        dateRap = dateRapport.replace(/\//g, "-");
        window.location.replace('table_rapport_mensuel_site.php?User='+$('#User').val()+'&siteId='+$('#siteId').val()+'&numRef='+$('#numRef').val()+'&dateRapport='+dateRap);
    })
    $(function(){
        $(".date").datepicker({closeText:'fermer',prevText:'&#x3c;Préc',nextText:'Suiv&#x3e;',currentText:'Courant',dateFormat:"dd/mm/yy", minDate: "01/01/1990",monthNames:["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aoùt","Septembre","Octobre","Novembre","Décembre"],monthNamesShort:["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"],dayNamesMin:["Dim","Lun","Mar","Mer","Jeu","Ven","Sam"], changeMonth: true, changeYear: true,onSelect: function(value, date) {
            date.dpDiv.find('.ui-datepicker-current-day a')
            .css('background-color', '#FE5000').css({"z-index":99999999999999});}
        });
    });
    </script>
</body>