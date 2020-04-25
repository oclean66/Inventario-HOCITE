<?php
// css/plugins/xeditable/bootstrap-editable.css
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/css/plugins/xeditable/bootstrap-editable.css', 'screen');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/css/plugins/icheck/all.css', 'screen');
// Yii::app()->clientScript->registerCssFile('https://raw.githubusercontent.com/fronteed/icheck/1.x/skins/flat/orange.css', 'screen');

// // Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/plugins/jquery-ui/jquery.ui.droppable.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/plugins/jquery-ui/jquery.ui.draggable.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/plugins/xeditable/bootstrap-editable.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/plugins/icheck/jquery.icheck.min.js');
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
		
		<h3 class="nopadding nomargin">
			<a href="<?php echo Yii::app()->createUrl('tcca')?>" class="btn ">
				<i class="fa fa-arrow-left"></i>
			</a>
				<span style="display:inline-flex" data-url="<?php echo Yii::app()->createUrl('tcca/update',array('id'=>$model->TCCA_Id))?>" 
				class="listTitle" data-placement="bottom" id="TCCA_Name" data-mode="popup"
				data-type="text" data-pk="<?php echo $model->TCCA_Id; ?>" data-id="<?php echo $model->TCCA_Id; ?>"  >
				<?php echo $model->TCCA_Name; ?>
			</span>
		</h3>
	</div>
	<div class="pull-right">
	
		<div class="btn-toolbar">
			
					<?php if($model->TCCA_Archived){ 
						echo "<div class='btn-group'>
						<div class='btn btn-danger'><i class='fa fa-book'></i> Archivado el ".date("d M",strtotime($model->TCCA_Archived)).'</div>
						</div>';
						}
					?>
							
			
			<div class="btn-group /*hidden-768*/">

				<div class="dropdown">
					<a href="#" class="btn" data-toggle="dropdown" rel="tooltip" data-placement="top" title="" data-original-title="Participantes del Tablero">
					<i class="fa fa-group"></i>
						<span class="caret"></span>
					</a>
					<div class="dropdown-menu user-list dropdown-menu-right" style="top:30px;padding:0;box-shadow: 2px 2px 4px 2px lightgrey;border: grey 1px solid;border-radius: 5px;">
						
							<h4 style="margin:0;">Participantes</h4>
							<div class="box-content nopadding scrollable"  data-visible="true" style="overflow: hidden; width: auto;">
								<table class="table table-user table-nohead nomargin">
									<tbody>
										<tr>
											<td colspan="2" class="nopadding">
												<a href="#" class="btn btn-block btn-text-left">
													<i class="fa fa-plus-square"></i> Invitar al Tablero
												</a>
											</td>									
										</tr>

										<tr>																					
											<td  class="user">
												<i class="fa fa-user"></i> Dan Doe
											</td>
											<td class="icon">  
												<a href="#" class="btn" onClick="alert('Estas seguro que quieres eliminar este participante?')">
													<i class="fa fa-times"></i>
												</a>
											</td>
										</tr>
										
										
										<tr>
											<td colspan="2" class="nopadding">
												<a href="#" onClick="alert('Estas seguro que quieres dejar el tablero?')" class="btn btn-block btn-text-left btn-danger nomargin">
													<i class="fa fa-sign-out"></i> Dejar el Tablero
												</a>
											</td>										
										</tr>
									</tbody>
								</table>
							</div>
						
					</div>
				</div>
			</div>
			

			<div class="btn-group /*hidden-768*/">

				<div class="dropdown">
					<a href="#" class="btn" data-toggle="dropdown" rel="tooltip" data-placement="top" title="" data-original-title="Opciones del Tablero">
						<i class="fa fa-cog"></i>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu dropdown-menu-right">
						<?php if(!$model->TCCA_Archived){ ?>
							<li>
								<!-- <a href="#"> Archivar este Tablero</a> -->
								<?php 
										echo CHtml::ajaxLink(
											'Archivar este Tablero',          // the link body (it will NOT be HTML-encoded.)
											array('delete','id'=>$model->TCCA_Id), // the URL for the AJAX request. If empty, it is assumed to be the current URL.
											array(
												'type'=>'POST',
												'beforeSend' => 'function() {           
													$("#List-'.$model->TCCA_Id.'").css("opacity","0.5");
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
						<?php }?>
						<li>
							<a href="#"> Listas Archivadas</a>
						</li>
					</ul>
				</div>
			</div>


			
		</div>	
	</div>
</div>






<div id="large-grid" style="display:flex;overflow:auto;">
	<?php 
		foreach ($lists as $value) {
			// print_r($value);
			?>
			<div class="box box-small" id="List-<?php echo $value['id']; ?>">
			<!-- <div class="progress"> <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width:45%"><span class="sr-only">45% Complete</span></div> </div> -->

				<div class="box-title" style="margin-top:5px;">
					<h3>
						<i class="fa fa-inbox"></i>
						<span data-url="<?php echo Yii::app()->createUrl('tcca/update',array('id'=>$value['id']))?>" 
							class="listTitle" data-placement="right" id="TCCA_Name" 
							data-type="text" data-pk="<?php echo $value['id']; ?>" data-id="<?php echo $value['id']; ?>" 
							data-original-title="Nombre de la Lista">
							<?php echo $value['name']?>
						</span>
					</h3>
					<div class="actions" style="margin-top:0">
								
						<span class="dropdown">
							<a href="#" class="btn btn-mini btn-primary dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-bars"></i>
							</a>
							<ul class="dropdown-menu dropdown-menu-right">
								<li class="dropdown-header">Opciones</li>
								<!-- <li>
									<a href="#" onclick="$('#TCCA_New<?php echo $value["id"]; ?>').innerHtml=Date()">Agregar Tarjeta</a>
								</li> -->
								<!-- <li>
									<a href="#">Ordenar por...</a>
								</li> -->
								<!-- <li class="divider"></li> -->
								<li>
									<!-- <a href="#">Archivar todas las tarjetas</a> -->
									<?php 
									echo CHtml::ajaxLink(
										'Archivar todas las tarjetas',          // the link body (it will NOT be HTML-encoded.)
										array('deleteAll','id'=>$value['id']), // the URL for the AJAX request. If empty, it is assumed to be the current URL.
										array(
											'type'=>'POST',
											'beforeSend' => 'function() {           
												$("#List-'.$value['id'].'").css("opacity","0.5");
											}',
											'complete' => 'function(data, value) {
												console.log(data, value);
												if(data.responseText=="All Archived")
												{
													$("#List-'.$value['id'].'").css("opacity","1");
												  	$("#Board-'.$value['id'].'").html("");
												  }
											}',        
										)
									);
									?>
								</li>
								<li>
									<a href="#">Tarjetas Archivadas</a>
								</li>
								
								<li class="divider"></li>
								<li>
									<!-- <a href="#">Archivar Esta Lista</a> -->
									<?php 
									echo CHtml::ajaxLink(
										'Archivar Esta Lista',          // the link body (it will NOT be HTML-encoded.)
										array('delete','id'=>$value['id']), // the URL for the AJAX request. If empty, it is assumed to be the current URL.
										array(
											'type'=>'POST',
											'beforeSend' => 'function() {           
												$("#List-'.$value['id'].'").css("opacity","0.5");
											 }',
											'complete' => 'function(data, value) {
											  console.log(data, value);
											  if(data.responseText=="Archived")
											  	$("#List-'.$value['id'].'").addClass("hidden");
											}',        
										)
									);
									?>
								</li>
							</ul>
						</span>

					</div>
				</div>
				<div 
					id="Board-<?php echo $value['id']; ?>" 
					data-pk="<?php echo $value['id']; ?>" 
					data-id="<?php echo $value['id']; ?>" 
					class="box-content board connectedSortable sortable" 
				>
				<?php 
					foreach ($value['task'] as $task) {						
						?>
							<div  
								id="Task-<?php echo $task->TCCD_Id; ?>" 
								class="alert alert-card "		
								data-board="<?php echo $value['id']; ?>"
								data-pos="<?php echo $task->TCCD_Order; ?>"
								data-toggle="modal" 
								data-id="<?php echo $task->TCCD_Id; ?>" 
								data-target=".bs-example-modal-lg"
								> 

									<?php echo $task->TCCD_Title; ?>
									<br/>
									<div class="toolbar">
										<!-- <i class="fa fa-square-o"></i>
										<i class="fa fa-refresh"></i>
										<i class="fa fa-inbox"></i>
										<i class="fa fa-exclamation-triangle"></i>
										<i class="fa fa-trash-o"></i> -->
										
										<?php echo $task->TCCD_Archived ? '<i class="fa fa-folder"></i>' :''; ?>							
									</div>
							</div>	
						<?php
					}
				?>  						
				</div>
				<div class="box-footer" style="padding:10px;border-radius:5px;">					
						<span 
							id="TCCA_New"
							role="button" 
							class="newCard btn btn-block btn-mini" 
							style="text-align:left;padding:5px;" 
							data-type="text"
							data-display="false"
							data-pk="<?php echo $value['id']; ?>"
							data-id="<?php echo $value['id']; ?>"
							data-url="<?php echo Yii::app()->createUrl('tccd/create',array('id'=>$value['id']))?>"
							data-value=""
							data-placeholder="Nombre de la Tarjeta"
							>
							<i class="fa fa-plus"></i> Agregar Tarjeta
						</span>		
				</div>
			</div>
			<?php
		}
	?>  

	<div class="box box-small" >
		<div class="box-title" style="margin-top:5px;">
			<h3 
				data-url="<?php echo Yii::app()->createUrl('tcca/view',array('id'=>$model->TCCA_Id))?>" 
				class="newList btn btn-block btn-mini" 
				style="text-align: left;" 
				data-placement="right" 
				id="TCCA_New" 
				data-defaultValue=""  
				data-value=""					
				data-type="text" 
				data-pk="<?php echo $model->TCCA_Id; ?>" 
				data-id="<?php echo $model->TCCA_Id; ?>" 
				data-placeholder="Nombre de la Lista"
			>
				<i class="fa fa-plus"></i> Agregar Lista
				
			</h3>							
		</div>
		
	</div>

