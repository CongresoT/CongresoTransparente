var test = {
	select_field_name: "",
	container_field_name: "",
	game_container_field_name: "",
	confirm_field_name: "", 
	data_field_name: "", 
	data: "",
	data_url: "",
	game_data_url: "",
	css_url: "",
	object: "",
	loadedObjects: Array(),
	init: function(select_field_name, container_field_name, data_field_name, confirm_field_name, data, data_url, css_url) {
		test.select_field_name		= select_field_name;
		test.container_field_name	= container_field_name;
		test.confirm_field_name		= confirm_field_name;
		test.data_field_name		= data_field_name;
		test.data					= data;
		test.data_url				= data_url;
		test.css_url				= css_url;
		
		$("#crudForm").submit( function() {
			if (test.object != "")
			{
				test.object.save();
				if (test.object.validate())
					$(test.data_field_name).val(test.object.get_data());
				else
				{
					alert(test.object.get_error_msg());
					return false;
				}
			}
			return true;
		});
		
		$("#header-title").click( function() {
			if (test.object != "")
			{
				test.object.save();
				if (test.object.validate())
					$(test.data_field_name).val(test.object.get_data());
				else
				{
					alert(test.object.get_error_msg());
					return false;
				}
			}
			return true;
		});

		$(test.select_field_name).change(function() {
			var has_confirm = true;
			if ($(test.confirm_field_name).val() == "1")
				has_confirm = confirm('¿Está seguro de cambiar el tipo de campo?');
			
			if (has_confirm)
			{
				$(data_field_name).val('');
				$.ajax({
					type: "POST",
					dataType: "json",
					url: test.data_url + '/' + $(this).val(),
					success: function(data, textStatus, jq)
					{
						if (data.success)
						{
							$(test.container_field_name).html('');
							if (test.object != "")
								test.object.clean();

							if (test.loadedObjects.indexOf(data.fieldname) == -1)
							{
								$.ajax({
									url: data.css_url,
									dataType: 'text',
									success: function(data) {
										$('<style type="text/css">' + data + '</style>').appendTo("head");
									}                  
								});

								jQuery.getScript(data.js_url, function(answer, textStatus, jqxhr) {
									test.object = window[data.fieldname];
									test.object.load_data(test.data);
									test.object.init(test.container_field_name, test.data_field_name, test.confirm_field_name);
								});
								
								test.loadedObjects.push(data.fieldname);
							}
							else
							{
								test.object = window[data.fieldname];
								test.object.load_data(test.data);
								test.object.init(test.container_field_name, test.data_field_name, test.confirm_field_name);
							}
						}
					}
				})
			}
		});
		
		$(test.select_field_name).trigger('change');
	},
	game_init: function (game_container_field_name, fieldname, data, game_finish_url, pass_score, max_score) {
		test.game_container_field_name	= game_container_field_name;
		test.data						= data;

		test.object = window[fieldname];
		test.object.load_data(test.data);
		test.object.game_init(test.game_container_field_name, game_finish_url, pass_score, max_score);
	}
};