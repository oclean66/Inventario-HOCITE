<div class="form">
    <h1><?php echo ucwords(CrugeTranslator::t('admin', 'Manage Users')); ?></h1>
    <?php
    /*
      para darle los atributos al CGridView de forma de ser consistente con el sistema Cruge
      es mejor preguntarle al Factory por los atributos disponibles, esto es porque si se decide
      cambiar la clase de CrugeStoredUser por otra entonces asi no haya dependenci directa a los
      campos.
     */
    $cols = array();

// presenta los campos de ICrugeStoredUser
    foreach (Yii::app()->user->um->getSortFieldNamesForICrugeStoredUser() as $key => $fieldName) {
        $value = null; // default
        $filter = null; // default, textbox
        $type = 'text';
        if ($fieldName == 'state') {
            $value = '$data->getStateName()';
            $filter = Yii::app()->user->um->getUserStateOptions();
        }
        if ($fieldName == 'logondate') {
            $type = 'datetime';
        }
        $cols[] = array('name' => $fieldName, 'value' => $value, 'filter' => $filter, 'type' => $type);
    }
    $cols[] = array('name' => 'iduser', 'header'=>'Telegram Token','value' => 'Yii::app()->user->um->getFieldValue($data->iduser,"teletoken")', 'filter' => false);

    $cols[] = array(
        'class' => 'CButtonColumn',
        'header' => 'Acciones',
        'template' => '<div class="btn-group">
                            <a href="#" data-toggle="dropdown" class="btn btn-success btn-sm dropdown-toggle">
                                <i class="fa fa-bars"></i>
                            </a>
                            <ul class="dropdown-menu pull-right" style="min-width:0">
                                <li>{update}</li>
                                <li>{eliminar}</li>
                            </ul>
                        </div>',
        'deleteConfirmation' => CrugeTranslator::t('admin', 'Are you sure you want to delete this user'),
        'buttons' => array(
            'update' => array(
                'imageUrl' => false,
                'label' =>  '<i class="fa fa-pencil"></i>  Editar',  /* CrugeTranslator::t('admin', 'Update User'), */
                'url' => 'array("usermanagementupdate","id"=>$data->getPrimaryKey())',
                'options' => array(
                    'target' => '_blank',
                    'class' => 'not-link btn btn-sm btn-info text-left',
                    'title' => 'Editar Usuario'
                )
            ),
            'eliminar' => array(
                'imageUrl' => false,
                /* 'imageUrl' => Yii::app()->user->ui->getResource("delete.png"), */
                'label' =>  '<i class="fa fa-trash-o"></i>  Eliminar',  /* CrugeTranslator::t('admin', 'Delete User'), */
                'url' => 'array("usermanagementdelete","id"=>$data->getPrimaryKey())',
                'options' => array(
                    'class' => 'not-link btn btn-sm btn-danger',
                    'title' => 'Eliminar Usuario'
                )
            ),
        ),
    );
    $this->widget(Yii::app()->user->ui->CGridViewClass, array(
        'dataProvider' => $dataProvider,
        'itemsCssClass' => 'table table-hover table-nomargin table-bordered',
        'pagerCssClass' => 'table-pagination',
        'pager' => array(
            'htmlOptions' => array('class' => 'pagination'),
            'selectedPageCssClass' => 'active',
        ),
        'columns' => $cols,
        'filter' => $model,
    ));
    ?>
</div>