function changeImage()
{
	$('input[type="file"]').trigger('click');
}

$(document).ready(function() {

		$('input[type="file"]').on('change', function() { $('form[name="photo"]').trigger('submit'); });
		$('form[name="photo"]').submit(function(e) {
			$('#upload_loading').toggle();
			$('#upload_holder').toggle();
	        var formData = new FormData($(this)[0]);

	        $.ajax({
	            url: $(this).attr('action'),
	            type: "POST",
	            data: formData,
	            async: false,
                dataType: 'JSON',
	            success: function (data) {
					$('#upload_loading').toggle();
					$('#upload_holder').toggle();
	                if (data.success)
	                {
	                	$('#upload_holder > img').attr('src', site_url + 'assets/images/student/users/' + data.image);
                        showSystemMessage(data.message, SYS_MSG_STYLE_SUCCESS);
	                }
	                else
                        showSystemMessage(data.message, SYS_MSG_STYLE_ERROR);

	            },
	            cache: false,
	            contentType: false,
	            processData: false
        });

        e.preventDefault();
		return false;
    });

		$.datepicker.setDefaults({
							  showOn: 'both',
							  buttonImageOnly: true,
							  buttonImage: 'assets/images/client/calendar.png',
							  buttonText: 'Calendar',
							  changeYear: true,
							  yearRange: '1920:-1'
							},
							$.datepicker.regional[ 'es' ] );
						$('input[name="birthday"]').datepicker()
						$('#calendar-button').click(function(){
							$('input[name="birthday"]').datepicker('show');
						});

		$('select[name="country"]').change(function() {
				country_id = $(this).val();
				
				list = $('select[name="department"]').empty().append(
						$('<option value="0">Seleccione un departamento</option>')
					);
				$('select[name="municipality"]').empty().append(
						$('<option value="0">Seleccione un municipio</option>')
					);
				$('select[name="coordinator"]').empty().append(
						$('<option value="0">Seleccione un coordinador</option>')
					);

				if (departments[country_id])
					for (i = 0; i<departments[country_id].length; i++)
						list.append($('<option value="'+departments[country_id][i].department_id+'">'+departments[country_id][i].name+'</option>'));
			});


		$('select[name="department"]').change(function() {
				department_id = $(this).val();
				
				list = $('select[name="municipality"]').empty().append(
						$('<option value="0">Seleccione un municipio</option>')
					);
				$('select[name="coordinator"]').empty().append(
						$('<option value="0">Seleccione un coordinador</option>')
					);

				if (municipalities[department_id])
					for (i = 0; i<municipalities[department_id].length; i++)
						list.append($('<option value="'+municipalities[department_id][i].municipality_id+'">'+municipalities[department_id][i].name+'</option>'));
			
			});

		$('select[name="municipality"]').change(function() {
				municipality_id = $(this).val();
				
				list = $('select[name="coordinator"]').empty().append(
						$('<option value="0">Seleccione un coordinador</option>')
					);

				if (coordinators[municipality_id])
					for (i = 0; i<coordinators[municipality_id].length; i++)
						list.append($('<option value="'+coordinators[municipality_id][i].coordinator_id+'">'+coordinators[municipality_id][i].name+'</option>'));
			
			});


		$('.language').click(function() {
				$('.language.selected').removeClass('selected');
				$('input[name="language"]').val($(this).addClass('selected').attr('language_id'));
			});

	if (country_selected != null)
	{
		country_id = country_selected;
		
		list = $('select[name="department"]').empty().append(
				$('<option value="0">Seleccione un departamento</option>')
			);
		$('select[name="municipality"]').empty().append(
				$('<option value="0">Seleccione un municipio</option>')
			);
		$('select[name="coordinator"]').empty().append(
				$('<option value="0">Seleccione un coordinador</option>')
			);

		if (department_selected != null)
			department_id = department_selected;
		else
			department_id = 0;

		if (departments[country_id])
			for (i = 0; i<departments[country_id].length; i++)
				list.append($('<option value="'+departments[country_id][i].department_id+'" '+((departments[country_id][i].department_id==department_id)?'selected':'')+'>'+departments[country_id][i].name+'</option>'));
	}	

	if (department_selected != null)
	{
		department_id = department_selected;
		list = $('select[name="municipality"]');		
		if (municipality_selected != null)
			municipality_id = municipality_selected;
		else
			municipality_id = 0;
		if (municipalities[department_id])
			for (i = 0; i<municipalities[department_id].length; i++)
				list.append($('<option value="'+municipalities[department_id][i].municipality_id+'" '+((municipalities[department_id][i].municipality_id==municipality_id)?'selected':'')+'>'+municipalities[department_id][i].name+'</option>'));
		
		list = $('select[name="coordinator"]');		
		if (coordinator_selected != null)
			coordinator_id = coordinator_selected;
		else
			coordinator_id = 0;
		if (coordinators[municipality_id])
			for (i = 0; i<coordinators[municipality_id].length; i++)
				list.append($('<option value="'+coordinators[municipality_id][i].coordinator_id+'" '+((coordinators[municipality_id][i].coordinator_id==coordinator_id)?'selected':'')+'>'+coordinators[municipality_id][i].name+'</option>'));
	}	
	
});
