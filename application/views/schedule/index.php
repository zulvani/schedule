<script>
var b = "<?=$this->config->base_url()?>";
</script>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Schedule</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-bar-chart-o fa-fw"></i> Panel
				<div class="pull-right">
					<div class="btn-group">
						<button type="button"
							class="btn btn-default btn-xs dropdown-toggle"
							data-toggle="dropdown">
							Actions <span class="caret"></span>
						</button>
						<ul class="dropdown-menu pull-right" role="menu">
							<li><a href="#" id="btn-add">Create New Schedule</a></li>
						</ul>
					</div>
				</div>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div>
					<table class="table table-striped table-bordered table-hover"
						id="dataTables-example">
						<thead>
							<tr>
								<th>No</th>
								<th>Time</th>
								<th>Venue</th>
								<th>#</th>
								<th>Employee(s)</th>
								<th>Client(s)</th>
								<th>Created</th>
								<th>Modified</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
					<?php $no = 1; foreach($schedules as $s){ ?>
							<tr>
								<td><?=$no?></td>
								<td><?=$s->start?> - <?=$s->end?></td>
								<td><?=$s->venue?></td>
								<td>
									<div>Type: <?=$s->visiting_type?></div>
									<div>Realization: <?=$s->visiting_realization?></div>
									<div>Target: <?=$s->target?></div>
									<div>Result: <?=$s->result?></div>
								</td>
								<td></td>
								<td></td>
								<td><?=$s->created?></td>
								<td><?=$s->modified?></td>
								<td>
									<?php if($s->visiting_realization == 'NEW') { ?>
									<a href="<?=$this->config->base_url()?>index.php/schedule/cancel/<?=$s->id?>" 
										class="btn btn-primary btn-xs" onclick="if(!confirm('Yakin?'))return false;">Cancel</a>
										
									<a href="<?=$this->config->base_url()?>index.php/schedule/success/<?=$s->id?>" 
										class="btn btn-primary btn-xs" onclick="if(!confirm('Yakin?'))return false;">Success</a>
										
									<button class="btn btn-primary btn-xs"
										onclick="removeSchedule(<?=$s->id?>)">Remove</button>
									<?php } ?>

								</td>
							</tr>
					<?php $no++; } ?>
						</tbody>
					</table>
				</div>
			</div>
			<!-- /.panel-body -->
		</div>
	</div>
</div>

<?php

$this->load->view ( 'schedule/form', [ 
		'types' => $types,
		'realizations' => $realizations,
		'selectedRealization' => $selectedRealization 
] );
?>
<script src="<?=$b . 'sb-admin'?>/js/schedule.js"></script>
