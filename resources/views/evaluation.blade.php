@include('inc/evaluation-header')
<div style="background-color:#3b5998;min-height:2200px;">
<div class="col-sm-offset-2 col-sm-8" style="background:#fff;">

	<div class="col-sm-12">
		<center>
			<p>JOHN PALL II COLLEGE OF DAVAO</p>
			<br>
			<p>Ecoland Drive, Matina, Davao City</p>

			<h4>EVALUATION OF INSTRUCTOR'S PERFORMANCE</h4>
		</center>
	</div>
	
	<div class="col-sm-12">
		<label>Direction</label>
		<p>Asses the performance of the above-name instructor on each factor listed below by writing the number which best describes your instructor according to the following scale below:</p>
	</div>
	

	<div class="col-sm-12">
		<b>4 - ( E ) Excellent </b>: displays outstanding professional mastery in all aspects responsibility
	</div>

	<div class="col-sm-12">
		<b>3 - ( VG ) Very Good </b>: surpasses the expected performance of his/her obligations of work
	</div>

	<div class="col-sm-12">
		<b>2 - ( S ) Satisfactory </b>: meets the average or normal requirements of his/her obligation or work
	</div>

	<div class="col-sm-12">
		<b>1 - ( U ) Unsatisfactory </b>: unsuccessful in meeting the minimum requirements of his/her obligation or work
	</div>

	<div class="col-sm-12">
		<hr>
		{!! Form::open(array('url' => 'calculate', 'method' => 'POST')) !!}
		<table class="table table-bordered table-striped">
			<tr class="bg-warning">
				<th>Scale</th>
				<th><center>U</center></th>
				<th><center>S</center></th>
				<th><center>VG</center></th>
				<th><center>E</center></th>
			</tr>
		
		<?php foreach($questions as $key => $question): ?>
			<tr>
				<td colspan="5" class="bg-primary"><label><?= $key ?></label></td>
			</tr>
			
			<?php foreach($question as $q): ?>
				<tr>
					<td><?= $q['question'] ?></td>
					<td><center><input type="radio" name="question[<?= $q['question_id'] ?>]" value="1" title="Unsatisfactory" required></center></td>
					<td><center><input type="radio" name="question[<?= $q['question_id'] ?>]" value="2" title="Satisfactory" required></center></td>
					<td><center><input type="radio" name="question[<?= $q['question_id'] ?>]" value="3" title="Very Good" required></center></td>
					<td><center><input type="radio" name="question[<?= $q['question_id'] ?>]" value="4" title="Execellent" required></center></td>
				</tr>
					
			<?php endforeach; ?>

		<?php endforeach; ?>

		</table>

		<div class="form-group">
			<label class="control-label">What are the strengths of your instructor?</label>
			<textarea class="form-control" name="strengths"></textarea>
		</div>

		<div class="form-group">
			<label class="control-label">What are the weaknesses of your instructor?</label>
			<textarea class="form-control" name="weaknesses"></textarea>
		</div>

		<button class="btn btn-success " style="width:100%;">Submit</button>
		{!! Form::close() !!}
		<br><br><br>
	</div>

</div>
</div>

@include('inc/evaluation-footer')