@include('../inc/header')

<div class="row">
	<div class="col-sm-12">
		<button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-send fa-fw"></i> Send Email</button>
		<br><br>
	</div>

	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i>
					
					Evaluation Result for:&nbsp;
					<b>{{ $evaluation->name }}</b>&nbsp;|&nbsp;
					<b>{{ $evaluation->subject_code }}</b>&nbsp;|&nbsp;
					<b>{{ $evaluation->subject_time }}</b>&nbsp;|&nbsp;
					<b>{{ $evaluation->semester }} Semester</b>
					<b>{{ $evaluation->evaluation_year }}</b>
				</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-6"><canvas id="studentChart"></canvas></div>
					<div class="col-sm-6"><canvas id="teacherChart"></canvas></div>
				</div>
				
			</div>
		</div>

		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-users fa-fw"></i>
					Teachers who evaluated
				</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-12">
						<table class="table table-bordered table-striped table-hover">
							<tr>
								<th>School ID</th>
								<th>Teacher Name</th>
							</tr>
					
							<?php foreach($teachers as $key => $value): ?>
								<tr>
									<td><?= $value->school_id ?></td>
									<td><?= $value->name ?></td>
								</tr>
							<?php endforeach; ?>
						</table>	
					</div>
				</div>
			</div>
		</div>

		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-list fa-fw"></i>
					Evaluation result per scale from highest to lowest
				</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					
					<div class="col-sm-12"><canvas id="scaleChart"></canvas></div>
	
					
				</div>
			</div>
		</div>

		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-comment fa-fw"></i>
					Comments
				</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-6">
						<h4>Strengths</h4>

						<?php foreach($comments as $data): ?>
							<?php if($data->comment_category == 'Strength'): ?>
							<div class="comment-div col-sm-12 alert alert-success">

								{{ $data->school_id.' Anonymous: "'.$data->comment.'"' }}
								
							</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>

					<div class="col-sm-6">
						<h4>Weaknesses</h4>
			
						<?php foreach($comments as $data): ?>
							<?php if($data->comment_category == 'Weakness'): ?>
							<div class="comment-div col-sm-12 alert alert-danger">
								{{ $data->school_id.' Anonymous: "'.$data->comment.'"' }}
							</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Send Email</h4>
      </div>
      <div class="modal-body">
      	{!! Form::open(array('url' => 'mail', 'method' => 'POST' )) !!}
        <div class="form-group">
        	<label class="control-label">Subject</label>
        	<input type="text" class="form-control" name="subject" required>
        </div>

        <div class="form-group">
        	<label class="control-label">Message</label>
        	<textarea class="form-control" name="message" required></textarea>
        </div>

        <input type="hidden" value="<?= $evaluation->teacher_id ?>" name="teacher_id">
   
      </div>
      <div class="modal-footer">
      	<input type="submit" class="btn btn-success" value="Send Message">
      	{!! Form::close() !!}
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<textarea class="hidden scale_labels"><?= json_encode($scales_data['scale_labels']) ?></textarea>
<textarea class="hidden scale_score"><?= json_encode($scales_data['scale_score']) ?></textarea>

@include('../inc/footer')

<script>
var ctx = document.getElementById("studentChart");
var studentChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Unsatifactory", "Satisfactory", "Very Good", "Excellent",],
        datasets: [{
            label: '# of Student Votes',
            data: JSON.parse("<?= json_encode($student_bar_data) ?>"),
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                // 'rgba(153, 102, 255, 0.2)',
                // 'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                // 'rgba(153, 102, 255, 1)',
                // 'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});


var tx = document.getElementById("teacherChart");
var teacherChart = new Chart(tx, {
    type: 'bar',
    data: {
        labels: ["Unsatifactory", "Satisfactory", "Very Good", "Excellent",],
        datasets: [{
            label: '# of Teacher Votes',
            data: JSON.parse("<?= json_encode($teacher_bar_data) ?>"),
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                // 'rgba(153, 102, 255, 0.2)',
                // 'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                // 'rgba(153, 102, 255, 1)',
                // 'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});

var sx = document.getElementById("scaleChart");
var scaleChart = new Chart(sx, {
    type: 'horizontalBar',
    data: {
        labels: JSON.parse($('.scale_labels').val()),
        datasets: [{
            label: '# Scales score',
            data: JSON.parse($('.scale_score').val()),
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>