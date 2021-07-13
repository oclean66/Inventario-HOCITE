<?php
$url = Yii::app()->request->requestUri;
if (isset($_GET['card'])) {
    $url = Yii::app()->createUrl('tcca/view', array('id' => $_GET['id']));
}

?>

<div class="container-fluid ">

    <a href="#" class="mobile-sidebar-toggle">
        <i class="fa fa-th-list"></i>
    </a>




    <a href="<?php echo $this->createUrl('/site/index') ?>" id="brand">Hefestos</a>

    <a href="#" class="toggle-nav" rel="tooltip" data-placement="bottom" title="Menu">
        <i class="fa fa-bars"></i>
    </a>

    <div>
        <?php

        $notificaciones = Tccn::model()->findAll('TCCN_IdUser=:id order by TCCN_Id desc', array(':id' => Yii::app()->user->id));
        $unread = Tccn::model()->count('TCCN_IdUser=:id and TCCN_Read=0 order by TCCN_Id desc', array(':id' => Yii::app()->user->id));

        $baseUrl = Yii::app()->theme->baseUrl;
        $visible = !Yii::app()->user->isGuest;
        $admin = Yii::app()->user->isSuperAdmin;
        $this->widget('zii.widgets.CMenu', array(
            'htmlOptions' => array('class' => 'main-nav'),
            'submenuHtmlOptions' => array('class' => 'dropdown-menu'),
            'encodeLabel' => false,
            'items' => array(
                array('label' => 'Inicio', 'url' => array('/site/index'), 'visible' => Yii::app()->user->checkAccess('action_site_index')),
                array('label' => 'Tableros', 'url' => array('/tcca/index'), 'visible' => Yii::app()->user->checkAccess('action_tcca_index')),
                array(
                    'label' => 'Activos <span class="caret"></span>', 'url' => '#', 'visible' => Yii::app()->user->checkAccess('controller_fccu'), 'itemOptions' => array('class' => 'dropdown', 'tabindex' => "-1"), 'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => "dropdown"),
                    'items' => array(
                        array('label' => 'Agregar', 'url' => array('/fccu/add'), 'visible' => Yii::app()->user->checkAccess('action_fccu_add')),
                        array('label' => 'Asignar', 'url' => array('/fcco/create'), 'visible' => Yii::app()->user->checkAccess('action_fcco_create')),
                        array('label' => 'Recibir', 'url' => array('/fcco/less'), 'visible' => Yii::app()->user->checkAccess('action_fcco_less')),
                        array('label' => 'Buscar', 'url' => array('/fccu/admin'), 'visible' => Yii::app()->user->checkAccess('action_fccu_admin')),
                    )
                ),


                array(
                    'label' => 'Reportes <span class="caret"></span>', 'url' => '#', 'visible' => Yii::app()->user->checkAccess('controller_site'), 'itemOptions' => array('class' => 'dropdown', 'tabindex' => "-1"), 'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => "dropdown"),
                    'items' => array(
                        array('label' => 'Arbol de Asignaciones', 'url' => array('/fcco/admin'), 'visible' => Yii::app()->user->checkAccess('action_fcco_admin')),
                        array('label' => 'Reporte de Salidas', 'url' => $this->createUrl('/fcco/report', array('FCCN_Id' => 1)), 'visible' => Yii::app()->user->checkAccess('action_fcco_report')),
                        array('label' => 'Reporte de Entradas', 'url' => $this->createUrl('/fcco/report', array('FCCN_Id' => 2)), 'visible' => Yii::app()->user->checkAccess('action_fcco_report')),
                        array('label' => 'Estadisticas', 'url' => array('/site/statistics'), 'visible' => $visible /*Yii::app()->user->checkAccess('action_site_statistics')*/),

                        array('label' => 'Recargas*', 'url' => array('/fcuc/admin'), 'visible' => $admin),
                        array('label' => 'Rendimiento laboral*', 'url' => array('#'), 'visible' => $admin),
                        //array('label' => 'Compras', 'url' => array('#'),'visible' =>  $admin ),
                        //array('label' => 'Resumen', 'url' => array('#'),'visible' => $admin ),
                        // array('label' => 'Bitacora', 'url' => array('#'),'visible' =>  $admin ),
                    )
                ),
                array(
                    'label' => 'Configuracion <span class="caret"></span>', 'url' => '#', 'visible' => Yii::app()->user->checkAccess('controller_site'), 'itemOptions' => array('class' => 'dropdown', 'tabindex' => "-1"), 'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => "dropdown"),
                    'items' => array(
                        array('label' => 'Grupos', 'url' => array('/gccd/admin'), 'visible' => Yii::app()->user->checkAccess('action_gccd_admin')),
                        array('label' => 'Agencias', 'url' => array('/gcca/admin'), 'visible' => Yii::app()->user->checkAccess('action_gcca_admin')),
                        array('label' => 'Activos', 'url' => array('/fccu/admin'), 'visible' => Yii::app()->user->checkAccess('action_fccu_admin')),
                        array('label' => 'Usuarios del Sistema', 'url' => array('/cruge/ui/usermanagementadmin'), 'visible' => Yii::app()->user->checkAccess('action_ui_usermanagementadmin')),
                        array('label' => 'Tipo de Activos', 'url' => array('/fcca/admin'), 'visible' => Yii::app()->user->checkAccess('action_fcca_admin')),
                        array('label' => 'Modelos de Activos', 'url' => array('/fcct/admin'), 'visible' => Yii::app()->user->checkAccess('action_fcct_admin')),
                        array('label' => 'Categorias de Activos*', 'url' => array('/fcuu/admin'), 'visible' => $admin),
                        array('label' => 'Operaciones con Activos', 'url' => array('/fccn/admin'), 'visible' => Yii::app()->user->checkAccess('action_fccn_admin')),
                        array('label' => 'Estado de Activos', 'url' => array('/fcci/admin'), 'visible' => Yii::app()->user->checkAccess('action_fcci_admin')),
                        array('label' => 'Operador de Lineas', 'url' => array('/fccd/admin'), 'visible' => Yii::app()->user->checkAccess('action_fccd_admin')),
                        array('label' => 'Migrar de 2.0', 'url' => array('/site/migrate'), 'visible' => Yii::app()->user->checkAccess('action_site_migrate')),
                        array(
                            'label' => 'Operaciones*', 'url' => '#', 'visible' => $admin, 'itemOptions' => array('class' => 'dropdown-submenu', 'tabindex' => "-1"), 'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => "dropdown"),
                            'items' => array(

                                array(
                                    'label' => 'Suministros*', 'url' => '#', 'visible' => $admin, 'itemOptions' => array('class' => 'dropdown-submenu', 'tabindex' => "-1"), 'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => "dropdown"),
                                    'items' => array(
                                        array('label' => 'Asignar', 'url' => array('/fcco/create')),
                                        array('label' => 'Recargar', 'url' => array('#')),
                                        array('label' => 'Buscar', 'url' => array('/fccu/admin')),
                                    )
                                ),
                                array(
                                    'label' => 'Facturacion*', 'url' => '#', 
                                    'visible' => $admin, 
                                    'itemOptions' => array('class' => 'dropdown-submenu', 'tabindex' => "-1"), 
                                    'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => "dropdown"),
                                    'items' => array(
                                        array('label' => 'Asignar', 'url' => array('#')),
                                        array('label' => 'Recargar', 'url' => array('#')),
                                        array('label' => 'Buscar', 'url' => array('#')),
                                    )
                                ),
                            )
                        ),
                    )
                ),
            ),
        ));
        ?>
    </div>

    <div class="dropdown hidden-lg" style="float:right;display: block;color:white;   padding: 11px 10px 9px 10px;background:orange">
        <a href="#" class="dropdown-toggle" style="color:white;" data-toggle="dropdown">
            <i class="fa fa-bell"></i>
            <span class="label label-lightred"><?php echo $unread; ?></span>
        </a>
        <div class="dropdown-menu pull-right " style="text-align: left;max-height:500px;overflow:auto;min-width:320px;right:-20px;">
            <div class="box">
                <div class="box-title" style="margin:0">
                    <h6 style="display:inline-block;color:black"> <i class="fa fa-bell"></i> Notificaciones</h6>
                    <div class="actions">
                        <a href="javascript:window.location.href='<?php echo $url; ?>'" rel="tooltip" data-placement="bottom" title="" data-original-title="Actualizar" class="btn btn-mini">
                            <i class="fa fa-refresh"></i>
                        </a>
                        <a href="#" rel="tooltip" onClick="removerAll()" data-placement="bottom" title="" data-original-title="Marcar como Visto" class="btn btn-mini">
                            <i class="fa fa-times"></i>
                        </a>

                    </div>
                </div>
            </div>
            <?php foreach ($notificaciones as $value) {
            ?>


                <a style="text-decoration: none;color:#383838" href="#" class="notification" id="<?php echo $value->TCCN_Id; ?>" data-link="<?php echo $value->TCCN_Url ? $value->TCCN_Url : "#"; ?>" data-status="<?php echo $value->TCCN_Read == 0 ? "active" : ''; ?>">
                    <div class="alert alert-card notificacion <?php echo $value->TCCN_Read == 0 ? "active" : ''; ?>">

                        <small class="" style="color:<?php echo $value->TCCN_Read == 0 ? "white" : '#368ee0'; ?>; font-weight:bolder;">
                            <?php echo $value->TCCN_Read == 0 ? '<i class="fa fa-star"></i>' : ""; ?>
                            <?php echo date("d M, h:ia", strtotime($value->TCCN_Created)); ?>
                        </small>
                        <br />

                        <?php echo $value->TCCN_Title; ?>
                    </div>
                </a>


            <?php
            }
            ?>



        </div>
    </div>

    <div class="user">
        <div class="dropdown">
            <?php
            $avatar = Yii::app()->user->um->getFieldValueInstance(Yii::app()->user->id, 'avatar')->value;
            if($avatar != ''){
                $profPic = $avatar;
            }else{
                $profPic = $baseUrl . '/img/avatars/user.png';
            }
            $var = !Yii::app()->user->isGuest ? ( 
                    Yii::app()->user->um->getFieldValue(Yii::app()->user->id, 'nombre') != '' ? 
                        Yii::app()->user->um->getFieldValue(Yii::app()->user->id, 'nombre') : 
                        Yii::app()->user->name 
                ) : "Invitado";

            $this->widget('zii.widgets.CMenu', array(
                'htmlOptions' => array('class' => 'main-nav'),
                'submenuHtmlOptions' => array('class' => 'dropdown-menu pull-right'),
                'encodeLabel' => false,
                'items' => array(
                    array(
                        'label' => '<i class="icon-user"></i>  ' . $var . '  <span class="caret"></span><img width="25" src="'.$profPic.'" alt="">',
                        'url' => '#', 'visible' => $visible,
                        'itemOptions' => array('class' => 'dropdown', 'tabindex' => "-1"), 
                        'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => "dropdown"),
                        'items' => array(
                            array('label' => 'Bitacora', 'url' => array('/pcue'), 'visible' => Yii::app()->user->checkAccess('controller_pcue')),
                            array('label' => 'Editar Perfil', 'url' => array('/cruge/ui/editprofile'), 'visible' => Yii::app()->user->checkAccess('action_ui_editprofile')),
                            array('label' => 'Salir (' . Yii::app()->user->name . ')', 'url' => Yii::app()->user->ui->logoutUrl, 'visible' => !Yii::app()->user->isGuest),
                        )
                    ),
                    array('label' => 'Entrar', 'url' => Yii::app()->user->ui->loginUrl, 'visible' => Yii::app()->user->isGuest),
                )
            ));
            ?>
        </div>
        <ul class="icon-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell"></i>
                    <span class="label label-lightred"><?php echo $unread; ?></span>
                </a>
                <div class="dropdown-menu pull-right " style="max-height:500px;overflow:auto;min-width:320px;background-color: #eeeeee;">
                    <div class="box">
                        <div class="box-title" style="margin:0">
                            <h6 style="display:inline-block;"> <i class="fa fa-bell"></i> Notificaciones</h6>
                            <div class="actions">
                                <a href="javascript:window.location.href='<?php echo $url; ?>'" rel="tooltip" data-placement="bottom" title="" data-original-title="Actualizar" class="btn btn-mini">
                                    <i class="fa fa-refresh"></i>
                                </a>
                                <a href="#" rel="tooltip" onClick="removerAll()" data-placement="bottom" title="" data-original-title="Marcar como Visto" class="btn btn-mini">
                                    <i class="fa fa-times"></i>
                                </a>
                                <!-- <button rel="tooltip" data-placement="bottom" title="" data-original-title="Participantes del Tablero" class="btn btn-mini content-slideUp">
                                    <i class="fa fa-angle-down"></i>
                                </button> -->
                            </div>
                        </div>
                    </div>

                    <?php foreach ($notificaciones as $value) {
                    ?>
                        <a href="#" style="text-decoration: none;color:#383838" class="notification" id="<?php echo $value->TCCN_Id; ?>" data-link="<?php echo $value->TCCN_Url ? $value->TCCN_Url : "#"; ?>" data-status="<?php echo $value->TCCN_Read == 0 ? "active" : ''; ?>">
                            <div class="alert alert-card notificacion <?php echo $value->TCCN_Read == 0 ? "active" : ''; ?>">

                                <small class="" style="color:<?php echo $value->TCCN_Read == 0 ? "white" : '#368ee0'; ?>; font-weight:bolder;">
                                    <?php echo $value->TCCN_Read == 0 ? '<i class="fa fa-star"></i>' : ""; ?>
                                    <?php echo date("d M, h:ia", strtotime($value->TCCN_Created)); ?>
                                </small>
                                <br />

                                <?php echo $value->TCCN_Title; ?>
                            </div>
                        </a>
                    <?php } ?>

                </div>
            </li>
        </ul>
    </div>





