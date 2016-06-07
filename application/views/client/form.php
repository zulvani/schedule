<div class="modal fade" id="modal-form-client" tabindex="-1"
	role="dialog" aria-labelledby="modal-form-client">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="exampleModalLabel">Client</h4>
			</div>
			<div class="modal-body">
				<?=form_open('client/save', 'id="form-client"')?>
					<input type="hidden" name="id" id="id" />
				<div class="form-group">
					<label for="name" class="control-label">Name:</label> <input
						type="text" class="form-control" id="name" name="name">
				</div>
				<div class="form-group">
					<label for="occupation" class="control-label">Address:</label> <input
						type="text" class="form-control" id="address" name="address">
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