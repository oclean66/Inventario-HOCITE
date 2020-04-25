<?php
/* @var $this FccuController */
/* @var $model Fccu */
/* @var $form CActiveForm */
?>

<div class="box box-bordered box-color">
    <div class="box-title">
        <h3>
            <i class="fa fa-th-list"></i><?php echo $model->isNewRecord ? 'Crear ' : 'Actualizar '; ?>Fccu</h3>
    </div>
    <div class="box-content nopadding">

        <?php
        $editable = false;
         if($model->isNewRecord || Yii::app()->user->isSuperAdmin){$editable = true;} 
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'fccu-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('class' => 'form-horizontal form-bordered'),
        ));
        ?>



        <?php echo $form->errorSummary($model, 'Corriga lo siguiente', '', array('class' => 'alert alert-danger alert-dismissable')); ?>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'FCCU_Serial', array('class' => 'control-label col-sm-2')); ?>
            <div class="col-sm-10">
                <?php echo $form->textField($model, 'FCCU_Serial', array($editable ? '' : 'readonly' => 'readonly', 'class' => 'form-control', 'size' => 45, 'maxlength' => 45)); ?>
                <?php echo $form->error($model, 'FCCU_Serial', array('class' => 'label label-danger')); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'FCCU_Timestamp', array('class' => 'control-label col-sm-2')); ?>
            <div class="col-sm-10">
                <?php echo $form->textField($model, 'FCCU_Timestamp', array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'FCCU_Timestamp', array('class' => 'label label-danger')); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'FCCU_Numero', array('class' => 'control-label col-sm-2')); ?>
            <div class="col-sm-10">
                <?php echo $form->textField($model, 'FCCU_Numero', array('class' => 'form-control', 'size' => 45, 'maxlength' => 45)); ?>
                <?php echo $form->error($model, 'FCCU_Numero', array('class' => 'label label-danger')); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'FCCU_ClaveDatos', array('class' => 'control-label col-sm-2')); ?>
            <div class="col-sm-10">
                <?php echo $form->textField($model, 'FCCU_ClaveDatos', array('class' => 'form-control', 'size' => 45, 'maxlength' => 45)); ?>
                <?php echo $form->error($model, 'FCCU_ClaveDatos', array('class' => 'label label-danger')); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'FCCU_ClaveMovil', array('class' => 'control-label col-sm-2')); ?>
            <div class="col-sm-10">
                <?php echo $form->textField($model, 'FCCU_ClaveMovil', array('class' => 'form-control', 'size' => 45, 'maxlength' => 45)); ?>
                <?php echo $form->error($model, 'FCCU_ClaveMovil', array('class' => 'label label-danger')); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'FCCU_DiaCorte', array('class' => 'control-label col-sm-2')); ?>
            <div class="col-sm-10">
                <?php echo $form->textField($model, 'FCCU_DiaCorte', array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'FCCU_DiaCorte', array('class' => 'label label-danger')); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'FCCU_MontoMin', array('class' => 'control-label col-sm-2')); ?>
            <div class="col-sm-10">
                <?php echo $form->textField($model, 'FCCU_MontoMin', array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'FCCU_MontoMin', array('class' => 'label label-danger')); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'FCCU_TipoServicio', array('class' => 'control-label col-sm-2')); ?>
            <div class="col-sm-10">
                <?php //echo $form->textField($model, 'FCCU_TipoServicio', array('class' => 'form-control', 'size' => 45, 'maxlength' => 45)); ?>
                <?php
                echo $form->dropDownList($model, 'FCCU_TipoServicio', array('0' => 'No Posee', '1' => 'Pre-Pago', '2' => 'Corporativa'), array('empty' => 'Selecciona Servicio', 'class' => 'form-control'));
                ?>
                <?php echo $form->error($model, 'FCCU_TipoServicio', array('class' => 'label label-danger')); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'FCCU_Descripcion', array('class' => 'control-label col-sm-2')); ?>
            <div class="col-sm-10">
                <?php echo $form->textField($model, 'FCCU_Descripcion', array('class' => 'form-control', 'size' => 45, 'maxlength' => 45)); ?>
                <?php echo $form->error($model, 'FCCU_Descripcion', array('class' => 'label label-danger')); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'FCCU_Cantidad', array('class' => 'control-label col-sm-2')); ?>
            <div class="col-sm-10">
                <?php echo $form->textField($model, 'FCCU_Cantidad', array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'FCCU_Cantidad', array('class' => 'label label-danger')); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'FCCU_Facturado', array('class' => 'control-label col-sm-2')); ?>
            <div class="col-sm-10">
                <?php
                echo $form->dropDownList($model, 'FCCU_Facturado', array('0' => 'No', '1' => 'Si', '2' => 'No aplica'), array('empty' => 'Selecciona Servicio', 'class' => 'form-control'));
                ?>
                <?php echo $form->error($model, 'FCCU_Facturado', array('class' => 'label label-danger')); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'FCCD_Id', array('class' => 'control-label col-sm-2')); ?>
            <div class="col-sm-10">
                <?php
                echo $form->dropDownList($model, 'FCCD_Id', CHtml::listData(Fccd::model()->findAll(), 'FCCD_Id', 'FCCD_Descripcion'), array('class' => 'form-control', 'prompt' => 'Seleccione un Operador...'));
                ?>
                <?php echo $form->error($model, 'FCCD_Id', array('class' => 'label label-danger')); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'FCCT_Id', array('class' => 'control-label col-sm-2')); ?>
            <div class="col-sm-10">
                <?php echo $form->dropDownList($model, 'FCCT_Id', CHtml::listData(Fcct::model()->findAll(), 'FCCT_Id', 'concatened'), array('class' => 'select2-me', 'style' => 'width:100%', 'prompt' => 'Seleccione un Operador...')); ?>
                <?php //echo $form->textField($model, 'FCCT_Id', array('class' => 'form-control', 'size' => 10, 'maxlength' => 10)); ?>
                <?php echo $form->error($model, 'FCCT_Id', array('class' => 'label label-danger')); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'FCCI_Id', array('class' => 'control-label col-sm-2')); ?>
            <div class="col-sm-10">
                <?php
                echo $form->dropDownList($model, 'FCCI_Id', CHtml::listData(Fcci::model()->findAll(), 'FCCI_Id', 'FCCI_Descripcion'), array('class' => 'form-control'/*,$editable ? '' : 'disabled' => 'disabled'*/, 'prompt' => 'Seleccione un estado...'));
                ?>
                <?php //echo $form->textField($model, 'FCCI_Id', array('class' => 'form-control', 'size' => 10, 'maxlength' => 10)); ?>
                <?php echo $form->error($model, 'FCCI_Id', array('class' => 'label label-danger')); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'FCCS_Id', array('class' => 'control-label col-sm-2')); ?>
            <div class="col-sm-10">
                <?php echo $form->textField($model, 'FCCS_Id', array('class' => 'form-control', 'size' => 10, 'maxlength' => 10)); ?>
                <?php echo $form->error($model, 'FCCS_Id', array('class' => 'label label-danger')); ?>
            </div>
        </div>



        <div class="form-actions col-sm-offset-2 col-sm-10">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar', array('class' => 'btn btn-primary')); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->