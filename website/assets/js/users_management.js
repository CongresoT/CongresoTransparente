/*
var users_managementHandler = {
	getRolesInfo: function(id_user) {
		if (id_user == '')
		{
			$('input[name="roles"]').val('');
		}
		
		$.ajax({
			url: base_url + 'user_management/get_roles_info/' + id_user,
			dataType: 'JSON',
			success: function( data ) {
				if (data.success)
				{
					$('input[name="roles"]').val(data.salary);
				} else
				{
					$('input[name="roles"]').val('');
				}
			}
		});

	}
};*/


$(document).ready(function() {
	$('select[name="modules_access[]"]').dropdownchecklist();
});
