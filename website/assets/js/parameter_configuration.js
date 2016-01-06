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


//select integers only
var intRegex = /^(-|)\d+$/;
var emailRegex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
 

$(document).ready(function() {

	$('.param-edit').each(function(){
		$firstname = $(this).prev();
		$(this).css({
		    'width': $firstname.width(),
		    'height': $firstname.height(),
		    'position': 'absolute',
		    'top': $firstname.offset().top,
		    'left': $firstname.offset().left			
		    }).hide();
		$(this).children('input').focus(function(){
    			$(this).select();
			}).bind("enterKey",function(e){

   				new_value = $(this).val();
   				old_value = $('#param-'+$(this).attr('name')+'-value').html().trim();
   				id = $(this).attr('name');
   				param = $(this).attr('param'); 

   				switch(param)
   				{
   					case 'int':
   						if (!(new_value.match(intRegex)))
   						{
   							$('#param-'+id).effect("highlight", {color: '#EE8888'}, 2000);
   							return;	
   						}
   						break;
   					case 'email':
   						if (!(new_value.match(emailRegex)))
   						{
   							$('#param-'+id).effect("highlight", {color: '#EE8888'}, 2000);
   							return;	
   						}
   						break;
   				}

   				$(this).parent().hide();
				$('#param-'+id+'-value').html(new_value);
				$('#param-'+id).fadeTo('slow', 0.5).find('button').attr('disabled', true);

   				$.ajax({
					url: site_url + 'admin/parameter/save/',
					dataType: 'JSON',
					type: 'POST',
					data: {key: id, value: new_value.trim(), type: param},
					success: function( data ) {
						if (data.success)
						{
   							$('#param-'+id).fadeTo('slow', 1.0).effect("highlight", {color: '#88EE88'}, 2000).find('button').removeAttr('disabled');
						} else
						{
   							$('#param-'+id).fadeTo('slow', 1.0).effect("highlight", {color: '#EE8888'}, 2000).find('button').removeAttr('disabled');							
			   				$('#param-'+id+'-value').html(old_value);

						}
					}
				});

			}).keyup(function(e){
			    if(e.keyCode == 13)
			    {
			        $(this).trigger("enterKey");
			    }
			}).keyup(function(e){
			    if(e.keyCode == 27)
			    {
	   				$(this).parent().hide();
	   				$(this).val($('#param-'+$(this).attr('name')+'-value').html().trim());
			    }
			}).focusout(function(){
   				$(this).parent().hide();
   				$(this).val($('#param-'+$(this).attr('name')+'-value').html().trim());
			});
	});

	$('button').click(function(){
		var value = $('#param-' + $(this).attr('value')+'-value').html().trim();
		$('#param-' + $(this).attr('value')+'-edit').show().children('input').val(value).focus();
		
	});

});

