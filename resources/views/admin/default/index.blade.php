@include('../inc/header')

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-list fa-fw"></i> List of {{ str_replace('_', ' ', ucfirst($controller)) }}</h3>
			</div>
			<div class="panel-body">

				<a href="{{url($controller.'/create')}}"><button class="btn btn-success"><i class="fa fa-plus fa-fw"></i> Add new</button></a>
				<hr>
				<table class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<?php foreach($columns as $key => $value): ?>
								<th><?= (array_key_exists($value, $fields['text_replace'])) ? str_replace('_',' ',ucfirst($fields['text_replace'][$value])) : str_replace('_',' ',ucfirst($value)) ?></th>
							<?php endforeach; ?>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($data as $key => $value): ?>
							<tr>
								<?php foreach($columns as $col_key => $col_val): ?>
									<td>
										<?php 
										if($col_val == 'created_at' || $col_val == 'updated_at'){
											echo date('F d, Y H:i:s', strtotime($value[$col_val]));
										}elseif(array_key_exists($col_val, $column_values)){
											echo $column_values[$col_val][$value[$col_val]];
										}else{
											$str = substr($value[$col_val], 0, 60);
											$dots = (strlen($value[$col_val]) > 60) ? '...' : '';
											echo $str.$dots;
										}
										?>
									</td>
								<?php endforeach; ?>
								<?php $url = url($controller.'/'.$value[$primary_key]).'/edit' ?>
								<td>
									<a href="<?= $url ?>"><button class="btn btn-default btn-xs pull-left"><i class="fa fa-search"></i></button></a>
									{!! Form::open(array('url' => $controller.'/'.$value[$primary_key], 'method' => 'DELETE', 'class' => 'delete-form' )) !!}
									<button class="btn btn-danger btn-xs pull-right"><i class="fa fa-trash-o"></i></button>
									{!! Form::close() !!}
								</td>
							</tr>
						<?php endforeach; ?>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@include('../inc/footer')