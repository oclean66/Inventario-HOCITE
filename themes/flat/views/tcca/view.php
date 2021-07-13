<?php
// css/plugins/xeditable/bootstrap-editable.css
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/plugins/xeditable/bootstrap-editable.css', 'screen');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/plugins/icheck/all.css', 'screen');
// Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/css/plugins/chosen/chosen.css', 'screen');

// Yii::app()->clientScript->registerCssFile('https://raw.githubusercontent.com/fronteed/icheck/1.x/skins/flat/orange.css', 'screen');

// // Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/plugins/jquery-ui/jquery.ui.droppable.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/plugins/jquery-ui/jquery.ui.draggable.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/plugins/xeditable/bootstrap-editable.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/plugins/icheck/jquery.icheck.min.js');
// Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/plugins/chosen/chosen.jquery.min.js');

// Yii::app()->clientScript->registerScriptFile('https://raw.githubusercontent.com/fronteed/icheck/1.x/icheck.js');

// $this->menu=array(
// 	array('label'=>'Mis Tableros', 'url'=>array('index'),'itemOptions'=>array('class'=>'active')),
// 	// array('label'=>'Actualizar Tablero', 'url'=>array('update', 'id'=>$model->TCCA_Id)),
// 	array('label'=>'Crear Lista', 'url'=>'#modal-1','itemOptions'=>array('href'=>"#modal-1",'data-toggle'=>"modal")),
// 	// array('label'=>'Delete Tcca', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->TCCA_Id),'confirm'=>'Are you sure you want to delete this item?')),
// 	// array('label'=>'admin', 'url'=>array('admin')),
// );
?>

<div class="page-header">
	<div class="pull-left">

		<h4 class="nopadding nomargin">
			<a href="<?php echo Yii::app()->createUrl('tcca') ?>" class="btn btn-sm btn-primary">
				<i class="fa fa-arrow-left"></i>
			</a>
			<span style="display:inline-flex" data-url="<?php echo Yii::app()->createUrl('tcca/update', array('id' => $model->TCCA_Id)) ?>" class="listTitle" data-placement="bottom" id="TCCA_Name" data-mode="popup" data-type="text" data-pk="<?php echo $model->TCCA_Id; ?>" data-id="<?php echo $model->TCCA_Id; ?>">
				<?php echo $model->TCCA_Name; ?>
			</span>
		</h4>
	</div>
	<div class="pull-right">

		<div class="btn-toolbar">

			<?php if ($model->TCCA_Archived) {
				echo "<div class='btn-group'>
						<div class='btn btn-danger'><i class='fa fa-book'></i> Archivado el " . date("d M", strtotime($model->TCCA_Archived)) . '</div>
						</div>';
			}
			?>


			<div class="btn-group /*hidden-768*/">

				<div class="dropdown">
					<a href="#" class="btn btn-primary not-link" data-toggle="dropdown" rel="tooltip" data-placement="top" title="" data-original-title="Participantes del Tablero">
						<i class="fa fa-group"></i>
						<span class="caret"></span>
					</a>
					<div class="dropdown-menu user-list dropdown-menu-right" style="width:auto;top:30px;padding:0;box-shadow: 2px 2px 4px 2px lightgrey;border: grey 1px solid;border-radius: 5px;">

						<h4 style="margin:0;">Participantes</h4>
						<div class="box-content nopadding scrollable" data-visible="true" style="overflow: auto;height:450px; width: auto;">
							<table class="table table-user table-nohead nomargin">
								<tbody>

									<?php
									foreach ($users as $user) {
									?>

										<tr>
											<td class="user">
												<i class="fa fa-user"></i> <?php echo $user['username']; ?>

												<!-- <br/>
												<small class="truncate"><?php echo $user['email']; ?></small> -->


											</td>
											<td class="icon">
												<?php if ($user['status'] == "Administrador") {
													echo '<a href="#" class="btn btn-mini btn-warning" >
													Propietario
												</a>';
												} ?>

												<?php if ($user['status'] && $user['status'] != "Administrador") {

													echo CHtml::ajaxLink(
														'Eliminar',          // the link body (it will NOT be HTML-encoded.)
														array('tccm/toggle'), // the URL for the AJAX request. If empty, it is assumed to be the current URL.
														array(

															'dataType' => 'json',
															'data' => array(
																'iduser' => $user['iduser'],
																'idmodel' => $model->TCCA_Id,
																'model' => 'TCCA'
															),
															'beforeSend' => 'function(xhr, opts) {           
																var confirmed = confirm("Seguro quieres agregar este participante al tablero?");
																if(!confirmed)  xhr.abort();
															}',
															'complete' => 'function(response, error) {
																if(response.responseText=="Agregar")
																	$("#add' . $user['iduser'] . '").removeClass("btn-danger");
																	$("#add' . $user['iduser'] . '").addClass("btn-success");
																if(response.responseText=="Eliminar")
																	$("#add' . $user['iduser'] . '").removeClass("btn-success");
																	$("#add' . $user['iduser'] . '").addClass("btn-danger");

															$("#add' . $user['iduser'] . '").html(response.responseText);
															}',
														),
														array(
															'rel' => "tooltip",
															'data-placement' => "left",
															// 'data-original-title'=>"ELiminar del Tablero",
															'class' => "btn btn-mini btn-danger",
															'id' => 'add' . $user['iduser']
														)
													);

												?>



												<?php
												}
												if (!$user['status']) {
													echo CHtml::ajaxLink(
														'Agregar',          // the link body (it will NOT be HTML-encoded.)
														array('tccm/toggle'), // the URL for the AJAX request. If empty, it is assumed to be the current URL.
														array(

															'dataType' => 'json',
															'data' => array(
																'iduser' => $user['iduser'],
																'idmodel' => $model->TCCA_Id,
																'model' => 'TCCA'
															),
															'beforeSend' => 'function(xhr, opts) {           
																var confirmed = confirm("Seguro quieres agregar este participante al tablero?");
																if(!confirmed)  xhr.abort();
															}',
															'complete' => 'function(response, error) {
																if(response.responseText=="Agregar")
																	$("#add' . $user['iduser'] . '").removeClass("btn-danger");
																	$("#add' . $user['iduser'] . '").addClass("btn-success");
																if(response.responseText=="Eliminar")
																	$("#add' . $user['iduser'] . '").removeClass("btn-success");
																	$("#add' . $user['iduser'] . '").addClass("btn-danger");

																$("#add' . $user['iduser'] . '").html(response.responseText);
															}',
														),
														array(
															'rel' => "tooltip",
															'data-placement' => "left",
															// 'data-original-title'=>"Agregar al Tablero",
															'class' => "btn btn-mini btn-success",
															'id' => 'add' . $user['iduser']
														)
													);

												?>



												<?php
												} ?>
												<!-- <a href="#" class="btn btn-mini btn-danger" data-toggle="dropdown" rel="tooltip" data-placement="left" title="" data-original-title="Eliminar del Tablero" onClick="alert('Estas seguro que quieres eliminar este participante?')">
													<i class="fa fa-times"></i>
												</a> -->


											</td>
										</tr>
									<?php
									}

									if (!$admin) {
									?>


										<!-- <tr>
											<td colspan="2" class="nopadding">
												<a href="#" onClick="confirm('Estas seguro que quieres dejar el tablero?')" class="btn btn-block btn-text-left btn-danger nomargin">
													<i class="fa fa-sign-out"></i> Dejar el Tablero
												</a>
											</td>										
										</tr> -->
									<?php } ?>
								</tbody>
							</table>
						</div>

					</div>
				</div>
			</div>


			<div class="btn-group /*hidden-768*/">

				<div class="dropdown">
					<a href="#" class="btn btn-primary not-link" data-toggle="dropdown" rel="tooltip" data-placement="top" title="" data-original-title="Opciones del Tablero">
						<i class="fa fa-cog"></i>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu dropdown-menu-right">
						<?php if (!$model->TCCA_Archived) { ?>
							<li>
								<!-- <a href="#"> Archivar este Tablero</a> -->
								<?php
								echo CHtml::ajaxLink(
									'Archivar este Tablero',          // the link body (it will NOT be HTML-encoded.)
									array('delete', 'id' => $model->TCCA_Id), // the URL for the AJAX request. If empty, it is assumed to be the current URL.
									array(
										'type' => 'POST',
										'beforeSend' => 'function() {           
											$("#List-' . $model->TCCA_Id . '").css("opacity","0.5");
										}',
										'complete' => 'function(data, value) {
											console.log(data, value);
											if(data.responseText=="Archived")
											window.location.replace("https://kingdeportes.com/hefestos/tcca");
										}',
									)
								);
								?>
							</li>
						<?php } ?>
						<li>
							<a href="#"> Listas Archivadas</a>
						</li>
					</ul>
				</div>
			</div>
			<!-- <div class="btn-group /*hidden-768*/">
				<div class="dropdown"> -->
			<a href="#" class="btn not-link" id="viewTabla">
				<i class="fa fa-eye"></i> Ver en Lista
				<!-- <span class="caret"></span> -->
			</a>
			<a href="#" class="btn not-link hide" id="viewBoard">
				<i class="fa fa-eye"></i> Ver en Tablero
			</a>
			<!-- <ul class="dropdown-menu dropdown-menu-right">
						<li id="tabla">
							<a href="#"> Ver en Lista</a>
						</li>
						<li  class="hide" id="board">
							<a href="#"> Ver en Tablero</a>
						</li>
					</ul> -->
			<!-- </div>
			</div> -->



		</div>
	</div>
