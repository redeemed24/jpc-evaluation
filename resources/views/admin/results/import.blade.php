@include('../inc/header')

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-upload fa-fw"></i>
					Import excel file from previous evaluations
				</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-6">
						{!! Form::open(array('url' => 'import', 'method' => 'POST', 'enctype'=> "multipart/form-data" )) !!}

						<?php foreach($fillables as $key => $value): ?>
						<div class="form-group">

							<?php if(!in_array($value, $fields['excludes'])): ?>
							<label class="control-label"><?= (array_key_exists($value, $fields['text_replace'])) ? $fields['text_replace'][$value] : str_replace('_', ' ', ucfirst($value)) ?></label>
							<?php endif ?>
							
							<?php if(in_array($value, $fields['checkboxes'])): ?>
								<input type="checkbox" class="form-control" name="{{ $value }}">
							<?php elseif(in_array($value, $fields['dates'])): ?>
								<input type="date" class="form-control" name="{{ $value }}">
							<?php elseif(in_array($value, $fields['textareas'])): ?>
								<textarea class="form-control" name="{{ $value }}"></textarea>
							<?php elseif(array_key_exists($value, $fields['dropdowns'])): ?>
								{!! Form::select($value, $fields['dropdowns'][$value], '', array('class' => 'form-control', )); !!}	
							<?php elseif(in_array($value, $fields['hiddens'])): ?>
								<input type="hidden" class="form-control" name="{{ $value }}">
							<?php elseif(in_array($value, $fields['times'])): ?>
								<input type="text" id="timepicker" class="form-control" name="{{ $value }}">
							<?php elseif(in_array($value, $fields['excludes'])): ?>
								{{-- do nothing --}}
							<?php else: ?>
								<input type="text" class="form-control" name="{{ $value }}">
							<?php endif; ?>

						</div>
						<?php endforeach; ?>
						
						<div class="form-group">
							<label>Excel File</label>
							<input type="file" name="import_file" class="btn btn-success"  accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel, .ods">
						</div>

						<div class="form-group">
							<button class="btn btn-primary pull-right"><i class="fa fa-save"></i> Save</button>
						</div>
						{!! Form::close() !!}
					</div>
				</div>
				
			</div>
		</div>

	</div>
</div>

@include('../inc/footer')
