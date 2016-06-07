$('document').ready(function() {
	$('#btn-add').click(function() {
		$('#id').val('');
		$('#name').val('');
		$('#email').val('');
		$('#address').val('');
		$('#modal-form-client').modal();
	});

	$('#btn-save').click(function() {
		$.ajax({
			url : b + 'index.php/client/save',
			method: 'POST',
			data: $('#form-client').serialize(),
			success : function(response) {
				if(response.status == "success"){
					alert(response.message);
					window.location.href = b + '/index.php/client/index';
				}
			}
		});
	});
});

function modify(id){
	$.ajax({
		url : b + 'index.php/client/modify/' + id,
		method: 'GET',
		success : function(response) {
			$('#id').val(response.id);
			$('#name').val(response.name);
			$('#email').val(response.email);
			$('#address').val(response.address);
			$('#modal-form-client').modal();
		}
	});
}

function removeEmployee(id){
	if(confirm('Yakin?')){
		$.ajax({
			url : b + 'index.php/client/remove/' + id,
			method: 'GET',
			success : function(response) {
				if(response.status == 'success') {
					window.location.href = b + '/index.php/client/index';
				}
			}
		});
	}
}