</div>





<!-- VISTA EN FORMA DE TABLERO PREDETERMINADA -->

<div id="large-grid" style="display:flex;overflow:auto;">
	<?php
	foreach ($lists as $value) {
		//print_r($value);
	?>
		<div class="box box-small" id="List-<?php echo $value['TCCA_Id']; ?>" data-board="<?php echo $model->TCCA_Id; ?>" data-pos="<?php echo $value['TCCA_Order']; ?>" data-toggle="modal" data-id="<?php echo $value['TCCA_Id']; ?>">

			<!-- <div class="progress"> <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width:45%"><span class="sr-only">45% Complete</span></div> </div> -->

			<div class="box-title" style="margin-top:0px;padding-bottom:5px">
				<h3>
					<i class="fa fa-inbox"></i>
					<span data-url="<?php echo Yii::app()->createUrl('tcca/update', array('id' => $value['TCCA_Id'])) ?>" class="listTitle" data-placement="right" id="TCCA_Name" data-type="text" data-pk="<?php echo $value['TCCA_Id']; ?>" data-id="<?php echo $value['TCCA_Id']; ?>" data-original-title="Nombre de la Lista">
						<?php //echo $value['TCCA_Name']." (".$value['TCCA_Order'].")"
						?>
						<?php echo $value['TCCA_Name']; ?>
					</span>
					<?php echo "(" . count($value['TCCA_Tasks']) . ")"; ?>
				</h3>
				<div class="actions" style="margin-top:0">

					<span class="dropdown">
						<a href="#" class="btn btn-mini btn-primary dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-bars"></i>
						</a>
						<ul class="dropdown-menu dropdown-menu-right">
							<li class="dropdown-header">Opciones</li>
							<!-- <li>
									<a href="#" onclick="$('#TCCA_New<?php echo $value["TCCA_Id"]; ?>').innerHtml=Date()">Agregar Tarjeta</a>
								</li> -->
							<!-- <li>
									<a href="#">Ordenar por...</a>
								</li> -->
							<!-- <li class="divider"></li> -->
							<!-- <li>
									
									<?php
									echo CHtml::ajaxLink(
										'Archivar todas las tarjetas',          // the link body (it will NOT be HTML-encoded.)
										array('deleteAll', 'id' => $value['TCCA_Id']), // the URL for the AJAX request. If empty, it is assumed to be the current URL.
										array(
											'type' => 'POST',
											'beforeSend' => 'function() {           
												$("#List-' . $value['TCCA_Id'] . '").css("opacity","0.5");
											}',
											'complete' => 'function(data, value) {
												console.log(data, value);
												if(data.responseText=="All Archived")
												{
													$("#List-' . $value['TCCA_Id'] . '").css("opacity","1");
												  	$("#Board-' . $value['TCCA_Id'] . '").html("");
												  }
											}',
										)
									);
									?>
								</li> -->
							<!-- <li>
									<a href="#">Tarjetas Archivadas</a>
								</li>
								
								<li class="divider"></li> -->
							<li>
								<!-- <a href="#">Archivar Esta Lista</a> -->
								<?php
								echo CHtml::ajaxLink(
									'Archivar Esta Lista',          // the link body (it will NOT be HTML-encoded.)
									array('delete', 'id' => $value['TCCA_Id']), // the URL for the AJAX request. If empty, it is assumed to be the current URL.
									array(
										'type' => 'POST',
										'beforeSend' => 'function() {           
												$("#List-' . $value['TCCA_Id'] . '").css("opacity","0.5");
											 }',
										'complete' => 'function(data, value) {
											  console.log(data, value);
											  if(data.responseText=="Archived")
											  	$("#List-' . $value['TCCA_Id'] . '").addClass("hidden");
											}',
									)
								);
								?>
							</li>
						</ul>
					</span>

				</div>
			</div>
			<div id="Board-<?php echo $value['TCCA_Id']; ?>" data-pk="<?php echo $value['TCCA_Id']; ?>" data-id="<?php echo $value['TCCA_Id']; ?>" class="box-content board connectedSortable sortable">
				<?php
				foreach ($value['TCCA_Tasks'] as $task) {
				?>
					<div id="Task-<?php echo $task->TCCD_Id; ?>" class="alert alert-card <?php echo isset($task->TCCD_Expired) && date("Y-m-d") > date("Y-m-d", strtotime($task->TCCD_Expired)) ? "active" : ""; ?>" data-board="<?php echo $value['TCCA_Id']; ?>" data-pos="<?php echo $task->TCCD_Order; ?>" data-toggle="modal" data-id="<?php echo $task->TCCD_Id; ?>" data-target=".bs-example-modal-lg">

						<small style="<?php echo isset($task->TCCD_Expired) && date("Y-m-d") > date("Y-m-d", strtotime($task->TCCD_Expired)) ? "color:black;" : "color:darkorange;"; ?>"><b><?php echo date("d M, h:ia", strtotime($task->TCCD_Created)); ?></b></small>
						<?php //echo "(".$task->TCCD_Order.") ".$task->TCCD_Title; 
						?>
						<?php echo $task->TCCD_Archived ? ' <small class="pull-right"><i class="fa fa-save"></i> </small> ' : ''; ?>
						<br />
						<?php echo $task->TCCD_Title; ?>
						<br />
						<div class="toolbar" style="display:flow-root;">
							<!-- <i class="fa fa-square-o"></i>
										<i class="fa fa-refresh"></i>
										<i class="fa fa-inbox"></i>
										<i class="fa fa-exclamation-triangle"></i>
										<i class="fa fa-trash-o"></i> -->

							<?php echo $task->TCCD_Expired ? ' <small>' . (date("Y-m-d") > date("Y-m-d", strtotime($task->TCCD_Expired)) ? "<b>" : "") . '<i class="fa fa-clock-o"></i> ' . date("d M", strtotime($task->TCCD_Expired)) . (date("Y-m-d") > date("Y-m-d", strtotime($task->TCCD_Expired)) ? "</b>" : "") . "</small> " : ''; ?>
							<?php

							$comments = Tcct::model()->findAll('TCCD_Id=:id and TCCT_Type="comento"', array(':id' => $task->TCCD_Id));
							echo count($comments) > 0 ? ' <small><i class="fa fa-comment-o"></i> ' . count($comments) . '</small> ' : '';

							$colss = Tccm::model()->findAll('TCCM_Model="TCCD" and TCCM_Status="Colaborador" and TCCM_IdModel=:id', array(':id' => $task->TCCD_Id));
							echo count($colss) > 0 ? ' <small><i class="fa fa-user"></i> ' . count($colss) . '</small> ' : '';


							$listas = $task->tccls;
							foreach ($listas as $tag) {
								echo '<small class="pull-right" style="margin-left:3px;"><i class="fa ' . $tag->TCCL_Icon . '"></i> </small> ';
							}
							?>



						</div>
					</div>
				<?php
				}
				?>
			</div>
			<div class="box-footer" style="padding:0;margin:5px;border-radius:5px;border:1px solid lightgray;">
				<span id="TCCA_New" role="button" class="newCard btn btn-block btn-mini" style="text-align:left;padding:10px; " data-type="text" data-display="false" data-pk="<?php echo $value['TCCA_Id']; ?>" data-id="<?php echo $value['TCCA_Id']; ?>" data-url="<?php echo Yii::app()->createUrl('tccd/create', array('id' => $value['TCCA_Id'])) ?>" data-value="" data-placeholder="Titulo de la Tarjeta">
					<i class="fa fa-plus"></i> Agregar Tarjeta
				</span>
			</div>
		</div>
	<?php
	}
	?>

	<div class="box box-small" style="padding:0">
		<!-- <div class="box-title" style="margin-top:5px;"> -->
		<span data-url="<?php echo Yii::app()->createUrl('tcca/view', array('id' => $model->TCCA_Id)) ?>" class="newList btn btn-block btn-mini" style="text-align: left;padding:10px;" data-placement="right" id="TCCA_New" data-defaultValue="" data-value="" data-type="text" data-pk="<?php echo $model->TCCA_Id; ?>" data-id="<?php echo $model->TCCA_Id; ?>" data-placeholder="Nombre de la Lista">
			<i class="fa fa-plus"></i> Agregar Lista

		</span>
		<!-- </div> -->

	</div>

