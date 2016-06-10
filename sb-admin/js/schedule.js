$('document').ready(function() {
	$('#btn-add').click(function() {
		$('#modal-form-schedule').modal();
	});

	$('#btn-save').click(function() {
		$.ajax({
			url : b + 'index.php/schedule/save',
			method: 'POST',
			data: $('#form-schedule').serialize(),
			success : function(response) {
				if(response.status == "success"){
					alert(response.message);
					window.location.href = b + '/index.php/schedule/index';
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

function removeSchedule(id){
	if(confirm('Yakin?')){
		$.ajax({
			url : b + 'index.php/schedule/remove/' + id,
			method: 'GET',
			success : function(response) {
				if(response.status == 'success') {
					window.location.href = b + '/index.php/schedule/index';
				}
			}
		});
	}
}