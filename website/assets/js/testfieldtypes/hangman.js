var hangman = {
	container_field_name: "",
	data_field_name: "",
	confirm_field_name: "",
	current_question: 0,
	words: Array(),
	max_tries: 3,
	interface_html: "",
	
	max_score: 0,
	pass_score: 0,
	tries: 0,
	selected_word_index: -1,
	used_letters: Array(),
	correct_letters: 0,
	resolved: false,
	game_finish_url: "",
	game_container_field_name: "",
	game_interface_html: "",	
	
	error_msg: "",
	validate: function() {
		return true;
	},
	get_error_msg: function() {
		return hangman.error_msg;
	},
	load_data: function(json) {
		if (json != "")
		{
			var object = $.parseJSON(json);
			hangman.words 			= object.words;		
			hangman.max_tries 		= object.max_tries;		
		}
	},
	get_data: function() {
		var object = {
			words: hangman.words,
			max_tries: hangman.max_tries
		};
		var json =  JSON.stringify(object);
		return json;
	},
	save: function() {
		var words = Array();
		$(hangman.container_field_name + ' .word-container').each(function (index) {
			words.push($(this).find('.word').val());

		});
		
		hangman.words		= words;
		hangman.max_tries 	= $(hangman.container_field_name + ' .max_tries').val();
	},
	load: function() {
		$(hangman.container_field_name).html(hangman.interface_html);
		if (hangman.words.length > 0)
		{
			$(hangman.container_field_name + ' .words-container').find('.word').val(hangman.words[0]);
			for (var i = 1; i < hangman.words.length; i++)
			{
				$(hangman.container_field_name + ' .words-container').append('<div class="word-container"><input class="word" value="' + hangman.words[i] + '" /><input type="button" class="btn-delete" value="Eliminar" /></div>');
			}
		}		
	},
	clean: function() {
		$(hangman.container_field_name + ' .btn-add').die();
		$(hangman.container_field_name + ' .btn-delete').die();

	},	
	init: function(container_field_name, data_field_name, confirm_field_name) {
		hangman.container_field_name = container_field_name;
		hangman.data_field_name	= data_field_name;
		hangman.confirm_field_name	= confirm_field_name;
		
	
		hangman.interface_html = '<div class="word-titles">Palabras</div>' +
		'<div class="words-container"><div class="word-container"><input class="word" /><input type="button" class="btn-delete" value="Eliminar" /></div></div>' +
		'<div class="options-container"><input type="button" class="btn-add" value="Agregar palabra" /><br/>Máximo número de intentos: <input class="max_tries" name="max_tries" value="3" /></div>';
		
		$(hangman.container_field_name + ' .btn-add').live('click', function() {
			$(hangman.container_field_name + ' .words-container').append('<div class="word-container"><input class="word" /><input type="button" class="btn-delete" value="Eliminar" /></div>');
		});		
		
		$(hangman.container_field_name + ' .btn-delete').live('click', function() {
			if ($(hangman.container_field_name + ' .word-container').length > 1)
			{
				if ($(this).parent().find('.word').val() != "")
				{
					if (confirm('¿Está seguro de eliminar esta palabra?'))
					{
						$(this).parent().remove();
					}
				}
				else
					$(this).parent().remove();
			} else
			{
				alert('Debe existir al menos una palabra')
			}
		});

		$(hangman.container_field_name).html(hangman.interface_html);

		hangman.load();
	},
	game_init: function(game_container_field_name, game_finish_url, pass_score, max_score) {
		hangman.game_container_field_name = game_container_field_name;
		hangman.game_finish_url = game_finish_url;
		hangman.pass_score = pass_score;
		hangman.max_score = max_score;
		
		hangman.resolved = false;
		hangman.selected_word_index = Math.floor(Math.random() * hangman.words.length);

		var letters = "";
		
		for (var i = 0; i < hangman.words[hangman.selected_word_index].length; i++)
		{
			letters += '<input type="text" class="letter letter-' + i + '" value="" maxlength="1" readonly="readonly" />';
		}

		var hangman_tries_html = '';
		
		for (var i = 0; i < hangman.max_tries; i++)
			hangman_tries_html += '<img src="' + site_url + 'assets/images/client/balloon.png" alt="Intento" />';
		
		
		hangman.game_interface_html	= 
						'<div class="test-content">' +
							'<div class="test-content-tries">' +
							'<strong>Intentos:</strong> <br/><span class="remaining-tries">' + hangman_tries_html + '</span>' +
							'</div>' +
							'<div class="test-content-word">' +
							letters +
							'</div>' +
							'<div class="test-content-wrong">' +
							'</div>' +
							'<div class="test-content-input">' +
							'<input type="text" class="input-letter" maxlength="1" /> <input class="btn-test btn-test-submit" type="submit" value="Ingresar" />' +
							'</div>' +
							'<div class="test-result">' +
							'</div>' +
						'</div>';
						
		$(hangman.game_container_field_name).html(hangman.game_interface_html);

		$(hangman.game_container_field_name).delegate('.btn-test-submit', 'click', function() {
		
			if ((hangman.tries < hangman.max_tries) && (!hangman.resolved))
			{
				var letter = $(hangman.game_container_field_name + ' .input-letter').val();
				letter = letter.toLowerCase();

				if (letter != "" && $.inArray(letter, hangman.used_letters) === -1)
				{
					hangman.used_letters.push(letter)
					if ($.inArray(letter, hangman.words[hangman.selected_word_index]) > -1)
					{
						for (var i = 0; i < hangman.words[hangman.selected_word_index].length; i++)
						{
							if (letter == hangman.words[hangman.selected_word_index][i])
							{
								$(hangman.game_container_field_name + ' .letter-' + i).val(letter);
								hangman.correct_letters++;
							}
						}
					}
					else
					{
						hangman.tries++;
						$(hangman.game_container_field_name + ' .test-content-wrong').append('<span class="wrong-letter">' + letter + '</span>');
						
						var hangman_tries_html = '';
						
						for (var i = 0; i < hangman.max_tries - hangman.tries; i++)
							hangman_tries_html += '<img src="' + site_url + 'assets/images/client/balloon.png" alt="Intento" />';						
						for (var i = 0; i < hangman.tries; i++)
							hangman_tries_html += '<img src="' + site_url + 'assets/images/client/balloon_buff.png" alt="Fallo" />';						
						
						$(hangman.game_container_field_name + ' .remaining-tries').html(hangman_tries_html);
					}
				}
				$(hangman.game_container_field_name + ' .input-letter').val('');
			}

			if (hangman.correct_letters == hangman.words[hangman.selected_word_index].length)
				hangman.resolved = true;
			
			if ((hangman.tries >= hangman.max_tries) || (hangman.resolved))
			{
				var results = hangman.grade();
				$(this).attr('disabled', true);
				$.ajax({
					url: hangman.game_finish_url,
					data: results,
					dataType: 'json',
					type: 'post',
					success: function(data) {
						$(hangman.game_container_field_name).undelegate('.btn-test-submit', 'click');
						if (results.passed == 1)
						{
							hangman.passed_state(data.next_url, data.next_caption);
						}
						else
							hangman.failed_state();
					}                  
				});
			}
			return false;
		});
		
	},
	grade: function() {
		var grade = 0;
		var passed = 0;
		
		var total = hangman.words[hangman.selected_word_index].length;
		var total_right = hangman.correct_letters;
				
		grade = Math.round(total_right * hangman.max_score / total);
		passed =  grade >= hangman.pass_score ? 1 : 0;
		
		return {grade: grade, passed: passed};
	},
	passed_state: function(next_url, next_caption) {
		var html = '<div class="test-star">' +
						'<img src="' + site_url + 'assets/images/client/star.png" alt="" /><br/>' +
						'<span class="message-passed">¡Felicidades! Ganaste la evaluación.</span>' +
					'</div>' +
					'<div class="test-kid">' +
						'<img src="' + site_url + 'assets/images/client/smile.png" alt="" />' +
					'</div>' +
					'<div class="test-content-buttons">' +
						'<input class="btn-test btn-test-next" type="submit" value="' + next_caption + '" />'
					'</div>';
						
		$(hangman.game_container_field_name + ' .test-result').html(html);
		$(hangman.game_container_field_name + ' .test-content .test-content-buttons .btn-test-next').click(function() {
			window.location.href = next_url;
		});
	
	},
	failed_state: function() {						
		var html = '<div class="test-star">' +
						'<span class="message-failed">Inténtalo de nuevo.<br/>Puedes repasar para obtener un mejor resultado.</span>' +
					'</div>' +
					'<div class="test-kid">' +
								'<img src="' + site_url + 'assets/images/client/antismile.png" alt="" />'+
					'</div>' +
					'<div class="test-content-buttons">' +
						'<input class="btn-test btn-test-repeat" type="submit" value="Repetir" />' +
					'</div>';
						
		$(hangman.game_container_field_name + ' .test-result').html(html);
		$(hangman.game_container_field_name + ' .test-content .test-content-buttons .btn-test-repeat').click(function() {
			location.reload();
		});
	}		
};