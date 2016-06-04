<script>
var b = "<?=$this->config->base_url()?>";
</script>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Employee</h1>
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
							<li><a href="#" id="btn-add">Create New Employee</a></li>
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
								<th>NIK</th>
								<th>Name</th>
								<th>Email</th>
								<th>Occupation</th>
								<th>Created</th>
								<th>Modified</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
					<?php $no = 1; foreach($employees as $em){ ?>
							<tr>
								<td><?=$no?></td>
								<td><?=$em->nik?></td>
								<td><?=$em->full_name?></td>
								<td><?=$em->email?></td>
								<td><?=$em->occupation?></td>
								<td><?=$em->created?></td>
								<td><?=$em->modified?></td>
								<td>
									<button class="btn btn-primary btn-xs"
										onclick="modify(<?=$em->id?>)">Modify</button>
									<button class="btn btn-primary btn-xs"
										onclick="removeEmployee(<?=$em->id?>)">Remove</button>
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

<?php $this->load->view('employee/form', []); ?>
<script src="<?=$b . 'sb-admin'?>/js/employee.js"></script>
