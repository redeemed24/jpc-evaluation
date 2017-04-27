@include('inc/evaluation-header');


<div class="container">
	<div class="col-sm-offset-4 col-sm-4">
		<center>
	{!! Html::image('../resources/assets/img/jp_logo.png',null, array('title' => 'logo', 'class' => 'img-responsive', 'style' => 'width:40%;'),null) !!}
	</center>
	</div>
	<div class="col-sm-offset-4 col-sm-4 well top10 login-container">
		@if(Session::has('message'))
		 <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
		@endif

		{!! Form::open(array('url' => 'evaluate', 'method' => 'POST')) !!}
		<div class="form-group">
			<center>
			<label>Select Teacher</label>
			</center>
			<select class="form-control" name="evaluation_id">
				<option value="">Select Teacher</option>
				<?php foreach ($data as $key => $value): ?>
				<option value="<?= $value->evaluation_id ?>"><?= $value->name." | ".$value->subject_code." | ".$value->subject_time.' | '.$value->evaluation_year.' | '.$value->semester.' Sem ' ?></option>
				<?php endforeach; ?>
			</select>

		</div>

		<div class="form-group">
			<center>
			<label>School ID</label>
			</center>
			<input type="text" class="login_school_id" name="school_id" placeholder="Optional">
		</div>

		<div class="form-group">
			<input  type="hidden" name="_token" value="{{ csrf_token() }}">
			<button class="btn btn-primary col-sm-12">Login</button>
		</div>
		{!! Form::close() !!}
	</div>
</div>	

@include('inc/evaluation-footer');





