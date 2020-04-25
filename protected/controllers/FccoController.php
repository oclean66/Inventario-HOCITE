<?php

class FccoController extends Controller {

    public $layout = '//layouts/column2'; 

    public function actionReport($FCCN_Id = null) {
        $model = new Fcco('search');
        $model->unsetAttributes();  // clear any default values
       
        if (isset($_POST['desde']) && isset($_POST['hasta'])) {
            $model->desde = strftime("%Y-%m-%d", strtotime($_POST['desde']));
            $model->hasta = strftime("%Y-%m-%d", strtotime($_POST['hasta']));

            if( $model->desde == $model->hasta ){
                $model->hasta = date('Y-m-d', strtotime($model->desde . ' +1 day'));
            }

            // $model->FCCO_Timestamp = strftime("%Y-%m-%d", strtotime($_POST['datepicker']));
        } 
        else {
            $model->FCCO_Timestamp = date('Y-m-d');
            $model->desde = date('Y-m-d');
            $model->hasta = date('Y-m-d', strtotime($model->desde . ' +1 day'));
        }

        $model->FCCN_Id = $FCCN_Id;
        if (isset($_GET['Fcco']))
            $model->attributes = $_GET['Fcco'];

        $this->render('report', array(
            'model' => $model, 'FCCN_Id' => $FCCN_Id,'desde'=>$model->desde,'hasta'=>$model->hasta
        ));
    }

    public function actionLess() {

        if (isset($_POST['Fcco'])) {
            // print_r($_POST['Fcco']);
            // $salida = array();
            $array = $_POST['Fcco']['FCCU_Id'];
            $criteria = new CDbCriteria;
            $criteria->select = 'max(FCCO_Lote) AS FCCO_Lote';
            $row = Fcco::model()->find($criteria);
            $somevariable = $row['FCCO_Lote'] + 1;
            foreach ($array as $key => $value) {

                $inventario = Fcco::model()->find('FCCO_Enabled = 1 and FCCN_Id = 1 and FCCU_Id=' . $value . ' order by FCCO_Timestamp DESC');
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

                $item = Fccu::model()->find('FCCU_Id = ' . $value);
                $item->FCCI_Id = $_POST['Fcco']['FCCI_Id'][$key]; //cambia de estado al seleccionado

                if ($inventario->save() && $model->save() && $item->save()) {
            //$salida[]=array('serial'=>$inventario->FCCU_Id, 'descripcion'=> $item->fCCU->fCCT->fCCA->FCCA_Descripcion . " " . $item->fCCU->fCCT->FCCT_Descripcion . " | " . $item->fCCU->FCCU_Numero, 'lugar'=>$item->lugar);

                    echo $item->FCCU_Id . " actualizado en " . $model->FCCO_Id;
                }
            }
            $this->redirect(array('enter', 'id' => $somevariable, 'tipo' => 2));
        } else {
            $this->render('less', array(
                'model' => new Fccu,
            ));
        }
    }

    public function actionView($id, $tipo = null, $view = null) {
        if ($tipo == null)
            $tipo = 1;

        $model = Fcco::model()->findAll("FCCO_Lote=:lote and FCCN_Id =:tipo", array(':lote' => $id, ':tipo' => $tipo));

        if ($view === null)
            $this->render('view', array(
                'modelo' => $model, 'tipo' => $tipo
            ));
        else
            $this->renderPartial('view', array(
                'modelo' => $model, 'tipo' => $tipo
            ));
    }

