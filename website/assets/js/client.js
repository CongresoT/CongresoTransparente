        $(document).ready(function() {
			
			$('.metaf-course').click(function() {
				window.location = site_url + "curso/" + $(this).attr('course');
			});
			
			
			/*
            $('#btn-lost').click(function() {
                email = $('.lost-email').val();
                $.ajax({
                    url: site_url + 'claveperdida',
                    data: {email: email},
                    type: 'POST',
                    dataType: 'JSON',
                    success: function( data ) {
                        $('#lost-pass-container').toggle(400);
                        if (data.success)
                            showSystemMessage(data.message, SYS_MSG_STYLE_SUCCESS);
                        else
                            showSystemMessage(data.message, SYS_MSG_STYLE_ERROR);
                    }
                });
            });
*/
            $('#moodleLoginForm').submit(function(e) {
				e.preventDefault();
                pass = $('input[name="password"]').val();
                user =  $('input[name="username"]').val();
                $.ajax({
                    url: site_url + 'acceder',
                    data: {user: user, pass: pass},
                    type: 'POST',
                    dataType: 'JSON',
                    success: function( data ) {
                        if (data.success)
                        {
                            //window.location = site_url + 'logosmed_disponible/';
                            window.location = site_url;
                        } else
                        {
                            showSystemMessage(data.message, SYS_MSG_STYLE_ERROR);
                        }
                    }
                });
            });
			
			$('#avatar_images img').click(function() {
				$('#avatar_images img').removeClass('selected');
				$(this).addClass('selected');
			});

/*
            $('#btn-courses').click(function() {
                window.location = site_url +  "cursos";
            });

            $('#btn-history').click(function() {
                window.location = site_url +  "historial";
            });

            $('.btn-eval').click(function() {
                window.location = site_url +  "evaluar/" + $(this).attr('course');
            });

            $('.star_count').click(function() {
                if ($(this).hasClass('star_selected'))
                    $(this).removeClass('star_selected').nextAll('.star_selected').removeClass('star_selected');
                else
                    $(this).addClass('star_selected').prevAll('.star_count').addClass('star_selected')
            });

            $('#btn-send-eval').click(function() {
                var send = new Array();
                $('td[question]').each(function() {
                    send.push({id: $(this).attr('question'), 
                            stars: $(this).children('.star_selected').length,
                            question: $(this).attr('content')
                        });
                });

                $.ajax({
                    url: site_url + 'enviar_evaluacion/'+$(this).attr('course'),
                    data: {questions: send},
                    type: 'POST',
                    dataType: 'JSON',
                    success: function( data ) {
                        if (data.success)
                        {
                            window.location = site_url + 'cursos/';
                        } else
                        {
                            showSystemMessage(data.message, SYS_MSG_STYLE_ERROR);
                        }
                    }
                });
            });
			*/
        });


function show_login()
{
	$('#loginModal').show();
}

function show_males()
{
	$('#male_avatars').show();
	$('#female_avatars').hide();
	$('#avatar_images img').removeClass('selected');
}
		
function show_females()
{
	$('#female_avatars').show();
	$('#male_avatars').hide();
	$('#avatar_images img').removeClass('selected');
}

function save_avatar()
{
	var selected = $('#avatar_images .selected');
	var student_name = $('#student_name').val();
	var institution = $('#institution').val();
	if (selected.length == 0)
		showSystemMessage("Debes elegir tu avatar.", SYS_MSG_STYLE_ERROR);
	else if (student_name == '')
		showSystemMessage("Debes elegir un nombre para tu avatar", SYS_MSG_STYLE_ERROR);
	else
	{
        $.ajax({
            url: site_url + 'guardar_avatar',
            data: {avatar_id: selected.attr('avatar_id'), avatar_name: student_name, institution: institution},
            type: 'POST',
            dataType: 'JSON',
            success: function( data ) {
                if (data.success)
                {
                    //window.location = site_url;
                    showSystemMessage(data.message, SYS_MSG_STYLE_SUCCESS);
                } else
                {
                    showSystemMessage(data.message, SYS_MSG_STYLE_ERROR);
                }
            }
		});		
	}
}
				
function close_login()
{
	$('#loginModal').hide();
}
		
function logout()
{
    $.ajax({
        url: site_url + 'cerrar',
        dataType: 'JSON',
        success: function( data ) {
            if (data.success)
            {
                window.location = site_url;
            } else
            {
                showSystemMessage(data.message, SYS_MSG_STYLE_ERROR);
            }
        }
    });			
}
