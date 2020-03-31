<?php

class TccdController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		// $this->render('view',array(
		// 	'model'=>$this->loadModel($id),
		// ));
		$model = $this->loadModel($id);
		echo CJSON::encode($model);
		return $model;

	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Tccd;
		if(isset($_POST['name']) && $_POST['name']=='TCCA_New'){
			// print_r($_POST);
				// $model=new Tcca;
				$model->TCCD_Title = $_POST['value'];
				$model->TCCA_Id=$_POST['pk'];
				// $model->TCCA_BoardId=$id;
				// $model->TCCA_Type=1;			

				if($model->save()){
					echo CJSON::encode(					
						array('id'=>$model->TCCD_Id,
						'board'=>$model->TCCA_Id,
						'title'=>$model->TCCD_Title)
					);
					return $model;

			 }else{
				throw new CHttpException(404,'The requested page does not exist.');
			 }
		}
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Tccd']))
		{
			$model->attributes=$_POST['Tccd'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->TCCD_Id));
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

		if(isset($_POST['Tccd']))
		{
			$model->attributes=$_POST['Tccd'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->TCCD_Id));
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Tccd');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Tccd('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Tccd']))
			$model->attributes=$_GET['Tccd'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Tccd the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Tccd::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Tccd $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tccd-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
