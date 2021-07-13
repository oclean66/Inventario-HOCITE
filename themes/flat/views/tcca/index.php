<?php
/* @var $this TccaController */
/* @var $dataProvider CActiveDataProvider */



// $this->menu=array(
// 	array('label'=>'Nuevo Tablero', 'url'=>array('create')),
// 	// array('label'=>'Manage Tcca', 'url'=>array('admin')),
// );
?>




<div class="row">
    <div class="col-sm-12 nopadding">
        <div class="box">
            <div class="box-title" style="">
                <h3>
                    <i class="fa fa-trello"></i>Mis Tableros
                </h3>
                <div class="actions">
                    <!-- <a href="javascript:print()" class="btn">
                        <i class="fa fa-print"></i> Imprimir
                    </a> -->
                    <div class="btn-group /*hidden-768*/">

                        <div class="dropdown">
                            <a href="#" class="btn btn-sm not-link" data-toggle="dropdown">
                                <i class="fa fa-bars"></i> Opciones
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>
                                    <a href="#" id='boton' class="not-link"> Ver Tableros Archivados</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

            <ul class="tiles" style='margin:0'>

                <?php

                foreach ($dataProvider as $value) {
                    if (!$value['TCCA_Archived']) {
                ?>
                        <li class='<?php echo $value['TCCA_Archived'] ? "pink long" : "blue long"; ?>'>
                            <a href="<?php echo Yii::app()->createUrl('tcca/view', array('id' => $value['TCCA_Id'])); ?>">
                                <span class="nopadding">
                                    <h5><?php echo $value['TCCA_Name']; ?>
                                        <br />
                                        <small style="color:white;"><?php echo $value['TCCA_Archived'] ? "Archivado" : ""; ?></small>
                                    </h5>
                                </span>

                            </a>
                        </li>
                <?php
                    }
                }
                ?>

                <li class="lime">
                    <a href="#modal-1" data-toggle="modal" target="_blank">
                        <span class="">
                            <i class="fa fa-plus-square"></i> </span>
                        <span class="name">Agregar Tablero</span>
                    </a>
                </li>

            </ul>


            <!-- <div class="panel-group panel-widget col-sm-6" style='margin:0'>
                <?php
                echo $data['tablero'];
                echo $data['tabla'];
                ?>
                <div class="panel panel-default lime">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="#modal-1" data-toggle="modal" target="_blank">
                                <i class="fa fa-plus-square"></i>
                                Agregar Tablero
                            </a>
                        </h4>
                    </div>
                </div>
                <?php
                foreach ($dataProvider as $value) {
                    if (!$value['TCCA_Archived']) {
                ?>
                        <div class='panel panel-default <?php echo $value['TCCA_Archived'] ? "pink long" : "blue long"; ?>'>
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a href="<?php echo Yii::app()->createUrl('tcca/view', array('id' => $value['TCCA_Id'])); ?>">
                                        <?php echo $value['TCCA_Name']; ?>
                                        <br />
                                        <small style="color:white;"><?php echo $value['TCCA_Archived'] ? "Archivado" : ""; ?></small>
                                    </a>
                                </h4>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>


            </div> -->
        </div>
    </div>
    <div id="archivados" class="col-sm-12 nopadding hide">
        <div class="box">
            <div class="box-title">
                <h3>Tableros Archivados</h3>
            </div>
        </div>
        <!-- <div class="panel-group panel-widget" style='margin:0'> -->

        <ul class="tiles" style="margin: 0;">
            <?php

            foreach ($dataProvider as $value) {
                if ($value['TCCA_Archived']) {
            ?>
                    <!-- <div class='panel panel-default <?php echo $value['TCCA_Archived'] ? "pink long" : "blue long"; ?>'> -->
                    <li class='<?php echo $value['TCCA_Archived'] ? "pink long" : "blue long"; ?>'>
                        <!-- <div class="panel-heading">
                                <h4 class="panel-title"> -->
                        <a href="<?php echo Yii::app()->createUrl('tcca/view', array('id' => $value['TCCA_Id'])); ?>">
                            <span class="noppading">
                                <h5>
                                    <?php echo $value['TCCA_Name']; ?>
                                    <br />
                                    <small style="color:white;"><?php echo $value['TCCA_Archived'] ? "Archivado" : ""; ?></small>
                                </h5>
                            </span>
                        </a>
                        <!-- </h4>
                            </div> -->
                    </li>
                    <!-- </div> -->
            <?php
                }
            }
            ?>

        </ul>
        <!-- </div> -->
    </div>

</div>
<div id="modal-1" class="modal fade" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content ">
            <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'tcca-form',
                'enableAjaxValidation' => false,
                'htmlOptions' => array('class' => 'form-bordered'),
            )); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">
                    <a href="#" class="listTitle" data-placement="right">Crear Tablero</a>
                </h4>
            </div>

            <div class="modal-body">


                <?php echo $form->errorSummary($model); ?>

                <div class="form-group">

                    <div class="col-sm-12">
                        <?php echo $form->textField($model, 'TCCA_Name', array('placeholder' => 'Nombre del Tablero', 'size' => 60, 'maxlength' => 80)); ?>
                        <?php echo $form->error($model, 'TCCA_Name'); ?>
                    </div>
                </div>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Crear Tablero</button>


                <!-- <button type="submit" class="btn btn-default">Sign in</button> -->
            </div>
            <?php $this->endWidget(); ?>
            <!-- /.modal-footer -->
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php
Yii::app()->clientScript->registerScript('toggleArchivados', '
            $("#boton").click(function (){
                $("#progress").attr("style", "width:100%");
                if($("#archivados").hasClass("hide")){
                    $("#archivados").removeClass("hide");
                    $("#boton").html("Ocultar Tablero Archivos");      
                }else{
                    $("#archivados").addClass("hide");
                    $("#boton").html("Ver Tablero Archivos");      
                }
                $("#progress").attr("style", "width:0%");
                return true;
            });
');

?>