<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connection");
    }
    require_once('connexion.php');
    $ID=$_GET["ID"];
    $rapport=$pdo->query("SELECT * FROM table_rapport_rectifier INNER JOIN site ON table_rapport_rectifier.ID_Site=site.ID_Site INNER JOIN province ON site.ID_Prov=province.ID_Prov WHERE table_rapport_rectifier.ID_Rapport=".$ID);
    $rapports=$rapport->fetch();
    $country=$pdo->query("SELECT * FROM pays ORDER BY Design_Pays");
    $client=$pdo->query("SELECT * FROM client ORDER BY Design_Client");
    $rectifier_make=$pdo->query("SELECT * FROM table_rectifier_make");
    $rectifier_model=$pdo->query("SELECT * FROM table_rectifier_model");
    $batterie_make=$pdo->query("SELECT * FROM table_make_batterie");
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
    <title>New Rectifier & Storage Battery Maintenance | <?php echo $app_infos['Design_App']; ?></title>
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
            <input type="hidden" name="RectifierMake" id="RectifierMake" value="<?php if(isset($_GET['RectifierMake']) && $_GET['RectifierMake']!=''){echo $_GET['RectifierMake']; } ?>">
            <input type="hidden" name="siteId" id="siteId" value="<?php if(isset($_GET['siteId']) && $_GET['siteId']!=''){echo $_GET['siteId']; } ?>">
            <input type="hidden" name="dateRapport" id="dateRapport" value="<?php if(isset($_GET['dateRapport']) && $_GET['dateRapport']!=''){echo $_GET['dateRapport']; } ?>">
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
                                    <div class="col-md-2" style="margin-bottom: 5px;">
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
                                      <div class="col-md-2" style="margin-bottom: 5px;">
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
                                      <div class="col-md-2" style="margin-bottom: 5px;">
                                        <div class="form-group ">
                                            <label for="site" class="control-label col-lg-12" style="text-align: left;">Site ID & Name *</label>
                                            <input type="text" name="site" id="site" class="form-control" value="<?php echo strtoupper(stripslashes($rapports['Site_ID'].' - '.$rapports['Site_Name'])); ?>">
                                            <input type="hidden" name="ID_Site" id="ID_Site" value="<?php echo($rapports['ID_Site']) ?>">
                                        </div>
                                      </div>
                                      <div class="col-md-2" style="margin-bottom: 10px">
                                        <div class="form-group ">
                                          <label for="rectifier_make" class="control-label col-lg-12" style="text-align: left;">Rectifier make *</label>
                                          <div class="col-lg-12">
                                            <?php if($_SESSION['user_eteelo_app']['Statut']=='Admin' || $_SESSION['user_eteelo_app']['Statut']=='User_IT'){ ?>
                                            <div class="input-group">
                                            <?php } ?>
                                                <select name="rectifier_make" id="rectifier_make" class="form-control " style="<?php if($_SESSION['user_eteelo_app']['Statut']=='Admin' || $_SESSION['user_eteelo_app']['Statut']=='User_IT'){echo 'border-top-right-radius: 0; height: 36px; border-bottom-right-radius: 0';} ?>">
                                                <option value="" id="add_rectifier_make">--</option>
                                                <?php while($rectifier_makes=$rectifier_make->fetch()){ ?>
                                                <option value="<?php echo($rectifier_makes['ID_Rectifier_Make'])?>" <?php if($rectifier_makes['ID_Rectifier_Make']==$rapports['ID_Rectifier_Make']){echo "selected";} ?>><?php echo(strtoupper($rectifier_makes['Design_Rectifier_Make'])); ?></option>
                                                <?php } ?>
                                                </select>
                                                <?php if($_SESSION['user_eteelo_app']['Statut']=='Admin' || $_SESSION['user_eteelo_app']['Statut']=='User_IT'){ ?>
                                                <div class="input-group-btn">
                                                    <a href="#" class="btn btn-primary" title="Ajouter" id="ajouter_rectifier_make" style="height: 36px; border-top-left-radius: 0; border-bottom-left-radius: 0"><i class="fa fa-plus"></i></a>
                                                </div>
                                            </div>
                                            <?php } ?>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-2" style="margin-bottom: 10px">
                                        <div class="form-group ">
                                          <label for="rectifier_model" class="control-label col-lg-12" style="text-align: left;">Rectifier model *</label>
                                          <div class="col-lg-12">
                                            <?php if($_SESSION['user_eteelo_app']['Statut']=='Admin' || $_SESSION['user_eteelo_app']['Statut']=='User_IT'){ ?>
                                            <div class="input-group">
                                            <?php } ?>
                                                <select name="rectifier_model" id="rectifier_model" class="form-control " style="<?php if($_SESSION['user_eteelo_app']['Statut']=='Admin' || $_SESSION['user_eteelo_app']['Statut']=='User_IT'){echo 'border-top-right-radius: 0; height: 36px; border-bottom-right-radius: 0';} ?>">
                                                <option value="" id="add_rectifier_model">--</option>
                                                <?php while($rectifier_models=$rectifier_model->fetch()){ ?>
                                                <option value="<?php echo($rectifier_models['ID_Rectifier_Model'])?>" <?php if($rectifier_models['ID_Rectifier_Model']==$rapports['ID_Rectifier_Model']){echo "selected";} ?>><?php echo(strtoupper($rectifier_models['Design_Rectifier_Model'])); ?></option>
                                                <?php } ?>
                                                </select>
                                                <?php if($_SESSION['user_eteelo_app']['Statut']=='Admin' || $_SESSION['user_eteelo_app']['Statut']=='User_IT'){ ?>
                                                <div class="input-group-btn">
                                                    <a href="#" class="btn btn-primary" title="Ajouter" id="ajouter_rectifier_model" style="height: 36px; border-top-left-radius: 0; border-bottom-left-radius: 0"><i class="fa fa-plus"></i></a>
                                                </div>
                                            </div>
                                            <?php } ?>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-2" style="margin-bottom: 10px">
                                        <div class="form-group ">
                                          <label for="batterie_make" class="control-label col-lg-12" style="text-align: left;">Make of Batteries *</label>
                                          <div class="col-lg-12">
                                            <?php if($_SESSION['user_eteelo_app']['Statut']=='Admin' || $_SESSION['user_eteelo_app']['Statut']=='User_IT'){ ?>
                                            <div class="input-group">
                                            <?php } ?>
                                                <select name="batterie_make" id="batterie_make" class="form-control " style="<?php if($_SESSION['user_eteelo_app']['Statut']=='Admin' || $_SESSION['user_eteelo_app']['Statut']=='User_IT'){echo 'border-top-right-radius: 0; height: 36px; border-bottom-right-radius: 0';} ?>">
                                                <option value="" id="add_make">--</option>
                                                <?php while($batterie_makes=$batterie_make->fetch()){ ?>
                                                <option value="<?php echo($batterie_makes['ID_Make_Batterie'])?>" <?php if($batterie_makes['ID_Make_Batterie']==$rapports['ID_Make_Batterie']){echo "selected";} ?>><?php echo(strtoupper($batterie_makes['Design_Make_Batterie'])); ?></option>
                                                <?php } ?>
                                                </select>
                                                <?php if($_SESSION['user_eteelo_app']['Statut']=='Admin' || $_SESSION['user_eteelo_app']['Statut']=='User_IT'){ ?>
                                                <div class="input-group-btn">
                                                    <a href="#" class="btn btn-primary" title="Ajouter" id="ajouter_batterie" style="height: 36px; border-top-left-radius: 0; border-bottom-left-radius: 0"><i class="fa fa-plus"></i></a>
                                                </div>
                                            </div>
                                            <?php } ?>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-2" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="num_bat" class="control-label col-lg-12" style="text-align: left;">No. of Bat./bank *</label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="num_bat" type="text" name="num_bat" value="<?php echo stripslashes($rapports['Number_Bat_By_bank']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-2" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="num_work_order" class="control-label col-lg-12" style="text-align: left;">Work Order No *</label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="num_work_order" type="text" name="num_work_order" value="<?php echo stripslashes($rapports['Num_Work_Order']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-2" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="num_serial" class="control-label col-lg-12" style="text-align: left;">Serial No</label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="num_serial" type="text" name="num_serial" value="<?php echo stripslashes($rapports['Num_Serial']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-2" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="history_card_ref" class="control-label col-lg-12" style="text-align: left;">History Card Ref</label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="history_card_ref" type="text" name="history_card_ref" value="<?php echo stripslashes($rapports['History_Card_Ref']) ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-2" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="rectifier_capacity" class="control-label col-lg-12" style="text-align: left;">Rectifier Capacity(AH) *</label>
                                          <div class="col-lg-12">
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="rectifier_capacity" name="rectifier_capacity" style="border-right: none; text-align: right;" min="0" step="1" value="<?php echo ($rapports['Rectifier_Capacity']) ?>">
                                                <div class="input-group-apend">
                                                  <span class="input-group-text" style="border-top-left-radius: 0; border-bottom-left-radius: 0; border-left: none; height: 36px;">W</span>
                                                </div>
                                              </div> 
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-2" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="number_bat" class="control-label col-lg-12" style="text-align: left;">No. of Bat. banks *</label>
                                          <div class="col-lg-12">
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="number_bat" name="number_bat" style="border-right: none; text-align: right;" min="0" step="1" value="<?php echo ($rapports['Number_Bat_banks']) ?>">
                                                <div class="input-group-apend">
                                                  <span class="input-group-text" style="border-top-left-radius: 0; border-bottom-left-radius: 0; border-left: none; height: 36px;">Bank</span>
                                                </div>
                                              </div> 
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-2" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="date_rapport" class="control-label col-lg-12" style="text-align: left;">Date *</label>
                                          <div class="col-lg-12">
                                            <input class="form-control date" id="date_rapport" type="text" name="date_rapport" value="<?= date('d/m/Y', strtotime($rapports['Date_Rapport'])); ?>">
                                            <input type="hidden" name="daterap" id="daterap" value="<?= date('Y-m-d', strtotime($rapports['Date_Rapport'])); ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-2" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                          <label for="time_in" class="control-label col-lg-12" style="text-align: left;">Time In *</label>
                                          <div class="col-lg-12">
                                            <input class="form-control" id="time_in" type="time" name="time_in" value="<?= date('H:i', strtotime($rapports['Time_In'])); ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-2" style="margin-bottom: 5px">
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
                                <span style="font-weight: bold; margin-bottom: 10px">1.1 Are rectifier and battery rooms locked </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rectifier WHERE ID_Rapport=".$ID." AND Indice=1");
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
                                <span style="font-weight: bold; margin-bottom: 10px">1.2 Are/is room(s) air conditioned </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rectifier WHERE ID_Rapport=".$ID." AND Indice=2");
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
                                <span style="font-weight: bold; margin-bottom: 10px">1.3 Record room temperature </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rectifier WHERE ID_Rapport=".$ID." AND Indice=3");
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
                                <span style="font-weight: bold; margin-bottom: 10px">1.4 Check cables for signs of burns or damage </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rectifier WHERE ID_Rapport=".$ID." AND Indice=4");
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
                                <span style="font-weight: bold; margin-bottom: 10px">1.5 Measure and record charging voltage </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rectifier WHERE ID_Rapport=".$ID." AND Indice=5");
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
                                <span style="font-weight: bold; margin-bottom: 10px">1.6 Measure and confirm power supply voltages to rect </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rectifier WHERE ID_Rapport=".$ID." AND Indice=6");
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
                                <span style="font-weight: bold; margin-bottom: 10px">1.7 Measure and confirm output voltages of rect </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rectifier WHERE ID_Rapport=".$ID." AND Indice=7");
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
                                <span style="font-weight: bold; margin-bottom: 10px">1.8 Measure output voltage of battery. Advise if replacement required </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rectifier WHERE ID_Rapport=".$ID." AND Indice=8");
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
                                <span style="font-weight: bold; margin-bottom: 10px">1.9 Check and report all relays and contacts for proper operation </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rectifier WHERE ID_Rapport=".$ID." AND Indice=9");
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
                                <span style="font-weight: bold; margin-bottom: 10px">1.10 Check and report ammeter and voltmeter for correct operation </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rectifier WHERE ID_Rapport=".$ID." AND Indice=10");
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
                                <span style="font-weight: bold; margin-bottom: 10px">1.11 Current load on rectifier </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rectifier WHERE ID_Rapport=".$ID." AND Indice=11");
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
                                <span style="font-weight: bold; margin-bottom: 10px">1.12 Total number of circuit breakers </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rectifier WHERE ID_Rapport=".$ID." AND Indice=12");
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
                                <span style="font-weight: bold; margin-bottom: 10px">1.13 Number of spare slots available inside rectifier </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rectifier WHERE ID_Rapport=".$ID." AND Indice=13");
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
                                <span style="font-weight: bold; margin-bottom: 10px">1.14 Conduct discharge test for battery holding time in Hrs </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rectifier WHERE ID_Rapport=".$ID." AND Indice=14");
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
                                <span style="font-weight: bold; margin-bottom: 10px">1.15 Check and report operation of inverter shutdown on low battery voltage </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rectifier WHERE ID_Rapport=".$ID." AND Indice=15");
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
                                <span style="font-weight: bold; margin-bottom: 10px">1.16 Check and report operation of maintenance by-pass switch </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rectifier WHERE ID_Rapport=".$ID." AND Indice=16");
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
                                <span style="font-weight: bold; margin-bottom: 10px">1.17 Check and report indicator lamps for satisfactory operation </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rectifier WHERE ID_Rapport=".$ID." AND Indice=17");
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
                                <span style="font-weight: bold; margin-bottom: 10px">1.18 Check and report alarm annunciations for satisfactory operation </span>
                                <div class="row" style="border-top: 1px solid #E6E7E9; margin-top: 10px; padding-top: 10px">
                                    <div class="col-md-4" style="margin-bottom: 5px">
                                        <div class="form-group ">
                                        <?php $detail=$pdo->query("SELECT * FROM questionnaire_rectifier WHERE ID_Rapport=".$ID." AND Indice=18");
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
                            <div class="col-12" style="text-align: center; border-top: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span style="font-weight: bold">2. Comments</span>
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
    <div id="ModalAjoutMakeBatterie" class="modal fade" data-backdrop="static" style="margin-top: 100px">
        <div class="modal-dialog modal-sm" style="border: 1px solid #E6E7E9">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ajout Make of Batteries</h4>
                    <!-- <button type="button" class="close" datadismiss="modal" ariahidden="true" onclick="fermerDialogueEcole()">&times;</button> -->
                </div>
                <div class="modal-body">
                   <form method="post" action="">
                    <input id="tok_make_batterie" type="hidden" name="tok_make_batterie" value="<?php echo($_SESSION['user_eteelo_app']['token']); ?>">
                    <div class="col-lg-12">Désignation *</div>
                    <div class="col-lg-12"><input type="text" name="Design_Make_Batterie" id="Design_Make_Batterie" class="form-control" style="margin-top: 1%;" value="" required></div>
                    </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="enregistrer_make_batterie">Enregistrer</button>
                <button  class="btn btn-danger" onclick="fermerDialogueMakeBatterie()">Annuler</button>
            </div>
            </div>
        </div>
    </div>
    <div id="ModalAjoutRectifierMake" class="modal fade" data-backdrop="static" style="margin-top: 100px">
        <div class="modal-dialog modal-sm" style="border: 1px solid #E6E7E9">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ajout Rectifier Make</h4>
                    <!-- <button type="button" class="close" datadismiss="modal" ariahidden="true" onclick="fermerDialogueEcole()">&times;</button> -->
                </div>
                <div class="modal-body">
                   <form method="post" action="">
                    <input id="tok_rectifier_make" type="hidden" name="tok_rectifier_make" value="<?php echo($_SESSION['user_eteelo_app']['token']); ?>">
                    <div class="col-lg-12">Désignation *</div>
                    <div class="col-lg-12"><input type="text" name="Design_Rectifier_Make" id="Design_Rectifier_Make" class="form-control" style="margin-top: 1%;" value="" required></div>
                    </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="enregistrer_rectifier_make">Enregistrer</button>
                <button  class="btn btn-danger" onclick="fermerDialogueRectifierMake()">Annuler</button>
            </div>
            </div>
        </div>
    </div>
    <div id="ModalAjoutRectifierModel" class="modal fade" data-backdrop="static" style="margin-top: 100px">
        <div class="modal-dialog modal-sm" style="border: 1px solid #E6E7E9">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ajout Rectifier Model</h4>
                    <!-- <button type="button" class="close" datadismiss="modal" ariahidden="true" onclick="fermerDialogueEcole()">&times;</button> -->
                </div>
                <div class="modal-body">
                   <form method="post" action="">
                    <input id="tok_rectifier_model" type="hidden" name="tok_rectifier_model" value="<?php echo($_SESSION['user_eteelo_app']['token']); ?>">
                    <div class="col-lg-12">Désignation *</div>
                    <div class="col-lg-12"><input type="text" name="Design_Rectifier_Model" id="Design_Rectifier_Model" class="form-control" style="margin-top: 1%;" value="" required></div>
                    </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="enregistrer_rectifier_model">Enregistrer</button>
                <button  class="btn btn-danger" onclick="fermerDialogueRectifierModel()">Annuler</button>
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
        if($('#province').val()=='' ||  $('#site').val()=='' || $('#rectifier_make').val()=='' || $('#rectifier_model').val()=='' || $('#batterie_make').val()=='' || $('#num_bat').val()=='' || $('#num_work_order').val()=='' || $('#rectifier_capacity').val()=='' || $('#number_bat').val()=='' || $('#date_rapport').val()=='' || $('#time_in').val()=='' || $('#time_out').val()==''){
          alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez remplir tous les champs obligatoires svp!', function(){$('#libelle').focus();});
        }else{
                let daterapport = $('#date_rapport').val();
                daterap = daterapport.replace(/\//g, "-");
                $('#daterap').val(daterap);
                $.ajax({
                    url:'edit_rapport_rectifier.php',
                    type:'post',
                    dataType:'text', 
                    data:{ID_Rapport:$('#ID_Rapport').val(), Province:$('#province').val(), Site:$('#ID_Site').val(), Rectifier_Make:$('#rectifier_make').val(), Rectifier_Model:$('#rectifier_model').val(), Batterie_Make:$('#batterie_make').val(), Num_Bat:$('#num_bat').val(), Num_Work_Order:$('#num_work_order').val(), Num_Serial:$('#num_serial').val(), History_Card_Ref:$('#history_card_ref').val(), Rectifier_Capacity:$('#rectifier_capacity').val(), Number_Bat:$('#number_bat').val(), Daterap:$('#daterap').val(), Time_in:$('#time_in').val(), Time_out:$('#time_out').val(), token:$('#token').val()},
                    success:function(ret){
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
            $('#rectifier_make').focus();
        }
    });
    $('#ajouter_batterie').click(function(e){
        e.preventDefault();
        $("#ModalAjoutMakeBatterie").modal('show');
        $('#Design_Make_Batterie').val('').focus();
    })
    function fermerDialogueMakeBatterie(){
        $("#ModalAjoutMakeBatterie").modal('hide');
    }
    $('#ajouter_rectifier_make').click(function(e){
        e.preventDefault();
        $("#ModalAjoutRectifierMake").modal('show');
        $('#Design_Rectifier_Make').val('').focus();
    })
    function fermerDialogueRectifierMake(){
        $("#ModalAjoutRectifierMake").modal('hide');
    }
    $('#ajouter_rectifier_model').click(function(e){
        e.preventDefault();
        $("#ModalAjoutRectifierModel").modal('show');
        $('#Design_Rectifier_Model').val('').focus();
    })
    function fermerDialogueRectifierModel(){
        $("#ModalAjoutRectifierModel").modal('hide');
    }
    $('#enregistrer_make_batterie').click(function(){
        if($('#Design_Make_Batterie').val()==''){
            alertify.alert('<?php echo $app_infos['Design_App']; ?>', 'Veuillez saisir la désignation svp!');
        }else{
            $.ajax({
                url:'enreg_make_batteries.php',
                type:'post',
                dataType:'html', 
                data:{Design:$('#Design_Make_Batterie').val(), token:$('#tok_make_batterie').val()},
                success:function(ret){
                    if(ret==2){
                        alertify.alert('<?php echo $app_infos['Design_App']; ?>', 'Cette désignation existe déjà !');
                    }else{
                        $('#add_make').nextAll().remove();
                        $('#add_make').after(ret);
                        $("#ModalAjoutMakeBatterie").modal('hide');
                        $('#num_bat').val('').focus();
                    }
                }
            });
        }
    });
    $('#enregistrer_rectifier_make').click(function(){
        if($('#Design_Rectifier_Make').val()==''){
            alertify.alert('<?php echo $app_infos['Design_App']; ?>', 'Veuillez saisir la désignation svp!');
        }else{
            $.ajax({
                url:'enreg_rectifier_makes.php',
                type:'post',
                dataType:'html', 
                data:{Design:$('#Design_Rectifier_Make').val(), token:$('#tok_rectifier_make').val()},
                success:function(ret){
                    // alertify.alert(ret);
                    if(ret==2){
                        alertify.alert('<?php echo $app_infos['Design_App']; ?>', 'Cette désignation existe déjà !');
                    }else{
                        $('#add_rectifier_make').nextAll().remove();
                        $('#add_rectifier_make').after(ret);
                        $("#ModalAjoutRectifierMake").modal('hide');
                        $('#rectifier_model').val('').focus();
                    }
                }
            });
        }
    });
    $('#enregistrer_rectifier_model').click(function(){
        if($('#Design_Rectifier_Model').val()==''){
            alertify.alert('<?php echo $app_infos['Design_App']; ?>', 'Veuillez saisir la désignation svp!');
        }else{
            $.ajax({
                url:'enreg_rectifier_models.php',
                type:'post',
                dataType:'html', 
                data:{Design:$('#Design_Rectifier_Model').val(), token:$('#tok_rectifier_model').val()},
                success:function(ret){
                    if(ret==2){
                        alertify.alert('<?php echo $app_infos['Design_App']; ?>', 'Cette désignation existe déjà !');
                    }else{
                        $('#add_rectifier_model').nextAll().remove();
                        $('#add_rectifier_model').after(ret);
                        $("#ModalAjoutRectifierModel").modal('hide');
                        $('#batterie_make').val('').focus();
                    }
                }
            });
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
    $('#rectifier_make').change(function(){
        if($('#rectifier_make').val()!=''){
            $('#rectifier_model').val('').focus();
        }
    })
    $('#rectifier_model').change(function(){
        if($('#rectifier_model').val()!=''){
            $('#batterie_make').val('').focus();
        }
    })
    $('#batterie_make').change(function(){
        if($('#batterie_make').val()!=''){
            $('#num_bat').val('').focus();
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
                    url:'edit_details_rapport_rectifier.php',
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
                            window.location.replace('table_rapport_rectifier.php?User='+$('#User').val()+'&siteId='+$('#siteId').val()+'&RectifierMake='+$('#RectifierMake').val()+'&dateRapport='+dateRap);
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
        window.location.replace('table_rapport_rectifier.php?User='+$('#User').val()+'&siteId='+$('#siteId').val()+'&RectifierMake='+$('#RectifierMake').val()+'&dateRapport='+dateRap);
    })
    $('#btn_annuler').click(function(){
        let dateRapport = $('#dateRapport').val();
        dateRap = dateRapport.replace(/\//g, "-");
        window.location.replace('table_rapport_rectifier.php?User='+$('#User').val()+'&siteId='+$('#siteId').val()+'&RectifierMake='+$('#RectifierMake').val()+'&dateRapport='+dateRap);
    });
    $('#btn_annuler_tout').click(function(){
        let dateRapport = $('#dateRapport').val();
        dateRap = dateRapport.replace(/\//g, "-");
        window.location.replace('table_rapport_rectifier.php?User='+$('#User').val()+'&siteId='+$('#siteId').val()+'&RectifierMake='+$('#RectifierMake').val()+'&dateRapport='+dateRap);
    })
    $(function(){
        $(".date").datepicker({closeText:'fermer',prevText:'&#x3c;Préc',nextText:'Suiv&#x3e;',currentText:'Courant',dateFormat:"dd/mm/yy", minDate: "01/01/1990",monthNames:["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aoùt","Septembre","Octobre","Novembre","Décembre"],monthNamesShort:["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"],dayNamesMin:["Dim","Lun","Mar","Mer","Jeu","Ven","Sam"], changeMonth: true, changeYear: true,onSelect: function(value, date) {
            date.dpDiv.find('.ui-datepicker-current-day a')
            .css('background-color', '#FE5000').css({"z-index":99999999999999});}
        });
    });
    </script>
</body>