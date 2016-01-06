
var complete = {
	container_field_name: "",
	data_field_name: "",
	confirm_field_name: "",
	
	words: new Array(),
	words_entered: 0,
	text: '',

	current_word: null,

	interface_html: "",
	
	max_score: 0,
	pass_score: 0,
	game_finish_url: "",
	game_container_field_name: "",
	game_interface_html: "",	
	
	error_msg: "",
	validate: function() {
		if (complete.words.length < 1)
		{
			complete.error_msg = 'El mínimo de palabras en completar es de 1';
			return false;
		}

		var i = 0, j;
		while (i < complete.words.length)
		{
			j = 0;
			if (complete.words[i].complete && complete.words[i].options.length == 0)
			{
				complete.error_msg = 'Debe haber mínimo una opcion cuando la palabra es de opción múltiple';
				return false;									
			}
			while (j < complete.words[i].options.length)
			{
				if (complete.words[i].options[j].trim() == '')
				{
					complete.error_msg = 'No pueden haber opciones vacias';
					return false;					
				}
				j++;
			}
			i++;
		}
		return true;
	},
	get_error_msg: function() {
		return complete.error_msg;
	},
	load_data: function(json) {
		if (json != "")
		{
			var object = $.parseJSON(json);
			complete.text 			= object.text;
			complete.words 		 	= object.words;
		}
	},
	get_data: function() {
		var object = {
			text: complete.text,
			words: complete.words
		};
		var json =  JSON.stringify(object);
		return json;
	},
	save: function() {
		if (complete.current_word == null)
			return;
		complete.text = $(complete.container_field_name + ' .txt-paragraph').val();
		var options = new Array();

		$(complete.container_field_name + ' .option-container').each(function (index) {
			options.push($(this).find('.option').val());
		});
		complete.words[complete.current_word].options = options;
		complete.words[complete.current_word].complete = $(complete.container_field_name + ' .options-container').find('input[name="complete"]').attr('checked') == 'checked';
		
	},
	load: function(index) {

		complete.current_word = index;
		$(complete.container_field_name + ' .options-container').html('<input type="button" name="alias" class="btn-add-alias" value="Agregar opcion a ' + complete.words[index].content  + '" />'+
			'<input type="checkbox" name="complete" class="complete" value="1" ' + ((complete.words[index].complete) ? ' checked="checked"' : '') + ' /> Opción múltiple');
		var i = 0;
		while (i < complete.words[index].options.length)
		{
			$(complete.container_field_name + ' .options-container').append('<div class="option-container"><input class="option" value="'+complete.words[index].options[i]+'" /><input type="button" class="btn-delete" value="Eliminar" /></div>');
			i++;			
		}
		
	},
	clean_options: function() {
		$(complete.container_field_name + ' .options-container').html('');
	},
	clean: function() {
		$(complete.container_field_name + ' .btn-add-alias').die();
		$(complete.container_field_name + ' .btn-delete').die();
	},
	init: function(container_field_name, data_field_name, confirm_field_name) {
		complete.container_field_name = container_field_name;
		complete.data_field_name	= data_field_name;
		complete.confirm_field_name	= confirm_field_name;
		
	
		complete.interface_html = '<div class="complete-titles">Párrafo</div>' +
		'<div class="text-container"><textarea class="txt-paragraph">'+complete.text+'</textarea></div>' +
		'<div class="options-container"></div>'; 

		$(complete.container_field_name).html(complete.interface_html);

		$(complete.container_field_name + ' .btn-add-alias').live('click', function() {
			$(complete.container_field_name + ' .options-container').append('<div class="option-container"><input class="option" value="" /><input type="button" class="btn-delete" value="Eliminar" /></div>');
		});

		$(complete.container_field_name + ' .btn-delete').live('click', function() {
			if ($(this).parent().find('.option').val() != "")
			{
				if (confirm('¿Está seguro de eliminar esta opción?'))
					$(this).parent().remove();
			}
			else
				$(this).parent().remove();
			
		});

		wordWid(complete.container_field_name + ' textarea', {
			wordButton: function(sel) {
				var i = 0;
				while (i < complete.words.length) // validations to avoid colliding selections
				{
					if ( (sel.start >= complete.words[i].start && sel.start <= complete.words[i].end) ||
						 (sel.end >= complete.words[i].start && sel.end <= complete.words[i].end) ||
						 (sel.start < complete.words[i].start && sel.end > complete.words[i].end) ||
						 (sel.start > complete.words[i].start && sel.end < complete.words[i].end))
						return false;
					i++;
				}

				$.extend(sel, {
						id: ++complete.words_entered, 
						options: Array(),
						complete: false
					});

				complete.words.push(sel);
				if (complete.current_word != null && complete.current_word < complete.words.length)
					complete.save();
				complete.current_word = complete.words.length - 1;
				complete.load(complete.words.length - 1);
				return true;
			},
			exist: function(sel)
			{
				var i = 0;
				while (i < complete.words.length)
				{
					if (complete.words[i].start == sel.start && complete.words[i].end == sel.end)
						return true;
					i++;
				}
				return false;
			},
			loadWord: function(id)
			{
				var i = 0;
				while (i < complete.words.length && complete.words[i].id != id)
					i++;
				if (complete.current_word != null && complete.current_word < complete.words.length)
					complete.save();

				if (complete.words[i].id == id)
					complete.load(i);
			},
			movingWords: function(before, after) { 
				var i = 0;
				var move = after.start - before.start;
				var before_move = before.start - before.end;

				if (move == 0 && before_move == 0) return;

				if (before_move != 0)
					var pos = before;
				else if (before.start < after.start)
					var pos = {start: before.start, end: after.start};
				else
					var pos = {start: after.start, end: before.start};

				while (i < complete.words.length)
				{
					// word is after
					if (pos.end <= complete.words[i].start)
					{
						complete.words[i].start+=move+before_move;
						complete.words[i].end+=move+before_move;
					}
					else if (pos.start <= complete.words[i].start)
					{
						if (move > 0 && before_move == 0) // word is not affected because addition doesnt touch it
						{
							complete.words[i].start+=move;
							complete.words[i].end+=move;
						}
						else
						{
							var diff = pos.end - complete.words[i].start;
							complete.words[i].start+=move + diff + before_move;
							complete.words[i].end+=move + before_move;
						}

					}
					else if (pos.start < complete.words[i].end)
					{
						if (pos.end < complete.words[i].end || (move > 0 && before_move == 0))
							complete.words[i].end+=move+before_move;
						else
							complete.words[i].end = pos.start;
					}

					if (complete.words[i].start >= complete.words[i].end) // clean if the word was erased
					{
						complete.words.splice(i--, 1); 
						complete.clean_options();						
					}
					else
						wordWid.setwordinto(complete.words[i]);
					i++;
				}
			}
		});
		var i = 0;
		while (i < complete.words.length)
		{
			wordWid.add(complete.words[i]);
			if (complete.words[i].id > complete.words_entered)
				complete.words_entered = complete.words[i].id;
			i++;
		}
	},
	game_init: function(game_container_field_name, game_finish_url, pass_score, max_score) {
		complete.game_container_field_name = game_container_field_name;
		complete.game_finish_url = game_finish_url;
		complete.pass_score = pass_score;
		complete.max_score = max_score;
		
		var text = complete.text;


		complete.words.sort(function (a, b) { return a.start - b.start; });
		function shuffleArray(array) {
		    for (var i = array.length - 1; i > 0; i--) {
		        var j = Math.floor(Math.random() * (i + 1));
		        var temp = array[i];
		        array[i] = array[j];
		        array[j] = temp;
		    }
		    return array;
		}

		var i = 0;
		var final_text = '';
		var last_ending = 0;
		while (i < complete.words.length)
		{
			final_text+= text.substring(last_ending, complete.words[i].start);			
			if (complete.words[i].complete)
			{
				var options = new Array();
				options.push(complete.words[i].content);
				options = shuffleArray(options.concat(complete.words[i].options));
				final_text+= '<select class="answer" name="' +  i + '">';
				var j = 0;
				while (j < options.length)
				{
					final_text+= '<option value="'+options[j]+'">'+options[j]+'</option>';
					j++;
				}
				final_text+='</select>';
			}
			else
			{
				final_text+= '<input type="text" class="answer" name="' +  i + '" />';
			}
			last_ending = complete.words[i].end;
			i++;
		}
		final_text+=text.substring(last_ending, text.length);
		text = final_text;

		complete.game_interface_html	= 
						'<div class="test-content">' +
							'<div class="test-content-questions">' +
							text +
							'</div>' +
							'<div class="test-content-buttons">' +
								'<input class="btn-test btn-test-submit" type="submit" value="Enviar" />' +
							'</div>' +
							'<div class="test-result">' +
							'</div>' +
						'</div>';
						
		$(complete.game_container_field_name).html(complete.game_interface_html);

		$(complete.game_container_field_name).delegate('.btn-test-submit', 'click', function() {
			var results = complete.grade();
			

			$(this).attr('disabled', true);
			$.ajax({
				url: complete.game_finish_url,
				data: results,
				dataType: 'json',
				type: 'post',
				success: function(data) {
					$(complete.game_container_field_name + ' .tab').unbind('click');
					$(complete.game_container_field_name).undelegate('.test-content .test-content-questions .answer', 'click');
					$(complete.game_container_field_name).undelegate('.btn-test-submit', 'click');
					if (results.passed == 1)
					{
						complete.passed_state(data.next_url, data.next_caption);
					}
					else
						complete.failed_state();
				}                  
			});
			return false;
		});

	},
	grade: function() {
		var grade = 0;
		var passed = 0;
		var total = complete.words.length;
		var total_right = 0;


		var i = 0;
		while (i < complete.words.length)
		{
			if (!complete.words[i].complete)
			{
				var answer = $('input[name='+i+']').val().trim().toLowerCase();
				if (answer == complete.words[i].content.toLowerCase())
				{
					total_right++;

				}
				else
				{
					$.each(complete.words[i].options, function(index, value) {
						if (answer == value.toLowerCase())
						{
							total_right++;
							return true;
						}
					});
				}
			}
			else
			{
				var answer = $('select[name='+i+']').val();
				if (answer == complete.words[i].content)
					total_right++;
			}
			i++;
		}
		
		grade = Math.round(total_right * complete.max_score / total);
		passed =  grade >= complete.pass_score ? 1 : 0;
		
		return {grade: grade, passed: passed};
	},
	passed_state: function(next_url, next_caption) {
		complete.game_interface_html	= '<div class="test-content">' +
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
						
		$(complete.game_container_field_name + ' .test-result').html(complete.game_interface_html);
		$(complete.game_container_field_name + ' .test-content .test-content-buttons .btn-test-next').click(function() {
			window.location.href = next_url;
		});
	
	},
	failed_state: function() {
		var questions_html = "";
		complete.game_interface_html	= '<div class="test-content">' +
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
						
		$(complete.game_container_field_name + ' .test-result').html(complete.game_interface_html);
		$(complete.game_container_field_name + ' .test-content .test-content-buttons .btn-test-repeat').click(function() {
			location.reload();
		});
	}	
};