</div>	  




<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			
			<div class="modal-body" id="modal-ajax">
				

				<div class="row">					
					<div class="col-sm-10">
						<h4 class="modal-title" id="myModalLabel">
							<a href="#" class="listTitle" data-placement="right">Modal title</a>
						</h4>

						<span>En la Lista Pendientes</span>
						<br/>
						<h5 style="margin-top:0">Descripcion</h5>
						<p 
							data-tpl='<textarea class="form-control " rows="7" style="width: 637px;margin: 0px 0px 10px;height: 99px;"></textarea>' 
							data-url="<?php echo Yii::app()->createUrl('tcca/update',array('id'=>$model->TCCA_Id))?>" 
							class="listTitle" 
							data-placement="bottom" 
							id="TCCA_Name" 
							style="padding: 10px; background-color: rgb(238, 238, 238);border-radius: 5px;font-weight: bolder;"
							data-type="textarea" 
							data-showbuttons= 'bottom'
							data-pk="<?php echo $model->TCCA_Id; ?>" 
							data-id="<?php echo $model->TCCA_Id; ?>" 
							data-original-title="Nombre del Tablero">Lorem ipsum anim ad culpa ex id anim Excepteur esse et do cillum dolor in dolore cillum. Lorem ipsum Ut est consequat pariatur sint ut incididunt nisi dolore occaecat.</p>


						<div class="box box-color box-bordered lightgrey">
							<div class="box-title" style="margin-top:0px;">
								<h3><i class="fa fa-check"></i>Tareas</h3>
								<div class="actions">
									<a href="#new-task" data-toggle="modal" class="btn btn-mini">
										<i class="fa fa-plus-circle"></i> Nueva Tarea</a>
								</div>
							</div>
							<div class="box-content nopadding">
								<ul class="tasklist ui-sortable">
									

									<li class="bookmarked">
										<div class="check">
											<div class="icheckbox_square-blue" >
												<!-- <input type="checkbox" class="icheck-me" data-skin="square" data-color="blue" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"> -->
												<input tabindex="1" type="checkbox" data-skin="square" data-color="blue" class="icheck-me" id="input-1">
												<label for="this" style="display:none;"> </label>
												<!-- <ins style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins> -->
											</div>
										</div>
										<span class="task">
											<!-- <i class="fa fa-bar-chart-o"></i> -->
											<span>Check statistics</span>
										</span>
										<span class="task-actions">
											<a href="#" class="task-delete" rel="tooltip" title="" data-original-title="Delete that task">
												<i class="fa fa-times"></i>
											</a>
											<!-- <a href="#" class="task-bookmark" rel="tooltip" title="" data-original-title="Mark as important">
												<i class="fa fa-bookmark-empty"></i>
											</a> -->
										</span>
									</li>

									<li>
										<div class="check">
											<div class="icheckbox_square-blue" >
												<!-- <input type="checkbox" class="icheck-me" data-skin="square" data-color="blue" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"> -->
												<input tabindex="1" type="checkbox" data-skin="square" data-color="blue" class="icheck-me" id="input-1">
												<label for="this" style="display:none;"> </label>
												<!-- <ins style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins> -->
											</div>
										</div>
										<span class="task">
											<i class="fa fa-bar-chart-o"></i>
											<span>Check statistics</span>
										</span>
										<span class="task-actions">
											<a href="#" class="task-delete" rel="tooltip" title="" data-original-title="Delete that task">
												<i class="fa fa-times"></i>
											</a>
											<!-- <a href="#" class="task-bookmark" rel="tooltip" title="" data-original-title="Mark as important">
												<i class="fa fa-bookmark-empty"></i>
											</a> -->
										</span>
									</li>

									<li class="done">
										<div class="check">
											<div class="icheckbox_square-blue checked" >
											<!-- <input type="checkbox" class="icheck-me" data-skin="square" data-color="blue"  style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"> -->
											<input tabindex="1" type="checkbox" data-skin="square" data-color="blue"  class="icheck-me" id="input-1">

											<label for="this" style="display:none;"> </label>

											
											</div>
										</div>
										<span class="task">
											<i class="fa fa-envelope"></i>
											<span>Check for new mails</span>
										</span>
										<span class="task-actions">
											<a href="#" class="task-delete" rel="tooltip" title="" data-original-title="Delete that task">
												<i class="fa fa-times"></i>
											</a>
											<a href="#" class="task-bookmark" rel="tooltip" title="" data-original-title="Mark as important">
												<i class="fa fa-bookmark-o"></i>
											</a>
										</span>
									</li>
									<!-- <li>
										<div class="check">
											<div class="icheckbox_square-blue" style="position: relative;">
												<input type="checkbox" class="icheck-me" data-skin="square" data-color="blue" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;">
												
												<label for="this" style="display:none;"> </label>

											</div>
										</div>
										<span class="task">
											<i class="fa fa-comment"></i>
											<span>Chat with John Doe</span>
										</span>
										<span class="task-actions">
											<a href="#" class="task-delete" rel="tooltip" title="" data-original-title="Delete that task">
												<i class="fa fa-times"></i>
											</a>
											<a href="#" class="task-bookmark" rel="tooltip" title="" data-original-title="Mark as important">
												<i class="fa fa-bookmark-o"></i>
											</a>
										</span>
									</li>
									<li>
										<div class="check">
											<div class="icheckbox_square-blue" style="position: relative;">
												<input type="checkbox" class="icheck-me" data-skin="square" data-color="blue" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;">
												<label for="this" style="display:none;"> </label>

											</div>
										</div>
										<span class="task">
											<i class="fa fa-retweet"></i>
											<span>Go and tweet some stuff</span>
										</span>
										<span class="task-actions">
											<a href="#" class="task-delete" rel="tooltip" title="" data-original-title="Delete that task">
												<i class="fa fa-times"></i>
											</a>
											<a href="#" class="task-bookmark" rel="tooltip" title="" data-original-title="Mark as important">
												<i class="fa fa-bookmark-o"></i>
											</a>
										</span>
									</li>
									<li>
										<div class="check">
											<div class="icheckbox_square-blue" style="position: relative;">
											<input type="checkbox" class="icheck-me" data-skin="square" data-color="blue" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;">
											<label for="this" style="display:none;"> </label>

											</div>
										</div>
										<span class="task">
											<i class="fa fa-edit"></i>
											<span>Write an article</span>
										</span>
										<span class="task-actions">
											<a href="#" class="task-delete" rel="tooltip" title="" data-original-title="Delete that task">
												<i class="fa fa-times"></i>
											</a>
											<a href="#" class="task-bookmark" rel="tooltip" title="" data-original-title="Mark as important">
												<i class="fa fa-bookmark-o"></i>
											</a>
										</span>
									</li> -->
								</ul>
							</div>
						</div>

						<div class="box box-color box-bordered green">
							<div class="box-title">
								<h3>
									<i class="fa fa-bullhorn"></i> Actividad Reciente
								</h3>
								
							</div>
							<div class="box-content" style="padding:0">
								<table class="table table-nohead" id="">
									<tbody>
										<tr style="display: table-row;">
											<td>
												<span class="label label-info">
												<i class="fa fa-shopping-cart"></i>
												</span> New order received
											</td>
										</tr>
										<tr style="display: table-row;">
											<td>
												<span class="label label-warning">
													<i class="fa fa-comment"></i>
												</span> 
												<a href="#">John Doe</a> commented on <a href="#">News #123</a>
											</td>
										</tr>
									
										<tr style="display: table-row;">
											<td>
												<span class="label label-info">
													<i class="fa fa-shopping-cart"></i>
												</span> New order received
											</td>
										</tr>
										<tr style="display: table-row;">
											<td>
												<span class="label label-info">
												<i class="fa fa-shopping-cart"></i>
												</span> New order received
											</td>
										</tr>
										<tr style="display: table-row;">
											<td>
												<span class="label label-warning">
												<i class="fa fa-comment"></i></span> 
												<a href="#">John Doe</a> commented on <a href="#">News #123</a>
											</td>
										</tr>
										<tr style="display: table-row;">
											<td>
												<span class="label label-default">
												<i class="fa fa-plus-square"></i></span> 
												<a href="#">John Doe</a> added a new photo
											</td>
										</tr>
										<tr style="display: table-row;">
											<td>
												<span class="label label-default">
												<i class="fa fa-plus-square"></i></span> 
												<a href="#">John Doe</a> added a new photo
											</td>
										</tr>
										<tr style="display: table-row;">
											<td>
												<span class="label label-default">
												<i class="fa fa-plus-square"></i></span> 
												<a href="#">John Doe</a> added a new photo
											</td>
										</tr>
										<tr style="display: table-row;">
											<td>
												<span class="label label-warning">
												<i class="fa fa-comment"></i></span> 
												<a href="#">John Doe</a> commented on <a href="#">News #123</a>
											</td>
										</tr>
										<tr style="display: table-row;">
											<td>
												<span class="label label-success">
												<i class="fa fa-user"></i></span> New user registered</td></tr>
										<tr style="display: table-row;">
											<td>
												<span class="label label-warning">
												<i class="fa fa-comment"></i></span> 
												<a href="#">John Doe</a> commented on <a href="#">News #123</a>
											</td>
										</tr>
										<tr style="display: table-row;">
											<td>
												<span class="label label-warning">
												<i class="fa fa-comment"></i></span> 
												<a href="#">John Doe</a> commented on <a href="#">News #123</a>
											</td>
										</tr>
										<tr style="display: table-row;">
											<td>
											<span class="label label-success">
											<i class="fa fa-user"></i></span> New user registered</td></tr>
										<tr>
											<td>
												<span class="label label-default">
												<i class="fa fa-plus-square"></i></span>
												<a href="#">John Doe</a>added a new photo</td>
										</tr>
										<tr>
											<td>
												<span class="label label-success">
												<i class="fa fa-user"></i></span>New user registered</td>
										</tr>
										<tr>
											<td>
												<span class="label label-info">
												<i class="fa fa-shopping-cart"></i></span>New order received</td>
										</tr>
										<tr>
											<td>
												<span class="label label-warning">
												<i class="fa fa-comment"></i></span><a href="#">John Doe</a>commented on<a href="#">News #123</a>
											</td>
										</tr>
										<tr>
											<td>
												<span class="label label-success">
												<i class="fa fa-user"></i></span>New user registered</td>
										</tr>
										<tr>
											<td>
												<span class="label label-info">
												<i class="fa fa-shopping-cart"></i></span>New order received</td>
										</tr>
										<tr>
											<td>
												<span class="label label-warning">
												<i class="fa fa-comment"></i></span><a href="#">John Doe</a>commented on<a href="#">News #123</a>
											</td>
										</tr>
									</tbody>
								</table>
							</div>													
							
						</div>

					</div>

					<div class="col-sm-2">
					
						<h5>Content</h5>

						<button type="button" class="btn btn-default btn-block" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary btn-block">Save changes</button>

						<h5>Content</h5>

						<button type="button" class="btn btn-default btn-block" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary btn-block">Save changes</button>

					</div>	

				</div>
				
			</div>		
		</div>
	</div>	
