<?php
/* @var $this FccoController */
/* @var $model Fcco */


$model = $modelo[0];
$x = $tipo == 1 ? "Salida" : "Entrada";
Yii::app()->name = $x." " . $model->gCCA->GCCA_Cod . " - " . $model->gCCA->GCCA_Nombre;

$this->menu = array(
    //array('label'=>'List Fcco', 'url'=>array('index')),
    array('label' => 'Asignar Activos', 'url' => array('create')),
    // array('label' => 'Actualizar Fcco', 'url' => array('update', 'id' => $model->FCCO_Id)),
    // array('label' => 'Borrar Fcco', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->FCCO_Id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Activos en esta Agencia', 'url' => array('agencia', 'id' => $model->GCCA_Id, 'type' => 258)),
);
?>
<img class="imprimir" width="150px" src="<?php echo Yii::app()->theme->baseUrl . "/img/brand.png"; ?>" alt="" />

<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-title">
                <h3>
                    <i class="fa fa-print"></i>
                    Reporte de <?php echo $tipo == 1 ? "Salida" : "Entrada"; ?>
                </h3>
                <button class="btn btn-primary" onclick="window.print();" style="float:right"><i class="fa fa-print"></i>  Imprimir</button>
            </div>
            <div class="box-content" style="padding: 0; padding-top: 10px">
                <div class="invoice-info">
                    <div class="invoice-to">
                        <strong>Comercializadora La Excelencia</strong>
                        <address>
                            Departamento Tecnico
                            <br>Calle 15, Barrio Obrero - San Cristobal
                            <br>
                            Telefono: (0276) 355-6947
                            <br>
                            Telefono Principal:  (0276) 356-7958
                        </address>
                    </div>                   
                </div>
                <table class="table table-striped table-invoice">
                    <thead>
                        <tr>
                            <th># Serial</th>
                            <th>Descripcion</th>
                            <th>Lugar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($modelo as $model) {
                            ?>   
                            <tr>
                                <td class='price'><?php
                                    echo $model->FCCO_Enabled == 0 ? '<strike>' : '';
                                    echo $model->fCCU->FCCU_Serial;
                                    echo $model->FCCO_Enabled == 0 ? '</strike>' : '';
                                    ?></td>
                                <td class='name'><?php
                                    echo $model->FCCO_Enabled == 0 ? '<strike>' : '';
                                    echo $model->fCCU->fCCT->fCCA->FCCA_Descripcion . " " . $model->fCCU->fCCT->FCCT_Descripcion . " | " . $model->fCCU->FCCU_Numero;
                                    echo $model->FCCO_Enabled == 0 ? '</strike>' : '';
                                    ?></td>
                                <td class='place'><?php
                            echo $model->FCCO_Enabled == 0 ? '<strike>' : '';
                            echo $model->lugar;
                            echo $model->FCCO_Enabled == 0 ? '</strike>' : '';
                            ?></td>
                            </tr>
    <?php
}
?>
                    </tbody>
                </table>               
            </div>
        </div>
    </div>
</div>
