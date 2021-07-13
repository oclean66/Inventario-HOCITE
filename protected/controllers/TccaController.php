<?php

class TccaController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	
	public function actionLista() {
		$id = $_POST['Tccd']['TCCA_BoardId'];

		$lista = Tcca::model()->findAll('TCCA_BoardId = ' . $id);
		$lista = CHtml::listData($lista, 'TCCA_Id', 'TCCA_Name');
		echo CHtml::tag('option', array('value' => ''), 'Selecciona una Lista...', true);
		foreach ($lista as $valor => $nombre) {
			echo CHtml::tag('option', array('value' => $valor), CHtml::encode($nombre), true);
		}
	}

	public function actionComment(){
		
		$event = new Tcct;
		$event->TCCT_Timestamp = date('Y-m-d h:i');
		$event->TCCT_Type = 'comento';
		$event->TCCT_IdUser = Yii::app()->user->id;
		$event->TCCT_Text = $_POST['comment'];
		$event->TCCD_Id = $_POST['idCard'];
		$event->save();

		$subcribed = Tccm::model()->find('TCCM_IdUser=:id and TCCM_IdModel=:model',array(':id'=>Yii::app()->user->id,':model'=>$_POST['idCard']));
		if(!isset($subcribed)){
			// echo "No se encontro";
			$access = new Tccm;
			$access->TCCM_IdModel=$_POST['idCard'];
			$access->TCCM_Model="TCCD";
			$access->TCCM_IdUser = Yii::app()->user->id;
			$access->TCCM_Status='Subscriber';
			$access->save();
		}
		
		
		$card = Tccd::model()->find('TCCD_Id=:id',array(':id'=>$_POST['idCard']));
		$users = Tccm::model()->findAll('TCCM_Model="TCCD" and TCCM_IdModel=:id',array(':id'=>$_POST['idCard']));
		
		foreach ($users as $value) {
			if(Yii::app()->user->id!=$value->TCCM_IdUser)
			$this-> sendNotification(
				$id=$value->TCCM_IdUser, 				
				$title = "<b>".Yii::app()->user->name."</b> comento en la tarjeta <b>".$card->TCCD_Title."</b>: '".$_POST['comment']."...'",
				$url = Yii::app()->createUrl('tcca/view',array('id'=>$card->tCCA->TCCA_BoardId,'card'=>$_POST['idCard']))						
			);
		}
		echo "Guardado";
	}
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		ini_set('memory_limit', '-1');
		if(isset($_POST['name']) && $_POST['name']=='TCCA_New'){
			// print_r($_POST);
				$model=new Tcca;
				$model->TCCA_Name = $_POST['value'];
				$model->TCCA_BoardId=$id;
				$model->TCCA_Type=1;			
				$model->TCCA_Order=	Tcca::model()->count('TCCA_BoardId='.$id);

				if($model->save()){
					echo $model->TCCA_Name;
					return $model;

			 }else{
				throw new CHttpException(404,'The requested page does not exist.');
			 }
		}
		$board=array();

		$admin = false;

		$listas = Tcca::model()->findAll('TCCA_Type=1 and TCCA_BoardId =:id and TCCA_Archived is null order by TCCA_Order',array('id'=>$id));
		foreach ($listas as  $value) {
			$board[]=array(
				'TCCA_Id'=>$value->TCCA_Id,
				'TCCA_Name'=>$value->TCCA_Name,
				'TCCA_Order'=>$value->TCCA_Order,
				'TCCA_Tasks'=>Tccd::model()->findAll('TCCA_Id =:id and TCCD_Hide is null order by TCCD_Created asc',array('id'=>$value->TCCA_Id)),
				//tambien por TCCD_Order
			);
		}

		$users = Yii::app()->user->um->searchUsersByAuthItem('Tableros',100)->data;
		$accesos = Tccm::model()->findAll("TCCM_IdModel=:id and TCCM_Model='TCCA'",array(':id'=>$id));
		$fusers="";
		$lista = array();


		foreach ($users as $user) {
			$fusers.="{id: '".$user->iduser."', text: '".$user->username."'},";
			$lista[$user->iduser]=array(
				'iduser'=>$user->iduser,
				'username'=>$user->username,
				'email'=>$user->email,
				'status'=>false
			);
		}
		foreach ($accesos as $user) {
			if(isset($lista[$user->TCCM_IdUser]))
			$lista[$user->TCCM_IdUser]['status']=$user->TCCM_Status;

			if(Yii::app()->user->id == $user->TCCM_IdUser && $user->TCCM_Status=="Administrador" ){
				$admin = true;
			}
			
		}

		$tags = Tccl::model()->findAll();
		$ftags="";
		foreach ($tags as $tag) {
			$ftags.="{id: '".$tag->TCCL_Id."', text: '".$tag->TCCL_Label."'},";
		}

		$temporal = Gcca::model()->findAll();
		$agencias =array();
		$fagencias="";
        foreach ($temporal as $value) {
            $fagencias.="{id: '".$value->GCCA_Id."', text: '".$value->GCCA_Cod." - ".$value->GCCA_Nombre."'},";
            $agencias[$value->GCCA_Id]=array(
				'id'=>$value->GCCA_Id,
				'cod'=>$value->GCCA_Cod,
				'name'=>$value->GCCA_Nombre,
				// 'status'=>false
			);
        }
		// print_r($accesos);
		// print_r($users);
		
		$tempo = Fccu::model()->findAll();
		$activos =array();
		$factivos="";
        foreach ($tempo as $value) {
            $factivos.="{id: '".$value->FCCU_Id."', text: '".$value->FCCU_Serial."'},";
            $activos[$value->FCCU_Id]=array(
				'id'=>$value->FCCU_Id,
				'cod'=>$value->FCCU_Serial,
			);
        }
		

		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'lists'=>$board,
			'admin'=>$admin,
			'users'=>$lista,
			'jusers'=>$fusers,
			'tags'=>$ftags,
			'agencias'=>$agencias,
			'jagencias'=>$fagencias,
			'jactivos'=>$factivos
			
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Tcca;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Tcca']))
		{
			$model->attributes=$_POST['Tcca'];
			if($model->save()){
				$access = new Tccm;
				$access->TCCM_IdModel=$model->TCCA_Id;
				$access->TCCM_Model="TCCA";
				$access->TCCM_IdUser = Yii::app()->user->id;
				$access->TCCM_Status='Administrador';
				$access->save();
				$this->redirect(array('view','id'=>$model->TCCA_Id));

			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Tcca']))
		{
			$model->attributes=$_POST['Tcca'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->TCCA_Id));
		}

		if(isset($_POST['name']) && $_POST['name']=='TCCA_Name'){
			// print_r($_POST);
			 $model->TCCA_Name = $_POST['value'];
			 if($model->save()){
				 echo $model->TCCA_Name;
				 return $model;

			 }else{
				throw new CHttpException(404,'The requested page does not exist.');
			 }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		$model->TCCA_Archived = date('Y-m-d H:i');
		$model->save();
		echo "Archived";
		
	}
	public function actionDeleteAll($id)
	{
		// Tcca::model()->update
		Tccd::model()->updateAll(array('TCCD_Archived'=>date("Y-m-d")),'TCCA_Id="'.$id.'"');


		// $model = $this->loadModel($id);
		// $model->TCCA_Archived = date('Y-m-d H:i');
		// $model->save();
		echo "All Archived";
		
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{

		$data['tablero'] = Tcca::model()->count('TCCA_Type=0 and TCCA_Archived is null and TCCA_ViewBy="BOARD"');
		$data['tabla'] = Tcca::model()->count('TCCA_Type=0 and TCCA_Archived is null and TCCA_ViewBy="TABLA"');

		$model=new Tcca;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Tcca']))
		{
			$model->attributes=$_POST['Tcca'];
			$model->TCCA_BoardId=null;
			$model->TCCA_Type=0;
			if($model->save()){
				$access = new Tccm;
				$access->TCCM_IdModel=$model->TCCA_Id;
				$access->TCCM_Model="TCCA";
				$access->TCCM_IdUser = Yii::app()->user->id;
				$access->TCCM_Status='Administrador';
				$access->save();
				// print_r($access);
				$this->redirect(array('view','id'=>$model->TCCA_Id));
			}
		}
		$tableros = Tccm::model()->findAll('TCCM_Model="TCCA" and TCCM_IdUser=:user',array(':user'=>Yii::app()->user->id));
		
		if(Yii::app()->user->isSuperAdmin)
			$tableros = Tccm::model()->findAll('TCCM_Model="TCCA" group by TCCM_IdModel');
		
		$dataProvider=array();
		foreach ($tableros as $tablero) {
			$board=Tcca::model()->find('TCCA_Type=0 and TCCA_Id =:id order by TCCA_Archived, TCCA_Name',array(':id'=>$tablero->TCCM_IdModel));
			if(isset($board))
			$dataProvider[]=array(
				'TCCA_Id'=>$board->TCCA_Id,
				'TCCA_Name'=>$board->TCCA_Name,
				'TCCA_Archived'=>$board->TCCA_Archived
			);
			# code...
		}
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'model'=>$model,
			'data'=>$data
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Tcca('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Tcca']))
			$model->attributes=$_GET['Tcca'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Tcca the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Tcca::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Tcca $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tcca-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
