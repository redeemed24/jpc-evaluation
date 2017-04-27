@include('../inc/header')

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil fa-fw"></i> Dashboard Settings Edit </h3>
			</div>
			<div class="panel-body">
				<div class="col-sm-6">
					<div class="row">
						<i>Only the selected year and semester evaluation results will reflect on Dashboard Page</i><br><br>
						{!! Form::open(array('url' => 'settings/save', 'method' => 'POST' )) !!}
						<div class="form-group">
							<label class="control-label">Year</label>
							{!! Form::select('year', $years , $admin_settings['year'], array('class' => 'form-control', )); !!}	
							{{-- <input type="text" class="form-control" name="year" value="{{ $admin_settings['year'] }}" required> --}}
						</div>

						<div class="form-group">
							<label class="control-label">Semester</label>
							{!! Form::select('semester', ['1st' => '1st', '2nd' => '2nd'], $admin_settings['semester'], array('class' => 'form-control', )); !!}	
							
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