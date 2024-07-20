                            <?php
                            session_start();
                            require_once('connexion.php');
                            $titre = $pdo->query("SELECT * FROM table_titre WHERE ID_Cient=".$_POST['Client']." ORDER BY ID_Titre");
                            $Numero_titre=0;
                            $Numero_stitre=0;
                            $Nombre_Total=0;
                            $app_info=$pdo->query("SELECT * FROM app_infos");
                            $app_infos=$app_info->fetch();
                            while ($titres = $titre->fetch()) {
                                $table_stitre = $pdo->query("SELECT * FROM table_sous_titre WHERE ID_Titre=" . $titres['ID_Titre']);
                                ?>
                                <div class="col-12" style="text-align: center">
                                        <span style="font-weight: bold;"><?php echo stripslashes(strtoupper($titres['Code_Titre'] . '. ' . $titres['Design_Titre'])); ?></span>
                                        <div class="row">
                                            <?php while ($table_stitres = $table_stitre->fetch()) {
                                                $Nombre = 1;
                                                $Numero_titre = $titres['Code_Titre'];
                                                $Numero_stitre = $table_stitres['Code_Sous_Titre'];
                                                ?>
                                                <div class="col-12" style="text-align: center; border-top: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                                    <span><?php echo stripslashes(strtoupper($titres['Code_Titre'] . '.' . $table_stitres['Code_Sous_Titre'] . '. ' . $table_stitres['Design_Sous_Titre'])); ?></span>
                                                    <div class="row">
                                                    <?php while ($Nombre <= $table_stitres['Nombre_Photo']) {
                                                        $Nombre++;
                                                        $Nombre_Total++; ?>
                                                            <div class="col-sm-3" style="border-top: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px; margin-bottom: 5px">
                                                              <form class="PicturesForm" id="PicturesForm_<?php echo $Nombre_Total; ?>" method="post" action="" enctype="multipart/form-data">
                                                                <input type="hidden" name="ID_Rapport_<?php echo $Nombre_Total; ?>" class="ID_Rapport">
                                                                <input id="token_<?php echo $Nombre_Total; ?>" type="hidden" name="token_<?php echo $Nombre_Total; ?>" value="<?php echo ($_SESSION['user_eteelo_app']['token']); ?>">
                                                                <input type="hidden" class="ID_Titre" name="ID_Titre_<?php echo $Nombre_Total; ?>" id="ID_Titre" value="<?php echo $table_stitres['ID_Sous_Titre']; ?>">
                                                                <input class="form-control fichier_image" id="fichier_image_<?php echo $Nombre_Total; ?>" type="file" name="fichier_image_<?php echo $Nombre_Total; ?>" style="display: none;" accept=".jpg, .jpeg, .png">
                                                                <div style="border: 2px solid RGB(234,234,234); height: 200px">
                                                                    <input type="hidden" name="Indice" value="<?php echo $Nombre_Total; ?>">
                                                                    <a href="#" class="btn_choisir_image" id="mapercu_<?php echo $Nombre_Total; ?>" indice="<?php echo $Nombre_Total; ?>" title="Choisir l'image">
                                                                    <img src="images/picture.png" style="height: 180px; margin-top: 10px" id="miamge_<?php echo $Nombre_Total; ?>" class="miamge">
                                                                    </a>
                                                                </div>
                                                              <input id="btn_submit_<?php echo $Nombre_Total; ?>" type="submit" name="btn_submit_<?php echo $Nombre_Total; ?>" value="btn_submit_<?php echo $Nombre_Total; ?>" style="display: none">
                                                              </form>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                </div>
                            <?php } ?>
                            <div class="col-12" style="text-align: center; border-top: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                <span><?php echo $Numero_titre . '.' . ($Numero_stitre + 1) . '. '; ?>ISSUE</span>
                            <div class="row">
                                <div class="col-12" style="text-align: center; border-top: 1px solid #E6E7E9; padding-top: 10px; margin-top: 10px">
                                    <textarea name="description" class="form-control" id="description" cols="30" rows="6"></textarea>
                                </div>
                            </div>
                            </div>
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

    idimg="";
    indice="";


        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }

        async function demo() {
            await sleep(2000);
            // $('#btn_submit_'+idimg).click();
            // $('#'+idimg).attr('src', images);
        }

         function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    $('#'+idimg).attr('src', 'images/loading.gif');
                    $('#btn_submit_'+indice).click();
                    images = e.target.result;
                    demo()
                }
                reader.readAsDataURL(input.files[0]);
            }
        }


    $('.btn_choisir_image').click(function(e){
        e.preventDefault();
        $('#fichier_image_'+$(this).attr('indice')).click();
        idimg="miamge_"+$(this).attr('indice');
        indice=$(this).attr('indice');
    })

    $('.fichier_image').change(function(){
         readURL(this);
    })

    $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    });

    $('.PicturesForm').submit(function(e){
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                    url:'enreg_picture.php',
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
                        const stret = retour;
                        const valeuret = stret.split(',');
                        waitingDialog.hide();
                        if(valeuret[0]==2){
                            alertify.alert('<?php echo $app_infos['Design_App']; ?>',"L'extension de l'image ne correspond pas!");
                            $('#fichier_image_'+idimg).val('');
                            $('#'+idimg).attr('src', 'images/picture.png');
                        }else if(valeuret[0]==3){
                            alertify.alert('<?php echo $app_infos['Design_App']; ?>',"Le téléchargement de l'image a échoué!");
                            $('#fichier_image_'+idimg).val('');
                            $('#'+idimg).attr('src', 'images/picture.png');
                        }else if(valeuret[0]==1){
                            $('#'+idimg).attr('src', images);
                            Toast.fire({
                                icon: 'success',
                                title: 'Upload éffectué'
                            })
                        }else{
                            alertify.alert(retour);
                            $('#fichier_image_'+idimg).val('');
                            $('#'+idimg).attr('src', 'images/picture.png');
                        }
                    }
                });
          })


        })

    </script>