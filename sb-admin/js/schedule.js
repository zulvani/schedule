$('document').ready(function() {
	$('#btn-add').click(function() {
		$('#id').val('');
		$('#start').val('');
		$('#end').val('');
		$('#venue').val('');
		$('#target').val('');
		$('#result').val('');
		$('#employees').val('');
		$('#clients').val('');
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
		url : b + 'index.php/schedule/modify/' + id,
		method: 'GET',
		success : function(response) {
			$('#id').val(response.schedule.id);
			$('#start').val(response.schedule.start);
			$('#end').val(response.schedule.end);
			$('#venue').val(response.schedule.venue);
			$('#target').val(response.schedule.target);
			$('#result').val(response.schedule.result);
			$('#employees').val(response.employees);
			$('#clients').val(response.clients);
			$('#modal-form-schedule').modal();
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