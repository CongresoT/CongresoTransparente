var word_search_puzzle = {
	container_field_name: "",
	data_field_name: "",
	confirm_field_name: "",
	current_question: 0,
	words: Array(),
	max_words: 3,
	interface_html: "",
	
	max_score: 0,
	pass_score: 0,
	game_finish_url: "",
	game_container_field_name: "",
	game_interface_html: "",	
	
	selected_words: Array(),
	grid_size: 0,

	error_msg: "",
	validate: function() {
		return true;
	},
	get_error_msg: function() {
		return word_search_puzzle.error_msg;
	},
	load_data: function(json) {
		if (json != "")
		{
			var object = $.parseJSON(json);
			word_search_puzzle.words 			= object.words;		
			word_search_puzzle.max_words 		= object.max_words;		
		}
	},
	get_data: function() {
		var object = {
			words: word_search_puzzle.words,
			max_words: word_search_puzzle.max_words
		};
		var json =  JSON.stringify(object);
		return json;
	},
	save: function() {
		var words = Array();
		$(word_search_puzzle.container_field_name + ' .word-container').each(function (index) {
			words.push($(this).find('.word').val());

		});
		
		word_search_puzzle.words		= words;
		word_search_puzzle.max_words 	= $(word_search_puzzle.container_field_name + ' .max_words').val();		
	},
	load: function() {
		$(word_search_puzzle.container_field_name).html(word_search_puzzle.interface_html);
		if (word_search_puzzle.words.length > 0)
		{
			$(word_search_puzzle.container_field_name + ' .words-container').find('.word').val(word_search_puzzle.words[0]);
			for (var i = 1; i < word_search_puzzle.words.length; i++)
			{
				$(word_search_puzzle.container_field_name + ' .words-container').append('<div class="word-container"><input class="word" value="' + word_search_puzzle.words[i] + '" /><input type="button" class="btn-delete" value="Eliminar" /></div>');
			}
		}		
	},
	clean: function() {
		$(word_search_puzzle.container_field_name + ' .btn-add').die();
		$(word_search_puzzle.container_field_name + ' .btn-delete').die();
	},	
	init: function(container_field_name, data_field_name, confirm_field_name) {
		word_search_puzzle.container_field_name = container_field_name;
		word_search_puzzle.data_field_name	= data_field_name;
		word_search_puzzle.confirm_field_name	= confirm_field_name;
		
	
		word_search_puzzle.interface_html = '<div class="word-titles">Palabras</div>' +
		'<div class="words-container"><div class="word-container"><input class="word" /><input type="button" class="btn-delete" value="Eliminar" /></div></div>' +
		'<div class="options-container"><input type="button" class="btn-add" value="Agregar palabra" /><br/>Máximo número de palabras: <input class="max_words" name="max_words" value="3" /></div>'; 	
		
		$(word_search_puzzle.container_field_name + ' .btn-add').live('click', function() {
			$(word_search_puzzle.container_field_name + ' .words-container').append('<div class="word-container"><input class="word" /><input type="button" class="btn-delete" value="Eliminar" /></div>');
		});		
		
		$(word_search_puzzle.container_field_name + ' .btn-delete').live('click', function() {
			if ($(word_search_puzzle.container_field_name + ' .word-container').length > 1)
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

		
		$(word_search_puzzle.container_field_name).html(word_search_puzzle.interface_html);
		
		word_search_puzzle.load();
		
	},
	game_init: function(game_container_field_name, game_finish_url, pass_score, max_score) {
		word_search_puzzle.game_container_field_name = game_container_field_name;
		word_search_puzzle.game_finish_url = game_finish_url;
		word_search_puzzle.pass_score = pass_score;
		word_search_puzzle.max_score = max_score;

		var script1 = document.createElement("script");
		script1.type = 'text/javascript';
		script1.src = site_url + 'assets/js/jquery.wordsearchgame.js';

		var script2 = document.createElement("script");
		script2.type = 'text/javascript';
		script2.src = site_url + 'assets/js/jquery.ui.touch-punch.min.js';

		$("head").append(script1);
		$("head").append(script2);
		
		word_search_puzzle.game_interface_html	= 
						'<div class="test-content">' +
							'<div class="test-content-puzzle">' +
							'</div>' +
							'<div class="test-content-options">' +
								'<input class="btn-test btn-test-submit" type="submit" value="Enviar" />' +
							'</div>' +
							'<div class="test-content-state">' +
							'</div>' +
						'</div>';
		
		$(word_search_puzzle.game_container_field_name).html(word_search_puzzle.game_interface_html);
		
		var selected_indexes = Array();
		var words = "";
		word_search_puzzle.grid_size = 10;
		for (var i = 0; i < word_search_puzzle.max_words; i++)
		{
			var j = Math.floor(Math.random() * (word_search_puzzle.words.length));

			while ($.inArray(j, selected_indexes) > -1)
				j = Math.floor(Math.random() * (word_search_puzzle.words.length));
			
			selected_indexes.push(j);
			word_search_puzzle.selected_words.push(word_search_puzzle.words[j]);
			word_search_puzzle.grid_size = word_search_puzzle.words[j].length > word_search_puzzle.grid_size ? word_search_puzzle.words[j].length : word_search_puzzle.grid_size;
			if (i < word_search_puzzle.max_words - 1)
				words += word_search_puzzle.words[j] + ',';
			else
				words += word_search_puzzle.words[j];
		}

		$(".test-content-puzzle").wordsearchwidget({"wordlist" : words, "gridsize" : word_search_puzzle.grid_size});
		
		$(word_search_puzzle.game_container_field_name).delegate('.btn-test-submit', 'click', function() {
			console.log(word_search_puzzle.clues);
			var results = word_search_puzzle.grade();
			$(this).attr('disabled', true);
			$.ajax({
				url: word_search_puzzle.game_finish_url,
				data: results,
				dataType: 'json',
				type: 'post',
				success: function(data) {
					$(word_search_puzzle.game_container_field_name).undelegate('.btn-test-submit', 'click');
					if (results.passed == 1)
					{
						word_search_puzzle.passed_state(data.next_url, data.next_caption);
					}
					else
						word_search_puzzle.failed_state();
				}                  
			});
			return false;
		});
		
	},
	grade: function() {
		var grade = 0;
		var passed = 0;
		var total = word_search_puzzle.clues.length;
		var total_right = 0;
		
		for (var i = 0; i < word_search_puzzle.clues.length; i++)
		{
			if (word_search_puzzle.clues[i].answer.toUpperCase() == word_search_puzzle.clues[i].enteredAnswer)
			{
				total_right++;
			}
		}
		
		grade = Math.round(total_right * word_search_puzzle.max_score / total);
		passed =  grade >= word_search_puzzle.pass_score ? 1 : 0;
		
		return {grade: grade, passed: passed};
	},
	passed_state: function(next_url, next_caption) {
		var html	= '<div class="test-star">' +
								'<img src="' + site_url + 'assets/images/client/star.png" alt="" /><br/>' +
								'<span class="message-passed">¡Felicidades! Ganaste la evaluación.</span>' +
							'</div>' +
							'<div class="test-kid">' +
								'<img src="' + site_url + 'assets/images/client/smile.png" alt="" />' +
							'</div>' +
							'<div class="test-content-buttons">' +
								'<input class="btn-test btn-test-next" type="submit" value="' + next_caption + '" />'
							'</div>';
						
		$(word_search_puzzle.game_container_field_name + ' .test-content-state').html(html);
		$(word_search_puzzle.game_container_field_name + ' .test-content .test-content-buttons .btn-test-next').click(function() {
			window.location.href = next_url;
		});
	
	},
	failed_state: function() {
		var html	= '<div class="test-star">' +
							'<span class="message-failed">Inténtalo de nuevo.<br/>Puedes repasar para obtener un mejor resultado.</span>' +
						'</div>' +
						'<div class="test-kid">' +
								'<img src="' + site_url + 'assets/images/client/antismile.png" alt="" />'+
						'</div>' +
						'<div class="test-content-buttons">' +
							'<input class="btn-test btn-test-repeat" type="submit" value="Repetir" />' +
						'</div>';
						
		$(word_search_puzzle.game_container_field_name + ' .test-content-state').html(html);
		$(word_search_puzzle.game_container_field_name + ' .test-content .test-content-buttons .btn-test-repeat').click(function() {
			location.reload();
		});
	}
};