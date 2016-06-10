<div class="modal fade" id="modal-form-schedule" tabindex="-1"
	role="dialog" aria-labelledby="modal-form-schedule">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="exampleModalLabel">Schedule</h4>
			</div>
			<div class="modal-body">
				<?=form_open('client/save', 'id="form-schedule"')?>
					<input type="hidden" name="id" id="id" />
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="name" class="control-label">Start:</label> <input
								type="text" class="form-control" id="start" name="start">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="name" class="control-label">End:</label> <input
								type="text" class="form-control" id="end" name="end">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="name" class="control-label">Type:</label> 
								<?=form_dropdown('visiting_type', $types, '', ['class' => 'form-control'])?>
							</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="name" class="control-label">Realization:</label> 
								<?=form_dropdown('visiting_realization', $realizations, $selectedRealization, ['class' => 'form-control'])?>
							</div>
					</div>
				</div>
				<div class="form-group">
					<label for="occupation" class="control-label">Venue:</label> <input
						type="text" class="form-control" id="venue" name="venue">
				</div>
				<div class="form-group">
					<label for="email" class="control-label">Target:</label> <input
						type="text" class="form-control" id="target" name="target">
				</div>
				<div class="form-group">
					<label for="email" class="control-label">Result:</label> <input
						type="text" class="form-control" id="result" name="result">
				</div>
				<div class="form-group">
					<label for="email" class="control-label">Employee(s):</label> <input
						type="text" class="form-control" id="employees" name="employees">
				</div>
				<div class="form-group">
					<label for="email" class="control-label">Client(s):</label> <input
						type="text" class="form-control" id="clients" name="client">
				</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary" id="btn-save">Save</button>
			</div>
		</div>
	</div>
</div>