    public function actionRecibe($id) {
        // echo $id;

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
        //
        //        $item = $this->loadModel($id);
        $item = Fccu::model()->find('FCCU_Id = ' . $id);
        $item->FCCI_Id = 2; //cambia de estado al seleccionado

        if ($inventario->save() && $model->save() && $item->save()) {

        //            echo $item->FCCU_Id . " actualizado en " . $model->FCCO_Id;
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('fcco/agencia/' . $inventario->GCCA_Id . "?type=1"));
        } else {
            echo "error";
        }
       
    }

    public function actionEnter($id, $tipo = null, $view = null) {
        if ($tipo == null)
            $tipo = 1;
        $model = Fcco::model()->findAll("FCCO_Lote=:lote and FCCN_Id =:tipo", array('lote' => $id, 'tipo' => $tipo));


        $this->render('enter', array(
            'modelo' => $model, 'tipo' => $tipo
        ));
    }

    public function actionActivos() {
        $request = trim($_GET['term']);
        if ($request != '') {
            $model = Fccu::model()->findAll(array("condition" => "FCCI_Id =2 and (FCCU_Serial like '$request%' or FCCU_Numero like '$request%')"));
            $data = array();
            foreach ($model as $item) {
                $data[] = array(
                    'id' => $item->FCCU_Id,
                    'value' => $item->FCCU_Serial,
                    'label' => $item->FCCU_Serial . " | " . $item->fCCT->fCCA->FCCA_Descripcion . " " . $item->fCCT->FCCT_Descripcion . " | " . $item->FCCU_Numero,
                    'descrip' => $item->fCCT->fCCA->FCCA_Descripcion . " " . $item->fCCT->FCCT_Descripcion . " | " . $item->FCCU_Numero,
                    'numero' => $item->FCCU_Numero,
                );

                // $data[] = $get->FCCU_Serial;
            }
            $this->layout = 'empty';
            echo json_encode($data);
        }
    }

    public function actionAsignados() {
        $request = trim($_GET['term']);
        if ($request != '') {
            $model = Fccu::model()->findAll(array("condition" => "FCCI_Id =5 and (FCCU_Serial like '$request%' or FCCU_Numero like '$request%')"));
            $data = array();
            foreach ($model as $item) {
                $data[] = array(
                    'id' => $item->FCCU_Id,
                    'value' => $item->FCCU_Serial,
                    'label' => $item->FCCU_Serial . " | " . $item->fCCT->fCCA->FCCA_Descripcion . " " . $item->fCCT->FCCT_Descripcion . " | " . $item->FCCU_Numero,
                    'descrip' => $item->fCCT->fCCA->FCCA_Descripcion . " " . $item->fCCT->FCCT_Descripcion . " | " . $item->FCCU_Numero,
                    'numero' => $item->FCCU_Numero,
                    'lugar' => Fcco::model()->find(array("condition" => "FCCU_Id = '$item->FCCU_Id' and FCCO_Enabled = 1"))->getLugar()
                );

                // $data[] = $get->FCCU_Serial;
            }
            $this->layout = 'empty';
            echo json_encode($data);
        }
    }

    public function actionGrupo($id, $type = null) {
        $grupo = Gccd::model()->find('GCCD_Id=:id', array(':id' => $id));
        $model = new Fcco('search');
        $model->unsetAttributes();  // clear any default values
        $model->GCCD_Id = "=" . $id; //array de gccd hijos, actualmente solo veo inventario propio del grupo
        $model->FCCN_Id = "=1"; //operacion: asignados
        $model->FCCO_Enabled = "=1"; //asignado actualmente



        $count = array();

        //--Estadisticas rapidas

        $count['CPU'] = Yii::app()->db->createCommand("Select count(*) as CPU from fcco, fccu, fcct, fcca, fcuu, gcca, gccd where fcco.FCCO_Enabled = 1 and fcco.FCCN_Id = 1 and fcco.FCCU_Id = fccu.FCCU_Id and fccu.FCCT_Id = fcct.FCCT_Id and fcct.FCCA_Id = fcca.FCCA_Id and fcca.FCUU_Id = fcuu.FCUU_Id and fcco.GCCA_Id = gcca.GCCA_id and gcca.GCCD_Id = gccd.GCCD_id and gccd.GCCD_Id = '" . $id . "' and fcca.FCCA_Id = 11 ")->queryRow();
        $count['Conexiones'] = Yii::app()->db->createCommand("Select count(*) as Conexiones from fcco, fccu, fcct, fcca, fcuu, gcca, gccd where fcco.FCCO_Enabled = 1 and fcco.FCCN_Id = 1 and fcco.FCCU_Id = fccu.FCCU_Id and fccu.FCCT_Id = fcct.FCCT_Id and fcct.FCCA_Id = fcca.FCCA_Id and fcca.FCUU_Id = fcuu.FCUU_Id and fcco.GCCA_Id = gcca.GCCA_id and gcca.GCCD_Id = gccd.GCCD_id and gccd.GCCD_Id = '" . $id . "' and fcuu.FCUU_Id = 2 ")->queryRow();
        $count['Monitores'] = Yii::app()->db->createCommand("Select count(*) as Monitores from fcco, fccu, fcct, fcca, fcuu, gcca, gccd where fcco.FCCO_Enabled = 1 and fcco.FCCN_Id = 1 and fcco.FCCU_Id = fccu.FCCU_Id and fccu.FCCT_Id = fcct.FCCT_Id and fcct.FCCA_Id = fcca.FCCA_Id and fcca.FCUU_Id = fcuu.FCUU_Id and fcco.GCCA_Id = gcca.GCCA_id and gcca.GCCD_Id = gccd.GCCD_id and gccd.GCCD_Id = '" . $id . "' and fcct.FCCA_Id = 12 ")->queryRow();
        $count['Impresoras'] = Yii::app()->db->createCommand("Select count(*) as Impresoras from fcco, fccu, fcct, fcca, fcuu, gcca, gccd where fcco.FCCO_Enabled = 1 and fcco.FCCN_Id = 1 and fcco.FCCU_Id = fccu.FCCU_Id and fccu.FCCT_Id = fcct.FCCT_Id and fcct.FCCA_Id = fcca.FCCA_Id and fcca.FCUU_Id = fcuu.FCUU_Id and fcco.GCCA_Id = gcca.GCCA_id and gcca.GCCD_Id = gccd.GCCD_id and gccd.GCCD_Id = '" . $id . "' and fcct.FCCA_Id = 13 ")->queryRow();
        $count['Maquinitas'] = Yii::app()->db->createCommand("Select count(*) as Maquinitas from fcco, fccu, fcct, fcca, fcuu, gcca, gccd where fcco.FCCO_Enabled = 1 and fcco.FCCN_Id = 1 and fcco.FCCU_Id = fccu.FCCU_Id and fccu.FCCT_Id = fcct.FCCT_Id and fcct.FCCA_Id = fcca.FCCA_Id and fcca.FCUU_Id = fcuu.FCUU_Id and fcco.GCCA_Id = gcca.GCCA_id and gcca.GCCD_Id = gccd.GCCD_id and gccd.GCCD_Id = '" . $id . "' and fcct.FCCA_Id = 4 ")->queryRow();
        if (isset($_GET['Fcco'])) {

            $model->attributes = $_GET['Fcco'];
            $model->GCCD_Id = "=" . $id; //array de gccd hijos, actualmente solo veo inventario propio del grupo
            $model->FCCN_Id = "=1"; //operacion: asignados
            $model->FCCO_Enabled = "=1"; //asignado actualmente
        }
        $model->desde = date('2000-01-01');
        $model->hasta = date('2025-01-01');

        if ($type == null) {
            $this->renderPartial('grupo', array(
                'model' => $model, 'count' => $count, 'type' => $type, 'grupo' => $grupo,
            ));
        } else {
            $this->render('grupo', array(
                'model' => $model, 'count' => $count, 'type' => $type, 'grupo' => $grupo,
            ));
        }

        //        $this->render('grupo', array(
        //            'model' => $model, 'count' => $count
        //        ));
    }

    public function actionAgencia($id, $type = null) {

        $agencia = Gcca::model()->find('GCCA_Id=:id', array(':id' => $id));
        $model = new Fcco('search');
        $model->unsetAttributes();  // clear any default values
        $model->GCCA_Id = "=" . $id;

        $model->FCCO_Enabled = 1; //asignado actualmente
        $model->FCCN_Id = 1; //operacion asignado
        $count = array();

        //--Estadisticas rapidas

        $count['CPU'] = Yii::app()->db->createCommand("Select count(*) as CPU from fcco, fccu, fcct, fcca, fcuu where fcco.FCCO_Enabled = 1 and fcco.FCCN_Id = 1 and fcco.FCCU_Id = fccu.FCCU_Id and fccu.FCCT_Id = fcct.FCCT_Id and fcct.FCCA_Id = fcca.FCCA_Id and fcca.FCUU_Id = fcuu.FCUU_Id and fcco.GCCA_Id = '" . $id . "' and  fcca.FCCA_Id = 11 ")->queryRow();
        $count['Conexiones'] = Yii::app()->db->createCommand("Select count(*) as Conexiones from fcco, fccu, fcct, fcca, fcuu where fcco.FCCO_Enabled = 1 and fcco.FCCN_Id = 1 and  fcco.FCCU_Id = fccu.FCCU_Id and fccu.FCCT_Id = fcct.FCCT_Id and fcct.FCCA_Id = fcca.FCCA_Id and fcca.FCUU_Id = fcuu.FCUU_Id and fcco.GCCA_Id = '" . $id . "' and   fcuu.FCUU_Id = 2 ")->queryRow();
        $count['Monitores'] = Yii::app()->db->createCommand("Select count(*) as Monitores from fcco, fccu, fcct, fcca, fcuu where fcco.FCCO_Enabled = 1 and fcco.FCCN_Id = 1 and  fcco.FCCU_Id = fccu.FCCU_Id and fccu.FCCT_Id = fcct.FCCT_Id and fcct.FCCA_Id = fcca.FCCA_Id and fcca.FCUU_Id = fcuu.FCUU_Id and fcco.GCCA_Id = '" . $id . "' and  fcct.FCCA_Id = 12 ")->queryRow();
        $count['Impresoras'] = Yii::app()->db->createCommand("Select count(*) as Impresoras from fcco, fccu, fcct, fcca, fcuu where fcco.FCCO_Enabled = 1 and fcco.FCCN_Id = 1 and  fcco.FCCU_Id = fccu.FCCU_Id and fccu.FCCT_Id = fcct.FCCT_Id and fcct.FCCA_Id = fcca.FCCA_Id and fcca.FCUU_Id = fcuu.FCUU_Id and fcco.GCCA_Id = '" . $id . "' and  fcct.FCCA_Id = 13 ")->queryRow();
        $count['Maquinitas'] = Yii::app()->db->createCommand("Select count(*) as Maquinitas from fcco, fccu, fcct, fcca, fcuu where fcco.FCCO_Enabled = 1 and fcco.FCCN_Id = 1 and  fcco.FCCU_Id = fccu.FCCU_Id and fccu.FCCT_Id = fcct.FCCT_Id and fcct.FCCA_Id = fcca.FCCA_Id and fcca.FCUU_Id = fcuu.FCUU_Id and fcco.GCCA_Id = '" . $id . "' and  fcct.FCCA_Id = 4 ")->queryRow();




        if (isset($_GET['Fcco'])) {

            $model->attributes = $_GET['Fcco'];
            $model->GCCA_Id = "=" . $id;
            $model->FCCO_Enabled = 1; //asignado actualmente
            $model->FCCN_Id = 1;
        }



        $model->desde = date('2000-01-01');
        $model->hasta = date('2025-01-01');




        if ($type == null) {
            $this->renderPartial('agencia', array(
                'model' => $model, 'count' => $count, 'type' => $type, 'agencia' => $agencia
            ));
        } else {
            $this->render('agencia', array(
                'model' => $model, 'count' => $count, 'type' => $type, 'agencia' => $agencia
            ));
        }
    }

    public function actionCreate($id = null) {

        $model = new Fcco;
        $criteria = new CDbCriteria;
        $criteria->select = 'max(FCCO_Lote) AS FCCO_Lote';
        $row = Fcco::model()->find($criteria);
        $somevariable = $row['FCCO_Lote'] + 1;

        if (isset($_POST['Fcco'])) {
            $x = array();
            $y = array();

            $id = $_POST['Fcco']['FCCU_Id'];
            $id = array_unique($id);

            foreach ($id as $value) {
                $modelo = new Fcco;
                $modelo->attributes = $_POST['Fcco'];
                $modelo->FCCO_Lote = $somevariable;
                $modelo->FCCN_Id = 1;
                $modelo->FCCO_Enabled = 1;
                $modelo->FCCU_Id = $value;

                $item = Fccu::model()->findByPk($value);
                $item->FCCI_Id = 5;

                $inventario = Fcco::model()->findAll('FCCO_Enabled = 1 and FCCU_Id=' . $item->FCCU_Id);

                foreach ($inventario as $inv){               
                    $inv->FCCO_Enabled = 0;
                    $inv->save();
                }

                if ($item->save()) {
                    $modelo->save();
                    $x[] = $value;
                } else {
                    $y[] = $value;
                }
            }

            $this->redirect(array('view', 'id' => $modelo->FCCO_Lote, 'tipo' => 1));
            // print_r($_POST);
        } else {
            $this->render('create', array(
                'model' => $model, 'lote' => $somevariable
            ));
        }
    }

    /*  public function actionUpdate($id) {
      $model = $this->loadModel($id);

      // Uncomment the following line if AJAX validation is needed
      // $this->performAjaxValidation($model);

      if (isset($_POST['Fcco'])) {
      $model->attributes = $_POST['Fcco'];
      if ($model->save())
      $this->redirect(array('view', 'id' => $model->FCCO_Id));
      }

      $this->render('update', array(
      'model' => $model,
      ));
      }

     */

//
    
    public function actionAdmin() {
        $model = new Fcco('search');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Fcco']))
            $model->attributes = $_GET['Fcco'];

        $this->render('admin', array(
            'model' => $model, 'arbol' => Gccd::model()->arbol()
        ));
    }

    public function loadModel($id) {
        $model = Fcco::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'fcco-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}