</div>
<div class="progress progress-striped active" style="margin: 0; height: 5px;background: #eee;">
    <div id="progress" class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">

    </div>
</div>
<img src="<?php echo Yii::app()->theme->baseUrl . "/img/logo-big.png"; ?>" alt="" class="imprimir" srcset="" style="width: 50px;position: absolute;right: 1px;z-index: 1;">
<div class="imprimir" style="position: absolute;top:70px;right: 1px;z-index: 1;">
    <?php echo Yii::app()->locale->dateFormatter->format("d MMM hh:mma", strtotime('-4 hours')) ?>
</div>


<script>
    $(".notification").click(function(e) {

        var link = $(this).data('link');
        var status = $(this).data('status');

        if (status == "active") {


            $.ajax({
                type: "POST",
                url: "<?php echo Yii::app()->createUrl("tccn/delete")?>" + "?id=" + $(this).attr('id'),
                beforeSend: function(xhr) {
                    jQuery('#progress').attr('style', 'width:100%');

                }
            }).done(function(data) {
                jQuery('#progress').attr('style', 'width:0%');
                $('#navigation > div.container-fluid > div.user > ul > li > a > span').html($('#navigation > div.container-fluid > div.user > ul > li > a > span').html() - 1);
                location.href = link;

            });
        } else {
            location.href = link;
        }

    });

    function removerAll() {
        // alert("removiendo");
        $.ajax({
            url: "<?php echo Yii::app()->createUrl("tccn/remove")?>",
            beforeSend: function(xhr) {
                jQuery('#progress').attr('style', 'width:100%');

            }
        }).done(function(data) {
            jQuery('#progress').attr('style', 'width:0%');
            $('#navigation > div.container-fluid > div.user > ul > li > a > span').html('0');
            // console.log(location.href);
            location.href = '<?php echo $url; ?>';
        });

    }
    console.log('<?php echo $url; ?>')
</script>