</div>





<!-- //---------------------------- -->

<style>
	.toolbar{
		padding-top:5px;
	}
	.box-small{
	
		border-radius:3px;
		padding:5px;
		margin-right:5px;
		background:#eeeeee;
		min-width:280px;
		height: fit-content;
	}
	.board{
		overflow:auto;
		height:100%;
		background:#eeeeee !important;

	}
	.alert-card{
		background-color:#fff;
		margin-bottom:5px;
		padding-left: 10px;
		padding-right: 10px;
		padding-bottom:5px;
		padding-top:5px;
		font-size:14px;
		box-shadow: 0px 1px 2px #a0a0a0;

	}
	.alert-dismissable .close {
		right:0;
	}
	.ui-state-highlightme{
		height:300px !important;
		background:#deffde;
		border-radius:5px;
	}
	.ui-state-highlighttw{
		/* height:300px !important; */
		background:#deffde !important;
	}
</style>

<!-- //----------------------- -->

<script>
	let isCard = false;

	$( function() {
		// $('.alert-card').click()
		$( ".alert-card" ).click(function() {
			// $( "#modal-ajax" ).load(  );
			let aux = $("#modal-ajax").html();
			$.ajax({
  				url: "https://kingdeportes.com/hefestos/tccd/view/"+$(this).attr("data-url"),
				beforeSend: function( xhr ) {
					$("#modal-ajax").html('<div class="progress progress-striped active"><div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span class="sr-only">45% Complete</span></div></div>');
				}
			}).done(function( data ) {
				$("#modal-ajax").html(data);
				// const vari = JSON.parse(data);
				// 	if ( console && console.log ) {
				// 	console.log( "Sample of data:", vari.TCCD_Title );
				// 	$('.icheckme').iCheck({
				// 		checkboxClass: 'icheckbox_square',
				// 		radioClass: 'iradio_square',
				// 		increaseArea: '20%' // optional
				// 	});
				// 	}
			});

		});

		//editables
		$('.listTitle').editable({
			mode:"inline"
		});

		$('.newList').editable({
			mode:"inline",
			success: function(response, newValue) {
				location.reload();
				console.log(response);
				// $('#large-grid .box:last').before('<div class="box box-small"><div class="box-title" style="margin-top:5px;"><h3><i class="fa fa-inbox"></i><span data-url="/hefestos/tcca/update/21.html" class="listTitle editable editable-click" data-placement="right" id="TCCA_Name" data-type="text" data-pk="21" data-id="21" data-original-title="Nombre de la Lista" style="display: inline;">'+newValue+'</span></h3><div class="actions" style="margin-top:0"><span class="dropdown"><a href="#" class="btn btn-mini btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i></a><ul class="dropdown-menu dropdown-menu-right"><li class="dropdown-header">Opciones</li><li><a href="#">Agregar Tarjeta</a></li><li><a href="#">Ordenar por...</a></li><li class="divider"></li><li><a href="#">Archivar todas las tarjetas</a></li><li><a href="#">Tarjetas Archivadas</a></li><li class="divider"></li><li><a href="#">Archivar Esta Lista</a></li></ul></span></div></div><div id="board21" class="box-content board connectedSortable sortable ui-sortable" style="max-height: 626px;">  </div><div class="box-footer" style="padding:10px;border-radius:5px;"><span id="TCCA_New" role="button" class="newCard btn btn-block btn-mini editable editable-click" style="text-align:left;padding:5px;" data-type="text" data-display="false" data-pk="21" data-url="/hefestos/tccd/create/21.html" data-value="" data-placeholder="Nombre de la Tarjeta"><i class="fa fa-plus"></i> Agregar Tarjeta</span></div></div>');
				// $('.newList').editable({value:''});
			}
		});

		$('.newCard').editable({
			mode:"inline",		
			success: function(response, newValue) {
				// $('.newCard').editable('value', '');
				$(this).editable('setValue', "", true);   
				// setValue(value, convertStr)
				// $(this).text("");
				const variables = JSON.parse(response)
				// location.reload();
				
				$('#Board-'+variables.board).append(
					'<div  data-toggle="modal" id="Task-'+variables.id+'" data-url="'+variables.id+'" data-target=".bs-example-modal-lg" class="alert alert-card">'+
					'  '+newValue+
					'	<br/>'+
					'	<div class="toolbar">'+
					'		<i class="fa fa-square-o"></i>'+
					'		<i class="fa fa-refresh"></i>'+
					'		<i class="fa fa-inbox"></i>'+
					'		<i class="fa fa-exclamation-triangle"></i>'+
					'		<i class="fa fa-trash-o"></i>'+
					'		<i class="fa fa-folder"></i>'+
					'	</div>'+
					'</div>'
				);

				$( "#Task-"+variables.id ).click(function() {
					// $( "#modal-ajax" ).load(  );
					let aux = $("#modal-ajax").html();
					$.ajax({
						url: "https://kingdeportes.com/hefestos/tccd/view/"+$(this).attr("data-url"),
						beforeSend: function( xhr ) {
							$("#modal-ajax").html('<div class="progress progress-striped active"><div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span class="sr-only">45% Complete</span></div></div>');
						}
					}).done(function( data ) {
						$("#modal-ajax").html(aux);
						const vari = JSON.parse(data);
							if ( console && console.log ) {
							console.log( "Sample of data:", vari.TCCD_Title );
							$('.icheckme').iCheck({
								checkboxClass: 'icheckbox_square',
								radioClass: 'iradio_square',
								increaseArea: '20%' // optional
							});
							}
					});

				});

				
				console.log('#board'+variables.board, newValue)

			}
		});
		//---------

		var area = $( "#large-grid" );
		var board = $( ".board" );
		var w = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
		var h = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;

		area.height(h-140);
		board.css({"max-height":(h-265)});

		$( "#large-grid" ).sortable({
			// placeholder: "ui-state-highlight",
			forcePlaceholderSize: true
			});
		$( "#large-grid" ).disableSelection();

		$( ".sortable" ).sortable({		
			connectWith: ".connectedSortable",			
			activate:function( event, ui){
				console.log("aqui activate");
			},
			beforeStop:function( event, ui){
				console.log("aqui beforeStop");
			},
			change:function( event, ui){
				console.log("aqui change");
			},
			create:function( event, ui){
				console.log("aqui create");
			},
			deactivate:function( event, ui){
				console.log("aqui deactivate");
			},
			out:function( event, ui){
				console.log("aqui out");
			},
			over:function( event, ui){
				console.log("aqui over");
			},
			receive: function( event, ui ) {
			
				console.log("Received: Moved from "+$(ui.sender.context).attr('data-id')+" to "+$(event.target).attr('data-id'));
				// alert(ui.item.context.attributes[2].value);
				ui.item.attr('data-board', $(event.target).attr('data-id'));
				
				$.ajax({
					url:"https://kingdeportes.com/hefestos/tccd/update/"+ui.item.attr('data-id'),
					method: "POST",
					data:{ 
						"Tccd":{
							"TCCA_Id":$(event.target).attr('data-id'),
							"TCCD_Order":ui.item.index()
						},
						"Old":ui.item.attr('data-previndex'), 
					},
					beforeSend: function( xhr ) {
						jQuery('#progress').attr('style', 'width:100%');
					},
					
				}).done(function( data ) {
					// alert("Actualizado");
					jQuery('#progress').attr('style', 'width:0%');
						$.gritter.add({
							position: 'bottom-left',
							// (string | mandatory) the heading of the notification
							title: 'Tarea Actualizada',
							sticky: false,
							image: '<?php echo Yii::app()->theme->baseUrl . "/img/logo-big.png"; ?>',
							// (string | mandatory) the text inside the notification
							text: 'Espere mientras se procesan los datos...'
						});               

				});
				// console.log("Received",event,ui);
				// console.log(event.target.id);
				// console.log(ui.sender.context.id);
				// console.log(event.target);
			},
			remote:function( event, ui){
				console.log("aqui remote");
			},
			sort:function( event, ui){
				console.log("aqui sort");
			},
			start: function( event, ui ) {
				// alert("start")
				isCard = true;
				ui.item.attr('data-previndex', ui.item.index());
				// ui.item.attr('data-prevBoard', ui.item.attr('data-board'));
				console.log("aqui start");
				
			},
			stop:function( event, ui){
				console.log("aqui stop");
			},						
			update: function(event, ui) {
				// gets the new and old index then removes the temporary attribute
				if($(event.target).attr('data-id')!=ui.item.attr('data-board'))
				{
					console.log("Update: cambio de Boards del ",$(event.target).attr('data-id')," al ",ui.item.attr('data-board'))
				}
				else if(ui.item.attr('data-previndex')){
					var newIndex = ui.item.index();
					var oldIndex = ui.item.attr('data-previndex');
					var element_id = ui.item.attr('id');
					console.log("Update: "+element_id," cambio de posicion del "+oldIndex," al "+newIndex, " en Board "+ui.item.attr('data-board'))
					// console.log("Update: Boards iguales ",$(event.target).attr('data-id')," y ",ui.item.attr('data-board'))
					// alert('id of Item moved = '+element_id+' old position = '+oldIndex+' new position = '+newIndex);
					ui.item.removeAttr('data-previndex');
					$.ajax({
						url:"https://kingdeportes.com/hefestos/tccd/update/"+ui.item.attr('data-id'),
						method: "POST",
						data:{ 
							"Tccd":{
								// "TCCA_Id":event.target.attributes[1].value,
								"TCCD_Order":ui.item.index()
							},
							"Old":ui.item.attr('data-previndex'), 
						},
						beforeSend: function( xhr ) {
							jQuery('#progress').attr('style', 'width:100%');
						},
						
					}).done(function( data ) {
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
	
	
	} );



	const slide = document.querySelector("#large-grid");
	slide.style.cursor= 'grab';
	let isDown = false;
	
	let startX;
	let scrollLeft;

	slide.addEventListener("mousedown", e => {
		slide.style.cursor= 'grabbing';
	isDown = true;
	slide.classList.add("active");
	startX = e.pageX - slide.offsetLeft;
	scrollLeft = slide.scrollLeft;
	});
	slide.addEventListener("mouseleave", () => {
		slide.style.cursor= 'grab';
	isDown = false;
	slide.classList.remove("active");
	});
	slide.addEventListener("mouseup", () => {
		slide.style.cursor= 'grab';
	isDown = false;
	slide.classList.remove("active");
	});
	slide.addEventListener("mousemove", e => {
	if (!isDown ) return;
	if (isCard ) return;
	// console.log(e);
	e.preventDefault();
	const x = e.pageX - slide.offsetLeft;
	const walk = x - startX;
	slide.scrollLeft = scrollLeft - walk;
	});


</script>