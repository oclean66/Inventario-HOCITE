<?php
/* @var $this FccsController */
/* @var $model Fccs */
/* @var $form CActiveForm */
?>

<div class="box box-bordered box-color">
    <div class="box-title">
        <h3>
            <i class="fa fa-th-list"></i><?php echo $model->isNewRecord ? 'Crear ' : 'Actualizar '; ?>Fccs</h3>
    </div>
    <div class="box-content nopadding">

        <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'fccs-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('class' => 'form-horizontal form-bordered'),
)); ?>



        <?php echo $form->errorSummary($model,'Corriga lo siguiente','', array('class' => 'alert alert-danger alert-dismissable')); ?>

                    <div class="form-group">
                <?php echo $form->labelEx($model,'FCCS_Fecha',array('class'=>'control-label col-sm-2')); ?>
                <div class="col-sm-10">
                    <?php echo $form->textField($model,'FCCS_Fecha',array('class'=>'form-control','size'=>45,'maxlength'=>45)); ?>
                    <?php echo $form->error($model,'FCCS_Fecha',array('class' => 'label label-danger')); ?>
                </div>
            </div>

                        <div class="form-group">
                <?php echo $form->labelEx($model,'FCCS_Control',array('class'=>'control-label col-sm-2')); ?>
                <div class="col-sm-10">
                    <?php echo $form->textField($model,'FCCS_Control',array('class'=>'form-control','size'=>45,'maxlength'=>45)); ?>
                    <?php echo $form->error($model,'FCCS_Control',array('class' => 'label label-danger')); ?>
                </div>
            </div>

                    <div class="form-actions col-sm-offset-2 col-sm-10">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar',array('class' => 'btn btn-primary')); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->