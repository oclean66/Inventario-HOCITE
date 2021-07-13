<?php

class TccdController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';


	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionLista()
	{
		$id = $_POST['Tccd']['TCCA'];

		$lista = Tcca::model()->findAll('TCCA_Archived is null and TCCA_BoardId = ' . $id);
		$lista = CHtml::listData($lista, 'TCCA_Id', 'TCCA_Name');
		echo CHtml::tag('option', array('value' => ''), 'Selecciona una Lista...', true);
		foreach ($lista as $valor => $nombre) {
			echo CHtml::tag('option', array('value' => $valor), CHtml::encode($nombre), true);
		}
	}

	public function actionhideComment($id)
	{
		$comment = Tcct::model()->find('TCCT_Id=' . $id.' and TCCT_idUser ='.Yii::app()->user->id);
		if(isset($comment)){
			$comment->TCCT_Text = $comment->TCCT_Type . " " . $comment->TCCT_Text;
			$comment->TCCT_Type = "hide";
			if ($comment->save()) {
				echo "ok";
			} else {
				echo "false";
			}
		}else
		echo "false";
		
	}
	public function actionTest()
	{
		Yii::app()->crugemailer->sendEmail(
			'el cuerpo de lo que va a ser enviado en el mensaje',
			array('oclean66@gmail.com'),
			array('soporte.kingdeportes@gmail.com'),
			'Asunto del Correo Electrónico'
		);
	}
	public function actionView($id, $type = "json")
	{



		if ($type == "form") {
			$this->render('view', array(
				'model' => $this->loadModel($id),
			));
		} else {




			$model = $this->loadModel($id);
			$timeline = Tcct::model()->findAll('TCCD_Id=:id', array(':id' => $id));
			$table = "";
			foreach ($timeline as $event) {
				$table = $table . '<tr style="display: table-row;text-decoration:' . ($event->TCCT_Type == 'hide' ? 'line-through' : '') . '">
			<td>
				<span style="color: 
				' . ($event->TCCT_Type == 'comento' ? 'powderblue' : '') . ' 
				' . ($event->TCCT_Type == 'creo' ? 'mediumspringgreen' : '') . '
				' . ($event->TCCT_Type == 'movio' ? 'darkorange' : '') . '
				' . ($event->TCCT_Type == 'edito' ? 'brown' : '') . '
				' . ($event->TCCT_Type == 'archivo' || $event->TCCT_Type == 'desarchivo' ? 'orangered' : '') . '
				' . ($event->TCCT_Type == 'oculto' || $event->TCCT_Type == 'desoculto' ? 'orangered' : '') . '
				' . ($event->TCCT_Type == 'hide' ? 'red' : '') . '
				 ">
								
					<i class="fa 
					' . ($event->TCCT_Type == 'comento' ? 'fa-comment' : '') . ' 
					' . ($event->TCCT_Type == 'creo' ? 'fa-plus' : '') . '
					' . ($event->TCCT_Type == 'movio' ? 'fa-exchange' : '') . '
					' . ($event->TCCT_Type == 'edito' ? 'fa-pencil' : '') . '
					' . ($event->TCCT_Type == 'archivo' || $event->TCCT_Type == 'desarchivo' ? 'fa-save' : '') . '
					' . ($event->TCCT_Type == 'oculto' || $event->TCCT_Type == 'desoculto' ? 'fa-save' : '') . ' 
					' . ($event->TCCT_Type == 'hide' ? 'fa-times' : '') . '
					"></i>

				</span>
				
				<span class="pull-right">' . date("M d, h:i", strtotime($event->TCCT_Timestamp)) . '' . ($event->TCCT_Type == 'comento' ? '<button id="c-' . $event->TCCT_Id . '" style="color:red; border:none" onClick="
				alert(\'¿Deseas eliminar este comentario?\'),
				$.ajax({
					url:\'' .  Yii::app()->createUrl('tccd/hideComment', array('id' => $event->TCCT_Id)) . '\',
					type:\'POST\',
					beforeSend:function(){

					}
				})
				.done(function(){
					$(\'#c-' . $event->TCCT_Id . '\').addClass(\'hide\');
					cargarTarjeta(\'' . $model->TCCD_Id . '\');
				});" 
				type="button"><i class="fa fa-trash-o"></i></button>' : '') . '
				  
				</span>
				
				<a href="#">' . Yii::app()->user->um->loadUserById($event->TCCT_IdUser, true)->username .
					'</a> ' . ($event->TCCT_Type !='hide' ? $event->TCCT_Type : '') . '  
				
				' . ($event->TCCT_Type == 'comento' ? "<b>" . $event->TCCT_Text . "</b>" : '') . '
				' . ($event->TCCT_Type == 'creo' ? $event->TCCT_Text : '') . '
				' . ($event->TCCT_Type == 'edito' ? $event->TCCT_Text : '') . '
				' . ($event->TCCT_Type == 'movio' ? $event->TCCT_Text : '') . '
				' . ($event->TCCT_Type == 'hide' ? $event->TCCT_Text : '') . '
				' . ($event->TCCT_Type == 'archivo' || $event->TCCT_Type == 'desarchivo' ? $event->TCCT_Text : '') . '
				' . ($event->TCCT_Type == 'oculto' || $event->TCCT_Type == 'desoculto' ? $event->TCCT_Text : '') . '
				
			</td>
			</tr>';
			}
			/*$baseUrl = Yii::app()->theme->baseUrl;
			$avatar = Yii::app()->user->um->getFieldValueInstance($cols->TCCM_IdUser, "avatar");  
            if($avatar != ''){
				$profPic = $avatar;
            }else{
				$profPic = $baseUrl . '/img/avatars/user.png';
            } */
			$labels = $model->tccls;
			$cols = Tccm::model()->findAll('TCCM_Model="TCCD" and TCCM_Status="Colaborador" and TCCM_IdModel=:id', array(":id" => $id));
			$pagencias = Tcga::model()->findAll('TCCD_Id=:id', array(":id" => $id));
			$act = TccdHasFccu::model()->findAll('TCCD_Id=:id', array(':id' => $id));
			// print_r($cols);
			$colaboradores = "";
			$agencias = "";
			$activos = "";
			$tags = "";
			$tagVal = '';
			$usersVal = '';
			$activosVal = '';
			$agenciasVal = '';
			foreach ($labels as $tag) {
				$tagVal .= $tag->TCCL_Id . ',';
				$tags .= '<h5 style="display:inline"><span class="label label-' . $tag->TCCL_Color . '" style="padding:5px;margin-right:3px"><i class="fa ' . $tag->TCCL_Icon . '"></i> ' . $tag->TCCL_Label . '</span></h5>';
			}
			foreach ($cols as $key) {
				$usersVal .= $key->TCCM_IdUser . ',';
				$colaboradores .= '<h5 style="display:inline"><span class="badge" style="padding:5px;margin-right:3px;"><i class="fa fa-user"></i> ' . Yii::app()->user->um->loadUserById($key->TCCM_IdUser)->username . '</span></h5>';/* <img width="30" src="'.  $profPic  .'" alt=""> */
			}
			foreach ($pagencias as $key) {
				$agenciasVal .= $key->GCCA_Id . ',';
				$agencias .= '<div class="alert alert-warning" style="padding:5px;margin-right:3px;margin-bottom:5px;"><i class="fa fa-desktop"></i> ' . $key->gCCA->GCCA_Cod . " - " . $key->gCCA->GCCA_Nombre . '<br/>Telefono: ' . $key->gCCA->GCCA_Telefono . '</br>Direccion: ' . $key->gCCA->GCCA_Direccion . '</div>';
			}
			foreach ($act as $key) {
				$activosVal .= $key->FCCU_Id . ',';
				$activos .= '<div class="alert alert-warning" style="padding:5px;margin-right:3px;margin-bottom:5px;"><i class="fa fa-thumb-tack"></i> ' . $key->fccu->FCCU_Serial . " - " . $key->fccu->fCCT->fCCA->FCCA_Descripcion . " (" . $key->fccu->fCCT->FCCT_Descripcion . ')</div>';
			}


			echo CJSON::encode(
				array(
					$model,
					'<div class="row">					
				<div class="col-sm-9">

					<h4 class="modal-title" id="myModalLabel">
						<a href="#" 
							data-url="' . Yii::app()->createUrl('tccd/update', array('id' => $model->TCCD_Id)) . '" 
							class="taskTitle" 
							id="TCCD_Title" 
							data-pk="' . $model->TCCD_Id . '" 
							data-id="' . $model->TCCD_Id . '" 
							data-placement="right">' . $model->TCCD_Title . '</a>
					</h4>

					<span>En la Lista <b>' . $model->tCCA->TCCA_Name . '</b>, creada ' . date("d M, h:ia", strtotime($model->TCCD_Created)) . '</span>

						' . (count($labels) > 0 ? '<br/><br/>
							<h5 style="margin-top:5px;font-weight:bolder;">Etiquetas</h5>' . $tags : "") . '					

						' . (count($cols) > 0 ? '<br/><br/>
							<h5 style="margin-top:5px;font-weight:bolder;">Colaborador</h5>' . $colaboradores : "") . '

						' . (count($pagencias) > 0 ? '<br/><br/>
							<h5 style="margin-top:5px;font-weight:bolder;">Agencias</h5><div style="max-height:150px;overflow:auto;">' . $agencias . '</div>' : "") . '
							
						' . (count($act) > 0 ? '<br/>
							<h5 style="margin-top:5px;font-weight:bolder;">Activos</h5><div style="max-height:150px;overflow:auto;">' . $activos . '</div>' : "") . '
					
								<h5 style="margin-top:5px;font-weight:bolder;">Descripcion</h5>
					<p 
						id="TCCD_Description" 
						class="description" 
						style="white-space: normal; padding: 10px; background-color: rgb(238, 238, 238);border-radius: 5px;font-weight: bolder; display: block;"								   
						
						data-tpl=\'<textarea class="form-control" style="width:100%;height: 99px;" cols="250" rows="4" ></textarea>
							<div class="shortcuts" style="border:0px;">
								<small>Enviar con <code>CTRL + ENTER</code> Cancelar con <code>ESC</code></small>
							</div>\' 
						data-url="' . Yii::app()->createUrl('tccd/update', array('id' => $model->TCCD_Id)) . '" 
						
						data-type="textarea" 
						data-showbuttons= "bottom"
						data-pk="' . $model->TCCD_Id . '" 
						data-id="' . $model->TCCD_Id . '" 
						data-mode="inline"
						data-title="Descripcion de la Tarea">
						' . $model->TCCD_Description . '
						</p>
													

					<div class="box box-color box-bordered orange" style="margin-bottom:10px;">
						<div class="box-title">
							<h3>
								<i class="fa fa-bullhorn"></i> Actividad Reciente
							</h3>
							
						</div>
						<div class="box-content" id="activity" style="padding:0;max-height: 350px;overflow: auto;">
							<table class="table table-nohead" id="activityTable">
								<tbody>									
									' . $table . '									
								</tbody>
							</table>
							<form action="#" method="POST" class="form-vertical form-bordered" onSubmit="event.preventDefault();  comentar();">
									
									<div class="form-group" style="padding:5px;">
										
										<div class="input-group">
										
											<input id="comentInput" card="' . $model->TCCD_Id . '" type="text" placeholder="Escribe un comentario.." class="form-control">
											<div class="input-group-btn">
												<button id="imageSend" class="btn" style="border:none" type="button"><i class="fa fa-archive"></i></button>
												<button id="commentSend" class="btn btn-success" type="submit">Enviar</button>
											</div>
										</div>
									</div>									
							</form>
						</div>													
						
					</div>

				</div>

				<div class="col-sm-3">
				
					<button type="button" class="btn btn-default btn-block" style="border:2px solid orange" data-dismiss="modal">Cerrar</button>
										
					<h5 style="font-weight:bolder;">Agregar a la Tarjeta</h5>		

					<a href="#" id="TCCD_Expired" 
						class="btn 
						' . ($model->TCCD_Expired ? (date("Y-m-d") > date("Y-m-d", strtotime($model->TCCD_Expired)) ? "btn-danger" : "btn-success") : "btn-default") . '  btn-block" 
						data-type="date" 
						data-autotext="auto"
						data-mode="popup"
						data-placement="bottom"
						data-datepicket="{autoclose:true} "
						data-format="yyyy-mm-dd"
						data-pk="' . $model->TCCD_Id . '" 
						data-url="' . Yii::app()->createUrl('tccd/update', array('id' => $model->TCCD_Id)) . '" 
						data-title="Vencimiento">
						<i class="fa fa-clock-o"></i>
						' . ($model->TCCD_Expired ? "Vence " . date("d M", strtotime($model->TCCD_Expired)) : "Vencimiento") . '
					</a>
					<a href="#" id="TCCD_Labels" 
						class="btn btn-primary btn-block"
						data-type="select2" 
							data-placement="bottom"
						data-autotext="never"
						data-tpl=\'<input type="hidden">\' 
						data-pk="' . $model->TCCD_Id . '" 
						data-url="' . Yii::app()->createUrl('tccd/update', array('id' => $model->TCCD_Id)) . '" 
						data-value="' . $tagVal . '" 
						data-title="Etiquetas"><i class="fa fa-tags"></i>  Etiquetas
					</a>
					<a href="#"	id="TCCD_Users" 
						class="btn btn-info btn-block"
						data-type="select2" 
							data-placement="bottom"
						data-autotext="never"
						data-tpl=\'<input type="hidden">\' 
						data-pk="' . $model->TCCD_Id . '" 
						data-url="' . Yii::app()->createUrl('tccd/update', array('id' => $model->TCCD_Id)) . '" 
						data-value="' . $usersVal . '" 
						data-title="Colaborador"><i class="fa fa-group"></i>  Colaborador
					</a>
					<a href="#"	id="GCCA_List" 
						class="btn btn-info btn-block"
						data-type="select2" 
						data-placement="bottom"
						data-autotext="never"
						data-tpl=\'<input type="hidden">\' 
						data-pk="' . $model->TCCD_Id . '" 
						data-url="' . Yii::app()->createUrl('tccd/update', array('id' => $model->TCCD_Id)) . '" 
						data-value="' . $agenciasVal . '" 
						data-title="Agencia"><i class="fa fa-desktop"></i>  Agencia
					</a>
					<a href="#"	id="FCCU_List" 
						class="btn btn-info btn-block"
						data-type="select2" 
						data-placement="bottom"
						data-autotext="never"
						data-tpl=\'<input type="hidden">\' 
						data-pk="' . $model->TCCD_Id . '" 
						data-url="' . Yii::app()->createUrl('tccd/update', array('id' => $model->TCCD_Id)) . '" 
						data-value="' . $activosVal . '" 
						data-title="Activo"><i class="fa fa-thumb-tack"></i>  Activo
					</a>

					<h5 style="font-weight:bolder;">Operaciones</h5>

					<button 
						type="button" 
						id="TCCD_Archived"
						onClick="
						$.ajax({
							url:\'' . Yii::app()->createUrl('tccd/update', array('id' => $model->TCCD_Id)) . '\',
							type:\'POST\',
							data:{			 
								name: \'TCCD_Archived\'								
							},
							beforeSend:function(){
								 
							}
						})
						.done(function( data ) {
							
							cargarTarjeta(\'' . $model->TCCD_Id . '\');
						});
						"
						class="btn ' . ($model->TCCD_Archived ? "btn-warning " : "btn-default ") . ' btn-block">
						<i class="fa fa-save"></i> 
						'

						. ($model->TCCD_Archived ? "Desarchivar" : "Archivar") . '
					</button>

					<button 
						type="button" 
						id="TCCD_Hide"
						onClick="
						$.ajax({
							url:\'' . Yii::app()->createUrl('tccd/update', array('id' => $model->TCCD_Id)) . '\',
							type:\'POST\',
							data:{			 
								name: \'TCCD_Hide\'								
							},
							beforeSend:function(){
								
							}
						})
						.done(function( data ) {	
							$(\'#Task-' . $model->TCCD_Id . '\').css(\'background-color\', \'#ff4433\');							
							$(\'#Task-' . $model->TCCD_Id . '\').css(\'color\', \'white\');							
							cargarTarjeta(\'' . $model->TCCD_Id . '\');
							if(' . ($model->TCCD_Hide ? "true" : "false") . '){
								$(\'#Task-' . $model->TCCD_Id . '\').css(\'background-color\', \'#fff\');							
								$(\'#Task-' . $model->TCCD_Id . '\').css(\'color\', \'initial\');	
							}
							
						});
						"
						class="btn ' . ($model->TCCD_Hide ? "btn-danger " : "btn-default ") . '  btn-block">
						<i class="fa fa-times"></i> ' . ($model->TCCD_Hide ? "Eliminada" : "Eliminar") . '
					</button>
					
					<button type="button" 
						onclick="
						
							var aux = document.createElement(\'input\');
							// aux.setAttribute(\'value\',\'Todo en orden\');
							aux.setAttribute(\'value\',\' [Titulo]=>' . $model->TCCD_Title . ', [Descripcion]=>' . $model->TCCD_Description . ',[Vencimiento]=>' . $model->TCCD_Expired . ' \');
							
							// Append the aux input to the body
							document.body.appendChild(aux);

							// Highlight the content
							aux.select();

							// Execute the copy command
							document.execCommand(\'copy\');

							// Remove the input from the body
							document.body.removeChild(aux);
							alert(\'Copiado al portapapeles\');
						
						"
						class="btn btn-default btn-block"><i class="fa fa-share"></i>  Compartir
					</button>

				</div>	

			</div>'
				)
			);
			// return $model;
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id = '')
	{
		$model = new Tccd;
		$activo = Fccu::model()->find('FCCU_Id = :id', array(':id' => $id));
		$model->TCCD_Created = date("Y-m-d H:i");
		if (isset($activo)) {
			$model->TCCD_Title = $activo->FCCU_Serial;
			$model->TCCD_Description = "Se ha reportado el activo #" . $activo->FCCU_Serial . " ";
		}

		// Con este se crean las tarjetas desde tableros
		if (isset($_POST['name']) && $_POST['name'] == 'TCCA_New') {
			// print_r($_POST);
			// $model=new Tcca;
			$model->TCCD_Title = $_POST['value'];
			$model->TCCA_Id = $_POST['pk'];
			$model->TCCD_Order = Tccd::model()->count('TCCA_Id=' . $_POST['pk']);
			// $model->TCCA_BoardId=$id;
			$model->TCCD_Created = date("Y-m-d H:i");

			if ($model->save()) {
				$access = new Tccm;
				$access->TCCM_IdModel = $model->TCCD_Id;
				$access->TCCM_Model = "TCCD";
				$access->TCCM_IdUser = Yii::app()->user->id;
				$access->TCCM_Status = 'Administrador';
				$access->save();

				echo CJSON::encode(array(
					'TCCD_Title' => $model->TCCD_Title,
					'TCCD_Id' => $model->TCCD_Id,
					'TCCA_Id' => $model->TCCA_Id,
					'TCCD_Created' => date("d M, h:ia", strtotime($model->TCCD_Created)),
				));
				$this->saveActivity("creo", Yii::app()->user->id, "esta tarjeta", $model->TCCD_Id);
				return $model;
			} else {
				throw new CHttpException(404, 'The requested page does not exist.');
			}
		}
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		//Con este se crean las tarjetas desde formulario
		if (isset($_POST['Tccd'])) {
			$model->attributes = $_POST['Tccd'];
			if ($model->save()) {
				$access = new Tccm;
				$access->TCCM_IdModel = $model->TCCD_Id;
				$access->TCCM_Model = "TCCD";
				$access->TCCM_IdUser = Yii::app()->user->id;
				$access->TCCM_Status = 'Administrador';
				$access->save();
				$this->saveActivity("creo", Yii::app()->user->id, "esta tarjeta", $model->TCCD_Id);
				$this->redirect(array('/tcca/view', 'id' => $model->tCCA->TCCA_BoardId, 'card' => $model->TCCD_Id));
			}
		}

		$this->render('create', array(
			'model' => $model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Tccd'])) {
			$model->attributes = $_POST['Tccd'];
			if (isset($_POST['Old'])) {
				echo $_POST['Old'];
			}
			if ($model->save())
				// $this->redirect(array('view','id'=>$model->TCCD_Id));
				echo CJSON::encode($model);
			echo "Updated";
		}

		if (isset($_POST['name']) && $_POST['name'] == 'TCCD_Title') {
			// echo CJSON::encode($_POST);
			$oldTitle =  $model->TCCD_Title;
			$model->TCCD_Title = $_POST['value'];
			if ($model->save()) {
				//  echo $model->TCCD_Title;
				$this->saveActivity("edito", Yii::app()->user->id, " el titulo de la tarjeta. antes, '" . $oldTitle . "' y ahora, '" . $_POST['value'] . "'", $model->TCCD_Id);

				echo CJSON::encode(array(
					'TCCD_Title' => $model->TCCD_Title,
					'TCCD_Id' => $model->TCCD_Id,
					'TCCD_Created' => date("d M, h:ia", strtotime($model->TCCD_Created)),
				));
			} else {
				throw new CHttpException(404, 'The requested page does not exist.');
			}
		}
		if (isset($_POST['name']) && $_POST['name'] == 'TCCD_Description') {
			// print_r($_POST);
			$model->TCCD_Description = $_POST['value'];
			if ($model->save()) {
				$this->saveActivity("edito", Yii::app()->user->id, " la descripcion de la tarjeta.", $model->TCCD_Id);
				echo CJSON::encode($model);
			} else {
				throw new CHttpException(404, 'The requested page does not exist.');
			}
		}
		if (isset($_POST['name']) && $_POST['name'] == 'TCCD_Expired') {
			// print_r($_POST);
			$model->TCCD_Expired = $_POST['value'];
			if ($model->save()) {
				$this->saveActivity("edito", Yii::app()->user->id, " el vencimiento de la tarjeta a " . date("d M Y", strtotime($_POST['value'])), $model->TCCD_Id);
				echo CJSON::encode($model);
			} else {
				throw new CHttpException(404, 'The requested page does not exist.');
			}
		}
		if (isset($_POST['name']) && $_POST['name'] == 'TCCD_Labels') {

			TccdHasTccl::model()->deleteAll('tccd_TCCD_Id=:id', array(':id' => $id));

			if (isset($_POST['value'])) {
				$values = $_POST['value'];

				foreach ($values as $val) {
					// echo $val;
					if ($val != '0') {
						$label = new TccdHasTccl;
						$label->tccd_TCCD_Id = $id;
						$label->tccl_TCCL_Id = $val;
						$label->save();
					}
				}
			}

			// if($model->save()){

			$this->saveActivity("edito", Yii::app()->user->id, " las etiquetas de la tarjeta", $model->TCCD_Id);
			echo CJSON::encode($model);

			// }else{
			// throw new CHttpException(404,'The requested page does not exist.');
			// }
		}
		if (isset($_POST['name']) && $_POST['name'] == 'TCCD_Users') {

			Tccm::model()->deleteAll('TCCM_Model="TCCD" and TCCM_Status="Colaborador" and TCCM_IdModel=:id', array(':id' => $id));

			if (isset($_POST['value'])) {
				$values = $_POST['value'];

				foreach ($values as $val) {
					// echo $val;
					if ($val != '0' && $val != "") {
						$user = new Tccm;
						$user->TCCM_IdModel = $id;
						$user->TCCM_IdUser = $val;
						$user->TCCM_Model = "TCCD";
						$user->TCCM_Status = "Colaborador";
						$user->save();
						if ($val != Yii::app()->user->id)
							$this->sendNotification(
								$val,
								"<b>" . Yii::app()->user->name . "</b> te etiqueto en la tarjeta <b>" . $model->TCCD_Title . "</b>",
								Yii::app()->createUrl('tcca/view', array('id' => $model->tCCA->TCCA_BoardId, 'card' => $model->TCCD_Id))

							);
					}
				}
			}

			// if($model->save()){

			$this->saveActivity("edito", Yii::app()->user->id, " los colaboradores de la tarjeta", $model->TCCD_Id);
			echo CJSON::encode($model);

			// }else{
			// throw new CHttpException(404,'The requested page does not exist.');
			// }
		}
		if (isset($_POST['name']) && $_POST['name'] == 'TCCA_Id') {
			// print_r($_POST);

			//  $model->TCCD_Expired = $_POST['value'];
			if ($model->save()) {
				$lista = $model->tCCA;
				$this->saveActivity("movio", Yii::app()->user->id, " la tarjeta a la lista '" . $lista->TCCA_Name . "'", $model->TCCD_Id);
				echo CJSON::encode($model);
			} else {
				throw new CHttpException(404, 'The requested page does not exist.');
			}
		}
		if (isset($_POST['name']) && $_POST['name'] == 'TCCD_Archived') {

			if ($model->TCCD_Archived) {
				$model->TCCD_Archived = null;
				if ($model->save()) {
					$this->saveActivity("desarchivo", Yii::app()->user->id, " esta tarjeta el " . date("d M Y"), $model->TCCD_Id);
					echo CJSON::encode($model);
				} else {
					throw new CHttpException(404, 'The requested page does not exist.');
				}
			} else {
				$model->TCCD_Archived = date("Y-m-d H:i");
				if ($model->save()) {
					$this->saveActivity("archivo", Yii::app()->user->id, " esta tarjeta el " . date("d M Y"), $model->TCCD_Id);
					echo CJSON::encode($model);
				} else {
					throw new CHttpException(404, 'The requested page does not exist.');
				}
			}
		}
		if (isset($_POST['name']) && $_POST['name'] == 'TCCD_Hide') {

			if ($model->TCCD_Hide) {
				$model->TCCD_Hide = null;
				if ($model->save()) {
					$this->saveActivity("desoculto", Yii::app()->user->id, " esta tarjeta el " . date("d M Y"), $model->TCCD_Id);
					echo CJSON::encode($model);
				} else {
					throw new CHttpException(404, 'The requested page does not exist.');
				}
			} else {
				$model->TCCD_Hide = date("Y-m-d H:i");
				if ($model->save()) {
					$this->saveActivity("oculto", Yii::app()->user->id, " esta tarjeta el " . date("d M Y"), $model->TCCD_Id);
					echo CJSON::encode($model);
				} else {
					throw new CHttpException(404, 'The requested page does not exist.');
				}
			}
		}
		if (isset($_POST['name']) && $_POST['name'] == 'GCCA_List') {

			Tcga::model()->deleteAll('TCCD_Id=:id', array(':id' => $id));

			if (isset($_POST['value'])) {
				$values = $_POST['value'];

				foreach ($values as $val) {
					// echo $val;
					if ($val != '0') {
						$label = new Tcga;
						$label->TCCD_Id = $id;
						$label->GCCA_Id = $val;
						if ($label->save()) {
						} else {
							print_r($label->getErrors());
						}
					}
				}
			}

			// if($model->save()){

			$this->saveActivity("edito", Yii::app()->user->id, " las agencias de la tarjeta", $model->TCCD_Id);
			echo CJSON::encode($model);

			// }else{
			// throw new CHttpException(404,'The requested page does not exist.');
			// }
		}
		if (isset($_POST['name']) && $_POST['name'] == 'FCCU_List') {

			TccdHasFccu::model()->deleteAll('TCCD_Id=:id', array(':id' => $id));

			if (isset($_POST['value'])) {
				$values = $_POST['value'];

				foreach ($values as $val) {
					// echo $val;
					if ($val != '0') {
						$activo = new TccdHasFccu;
						$activo->TCCD_Id = $id;
						$activo->FCCU_Id = $val;
						if ($activo->save()) {
						} else {
							print_r($activo->getErrors());
						}
					}
				}
			}

			// if($model->save()){

			$this->saveActivity("edito", Yii::app()->user->id, " las agencias de la tarjeta", $model->TCCD_Id);
			echo CJSON::encode($model);

			// }else{
			// throw new CHttpException(404,'The requested page does not exist.');
			// }
		}
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
		if (!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('Tccd');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Tccd('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Tccd']))
			$model->attributes = $_GET['Tccd'];

		$this->render('admin', array(
			'model' => $model,
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
		$model = Tccd::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}


	public function saveActivity($TCCT_Type, $TCCT_IdUser, $TCCT_Text, $TCCD_Id)
	{
		$event = new Tcct;
		$event->TCCT_Timestamp = date('Y-m-d h:i');
		$event->TCCT_Type = $TCCT_Type;
		$event->TCCT_IdUser = $TCCT_IdUser;
		$event->TCCT_Text = $TCCT_Text;
		$event->TCCD_Id = $TCCD_Id;
		$event->save();
	}


	/**
	 * Performs the AJAX validation.
	 * @param Tccd $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'tccd-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
