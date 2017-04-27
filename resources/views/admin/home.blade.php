@include('../inc/header')


<div class="row">
	<div class="col-lg-12">
		<div class="alert alert-info alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<i class="fa fa-info-circle"></i>  <strong>Welcome Back!</strong> Checkout evaluation results <a href="{{ url('results') }}" class="alert-link">here</a>
		</div>
	</div>
</div>
<!-- /.row -->

<div class="row">
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-users fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge"><?= ($data['teachers']) ? count($data['teachers']) : 0 ?></div>
						<div>Teachers</div>
					</div>
				</div>
			</div>
			<a href="{{ url('teachers') }}">
				<div class="panel-footer">
					<span class="pull-left">View teachers</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-green">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-tasks fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge"><?= ($data['subjects']) ? count($data['subjects']) : 0 ?></div>
						<div>Subjects</div>
					</div>
				</div>
			</div>
			<a href="{{ url('subjects') }}">
				<div class="panel-footer">
					<span class="pull-left">View subjects</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-yellow">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-university fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge"><?= ($data['departments']) ? count($data['departments']) : 0 ?></div>
						<div>Departments</div>
					</div>
				</div>
			</div>
			<a href="{{ url('departments') }}">
				<div class="panel-footer">
					<span class="pull-left">View departments</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-red">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-question fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge"><?= ($data['questions']) ? count($data['questions']) : 0 ?></div>
						<div>Scales</div>
					</div>
				</div>
			</div>
			<a href="{{ url('questions') }}">
				<div class="panel-footer">
					<span class="pull-left">View scales</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
</div>
<!-- /.row -->

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Top Teachers for {{ $admin_settings['year'].'-'.$admin_settings['semester'].' semester' }}</h3>
			</div>
			<div class="panel-body">
				<div id="morris-bar-chart"></div>
			</div>
		</div>
	</div>
</div>
<!-- /.row -->

<div class="row">
	<div class="col-sm-offset-8 col-sm-4"><button class="btn btn-success pull-right" onclick="printDiv()"><i class="fa fa-print fa-xs"></i> Print</button><br><br></div>
</div>
<div class="row" id="print-div">

	<?php foreach($scale_teacher_results as $key => $value): ?>
	<div class="col-lg-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i> Teacher performance with <b>{{ $key }}</b> result</h3>
			</div>
			<div class="panel-body">
	
				<table class="table table-striped table-bordered" border="1">
					<tr>
						<th>Name of Faculty</th>
						<th>Mean Rating</th>
						<th>Descriptive Equivalent</th>
					</tr>

					@foreach($value as $tkey => $tvalue)
					<tr>
						<td>{{ $tvalue['name'] }}</td>
						<td>{{ $tvalue['score'] }}</td>
						<td>{{ ($tvalue['equivalent']) }}</td>
					</tr>
					@endforeach
				</table>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
</div>

<div class="row">
	<div class="col-lg-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i> School Teachers' Overall Performance {{ $admin_settings['year'].'-'.$admin_settings['semester'].' semester' }}</h3>
			</div>
			<div class="panel-body">
				<div id="teacher-donut-chart"></div>
				<div class="text-right">
					<a href="{{ url('results') }}">View Details <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
		</div>
	</div>


	<div class="col-lg-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i> Scales' Overall Results for {{ $admin_settings['year'].'-'.$admin_settings['semester'].' semester' }}</h3>
			</div>
			<div class="panel-body">
				<i>Recommendation will be displayed if the average score is less than 2.5</i>
				<table class="table table-striped table-bordered">
					<tr>
						<th>Scale</th>
						<th>Score</th>
						<th>Recommendation</th>
					</tr>

					@foreach($category_data as $key => $value)
					<tr>
						<td>{{ $value['label'] }}</td>
						<td>{{ $value['score'] }}</td>
						<td>{{ ($value['recommendation']) ? $value['recommendation'] : 'N/A' }}</td>
					</tr>
					@endforeach
				</table>
			</div>
		</div>
	</div>

	<div class="col-lg-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> On-going Evaluation</h3>
			</div>
			<div class="panel-body">
				<div class="list-group">
					<?php if($ongoing_evaluations): ?>
						<?php foreach($ongoing_evaluations as $col): ?>
						<a href="#" class="list-group-item">
							<span class="badge"><?= $col->evaluation_year.'-'.$col->semester.' Sem'.' | '.$col->subject_code.' '.$col->subject_time  ?></span>
							<i class="fa fa-fw fa-calendar"></i> <?= $col->name ?>
						</a>
						<?php endforeach; ?>
					<?php else: ?>
						<p>No evaluation active at the moment</p>
					<?php endif; ?>
				</div>
				<div class="text-right">
					<a href="{{ url('evaluations') }}">View All Evaluations <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-university fa-fw"></i> School Departments</h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Department</th>
								<th>Teachers</th>
	
							</tr>
						</thead>
						<tbody>
							<?php foreach($departments as $col): ?>
							<tr>
								<td><?= $col->name ?></td>
								<td><?= $col->teacher_count ?></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<div class="text-right">
					<a href="{{ url('departments') }}">View All Departments <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /.row -->


@include('../inc/footer')
<textarea class="home-donut-data" style="display:none;"><?= json_encode($donut_data) ?></textarea>
<textarea class="home-bar-data" style="display:none;"><?= json_encode($top_teachers) ?></textarea>

<script type="text/javascript">
	Morris.Donut({
        element: 'teacher-donut-chart',
        data: JSON.parse($('.home-donut-data').val()),
        resize: true
    });


    Morris.Bar({
        element: 'morris-bar-chart',
        data: JSON.parse($('.home-bar-data').val()),
        xkey: 'teacher',
        ykeys: ['total_score'],
        labels: ['Total Score'],
        barRatio: 0.4,
        xLabelAngle: 0,
        hideHover: 'auto',
        resize: true
    });

    function printDiv() 
	{

	  var divToPrint=document.getElementById('print-div');

	  var newWin=window.open('','Print-Window');

	  newWin.document.open();

	  newWin.document.write('<html><body onload="window.print()"><center>Teacher Performance Results for <?= $admin_settings['year'].'-'.$admin_settings['semester'].' semester' ?></center><br>'+divToPrint.innerHTML+'</body></html>');

	  newWin.document.close();

	  setTimeout(function(){newWin.close();},10);

	}
</script>