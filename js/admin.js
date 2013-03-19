$(document).ready(function() {
	$('#selectall').click(function() {
		$('input[type="checkbox"]').attr('checked',this.checked);
	});

	$('#admin_users li .column_id, #admin_users li .column_username, #admin_users li .column_title, #admin_users li .column_firstname, #admin_users li .column_lastname, #admin_users li .column_role, #admin_users li .column_doctor, #admin_users li .column_active').click(function(e) {
		e.preventDefault();

		if ($(this).parent().attr('data-attr-id')) {
			window.location.href = baseUrl+'/admin/users/edit/'+$(this).parent().attr('data-attr-id');
		}
	});

	handleButton($('#et_save'),function(e) {
		e.preventDefault();

		$('#adminform').submit();
	});

	handleButton($('#et_cancel'),function(e) {
		e.preventDefault();

		var e = window.location.href.split('/');

		var page = false;

		if (parseInt(e[e.length-1])) {
			page = Math.ceil(parseInt(e[e.length-1]) / items_per_page);
		}

		for (var i in e) {
			if (e[i] == 'admin') {
				window.location.href = baseUrl+'/admin/'+e[parseInt(i)+1]+(page ? '/'+page : '');
			}
		}
	});

	handleButton($('#et_add'),function(e) {
		e.preventDefault();

		var e = window.location.href.split('/');

		for (var i in e) {
			if (e[i] == 'admin') {
				window.location.href = baseUrl+'/admin/'+e[parseInt(i)+1]+'/add';
			}
		}
	});
});
