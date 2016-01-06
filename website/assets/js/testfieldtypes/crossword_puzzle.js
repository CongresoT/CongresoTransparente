var crossword_puzzle = {
	container_field_name: "",
	data_field_name: "",
	confirm_field_name: "",

	matrix: Array(),
	max_rows: 5,
	max_cols: 5,
	horizontal_words: Array(),
	vertical_words: Array(),
	interface_html: "",
	
	max_score: 0,
	pass_score: 0,
	game_finish_url: "",
	game_container_field_name: "",
	game_interface_html: "",
	clues: [],
	
	error_msg: "",
	validate: function() {
		return true;
	},
	get_error_msg: function() {
		return crossword_puzzle.error_msg;
	},
	load_data: function(json) {
		if (json != "")
		{
			var object = $.parseJSON(json);
			crossword_puzzle.matrix 		= object.matrix;
			crossword_puzzle.max_rows 		= object.max_rows;
			crossword_puzzle.max_cols 		= object.max_cols;
			crossword_puzzle.horizontal_words = object.horizontal_words;
			crossword_puzzle.vertical_words = object.vertical_words;
		}
	},
	get_data: function() {
		var object = {
			matrix: crossword_puzzle.matrix,
			max_rows: crossword_puzzle.max_rows,
			max_cols: crossword_puzzle.max_cols,
			horizontal_words: crossword_puzzle.horizontal_words,
			vertical_words: crossword_puzzle.vertical_words
		};
		var json =  JSON.stringify(object);
		return json;
	},
	save: function() {
		crossword_puzzle.resize_matrix();
		for (var i = 0; i < crossword_puzzle.max_rows; i++)
			for (var j = 0; j < crossword_puzzle.max_cols; j++)
		{
			crossword_puzzle.matrix[i][j] = $(crossword_puzzle.container_field_name + ' .cell_' + i + '_' + j).val();
		}
		
		if ($(crossword_puzzle.container_field_name + ' .crossword-horizontal-container .hint-row').length > 0) {
			crossword_puzzle.horizontal_words = Array();
			$(crossword_puzzle.container_field_name + ' .crossword-horizontal-container .hint-row').each(function(index) {
				crossword_puzzle.horizontal_words.push({word: $(this).find('.hint-word').val(), description: $(this).find('.hint-description').val()});
			});
		}

		if ($(crossword_puzzle.container_field_name + ' .crossword-vertical-container .hint-row').length > 0) {
			crossword_puzzle.vertical_words = Array();
			$(crossword_puzzle.container_field_name + ' .crossword-vertical-container .hint-row').each(function(index) {
				crossword_puzzle.vertical_words.push({word: $(this).find('.hint-word').val(), description: $(this).find('.hint-description').val()});
			});
		}
		
		crossword_puzzle.max_rows = $(crossword_puzzle.container_field_name + ' .max_rows').val();
		crossword_puzzle.max_cols = $(crossword_puzzle.container_field_name + ' .max_cols').val();
	},
	load: function() {
		crossword_puzzle.resize_matrix();
		for (var i = 0; i < crossword_puzzle.max_rows; i++)
			for (var j = 0; j < crossword_puzzle.max_cols; j++)
			{
				$(crossword_puzzle.container_field_name + ' .cell_' + i + '_' + j).val(crossword_puzzle.matrix[i][j]);
			}
		$(crossword_puzzle.container_field_name + ' .max_rows').val(crossword_puzzle.max_rows);
		$(crossword_puzzle.container_field_name + ' .max_cols').val(crossword_puzzle.max_cols);

		if (crossword_puzzle.horizontal_words.length > 0)
		{
			$(crossword_puzzle.container_field_name + ' .crossword-hints').append('<div class="crossword-horizontal-title">Horizontal</div><div class="crossword-horizontal-container"></div>');
			var html =  '<table><tr class="hint-header"><td>Palabra</td><td>Descripción</td></tr>';		
			for (var i = 0; i < crossword_puzzle.horizontal_words.length; i++)
			{
				html += '<tr class="hint-row"><td><input class="hint-word" value="' + crossword_puzzle.horizontal_words[i].word + '" /></td><td><input class="hint-description" value="' + crossword_puzzle.horizontal_words[i].description + '" /></td></tr>';
			}
			html += '</table>';
			$(crossword_puzzle.container_field_name + ' .crossword-hints .crossword-horizontal-container').append(html);		
		}

		if (crossword_puzzle.vertical_words.length > 0)
		{
			$(crossword_puzzle.container_field_name + ' .crossword-hints').append('<div class="crossword-vertical-title">Vertical</div><div class="crossword-vertical-container"></div>');
			var html =  '<table><tr class="hint-header"><td>Palabra</td><td>Descripción</td></tr>';		
			for (var i = 0; i < crossword_puzzle.vertical_words.length; i++)
			{
				html += '<tr class="hint-row"><td><input class="hint-word" value="' + crossword_puzzle.vertical_words[i].word + '" /></td><td><input class="hint-description" value="' + crossword_puzzle.vertical_words[i].description + '" /></td></tr>';
			}
			html += '</table>';
			$(crossword_puzzle.container_field_name + ' .crossword-hints .crossword-vertical-container').append(html);
		}
		
	},
	resize_matrix: function () {
		$(crossword_puzzle.container_field_name + ' .crossword-container').html('');
		temp_matrix = Array();
		for (var i = 0; i < crossword_puzzle.max_rows; i++)
		{
			temp_matrix.push(Array());
			var columns = "";
			for (var j = 0; j < crossword_puzzle.max_cols; j++)
			{
				var character = "";
				var hasI = crossword_puzzle.matrix.length > i;
				var hasJ = false;
				if (hasI)
					hasJ = crossword_puzzle.matrix[i].length > j;
				if (hasI && hasJ)
					character = crossword_puzzle.matrix[i][j];
				else
					character = "";
					
				temp_matrix[i].push(character);
				columns += '<input type="" maxlength="1" style="width: 30px" class="cell_' + i + '_' + j + '" value="' + character + '" />';
			}
			$(crossword_puzzle.container_field_name + ' .crossword-container').append('<div class="crossword-puzzle-row">' + columns + '</div>');
		}
		crossword_puzzle.matrix = temp_matrix;
	},
	scan_horizontal_words: function () {
		crossword_puzzle.horizontal_words = Array();
		for (var i = 0; i < crossword_puzzle.max_rows; i++)
		{
			var word = "";
			for (var j = 0; j < crossword_puzzle.max_cols; j++)
			{
				var letter = crossword_puzzle.matrix[i][j];
				if ((letter != "") && (j < crossword_puzzle.max_cols - 1))
					word += letter;
				else
				{
					if ((letter != "") && (j == crossword_puzzle.max_cols - 1))
						word += letter;
					if (word != "" && word.length > 1)
						crossword_puzzle.horizontal_words.push({word: word, description: ''});

					word = "";
				}
			}
		}
	},
	scan_vertical_words: function () {
		crossword_puzzle.vertical_words = Array();
		for (var i = 0; i < crossword_puzzle.max_cols; i++)
		{
			var word = "";
			for (var j = 0; j < crossword_puzzle.max_rows; j++)
			{
				var letter = crossword_puzzle.matrix[j][i];
				if ((letter != "") && (j < crossword_puzzle.max_rows - 1))
					word += letter;
				else
				{
					if ((letter != "") && (j == crossword_puzzle.max_rows - 1))
						word += letter;
					if (word != "" && word.length > 1)
						crossword_puzzle.vertical_words.push({word: word, description: ''});
					word = "";
				}
			}
		}
	},
	clean: function() {
		$(crossword_puzzle.container_field_name + ' .btn-resize').unbind();
		$(crossword_puzzle.container_field_name + ' .btn-hints').unbind();
		$(crossword_puzzle.container_field_name + ' .crossword-puzzle-row input').die();
	},	
	init: function(container_field_name, data_field_name, confirm_field_name) {
		crossword_puzzle.container_field_name = container_field_name;
		crossword_puzzle.data_field_name	= data_field_name;
		crossword_puzzle.confirm_field_name	= confirm_field_name;
	
		crossword_puzzle.interface_html = '<div class="crossword-options">Filas: <input class="max_rows" id="max_rows" /> Columnas: <input class="max_cols" id="max_cols" /><input type="button" class="btn-resize" value="Aplicar" /></div>' +
		'<div class="crossword-title">Letras</div>' +
		'<div class="crossword-container"></div>' +
		'<div class="crossword-options-bottom"><input type="button" class="btn-hints" value="Ingresar pistas" /></div>' +
		'<div class="crossword-hints"></div>';
		$(crossword_puzzle.container_field_name).html(crossword_puzzle.interface_html);
		
		$(crossword_puzzle.container_field_name + ' .btn-resize').click(function () {
			crossword_puzzle.save();
			crossword_puzzle.load();
		});

		$(crossword_puzzle.container_field_name + ' .btn-hints').click(function () {
			crossword_puzzle.scan_horizontal_words();
			crossword_puzzle.scan_vertical_words();
			crossword_puzzle.load();
		});

		$(crossword_puzzle.container_field_name + ' .crossword-puzzle-row input').live('change', function () {
			var parts = $(this).attr('class').split("_");
			var i = parseInt(parts[1]);
			var j = parseInt(parts[2]);
			crossword_puzzle.matrix[i][j] = $(this).val();
		});
		
		crossword_puzzle.load();
	},
	game_init: function(game_container_field_name, game_finish_url, pass_score, max_score) {
		crossword_puzzle.game_container_field_name = game_container_field_name;
		crossword_puzzle.game_finish_url = game_finish_url;
		crossword_puzzle.pass_score = pass_score;
		crossword_puzzle.max_score = max_score;

		var script = document.createElement("script");
		script.type = 'text/javascript';
		script.src = site_url + 'assets/js/crossword.js';

		$("head").append(script);
		
		crossword_puzzle.game_interface_html	= 
						'<div class="test-content">' +
							'<div class="test-content-puzzle">' +
							'</div>' +
							'<div class="test-content-options">' +
								'<input class="btn-test btn-test-submit" type="submit" value="Enviar" />' +
							'</div>' +
							'<div class="test-content-state">' +
							'</div>' +
						'</div>';
		
		$(crossword_puzzle.game_container_field_name).html(crossword_puzzle.game_interface_html);
		
		var grid = Array();
		for (var i = 0; i < crossword_puzzle.max_rows; i++)
		{
			var line = '';
			for (var j = 0; j < crossword_puzzle.max_cols; j++)
			{
				line += (crossword_puzzle.matrix[i][j] == '' ? '@' : ' ');
			}
			grid.push(line);
		}
		
		var acrossClues = Array();
		for (var i = 0; i < crossword_puzzle.horizontal_words.length; i++)
		{
			acrossClues.push(crossword_puzzle.horizontal_words[i].description + '%%' + crossword_puzzle.horizontal_words[i].word);
		}
		
		var downClues = Array();
		for (var i = 0; i < crossword_puzzle.vertical_words.length; i++)
		{
			downClues.push(crossword_puzzle.vertical_words[i].description + '%%' + crossword_puzzle.vertical_words[i].word);
		}							
							
		$(crossword_puzzle.game_container_field_name + ' .test-content-puzzle').crossword({ gridMask: grid, acrossClues: acrossClues, downClues: downClues, validateAnswer: 'grid', clues: crossword_puzzle.clues})
		
		$(crossword_puzzle.game_container_field_name).delegate('.btn-test-submit', 'click', function() {
			console.log(crossword_puzzle.clues);
			var results = crossword_puzzle.grade();
			$(this).attr('disabled', true);
			$.ajax({
				url: crossword_puzzle.game_finish_url,
				data: results,
				dataType: 'json',
				type: 'post',
				success: function(data) {
					$(crossword_puzzle.game_container_field_name).undelegate('.btn-test-submit', 'click');
					if (results.passed == 1)
					{
						crossword_puzzle.passed_state(data.next_url, data.next_caption);
					}
					else
						crossword_puzzle.failed_state();
				}                  
			});
			return false;
		});
		
	},
	grade: function() {
		var grade = 0;
		var passed = 0;
		var total = crossword_puzzle.clues.length;
		var total_right = 0;
		
		for (var i = 0; i < crossword_puzzle.clues.length; i++)
		{
			if (crossword_puzzle.clues[i].answer.toUpperCase() == crossword_puzzle.clues[i].enteredAnswer)
			{
				total_right++;
			}
		}
		
		grade = Math.round(total_right * crossword_puzzle.max_score / total);
		passed =  grade >= crossword_puzzle.pass_score ? 1 : 0;
		
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
						
		$(crossword_puzzle.game_container_field_name + ' .test-content-state').html(html);
		$(crossword_puzzle.game_container_field_name + ' .test-content .test-content-buttons .btn-test-next').click(function() {
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
						
		$(crossword_puzzle.game_container_field_name + ' .test-content-state').html(html);
		$(crossword_puzzle.game_container_field_name + ' .test-content .test-content-buttons .btn-test-repeat').click(function() {
			location.reload();
		});
	}
};