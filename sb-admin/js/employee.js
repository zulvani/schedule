$('document').ready(function() {
	$('#btn-add').click(function() {
		$('#id').val('');
		$('#nik').val('');
		$('#full-name').val('');
		$('#email').val('');
		$('#occupation').val('');
		$('#modal-form-employee').modal();
	});

	$('#btn-save').click(function() {
		$.ajax({
			url : b + 'index.php/employee/save',
			method: 'POST',
			data: $('#form-employee').serialize(),
			success : function(response) {
				if(response.status == "success"){
					alert(response.message);
					window.location.href = b + '/index.php/employee/index';
				}
				else if (response.status == 'failed') {
					alert(response.message);
				}
			}
		});
	});
});

function modify(id){
	$.ajax({
		url : b + 'index.php/employee/modify/' + id,
		method: 'GET',
		data: $('#form-employee').serialize(),
		success : function(response) {
			$('#id').val(response.id);
			$('#nik').val(response.nik);
			$('#full-name').val(response.full_name);
			$('#email').val(response.email);
			$('#occupation').val(response.occupation);
			$('#modal-form-employee').modal();
		}
	});
}

function removeEmployee(id){
	if(confirm('Yakin?')){
		$.ajax({
			url : b + 'index.php/employee/remove/' + id,
			method: 'GET',
			data: $('#form-employee').serialize(),
			success : function(response) {
				if(response.status == 'success') {
					window.location.href = b + '/index.php/employee/index';
				}
			}
		});
	}
}