</div>

<!-- VISTA EN FORMA DE LISTA PREDETERMINADA -->

<div id="viewTabla1" class="hide">
	<table class="col-sm-12">
		<?php foreach ($lists as $value) { ?>
			<tr class="col-sm-12" id="List-<?php echo $value['TCCA_Id']; ?>" data-board="<?php echo $model->TCCA_Id; ?>" data-pos="<?php echo $value['TCCA_Order']; ?>" data-toggle="modal" data-id="<?php echo $value['TCCA_Id']; ?>">
				<th class="col-sm-12" style="margin-top:0px;padding-bottom:5px">
					<h3>
						<i class="fa fa-inbox"></i>
						<span data-url="<?php echo Yii::app()->createUrl('tcca/update', array('id' => $value['TCCA_Id'])) ?>" class="listTitle" data-placement="right" id="TCCA_Name" data-type="text" data-pk="<?php echo $value['TCCA_Id']; ?>" data-id="<?php echo $value['TCCA_Id']; ?>" data-original-title="Nombre de la Lista">
							<?php echo $value['TCCA_Name']; ?>
						</span>
						<?php echo "(" . count($value['TCCA_Tasks']) . ")"; ?>
						<span class="dropdown">
							<a href="#" class="btn btn-mini btn-primary dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-bars"></i>
							</a>
							<ul class="dropdown-menu dropdown-menu-right">
								<li class="dropdown-header">Opciones</li>
								<?php
								echo CHtml::ajaxLink(
									'Archivar todas las tarjetas',          // the link body (it will NOT be HTML-encoded.)
									array('deleteAll', 'id' => $value['TCCA_Id']), // the URL for the AJAX request. If empty, it is assumed to be the current URL.
									array(
										'type' => 'POST',
										'beforeSend' => 'function() {           
													$("#List-' . $value['TCCA_Id'] . '").css("opacity","0.5");
												}',
										'complete' => 'function(data, value) {
											console.log(data, value);
											if(data.responseText=="All Archived")
											{
														$("#List-' . $value['TCCA_Id'] . '").css("opacity","1");
														$("#Board-' . $value['TCCA_Id'] . '").html("");
													}
												}',
									)
								);
								?>
								</li>
								<li>
									<?php
									echo CHtml::ajaxLink(
										'Archivar Esta Lista',          // the link body (it will NOT be HTML-encoded.)
										array('delete', 'id' => $value['TCCA_Id']), // the URL for the AJAX request. If empty, it is assumed to be the current URL.
										array(
											'type' => 'POST',
											'beforeSend' => 'function() {           
													$("#List-' . $value['TCCA_Id'] . '").css("opacity","0.5");
												}',
											'complete' => 'function(data, value) {
												  console.log(data, value);
												  if(data.responseText=="Archived")
												  $("#List-' . $value['TCCA_Id'] . '").addClass("hidden");
												}',
										)
									);
									?>
								</li>
							</ul>
						</span>
					</h3>
				</th>
			</tr>
			<tr id="Board-<?php echo $value['TCCA_Id']; ?>" data-pk="<?php echo $value['TCCA_Id']; ?>" data-id="<?php echo $value['TCCA_Id']; ?>" class="box-content board connectedSortable sortable col-sm-12">
				<?php
				foreach ($value['TCCA_Tasks'] as $task) {
				?>
					<td id="Task-<?php echo $task->TCCD_Id; ?>" class="col-sm-12 alert alert-card <?php echo isset($task->TCCD_Expired) && date("Y-m-d") > date("Y-m-d", strtotime($task->TCCD_Expired)) ? "active" : ""; ?>" style="float: right;" data-board="<?php echo $value['TCCA_Id']; ?>" data-pos="<?php echo $task->TCCD_Order; ?>" data-toggle="modal" data-id="<?php echo $task->TCCD_Id; ?>" data-target=".bs-example-modal-lg">

						<small style="<?php echo isset($task->TCCD_Expired) && date("Y-m-d") > date("Y-m-d", strtotime($task->TCCD_Expired)) ? "color:black;" : "color:darkorange;"; ?>"><b><?php echo date("d M, h:ia", strtotime($task->TCCD_Created)); ?></b></small>
						<?php //echo "(".$task->TCCD_Order.") ".$task->TCCD_Title; 
						?>
						<?php echo $task->TCCD_Archived ? ' <small class="pull-right"><i class="fa fa-save"></i> </small> ' : ''; ?>
						<br />
						<?php echo $task->TCCD_Title; ?>
						<br />
						<div class="toolbar" style="display:flow-root;">
							<!-- <i class="fa fa-square-o"></i>
											<i class="fa fa-refresh"></i>
											<i class="fa fa-inbox"></i>
											<i class="fa fa-exclamation-triangle"></i>
											<i class="fa fa-trash-o"></i> -->

							<?php echo $task->TCCD_Expired ? ' <small>' . (date("Y-m-d") > date("Y-m-d", strtotime($task->TCCD_Expired)) ? "<b>" : "") . '<i class="fa fa-clock-o"></i> ' . date("d M", strtotime($task->TCCD_Expired)) . (date("Y-m-d") > date("Y-m-d", strtotime($task->TCCD_Expired)) ? "</b>" : "") . "</small> " : ''; ?>
							<?php

							$comments = Tcct::model()->findAll('TCCD_Id=:id and TCCT_Type="comento"', array(':id' => $task->TCCD_Id));
							echo count($comments) > 0 ? ' <small><i class="fa fa-comment-o"></i> ' . count($comments) . '</small> ' : '';

							$colss = Tccm::model()->findAll('TCCM_Model="TCCD" and TCCM_Status="Colaborador" and TCCM_IdModel=:id', array(':id' => $task->TCCD_Id));
							echo count($colss) > 0 ? ' <small><i class="fa fa-user"></i> ' . count($colss) . '</small> ' : '';


							$listas = $task->tccls;
							foreach ($listas as $tag) {
								echo '<small class="pull-right" style="margin-left:3px;"><i class="fa ' . $tag->TCCL_Icon . '"></i> </small> ';
							}
							?>



						</div>
					</td>
				<?php
				}
				?>
			</tr>
		<?php } ?>
	</table>
