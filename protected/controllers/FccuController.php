<?php

class FccuController extends Controller {

    public $layout = '//layouts/column2';

    public function actionAdd() {
        $buenas = "";
        $malas = "";

        if (isset($_POST['Fccu'])) {

            if ($_POST['Fccu']['FCUU_Id'] !=2) {

                // print_r($_POST['Fccu']);
                $fccu_serial = $_POST['Fccu']['FCCU_Serial'];
                $fcct_id = $_POST['Fccu']['FCCT_Id'];

                foreach ($fccu_serial as $key => $value) {

                    $model = new Fccu;
                    $model->FCCU_Serial = str_replace(" ", "", $value);
                    $model->FCCU_Facturado = 0; //false
                    $model->FCCI_Id = $_POST['Fccu']['FCCI_Id']; //almacen 2
                    // $model->FCUU_Id = $_POST['Fccu']['FCUU_Id']; //tipo equipo
                    $model->FCCU_Cantidad = 1;
                    $model->FCCD_Id = 5;
                    $model->FCCU_Descripcion = "Sin Comentarios";
                    $model->FCCT_Id = $fcct_id[$key]; //modelo
                    try {
                        if ($model->save()) {
                            $buenas = $buenas . "Se guardo item " . $value . "</br>";
                        } else {
                            //print_r( $model->getErrors());
                        }
                    } catch (Exception $exc) {
                       echo $exc->getCode();
                       echo serialize($model->getErrors()) ;
                        $malas = $malas . "No se pudo con este " . $model->FCCU_Serial . " </br>"; //;
                    }
                }
                echo $malas . $buenas;
                return;
            } else if ($_POST['Fccu']['FCUU_Id'] == 2) {

                //print_r($_POST['Fccu']);
                $fccu_serial = $_POST['Fccu']['FCCU_Serial'];
                $fcct_id = $_POST['Fccu']['FCCT_Id'];
                $FCCU_Numero = $_POST['Fccu']['FCCU_Numero'];
                $FCCU_MontoMin = $_POST['Fccu']['FCCU_MontoMin'];
                $FCCU_DiaCorte = $_POST['Fccu']['FCCU_DiaCorte'];

                foreach ($fccu_serial as $key => $value) {  
                    $model = new Fccu;
                    $model->FCCU_Serial =str_replace(" ", "", $value);
                    $model->FCCU_Facturado = 0; //false
                    $model->FCCI_Id = $_POST['Fccu']['FCCI_Id']; //almacen 2
                    //  $model->FCUU_Id = $_POST['Fccu']['FCUU_Id']; //tipo equipo
                    $model->FCCU_Cantidad = 1;
                    $model->FCCD_Id = $_POST['Fccu']['FCCD_Id'];
                    $model->FCCU_MontoMin = $FCCU_MontoMin[$key];
                    $model->FCCU_DiaCorte = $FCCU_DiaCorte[$key];
                    $model->FCCU_TipoServicio = $_POST['Fccu']['FCCU_TipoServicio'];
                    $model->FCCU_Numero =trim( preg_replace( "/[\\x00-\\x20]+/" , "" , $FCCU_Numero[$key] ) , "\\x00-\\x20" );
                    $model->FCCU_Descripcion = "Sin Comentarios";
                    $model->FCCT_Id = $fcct_id; //modelo
                    try {
                        if ($model->save()) {
                            $buenas = $buenas . "Se guardo item " . $value . "</br>";
                        }
                    } catch (Exception $exc) {
                        throw new CHttpException(500,$exc->getMessage());
                        $malas = $malas . "No se pudo con este " . $model->FCCU_Serial . "</br>"; //$exc->getTraceAsString();
                    }
                }
                echo $malas . $buenas;
                return;
            }
        } else {
            $this->render('add', array(
                'model' => new Fccu,
            ));
        }
    }

