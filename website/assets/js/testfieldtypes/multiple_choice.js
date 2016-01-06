var multiple_choice = {
	container_field_name: "",
	data_field_name: "",
	confirm_field_name: "",
	current_question: 0,
	is_random_select: false,
	random_select_max: 3,
	questions: Array(),
	
	interface_html: "",
	max_score: 0,
	pass_score: 0,
	users_answers: Array(),
	selected_questions: Array(),
	answered_correct: Array(),
	game_finish_url: "",
	game_container_field_name: "",
	game_interface_html: "",
	
	error_msg: "",
	validate: function() {
		return true;
	},
	get_error_msg: function() {
		return multiple_choice.error_msg;
	},
	load_data: function(json) {
		if (json != "")
		{
			var object = $.parseJSON(json);
			multiple_choice.questions 			= object.questions;
			multiple_choice.current_question 	= object.current_question;
			multiple_choice.is_random_select 	= object.is_random_select;
			multiple_choice.random_select_max 	= object.random_select_max;
		}
	},
	get_data: function() {
		var object = {
			questions: multiple_choice.questions,
			current_question: multiple_choice.current_question,
			is_random_select: multiple_choice.is_random_select,
			random_select_max: multiple_choice.random_select_max
		};
		var json =  JSON.stringify(object);
		return json;
	},
	save: function() {
		
		question = {
			question: $(multiple_choice.container_field_name + ' .question').val(),
			type: $(multiple_choice.container_field_name + ' .question-type').attr('checked') ? true : false,
			answers: Array(),
			right_answer: Array()
		};
		
		$(multiple_choice.container_field_name + ' .answer-container').each(function (index) {
			question.answers.push($(this).find('.answer').val());

			if ($(this).find('input[name="right_answer"]').attr('checked'))
				question.right_answer.push(index);
		});
		
		if (multiple_choice.current_question < multiple_choice.questions.length)
			multiple_choice.questions[multiple_choice.current_question]	= question;
		else
			multiple_choice.questions.push(question);
			
		if ($('input[name="random_select"]').attr('checked'))
			multiple_choice.is_random_select	= true;
		else
			multiple_choice.is_random_select	= false;
		
		multiple_choice.random_select_max = $(multiple_choice.container_field_name + ' .random_select_max').val();
		
	},
	load: function(index) {
		$(multiple_choice.container_field_name).html(multiple_choice.interface_html);
		if (multiple_choice.current_question < multiple_choice.questions.length)
		{
			$(multiple_choice.container_field_name + ' .question').val(multiple_choice.questions[index].question);
			if (multiple_choice.questions[index].type)
				$(multiple_choice.container_field_name + ' .question-type').attr('checked', true);
			$(multiple_choice.container_field_name + ' .answers-container').find('.answer').val(multiple_choice.questions[index].answers[0]);
			if (multiple_choice.questions[index].type)
				$(multiple_choice.container_field_name + ' .right-answer').attr('type', 'checkbox');
			else
				$(multiple_choice.container_field_name + ' .right-answer').attr('type', 'radio');
			for (var i = 1; i < multiple_choice.questions[index].answers.length; i++)
			{
				$(multiple_choice.container_field_name + ' .answers-container').append('<div class="answer-container"><input type="' + (multiple_choice.questions[index].type ? 'checkbox' : 'radio') + '" name="right_answer" class="right-answer" value="1"' + ((multiple_choice.questions[index].right_answer.indexOf(i) > -1) ? ' checked="checked"' : '') + ' /><input class="answer" value="' + multiple_choice.questions[index].answers[i] + '" /><input type="button" class="btn-delete" value="Eliminar" /></div>');
			}
		}

		$(multiple_choice.container_field_name + ' .random_select_max').val(multiple_choice.random_select_max);
		
		if (multiple_choice.is_random_select)
		{
			$(multiple_choice.container_field_name + ' .random_select').attr('checked', true);
			$(multiple_choice.container_field_name + ' .random_select_max').attr('disabled', false);
		}
		else
		{
			$(multiple_choice.container_field_name + ' .random_select').attr('checked', false);
			$(multiple_choice.container_field_name + ' .random_select_max').attr('disabled', true);
		}
		
		if (!$(this).parent().find('input[name="right_answer"]:checked'))
			$(multiple_choice.container_field_name + ' .right-answer').first().attr('checked', 'checked');
	},
	clean: function() {
		$(multiple_choice.container_field_name + ' .btn-add').die();
		$(multiple_choice.container_field_name + ' .btn-delete').die();
		$(multiple_choice.container_field_name + ' .question-type').die();
	},	
	init: function(container_field_name, data_field_name, confirm_field_name) {
		multiple_choice.container_field_name = container_field_name;
		multiple_choice.data_field_name	= data_field_name;
		multiple_choice.confirm_field_name	= confirm_field_name;
		
		$(multiple_choice.confirm_field_name).val(1);
		
		multiple_choice.interface_html = '<div class="navigation-container"><input type="button" class="btn-prev" value="<<" /><input class="current-question" value="' + (multiple_choice.current_question + 1) + '" /><input type="button" class="btn-next" value=">>" /></div>' +
		'<div class="question-container">Pregunta: <input class="question" /> <input type="checkbox" class="question-type" value="1" /> Múltiples respuestas</div>' +
		'<div class="answer-titles">Respuestas</div>' +
		'<div class="answers-container"><div class="answer-container"><input type="radio" name="right_answer" class="right-answer" value="1" /><input class="answer" /><input type="button" class="btn-delete" value="Eliminar" /></div></div>' +
		'<div class="options-container"><input type="button" class="btn-add" value="Agregar respuesta" /><input type="button" class="btn-delete-question" value="Eliminar pregunta" /><br/><input type="checkbox" name="random_select" class="random_select" value="0" /> Seleccionar al azar un máximo de <input class="random_select_max" value="1" /></div>'; 

		$(multiple_choice.container_field_name).html(multiple_choice.interface_html);
		$(multiple_choice.container_field_name + ' .btn-add').live('click', function() {
			$(multiple_choice.container_field_name + ' .answers-container').append('<div class="answer-container"><input type="' +  ($(multiple_choice.container_field_name + ' .question-type').attr('checked') ? 'checkbox' : 'radio')+ '" name="right_answer" class="right-answer" value="1" /><input class="answer" /><input type="button" class="btn-delete" value="Eliminar" /></div>');
		});

		$(multiple_choice.container_field_name + ' .btn-delete').live('click', function() {
			if ($(multiple_choice.container_field_name + ' .answer-container').length > 1)
			{
				if ($(this).parent().find('.answer').val() != "")
				{
					if (confirm('¿Está seguro de eliminar esta respuesta?'))
					{
						if ($(this).parent().find('input[name="right_answer"]:checked'))
							$(multiple_choice.container_field_name + ' .right-answer').first().attr('checked', 'checked');
						$(this).parent().remove();
					}
				}
				else
					$(this).parent().remove();
			} else
			{
				alert('Debe existir al menos una respuesta')
			}
		});

		$(multiple_choice.container_field_name + ' .btn-prev').live('click', function() {
			if (multiple_choice.current_question > 0)
			{
				multiple_choice.save();
				multiple_choice.current_question	-=  1;
				multiple_choice.load(multiple_choice.current_question);
				$(multiple_choice.container_field_name + ' .current-question').val(multiple_choice.current_question + 1);
			}
		});

		$(multiple_choice.container_field_name + ' .random_select').live('click', function() {

			if ($(multiple_choice.container_field_name + ' input[name="random_select"]').attr('checked'))
			{
				$(multiple_choice.container_field_name + ' .random_select_max').attr('disabled', false);
			}
			else
			{
				$(multiple_choice.container_field_name + ' .random_select_max').attr('disabled', true);
			}
		});
		
		$(multiple_choice.container_field_name + ' .btn-next').live('click', function() {
			multiple_choice.save();
			multiple_choice.current_question	+=  1;
			multiple_choice.load(multiple_choice.current_question);
			$(multiple_choice.container_field_name + ' .current-question').val(multiple_choice.current_question + 1);
		});

		$(multiple_choice.container_field_name + ' .question-type').live('change', function() {
			if ($(this).attr('checked'))
				$(multiple_choice.container_field_name + ' .right-answer').attr('type', 'checkbox')
			else
				$(multiple_choice.container_field_name + ' .right-answer').attr('type', 'radio')
		});
		
		multiple_choice.load(multiple_choice.current_question);
	},
	game_init: function(game_container_field_name, game_finish_url, pass_score, max_score) {
		multiple_choice.game_container_field_name = game_container_field_name;
		multiple_choice.game_finish_url = game_finish_url;
		multiple_choice.pass_score = pass_score;
		multiple_choice.max_score = max_score;

		var questions_html = '';
		var questions_body = Array();
		multiple_choice.selected_questions = multiple_choice.questions;
			
		for (var i = 0; i < multiple_choice.selected_questions.length; i++)
		{
			multiple_choice.users_answers.push(Array());
			questions_html += '<div class="tab" id="question_' + i + '" data-index="' + i + '"><a class="question' + (i == 0 ? ' selected' : '') + '">Pregunta ' + (i + 1) + '</a></div>';
			question_body_html = '<h1>' + multiple_choice.selected_questions[i].question + '</h1><div class="answers">';
			for (var j = 0; j < multiple_choice.selected_questions[i].answers.length; j++)
			{
				if (multiple_choice.selected_questions[i].type)
					question_body_html += '<br/><input type="checkbox" data-index="' + i + '" class="answer answer-' + j + '" name="answer[]" value="' + j + '"> ';
				else
					question_body_html += '<br/><input type="radio" data-index="' + i + '" class="answer answer-' + j + '" name="answer[]" value="' + j + '"> ';
					
				question_body_html += multiple_choice.selected_questions[i].answers[j];	
			}
			question_body_html += '</div>';
			questions_body.push(question_body_html);
		}

		multiple_choice.game_interface_html	= '<div class="tabs">' +
							questions_html +
						'</div>' +
						'<div class="test-content">' +
							'<div class="test-content-questions">' +
							questions_body[0] +
							'</div>' +
							'<div class="test-content-buttons">' +
							'</div>' +
						'</div>';
							
		$(multiple_choice.game_container_field_name).html(multiple_choice.game_interface_html);

		if (multiple_choice.selected_questions.length == 1)
			$(multiple_choice.game_container_field_name + ' .test-content .test-content-buttons').html('<input class="btn-test btn-test-submit" type="submit" value="Enviar" />');
		else
			$(multiple_choice.game_container_field_name + ' .test-content .test-content-buttons').html('<input class="btn-test btn-test-next" type="submit" value="Siguiente" />');		

		$(multiple_choice.game_container_field_name ).delegate('.test-content .test-content-questions .answer', 'click', function() {
			var value = parseInt($(this).val());
			var i = parseInt($(this).attr('data-index'));
			if (!multiple_choice.selected_questions[i].type)
				multiple_choice.users_answers[i] = Array();
			
			if ($(this).is(':checked'))
			{
				if($.inArray(value, multiple_choice.users_answers[i]) === -1) 
					multiple_choice.users_answers[i].push(value);
			}
			else
			{
				var index = multiple_choice.users_answers[i].indexOf(value);
				if (index > -1) {
					multiple_choice.users_answers[i].splice(index, 1);
				}
			}
		}); 

		$(multiple_choice.game_container_field_name + ' .tab').click(function() {
			var i = parseInt($(this).attr('data-index'));
			$(multiple_choice.game_container_field_name + ' .test-content .test-content-questions').html(questions_body[i])
			$(multiple_choice.game_container_field_name + ' .tab .question').removeClass('selected');
			$(this).find('.question').addClass('selected');
			$.each(multiple_choice.users_answers[i], function (index, value) {
				$(multiple_choice.game_container_field_name + ' .test-content .test-content-questions .answer-' + value).attr('checked', true);
			});
			if (i == multiple_choice.selected_questions.length - 1)
			{
				$(multiple_choice.game_container_field_name + ' .test-content .test-content-buttons').html('<input class="btn-test btn-test-submit" type="submit" value="Enviar" />');
			}
			else
				$(multiple_choice.game_container_field_name + ' .test-content .test-content-buttons').html('<input class="btn-test btn-test-next" type="submit" value="Siguiente" />');
		});
		
		$(multiple_choice.game_container_field_name).delegate('.btn-test-next', 'click', function() {
			$('.question.selected').parent().next().trigger('click');
		});

		$(multiple_choice.game_container_field_name).delegate('.btn-test-submit', 'click', function() {
			var results = multiple_choice.grade();
			//$(this).attr('disabled', true);
			$.ajax({
				url: multiple_choice.game_finish_url,
				data: results,
				dataType: 'json',
				type: 'post',
				success: function(data) {
					$(multiple_choice.game_container_field_name + ' .tab').unbind('click');
					$(multiple_choice.game_container_field_name).undelegate('.test-content .test-content-questions .answer', 'click');
					$(multiple_choice.game_container_field_name).undelegate('.btn-test-submit', 'click');
					if (results.passed == 1)
					{
						multiple_choice.passed_state(data.next_url, data.next_caption);
					}
					else
						multiple_choice.failed_state();
				}                  
			});
			return false;
		});
		
	},
	grade: function() {
		var grade = 0;
		var passed = 0;
		var total = multiple_choice.selected_questions.length;
		var total_right = 0;
		multiple_choice.answered_correct = Array();
		
		for (var i = 0; i < multiple_choice.users_answers.length; i++)
		{
			if (multiple_choice.users_answers[i].length == multiple_choice.selected_questions[i].right_answer.length)
			{
				var total_correct = 0;
				for (var j = 0; j < multiple_choice.users_answers[i].length; j++)
				{
					if (jQuery.inArray(multiple_choice.users_answers[i][j], multiple_choice.questions[i].right_answer) > -1)
						total_correct++;
				}
				if (total_correct == multiple_choice.users_answers[i].length)
				{
					total_right = total_right + 1;
					multiple_choice.answered_correct.push(true);
				}
				else
					multiple_choice.answered_correct.push(false);
			}
		}
		
		grade = Math.round(total_right * multiple_choice.max_score / total);
		passed =  grade >= multiple_choice.pass_score ? 1 : 0;
		
		return {grade: grade, passed: passed};
	},
	passed_state: function(next_url, next_caption) {
		var questions_html = "";
		for (var i = 0; i < multiple_choice.selected_questions.length; i++)
		{
			multiple_choice.users_answers.push(Array());
			questions_html += '<div class="tab"><img src="' + site_url + 'assets/images/client/' + (multiple_choice.answered_correct[i] ? 'like-red.png': 'dislike.png') + '" class="icon" alt="Correcto" /><a class="question">Pregunta ' + (i + 1) + '</a></div>';
		}

		multiple_choice.game_interface_html	= '<div class="tabs">' +
							questions_html +
						'</div>' +
						'<div class="test-content">' +
							'<div class="test-star">' +
								'<img src="' + site_url + 'assets/images/client/star.png" alt="" /><br/>' +
								'<span class="message-passed">¡Felicidades! Ganaste la evaluación.</span>' +
							'</div>' +
							'<div class="test-kid">' +
								'<img src="' + site_url + 'assets/images/client/smile.png" alt="" />' +
							'</div>' +
							'<div class="test-content-buttons">' +
								'<input class="btn-test btn-test-next" type="submit" value="' + next_caption + '" />'
							'</div>' +							
						'</div>';
						
		$(multiple_choice.game_container_field_name).html(multiple_choice.game_interface_html);
		$(multiple_choice.game_container_field_name + ' .test-content .test-content-buttons .btn-test-next').click(function() {
			window.location.href = next_url;
		});
	
	},
	failed_state: function() {
		var questions_html = "";
		for (var i = 0; i < multiple_choice.selected_questions.length; i++)
		{
			multiple_choice.users_answers.push(Array());
			questions_html += '<div class="tab"><img src="' + site_url + 'assets/images/client/' + (multiple_choice.answered_correct[i] ? 'like-red.png': 'dislike.png') + '" class="icon" alt="Correcto" /><a class="question">Pregunta ' + (i + 1) + '</a></div>';
		}

		multiple_choice.game_interface_html	= '<div class="tabs">' +
							questions_html +
						'</div>' +
						'<div class="test-content">' +
							'<div class="test-star">' +
								'<span class="message-failed">Inténtalo de nuevo.<br/>Puedes repasar para obtener un mejor resultado.</span>' +
							'</div>' +
							'<div class="test-kid">' +
								'<img src="' + site_url + 'assets/images/client/antismile.png" alt="" />'+
							'</div>' +
							'<div class="test-content-buttons">' +
							'<input class="btn-test btn-test-repeat" type="submit" value="Repetir" />' +
							'</div>' +							
						'</div>';
						
		$(multiple_choice.game_container_field_name).html(multiple_choice.game_interface_html);
		$(multiple_choice.game_container_field_name + ' .test-content .test-content-buttons .btn-test-repeat').click(function() {
			location.reload();
		});
	}
};