</div>


<!-- <pre>
	<?php
	// print_r($agencias);
	?>
</pre> -->


<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-body" id="modal-ajax">
			</div>
		</div>
	</div>
</div>





<!-- //---------------------------- -->

<style>
	.select2-input {
		min-width: 100px;
	}

	/*   */
	.toolbar {
		padding-top: 5px;
	}

	.box-small {
		border: 1px solid lightgray;
		border-radius: 3px;
		padding: 5px;
		margin-right: 5px;
		background: #eeeeee;
		min-width: 320px;
		height: fit-content;
	}

	.board {
		overflow: auto;
		height: 100%;
		background: #eeeeee !important;

	}

	.alert-card {
		background-color: #fff;
		margin-bottom: 5px;
		padding-left: 10px;
		padding-right: 10px;
		padding-bottom: 5px;
		padding-top: 5px;
		font-size: 14px;
		box-shadow: 0px 1px 2px #a0a0a0;

	}

	.alert-card.active {
		background-color: #faa;
	}

	.alert-dismissable .close {
		right: 0;
	}

	.ui-state-highlightme {
		height: 300px !important;
		background: #deffde;
		border-radius: 5px;
	}

	.ui-state-highlighttw {
		/* height:300px !important; */
		background: #deffde !important;
	}

	#main {
		/* background-color: #ffffff; */
		background-image: url("https://www.transparenttextures.com/patterns/gplay.png");

	}