    public function actionRecibe($id) {
        //echo $id;

        $criteria = new CDbCriteria;
        $criteria->select = 'max(FCCO_Lote) AS FCCO_Lote';
        $row = Fcco::model()->find($criteria);
        $somevariable = $row['FCCO_Lote'] + 1;

        $inventario = Fcco::model()->find('FCCO_Enabled = 1 and FCCN_Id = 1 and FCCU_Id=' . $id . ' order by FCCO_Timestamp DESC');
        $inventario->FCCO_Enabled = 0; // deshabilito los anteriores

        $model = new Fcco;
        $model->FCCO_Timestamp = date('Y-m-d H:i:s');
        $model->FCCO_Lote = $somevariable;
        $model->FCCO_Descripcion = $inventario->FCCO_Descripcion;
        $model->FCCO_Enabled = 1;
        $model->FCCN_Id = 2;
        $model->FCCU_Id = $inventario->FCCU_Id;
        $model->GCCA_Id = $inventario->GCCA_Id;
        $model->GCCD_Id = $inventario->GCCD_Id;

        //$item = $this->loadModel($id);
        $item = Fccu::model()->find('FCCU_Id = ' . $id);
        $item->FCCI_Id = 2; //cambia de estado al seleccionado

        if ($inventario->save() && $model->save() && $item->save()) {
            echo "ok";

            //echo $item->FCCU_Id . " actualizado en " . $model->FCCO_Id;
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else {
            echo "error";
        }
//
//
//        
    }
/*Funcion para agregar comunicaciones nuevas, lista los modelos*/
   public function actionRellenarmodos() {
       $id = $_POST['Fccu']['FCCA'];

       $lista = Fcct::model()->findAll('FCCA_Id = ' . $id);
       $lista = CHtml::listData($lista, 'FCCT_Id', 'FCCT_Descripcion');
       echo CHtml::tag('option', array('value' => ''), 'Seleccione modelo...', true);
       foreach ($lista as $valor => $nombre) {
           echo CHtml::tag('option', array('value' => $valor), CHtml::encode($nombre), true);
       }
   }
/*Funcion para agregar equipos nuevos, lista los modelos*/
    public function actionRellenar() {
        $id = $_POST['Fccu']['FCCA_Id_Master'];

        $lista = Fcct::model()->findAll('FCCA_Id = ' . $id);
        $lista = CHtml::listData($lista, 'FCCT_Id', 'FCCT_Descripcion');
        echo CHtml::tag('option', array('value' => ''), 'Seleccione modelo...', true);
        foreach ($lista as $valor => $nombre) {
            echo CHtml::tag('option', array('value' => $valor), CHtml::encode($nombre), true);
        }
    }

    public function actionView($id) {

        ignore_user_abort(true);
        set_time_limit(0);

        $modelo = new Fcco('search');
        $modelo->unsetAttributes();
        $modelo->desde = date('2000-01-01');
        $modelo->hasta = date('2025-01-01');

        $modelo->FCCU_Id = $id; 
        // da madre error de constraint ambiguos


        $this->render('view', array(
            'model' => $this->loadModel($id), 
            'modelo' => $modelo,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
//        $this->redirect(array('view', 'id' => $model->FCCU_Id));
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Fccu'])) {
            $model->attributes = $_POST['Fccu'];

            if ($model->FCCS_Id == '')
                $model->FCCS_Id = null;

            if ($model->save())
                $this->redirect(array('view', 'id' => $model->FCCU_Id));
        }
        if(  !Yii::app()->user->checkAccess('Inventario') ){
             $this->redirect(array('view', 'id' => $model->FCCU_Id));
        }else{
            
            $this->render('update', array(
                'model' => $model,
            ));
        
        }
    }

    public function actionCreate() {
        $model = new Fccu();
//        $this->redirect(array('view', 'id' => $model->FCCU_Id));
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Fccu'])) {
            $model->attributes = $_POST['Fccu'];

            if ($model->FCCS_Id == '')
                $model->FCCS_Id = null;
            try {
                if ($model->save()) {
                    $this->redirect(array('view', 'id' => $model->FCCU_Id));
                }
            } catch (Exception $exc) {
                echo $exc->getMessage();
                print_r($model->getErrors());
                //$malas = $malas . "No se pudo con este " . $model->FCCU_Serial . " </br>"; //;
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {

        $model = $this->loadModel($id);
        $this->redirect(array('view', 'id' => $model->FCCU_Id));


//        $this->loadModel($id)->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//        if (!isset($_GET['ajax']))
//            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionAdmin() {
        $model = new Fccu('search');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Fccu']))
            $model->attributes = $_GET['Fccu'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = Fccu::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'fccu-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
