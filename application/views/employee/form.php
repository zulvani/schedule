<div class="modal fade" id="modal-form-employee" tabindex="-1"
	role="dialog" aria-labelledby="modal-form-employee">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="exampleModalLabel">Employee</h4>
			</div>
			<div class="modal-body">
				<?=form_open('employee/save', 'id="form-employee"')?>
					<input type="hidden" name="id" id="id" />
				<div class="form-group">
					<label for="nik" class="control-label">NIK:</label> <input
						type="text" class="form-control" id="nik" name="nik">
				</div>
				<div class="form-group">
					<label for="full-name" class="control-label">Full Name:</label> <input
						type="text" class="form-control" id="full-name" name="full-name">
				</div>
				<div class="form-group">
					<label for="occupation" class="control-label">Occupation:</label> <input
						type="text" class="form-control" id="occupation" name="occupation">
				</div>
				<div class="form-group">
					<label for="email" class="control-label">Email:</label> <input
						type="text" class="form-control" id="email" name="email">
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