</style>

<!-- //----------------------- -->

<script>
	let isCard = false;
	const params = <?php echo json_encode($_GET); ?>



	$(function() {



		$("#viewTabla").click(function() {
			$("#viewBoard").removeClass("hide")
			$("#viewTabla1").removeClass("hide")
			$("#viewTabla").addClass("hide")
			$("#large-grid").addClass("hide")
		});
		$("#viewBoard").click(function() {
			$("#viewTabla").removeClass("hide")
			$("#viewBoard").addClass("hide")
			$("#viewTabla1").addClass("hide")
			$("#large-grid").removeClass("hide")
		});
		// Abrir una tarea
		$(".alert-card").click(function() {
			// $( "#modal-ajax" ).load(  );
			$(".alert-card").attr("style", "border:none;")
			$(this).attr("style", "border:1px solid orange;")
			let aux = $("#modal-ajax").html();
			$.ajax({
				url: "<?php echo Yii::app()->createUrl("tccd/view"); ?>?id=" + $(this).attr("data-id"),
				// url: "https://kingdeportes.com/hefestos/tccd/view/"+$(this).attr("data-id"),
				beforeSend: function(xhr) {
					$("#modal-ajax").html('<div class="progress progress-striped active"><div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span class="sr-only">45% Complete</span></div></div>');
				}
			}).done(function(data) {
				// console.log(JSON.parse(data)[1])
				$("#modal-ajax").html(JSON.parse(data)[1]);

				$('.taskTitle').editable({
					mode: "inline",
					success: function(r, v) {
						const task = JSON.parse(r);
						// $('#Task-'+task.TCCD_Id).html("("+task.TCCD_Order+") "+task.TCCD_Title);
						$('#Task-' + task.TCCD_Id).html('<small style="color:darkorange;"><b>' + task.TCCD_Created + '</b></small><br/>' +
							task.TCCD_Title + (task.TCCD_Archived ? '<small class="pull-right"><i class="fa fa-save"></i> </small> ' : '') +
							'<br/><div class="toolbar" style="display:flow-root;"></div>');
						// console.log(task.TCCD_Id);
					}
				});
				$('.description').editable({
					mode: "inline",

				});
				$('#TCCD_Expired').editable({
					format: 'YYYY-MM-DD',
					yearDescending: true,
					showbuttons: 'bottom',
					placement: 'left',
					smartDays: true,

					template: 'DD MMMM YYYY',
					combodate: {
						minYear: 2020,
						maxYear: 2025,
						minuteStep: 1
					},
					success: function() {
						cargarTarjeta($('#comentInput').attr('card'));
					}

				});
				$('#TCCD_Labels').editable({
					showbuttons: 'bottom',
					placement: 'left',
					source: [<?php echo $tags; ?>],
					select2: {
						multiple: true
					},
					success: function() {
						cargarTarjeta($('#comentInput').attr('card'));
					}
				});
				$('#TCCD_Users').editable({
					showbuttons: 'bottom',
					placement: 'left',
					source: [<?php echo $jusers; ?>],
					select2: {
						multiple: true,
						// minimumInputLength: 3
					},
					success: function() {
						cargarTarjeta($('#comentInput').attr('card'));
					}
				});
				$('#GCCA_List').editable({
					showbuttons: 'bottom',
					placement: 'left',
					source: [<?php echo $jagencias; ?>],
					select2: {
						multiple: true,
						formatInputTooShort: function() {
							return "Ingrese 3 caracteres";
						},
						formatNoMatches: function() {
							return "Sin resultados";
						},
						formatSearching: function() {
							return "Buscando...";
						},
						minimumInputLength: 3
					},
					success: function() {
						cargarTarjeta($('#comentInput').attr('card'));
					}
				});
				$('#FCCU_List').editable({
					showbuttons: 'bottom',
					placement: 'left',
					source: [<?php echo $jactivos; ?>],
					select2: {
						multiple: true,
						formatInputTooShort: function() {
							return "Ingrese 3 caracteres";
						},
						formatNoMatches: function() {
							return "Sin resultados";
						},
						formatSearching: function() {
							return "Buscando...";
						},
						minimumInputLength: 3
					},
					success: function() {
						cargarTarjeta($('#comentInput').attr('card'));
					}
				});



				$('#activity').scrollTop($('#activityTable').height());
			});

		});

		//Titulo de la lista
		$('.listTitle').editable({
			mode: "inline"
		});
		//Nueva Lista
		$('.newList').editable({
			mode: "inline",
			success: function(response, newValue) {
				location.reload();
				// console.log(response);
				// $('#large-grid .box:last').before('<div class="box box-small"><div class="box-title" style="margin-top:5px;"><h3><i class="fa fa-inbox"></i><span data-url="/hefestos/tcca/update/21.html" class="listTitle editable editable-click" data-placement="right" id="TCCA_Name" data-type="text" data-pk="21" data-id="21" data-original-title="Nombre de la Lista" style="display: inline;">'+newValue+'</span></h3><div class="actions" style="margin-top:0"><span class="dropdown"><a href="#" class="btn btn-mini btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i></a><ul class="dropdown-menu dropdown-menu-right"><li class="dropdown-header">Opciones</li><li><a href="#">Agregar Tarjeta</a></li><li><a href="#">Ordenar por...</a></li><li class="divider"></li><li><a href="#">Archivar todas las tarjetas</a></li><li><a href="#">Tarjetas Archivadas</a></li><li class="divider"></li><li><a href="#">Archivar Esta Lista</a></li></ul></span></div></div><div id="board21" class="box-content board connectedSortable sortable ui-sortable" style="max-height: 626px;">  </div><div class="box-footer" style="padding:10px;border-radius:5px;"><span id="TCCA_New" role="button" class="newCard btn btn-block btn-mini editable editable-click" style="text-align:left;padding:5px;" data-type="text" data-display="false" data-pk="21" data-url="/hefestos/tccd/create/21.html" data-value="" data-placeholder="Nombre de la Tarjeta"><i class="fa fa-plus"></i> Agregar Tarjeta</span></div></div>');
				// $('.newList').editable({value:''});
			}
		});
		//Nueva Tarea
		$('.newCard').editable({
			mode: "inline",
			// showbuttons:'bottom',
			success: function(response, newValue) {
				// $('.newCard').editable('value', '');
				const task = JSON.parse(response)
				$(this).editable('setValue', "", true);
				$(".alert-card").attr("style", "border:none;")
				$("#Task-" + task.TCCD_Id).attr("style", "border:1px solid orange;")
				// setValue(value, convertStr)
				// $(this).text("");
				// location.reload();
				// console.log(task);
				// $('#Task-'+task.TCCD_Id).html('<small style="color:darkorange;"><b>'+task.TCCD_Created+'</b></small><br/>'+
				// 					task.TCCD_Title+(task.TCCD_Archived ? '<small class="pull-right"><i class="fa fa-save"></i> </small> ' :'')+			
				// 					'<br/><div class="toolbar" style="display:flow-root;"></div>');
				$('#Board-' + task.TCCA_Id).append(
					'<div  data-toggle="modal" id="Task-' + task.TCCD_Id + '" data-url="' + task.TCCD_Id + '" data-target=".bs-example-modal-lg" class="alert alert-card" style="border:1px solid orange;">' +
					'<small style="color:darkorange;"><b>' + task.TCCD_Created + '</b></small><br/>' + task.TCCD_Title +
					// '  ('+task.TCCD_Order+") "+task.TCCD_Title+
					'	<br/>' +
					// '	<div class="toolbar">'+
					// '		<i class="fa fa-square-o"></i>'+
					// '		<i class="fa fa-refresh"></i>'+
					// '		<i class="fa fa-inbox"></i>'+
					// '		<i class="fa fa-exclamation-triangle"></i>'+
					// '		<i class="fa fa-trash-o"></i>'+
					// '		<i class="fa fa-folder"></i>'+
					// '	</div>'+
					'</div>'
				);

				$("#Task-" + task.TCCD_Id).click(function() {
					// $( "#modal-ajax" ).load(  );
					$(".alert-card").attr("style", "border:none;")
					$(this).attr("style", "border:1px solid orange;")
					let aux = $("#modal-ajax").html();
					$.ajax({
						//url: "https://kingdeportes.com/hefestos/tccd/view/"+$(this).attr("data-url"),
						url: "<?php echo Yii::app()->createUrl("tccd/view"); ?>?id=" + $(this).attr("data-url"),
						beforeSend: function(xhr) {
							$("#modal-ajax").html('<div class="progress progress-striped active"><div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span class="sr-only">45% Complete</span></div></div>');
						}
					}).done(function(data) {
						// $("#modal-ajax").html(aux);
						// console.log(JSON.parse(data)[1])
						$("#modal-ajax").html(JSON.parse(data)[1]);

						$('.taskTitle').editable({
							mode: "inline",
							success: function(r, v) {
								const task = JSON.parse(r);
								// $('#Task-'+task.TCCD_Id).html("("+task.TCCD_Order+") "+task.TCCD_Title);
								$('#Task-' + task.TCCD_Id).html('<small style="color:darkorange;"><b>' + task.TCCD_Created + '</b></small><br/>' +
									task.TCCD_Title + (task.TCCD_Archived ? '<small class="pull-right"><i class="fa fa-save"></i> </small> ' : '') +
									'<br/><div class="toolbar" style="display:flow-root;">' +
									(task.TCCD_Expired ? ' <small><i class="fa fa-clock-o"></i> ' + task.TCCD_Expired + "</small> " : '') + '</div>');
								// console.log(task);
							}
						});
						$('.description').editable({
							mode: "inline"
						});
						$('#TCCD_Expired').editable({
							format: 'YYYY-MM-DD',
							yearDescending: true,
							showbuttons: 'bottom',
							placement: 'left',
							smartDays: true,

							template: 'DD MMMM YYYY',
							combodate: {
								minYear: 2020,
								maxYear: 2025,
								minuteStep: 1
							},
							success: function() {
								cargarTarjeta($('#comentInput').attr('card'));
							}

						});
						$('#TCCD_Labels').editable({
							showbuttons: 'bottom',
							placement: 'left',
							source: [<?php echo $tags; ?>],
							select2: {
								multiple: true
							},
							success: function() {
								cargarTarjeta($('#comentInput').attr('card'));
							}
						});
						$('#TCCD_Users').editable({
							showbuttons: 'bottom',
							placement: 'left',
							source: [<?php echo $jusers; ?>],
							select2: {
								multiple: true,
								// minimumInputLength: 3
							},
							success: function() {
								cargarTarjeta($('#comentInput').attr('card'));
							}
						});
						$('#GCCA_List').editable({
							showbuttons: 'bottom',
							placement: 'left',
							source: [<?php echo $jagencias; ?>],
							select2: {
								formatInputTooShort: function() {
									return "Ingrese 3 caracteres";
								},
								formatNoMatches: function() {
									return "Sin resultados";
								},
								formatSearching: function() {
									return "Buscando...";
								},
								multiple: true,
								minimumInputLength: 3
							},
							success: function() {
								cargarTarjeta($('#comentInput').attr('card'));
							}
						});
						$('#FCCU_List').editable({
							showbuttons: 'bottom',
							placement: 'left',
							source: [<?php echo $jactivos; ?>],
							select2: {
								formatInputTooShort: function() {
									return "Ingrese 3 caracteres";
								},
								formatNoMatches: function() {
									return "Sin resultados";
								},
								formatSearching: function() {
									return "Buscando...";
								},
								multiple: true,
								minimumInputLength: 3
							},
							success: function() {
								cargarTarjeta($('#comentInput').attr('card'));
							}
						});


						$('#activity').scrollTop($('#activityTable').height());

					});

				});

				$('#Board-' + task.TCCA_Id).animate({
					scrollTop: $('#Board-' + task.TCCA_Id).prop("scrollHeight") + 60
				}, 1000);


				// console.log('#board'+task.TCCA_Id, newValue)

			}
		});

		// $.fn.editableform.buttons  = '<button type="submit" class="editable-submit">ok</button><button type="button" class="editable-cancel">cancel</button>';
		//$.fn.editableform.buttons = '<button type="submit" class="btn btn-primary btn-sm editable-submit"><i class="glyphicon glyphicon-ok"></i></button><button type="button" class="btn btn-danger btn-sm editable-cancel"><i class="glyphicon glyphicon-remove"></i></button>';
		$.fn.editableform.buttons = '<button type="submit" class="btn-sm editable-submit" style="color:green; border:none"><i class="glyphicon glyphicon-ok"></i></button><button type="button" class="btn-sm editable-cancel" style="color:red; border:none"><i class="glyphicon glyphicon-remove"></i></button>';
		//---------

		var area = $("#large-grid");
		var board = $(".board");
		var w = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
		var h = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;

		area.height(h - 140);
		board.css({
			"max-height": (h - 265)
		});

		$("#large-grid").sortable({
			// placeholder: "ui-state-highlight",
			forcePlaceholderSize: true,
			start: function(event, ui) {
				// alert("start")
				// isCard = true;
				ui.item.attr('data-previndex', ui.item.index());
				// ui.item.attr('data-prevBoard', ui.item.attr('data-board'));
				console.log("aqui start");

			},
			update: function(event, ui) {
				// gets the new and old index then removes the temporary attribute
				if (ui.item.attr('data-previndex')) {
					var newIndex = ui.item.index();
					var oldIndex = ui.item.attr('data-previndex');
					var element_id = ui.item.attr('id');
					console.log("Update: " + element_id, " cambio de posicion del " + oldIndex, " al " + newIndex, " en Board " + ui.item.attr('data-board'))
					// console.log("Update: Boards iguales ",$(event.target).attr('data-id')," y ",ui.item.attr('data-board'))
					// alert('id of Item moved = '+element_id+' old position = '+oldIndex+' new position = '+newIndex);
					ui.item.removeAttr('data-previndex');
					$.ajax({
						//url:"https://kingdeportes.com/hefestos/tcca/update/"+ui.item.attr('data-id'),
						url: "<?php echo Yii::app()->createUrl("tccd/update"); ?>?id=" + ui.item.attr('data-id'),

						method: "POST",
						data: {
							"Tcca": {
								// "TCCA_Id":event.target.attributes[1].value,
								"TCCA_Order": ui.item.index()
							},
							"Old": ui.item.attr('data-previndex'),
						},
						beforeSend: function(xhr) {
							jQuery('#progress').attr('style', 'width:100%');
						},

					}).done(function(data) {
						// alert("Actualizado");
						jQuery('#progress').attr('style', 'width:0%');
						// $.gritter.add({
						// 	position: 'bottom-left',
						// 	// (string | mandatory) the heading of the notification
						// 	title: 'Tarea Actualizada',
						// 	sticky: false,
						// 	image: '<?php echo Yii::app()->theme->baseUrl . "/img/logo-big.png"; ?>',
						// 	// (string | mandatory) the text inside the notification
						// 	text: 'Espere mientras se procesan los datos...'
						// });               

					});
					// console.log("Update",event,ui);
				}

			}

		});
		$("#large-grid").disableSelection();

		$(".sortable").sortable({
			connectWith: ".connectedSortable",
			activate: function(event, ui) {
				console.log("aqui activate");
			},
			beforeStop: function(event, ui) {
				console.log("aqui beforeStop");
			},
			change: function(event, ui) {
				console.log("aqui change");
			},
			create: function(event, ui) {
				// console.log("aqui create");
			},
			deactivate: function(event, ui) {
				console.log("aqui deactivate");
			},
			out: function(event, ui) {
				console.log("aqui out");
			},
			over: function(event, ui) {
				console.log("aqui over");
			},
			receive: function(event, ui) {

				console.log("Received: Moved from " + $(ui.sender.context).attr('data-id') + " to " + $(event.target).attr('data-id'));
				// alert(ui.item.context.attributes[2].value);
				ui.item.attr('data-board', $(event.target).attr('data-id'));

				$.ajax({
					//url:"https://kingdeportes.com/hefestos/tccd/update/"+ui.item.attr('data-id'),
					url: "<?php echo Yii::app()->createUrl("tccd/update"); ?>?id=" + ui.item.attr('data-id'),
					method: "POST",
					data: {
						"name": "TCCA_Id",
						"Tccd": {
							"TCCA_Id": $(event.target).attr('data-id'),
							"TCCD_Order": ui.item.index()
						},
						"Old": ui.item.attr('data-previndex'),
					},
					beforeSend: function(xhr) {
						jQuery('#progress').attr('style', 'width:100%');
					},

				}).done(function(data) {
					// alert("Actualizado");
					jQuery('#progress').attr('style', 'width:0%');
					// $.gritter.add({
					// 	position: 'bottom-left',
					// 	// (string | mandatory) the heading of the notification
					// 	title: 'Tarea Actualizada',
					// 	sticky: false,
					// 	image: '<?php echo Yii::app()->theme->baseUrl . "/img/logo-big.png"; ?>',
					// 	// (string | mandatory) the text inside the notification
					// 	text: 'Los cambios fueron guardados'
					// });               

				});
				// console.log("Received",event,ui);
				// console.log(event.target.id);
				// console.log(ui.sender.context.id);
				// console.log(event.target);
			},
			remote: function(event, ui) {
				console.log("aqui remote");
			},
			sort: function(event, ui) {
				console.log("aqui sort");
			},
			start: function(event, ui) {
				// alert("start")
				isCard = true;
				ui.item.attr('data-previndex', ui.item.index());
				// ui.item.attr('data-prevBoard', ui.item.attr('data-board'));
				console.log("aqui start");

			},
			stop: function(event, ui) {
				console.log("aqui stop");
			},
			update: function(event, ui) {
				// gets the new and old index then removes the temporary attribute
				if ($(event.target).attr('data-id') != ui.item.attr('data-board')) {
					console.log("Update: cambio de Boards del ", $(event.target).attr('data-id'), " al ", ui.item.attr('data-board'))
				} else if (ui.item.attr('data-previndex')) {
					var newIndex = ui.item.index();
					var oldIndex = ui.item.attr('data-previndex');
					var element_id = ui.item.attr('id');
					console.log("Update: " + element_id, " cambio de posicion del " + oldIndex, " al " + newIndex, " en Board " + ui.item.attr('data-board'))
					// console.log("Update: Boards iguales ",$(event.target).attr('data-id')," y ",ui.item.attr('data-board'))
					// alert('id of Item moved = '+element_id+' old position = '+oldIndex+' new position = '+newIndex);
					ui.item.removeAttr('data-previndex');
					$.ajax({
						//url:"https://kingdeportes.com/hefestos/tccd/update/"+ui.item.attr('data-id'),
						url: "<?php echo Yii::app()->createUrl("tccd/update"); ?>?id=" + ui.item.attr('data-id'),
						method: "POST",
						data: {
							"Tccd": {
								// "TCCA_Id":event.target.attributes[1].value,
								"TCCD_Order": ui.item.index()
							},
							"Old": ui.item.attr('data-previndex'),
						},
						beforeSend: function(xhr) {
							jQuery('#progress').attr('style', 'width:100%');
						},

					}).done(function(data) {
						// alert("Actualizado");
						jQuery('#progress').attr('style', 'width:0%');
						// $.gritter.add({
						// 	position: 'bottom-left',
						// 	// (string | mandatory) the heading of the notification
						// 	title: 'Tarea Actualizada',
						// 	sticky: false,
						// 	image: '<?php echo Yii::app()->theme->baseUrl . "/img/logo-big.png"; ?>',
						// 	// (string | mandatory) the text inside the notification
						// 	text: 'Espere mientras se procesan los datos...'
						// });               

					});
					// console.log("Update",event,ui);
				}

			}

		}).disableSelection();


		if (params.card) {
			$("#Task-" + params.card).click();
		}


	});

	function cargarTarjeta(id) {

		// $( "#modal-ajax" ).load(  );
		let aux = $("#modal-ajax").html();
		$.ajax({
			// url: "https://kingdeportes.com/hefestos/tccd/view/"+id,
			url: "<?php echo Yii::app()->createUrl("tccd/view"); ?>?id=" + id,
			beforeSend: function(xhr) {
				$("#modal-ajax").html('<div class="progress progress-striped active"><div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span class="sr-only">45% Complete</span></div></div>');
			}
		}).done(function(data) {
			// console.log(JSON.parse(data)[1])
			$("#modal-ajax").html(JSON.parse(data)[1]);

			$('.taskTitle').editable({
				mode: "inline",
				success: function(r, v) {
					const task = JSON.parse(r);
					// $('#Task-'+task.TCCD_Id).html("("+task.TCCD_Order+") "+task.TCCD_Title);
					$('#Task-' + task.TCCD_Id).html('<small style="color:darkorange;"><b>' + task.TCCD_Created + '</b></small><br/>' +
						task.TCCD_Title + (task.TCCD_Archived ? '<small class="pull-right"><i class="fa fa-save"></i> </small> ' : '') +
						'<br/><div class="toolbar" style="display:flow-root;"></div>');
					// console.log(task);
				}
			});
			$('.description').editable({
				mode: "inline"
			});
			$('#TCCD_Expired').editable({
				format: 'YYYY-MM-DD',
				yearDescending: true,
				showbuttons: 'bottom',
				placement: 'left',
				smartDays: true,

				template: 'DD MMMM YYYY',
				combodate: {
					minYear: 2020,
					maxYear: 2025,
					minuteStep: 1
				},
				success: function() {
					cargarTarjeta($('#comentInput').attr('card'));
				}

			});
			$('#TCCD_Labels').editable({
				showbuttons: 'bottom',
				placement: 'left',
				source: [<?php echo $tags; ?>],
				select2: {
					multiple: true
				},
				success: function() {
					cargarTarjeta($('#comentInput').attr('card'));
				}
			});

			$('#TCCD_Users').editable({
				showbuttons: 'bottom',
				placement: 'left',
				source: [<?php echo $jusers; ?>],
				select2: {
					multiple: true,
					// minimumInputLength: 3
				},
				success: function() {
					cargarTarjeta($('#comentInput').attr('card'));
				}
			});

			$('#GCCA_List').editable({
				showbuttons: 'bottom',
				placement: 'left',
				source: [<?php echo $jagencias; ?>],
				select2: {
					multiple: true,
					formatInputTooShort: function() {
						return "Ingrese 3 caracteres";
					},
					formatNoMatches: function() {
						return "Sin resultados";
					},
					formatSearching: function() {
						return "Buscando...";
					},
					minimumInputLength: 3
				},
				success: function() {
					cargarTarjeta($('#comentInput').attr('card'));
				}
			});
			$('#FCCU_List').editable({
				showbuttons: 'bottom',
				placement: 'left',
				source: [<?php echo $jactivos; ?>],
				select2: {
					multiple: true,
					formatInputTooShort: function() {
						return "Ingrese 3 caracteres";
					},
					formatNoMatches: function() {
						return "Sin resultados";
					},
					formatSearching: function() {
						return "Buscando...";
					},
					minimumInputLength: 3
				},
				success: function() {
					cargarTarjeta($('#comentInput').attr('card'));
				}
			});




			$('#activity').scrollTop($('#activityTable').height());
		});


	}

	function comentar() {


		$.ajax({
				url: 'comment',
				type: "POST",
				data: {
					idCard: $('#comentInput').attr('card'),
					comment: $('#comentInput').val()
				},
				beforeSend: function() {
					// alert("Enviando");
					$('#commentSend').prop("disabled", true);
					$('#comentInput').prop("disabled", true);
					$('#commentSend').html("Enviando..");
				}
			})
			.done(function(data) {
				// alert( "Data Loaded: " + data );
				cargarTarjeta($('#comentInput').attr('card'));
			});

	}




	const slide = document.querySelector("#large-grid");
	slide.style.cursor = 'grab';
	let isDown = false;

	let startX;
	let scrollLeft;

	slide.addEventListener("mousedown", e => {
		slide.style.cursor = 'grabbing';
		isDown = true;
		slide.classList.add("active");
		startX = e.pageX - slide.offsetLeft;
		scrollLeft = slide.scrollLeft;
	});
	slide.addEventListener("mouseleave", () => {
		slide.style.cursor = 'grab';
		isDown = false;
		slide.classList.remove("active");
	});
	slide.addEventListener("mouseup", () => {
		slide.style.cursor = 'grab';
		isDown = false;
		slide.classList.remove("active");
	});
	slide.addEventListener("mousemove", e => {
		if (!isDown) return;
		if (isCard) return;
		// console.log(e);
		e.preventDefault();
		const x = e.pageX - slide.offsetLeft;
		const walk = x - startX;
		slide.scrollLeft = scrollLeft - walk;
	});
</script>