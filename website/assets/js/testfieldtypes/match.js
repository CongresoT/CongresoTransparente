function show_upload_button(unique_id, uploader_element)
{
	$('#upload-state-message-'+unique_id).html('');
	$("#loading-"+unique_id).hide();

	$('#upload-button-'+unique_id).slideDown('fast');
	$("input[rel="+uploader_element.attr('name')+"]").val('');
	$('#success_'+unique_id).slideUp('fast');	
}

function load_fancybox(elem)
{
	elem.fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	600, 
		'speedOut'		:	200, 
		'overlayShow'	:	false
	});		
}

var  match_loadImage = function(){
	$('.gc-file-upload').each(function(){
		if ($(this).attr('up')=='true')
			return $(this);

		$(this).attr('up', 'true');
		var unique_id 	= $(this).attr('id');
		var uploader_url = $(this).attr('rel');
		var uploader_element = $(this);
		var delete_url 	= $('#delete_url_'+unique_id).attr('href');

		var file_upload_info = {
			accepted_file_types: /(\.|\/)(gif|jpeg|jpg|png|tiff|doc|docx|txt|odt|xls|xlsx|pdf|ppt|pptx|pps|ppsx|mp3|m4a|ogg|wav|mp4|m4v|mov|wmv|flv|avi|mpg|ogv|3gp|3g2|zip)$/i,
			accepted_file_types_ui : ".gif,.jpeg,.jpg,.png,.tiff,.doc,.docx,.txt,.odt,.xls,.xlsx,.pdf,.ppt,.pptx,.pps,.ppsx,.mp3,.m4a,.ogg,.wav,.mp4,.m4v,.mov,.wmv,.flv,.avi,.mpg,.ogv,.3gp,.3g2,.zip",
			max_file_size: 20971520,
			max_file_size_ui: "20MB"
		};
		var string_upload_file 	= "Subir un archivo";
		var string_delete_file 	= "Eliminando archivo";
		var string_progress 			= "Progreso: ";
		var error_on_uploading 			= "Ha ocurrido un error al intentar subir el archivo.";
		var message_prompt_delete_file 	= "Estas seguro que quieres eliminar este archivo?";

		var error_max_number_of_files 	= "Solo puedes subir un archivo a la vez.";
		var error_accept_file_types 	= "No se permite este tipo de extension.";
		var error_max_file_size 		= "El archivo excede el tamaño 20MB que fue especificado.";
		var error_min_file_size 		= "No puedes subir un arvhivo vacio.";

		var base_url = site_url;
		var upload_a_file_string = "Subir un archivo";

	    $(this).fileupload({
	        dataType: 'json',
	        url: uploader_url,
	        cache: false,
	        acceptFileTypes:  file_upload_info.accepted_file_types,
			beforeSend: function(){
	    		$('#upload-state-message-'+unique_id).html(string_upload_file);
				$("#loading-"+unique_id).show();
				$("#upload-button-"+unique_id).slideUp("fast");
			},
	        limitMultiFileUploads: 1,
	        maxFileSize: file_upload_info.max_file_size,			
			send: function (e, data) {						
				var errors = '';

				
			    if (data.files.length > 1) {
			    	errors += error_max_number_of_files + "\n" ;
			    }
				
	            $.each(data.files,function(index, file){
		            if (!(data.acceptFileTypes.test(file.type) || data.acceptFileTypes.test(file.name))) {
		            	errors += error_accept_file_types + "\n";
		            }
		            if (data.maxFileSize && file.size > data.maxFileSize) {
		            	errors +=  error_max_file_size + "\n";
		            }
		            if (typeof file.size === 'number' && file.size < data.minFileSize) {
		            	errors += error_min_file_size + "\n";
		            }			            	
	            });	
	            
	            if(errors != '')
	            {
	            	alert(errors);
	            	return false;
	            }
				
			    return true;
			},
	        done: function (e, data) {
				if(typeof data.result.success != 'undefined' && data.result.success)
				{
					$("#loading-"+unique_id).hide();
					$("#progress-"+unique_id).html('');
		            $.each(data.result.files, function (index, file) {
		            	$('#upload-state-message-'+unique_id).html('');
		            	$("input[rel="+uploader_element.attr('name')+"]").val(file.name);
		            	var file_name = file.name;
						
		            	var is_image = (file_name.substr(-4) == '.jpg'  
		            						|| file_name.substr(-4) == '.png' 
		            						|| file_name.substr(-5) == '.jpeg' 
		            						|| file_name.substr(-4) == '.gif' 
		            						|| file_name.substr(-5) == '.tiff')
							? true : false;

		            	if(is_image)
		            	{
		            		$('#file_'+unique_id).addClass('image-thumbnail');
		            		load_fancybox($('#file_'+unique_id));
		            		$('#file_'+unique_id).html('<img src="'+file.url+'" height="50" />');
		            	}
		            	else
		            	{
		            		$('#file_'+unique_id).removeClass('image-thumbnail');
		            		$('#file_'+unique_id).unbind("click");
		            		$('#file_'+unique_id).html(file_name);
		            	}
		            	
						$('#file_'+unique_id).attr('href',file.url);
						$('#hidden_'+unique_id).val(file_name);

						$('#success_'+unique_id).fadeIn('slow');
						$('#delete_url_'+unique_id).attr('rel',file_name);
						$('#upload-button-'+unique_id).slideUp('fast');
		            });
				}
				else if(typeof data.result.message != 'undefined')
				{
					alert(data.result.message);
					show_upload_button(unique_id, uploader_element);
				}
				else
				{
					alert(error_on_uploading);
					show_upload_button(unique_id, uploader_element);
				}
	        },
	        autoUpload: true,
	        error: function()
	        {
	        	alert(error_on_uploading);
	        	show_upload_button(unique_id, uploader_element);
	        },
	        fail: function(e, data)
	        {
	            // data.errorThrown
	            // data.textStatus;
	            // data.jqXHR;	        	
	        	alert(error_on_uploading);
	        	show_upload_button(unique_id, uploader_element);
	        },	        
	        progress: function (e, data) {
                $("#progress-"+unique_id).html(string_progress + parseInt(data.loaded / data.total * 100, 10) + '%');
            }	        
	    });
		$('#delete_'+unique_id).click(function(){

			if( confirm(message_prompt_delete_file) )
			{
				var file_name = $('#delete_url_'+unique_id).attr('rel');
				$.ajax({
					url: delete_url+"/"+file_name,
					cache: false,
					success:function(){
						show_upload_button(unique_id, uploader_element);
					},
					beforeSend: function(){
						$('#upload-state-message-'+unique_id).html(string_delete_file);
						$('#success_'+unique_id).hide();
						$("#loading-"+unique_id).show();
						$("#upload-button-"+unique_id).slideUp("fast");
					}
				});
			}
			
			return false;
		});		    
	    
	});
};






var match = {
	container_field_name: "",
	data_field_name: "",
	confirm_field_name: "",
	current_question: 0,
	words: Array(),
	is_random_select: false,
	random_select_max: 3,
	interface_html: "",
	error_msg: "",
	images: 0,
	image_mode: true,

	max_score: 0,
	pass_score: 0,
	game_finish_url: "",
	game_container_field_name: "",
	game_interface_html: "",	

	validate: function() {
		if (match.words.length < 3)
		{
			match.error_msg = 'El mínimo de palabras a emparejar es de 3';
			return false;
		}
		var i = 0;
		while (i < match.words.length)
		{
			if (match.words[i].word1.trim() == '')
			{
				match.error_msg = 'No pueden haber palabras vacias al emparejar';
				return false;
			}
			if (match.words[i].word2.trim() == '')
			{
				match.error_msg = 'No pueden haber palabras vacias al emparejar';
				return false;
			}

			i++;
		}
		if (match.is_random_select) 
		{
			if (match.random_select_max < 3)
			{
				match.error_msg = 'El mínimo de selección aleatoria es de 3 elementos';
				return false;				
			}
			if (match.random_select_max > match.words.length)
			{
				match.error_msg = 'El mínimo de selección aleatoria no puede ser mayor a la cantidad de palabras';
				return false;								
			}
		}
		return true;
	},
	get_error_msg: function() {
		return match.error_msg;
	},
	load_data: function(json) {
		if (json != "")
		{
			var object = $.parseJSON(json);
			match.words 			= object.words;		
			match.is_random_select 	= object.is_random_select;
			match.random_select_max 		= object.random_select_max;	
			match.image_mode		= object.image_mode;	
		}
	},
	get_data: function() {
		var object = {
			words: match.words,
			is_random_select: match.is_random_select,
			random_select_max: match.random_select_max,
			image_mode: match.image_mode
		};
		var json =  JSON.stringify(object);
		return json;
	},
	save: function() {
		var words = Array();
		$(match.container_field_name + ' .word-container').each(function (index) {
			if (match.image_mode)
				words.push({word1: $(this).find('.word1').val(), word2: $(this).find('.hidden-upload-input').val()});
			else
				words.push({word1: $(this).find('.word1').val(), word2: $(this).find('.word2').val()});

		});

		if ($('input[name="random_select"]').attr('checked'))
			match.is_random_select	= true;
		else
			match.is_random_select	= false;
		
		match.words		= words;
		match.random_select_max 	= $(match.container_field_name + ' .random_select_max').val();
	},
	load: function() {
		$(match.container_field_name).html(match.interface_html);
		$(match.container_field_name + ' .image_mode').prop('checked', match.image_mode);
		var word_container = '';
		if (match.words.length > 0)
		{
			for (var i = 0; i < match.words.length; i++)
			{
				if (match.image_mode)
					word_container = '<div class="word-container"><input class="word1" value="' + match.words[i].word1 + '" />'+
					match.generate_file_input(i, match.words[i].word2)+
					'<input type="button" class="btn-delete" value="Eliminar" /></div>';
				else
					word_container = '<div class="word-container"><input class="word1" value="' + match.words[i].word1 + '" />'+
					'<input class="word2" value="' + match.words[i].word2 + '" />'+
					'<input type="button" class="btn-delete" value="Eliminar" /></div>';

				$(match.container_field_name + ' .words-container').append(word_container);
			}
			match.images = match.words.length;
		}
		else
		{
			if (match.image_mode)
				word_container = '<div class="word-container"><input class="word1" value="" />'+
				match.generate_file_input(0)+
				'<input type="button" class="btn-delete" value="Eliminar" /></div>';
			else
				word_container = '<div class="word-container"><input class="word1" value="" />'+
				'<input class="word2" value="" />'+
				'<input type="button" class="btn-delete" value="Eliminar" /></div>';

			$(match.container_field_name + ' .words-container').append(word_container);
		}

		$(match.container_field_name + ' .random_select_max').val(match.random_select_max);
		
		if (match.is_random_select)
		{
			$(match.container_field_name + ' .random_select').attr('checked', true);
			$(match.container_field_name + ' .random_select_max').attr('disabled', false);
		}
		else
		{
			$(match.container_field_name + ' .random_select').attr('checked', false);
			$(match.container_field_name + ' .random_select_max').attr('disabled', true);
		}		

		match_loadImage();
	},
	clean: function() {
		$(match.container_field_name + ' .btn-add').die();
		$(match.container_field_name + ' .btn-delete').die();

	},	
	generate_file_input: function(unique, value){
		unique = 'img-' + unique;
		upload_url = site_url+'admin/test/match_image/' + unique;
		delete_url = site_url+'admin/test/match_delete_image';
		if (typeof value !== 'undefined' && value != '') // display image, if not display upload button
		{
			uploader_display_none = "display:none;";
			file_display_none = "";
		}
		else
		{
			value = '';
			uploader_display_none = "";
			file_display_none = "display:none;";
		}
		file_url = site_url+'assets/images/test/' + value;
		up = '<div><span class="fileinput-button qq-upload-button" id="upload-button-'+unique+'" style="'+uploader_display_none+'">'+
			'<span>Subir un archivo</span>'+
			'<input type="file" name="filename_'+unique+'" class="gc-file-upload" rel="'+upload_url+'" id="'+unique+'" />'+
			'<input class="hidden-upload-input" type="hidden" name="filename_hidden_'+unique+'" value="'+value+'" rel="filename_'+unique+'" />'+
		'</span>'+
		'<div id="uploader_'+unique+'" rel="'+unique+'" class="grocery-crud-uploader" style="'+uploader_display_none+'"></div>'+
		'<div id="success_'+unique+'" class="upload-success-url" style="'+file_display_none+' padding-top:7px;">'+
		'<a href="'+file_url+'" id="file_'+unique+'" class="open-file image-thumbnail"'+
		 ((value=='')?' target="_blank">'+value : '><img src="'+file_url+'" height="50px">')+
		'</a> '+
		'<a href="javascript:void(0)" id="delete_'+unique+'" class="delete-anchor">eliminar</a> '+
		'</div><div style="clear:both"></div>'+
		'<div id="loading-'+unique+'" style="display:none"><span id="upload-state-message-'+unique+'"></span> <span class="qq-upload-spinner"></span> <span id="progress-'+unique+'"></span></div>'+
		'<div style="display:none"><a href="'+upload_url+'" id="url_'+unique+'"></a></div>'+
		'<div style="display:none"><a href="'+delete_url+'" id="delete_url_'+unique+'" rel="'+value+'" ></a></div></div>';
		return up;

	},
	init: function(container_field_name, data_field_name, confirm_field_name) {
		match.container_field_name = container_field_name;
		match.data_field_name	= data_field_name;
		match.confirm_field_name	= confirm_field_name;
		
	
		match.interface_html = '<div class="word-titles">Palabras</div>' +
		'Emparejar imagenes con palabras: <input type="checkbox" name="image_mode" class="image_mode" value="1" />'+
		'<div class="words-container">'+
/*
		'<div class="word-container">'+
		'<input class="word1" />'+

		match.generate_file_input(0)+

		'<input type="button" class="btn-delete" value="Eliminar" /></div>'+
		*/
		'</div>' +
		'<div class="options-container"><input type="button" class="btn-add" value="Agregar pareja" /><br/><input type="checkbox" name="random_select" class="random_select" value="0" /> Seleccionar al azar un máximo de  <input class="random_select_max" name="random_select_max" value="3" /></div>';
		
		$(match.container_field_name + ' .btn-add').live('click', function() {
			var word_container = '';
			if (match.image_mode)
				word_container =  '<div class="word-container"><input class="word1" />'+
				match.generate_file_input(++match.images)+
				'<input type="button" class="btn-delete" value="Eliminar" /></div>';
			else
				word_container = '<div class="word-container"><input class="word1" />'+
				'<input class="word2" value="" />'+
				'<input type="button" class="btn-delete" value="Eliminar" /></div>';
			$(match.container_field_name + ' .words-container').append(word_container);
			match_loadImage();
		});		
		
		$(match.container_field_name + ' .image_mode').live('click', function() {
			match.save();
			match.image_mode = this.checked;
			var i = 0;
			while(i < match.words.length)
				match.words[i++].word2 = '';
			match.load();
		});

		$(match.container_field_name + ' .btn-delete').live('click', function() {
			if ($(match.container_field_name + ' .word-container').length > 1)
			{
				if ($(this).parent().find('.word').val() != "")
				{
					if (confirm('¿Está seguro de eliminar esta pareja?'))
					{
						$(this).parent().remove();
					}
				}
				else
					$(this).parent().remove();
			} else
			{
				alert('Debe existir al menos una pareja')
			}
		});

		$(match.container_field_name).html(match.interface_html);

		$(match.container_field_name + ' .random_select').live('click', function() {

			if ($(match.container_field_name + ' input[name="random_select"]').attr('checked'))
			{
				$(match.container_field_name + ' .random_select_max').attr('disabled', false);
			}
			else
			{
				$(match.container_field_name + ' .random_select_max').attr('disabled', true);
			}
		});		

		match.load();
	},
	game_init: function(game_container_field_name, game_finish_url, pass_score, max_score) {
		match.game_container_field_name = game_container_field_name;
		match.game_finish_url = game_finish_url;
		match.pass_score = pass_score;
		match.max_score = max_score;
		function shuffleArray(array) {
		    for (var i = array.length - 1; i > 0; i--) {
		        var j = Math.floor(Math.random() * (i + 1));
		        var temp = array[i];
		        array[i] = array[j];
		        array[j] = temp;
		    }
		    return array;
		}


		function selectShuffleArray(array1, array2) {
		    for (var i = array1.length - 1; i > 0; i--) {
		        var j = Math.floor(Math.random() * (i + 1));
		        var temp = array1[i];
		        array1[i] = array1[j];
		        array1[j] = temp;
		        temp = array2[i];
		        array2[i] = array2[j];
		        array2[j] = temp;
		    }
		}


		var questions = new Array();
		var answers = new Array();

		$.each(match.words, function(index, value) {
			if (match.image_mode)
			{
				questions.push('<div class="test-content-question">' + 
								'<div class="test-content-question-content" data-index="'+index+'"><img src="'+ 
								site_url + 'assets/images/test/' + value.word2 +
								'" /></div>' +
								'<div class="test-content-question-dock test-content-dock">' + 
								'</div>' +
								'<div class="clear"></div>' +
								'</div>');
				answers.push('<div class="test-content-answer test-content-dock">' + 
								'<div class="test-content-answer-portable" data-index="'+index+'"><span>' + 
								value.word1 +
								'</span></div></div>');								
			}
			else
			{
				questions.push('<div class="test-content-question">' + 
								'<div class="test-content-question-content" data-index="'+index+'"><span>' + 
								value.word1 +
								'</span></div>' +
								'<div class="test-content-question-dock test-content-dock">' + 
								'</div>' +
								'<div class="clear"></div>' +
								'</div>');
				answers.push('<div class="test-content-answer test-content-dock">' + 
								'<div class="test-content-answer-portable" data-index="'+index+'"><span>' + 
								value.word2 +
								'</span></div></div>');				
			}
		});


		if (match.is_random_select)
		{
			selectShuffleArray(questions, answers);
			questions = questions.slice(0, match.random_select_max);
			answers = answers.slice(0, match.random_select_max);
		}

		answers = shuffleArray(answers);

		match.game_interface_html	= 
						'<div class="test-content">' +
							'<div class="test-content-questions">' +
							questions.join('') +
							'</div>' +
							'<div class="test-content-answers">' +
							answers.join('') +
							'</div>' +
							'<div class="clear"></div>' +
							'<div class="test-content-buttons">' +
								'<input class="btn-test btn-test-submit" type="submit" value="Enviar" />' +
							'</div>' +
							'<div class="test-result">' +
							'</div>' +
						'</div>';
						
		$(match.game_container_field_name).html(match.game_interface_html);
		$('.test-content-dock').sortable({
			connectWith: '.test-content-dock',
			forcePlaceholderSize: true,
			placeholder: 'portlet-placeholder',
			cursor: 'move',
			opacity: 0.5,
			over: function(event, ui) {
				if ( $(this).children().length == 2 )
					$(ui.placeholder).hide();
				else
					$(ui.placeholder).show();
			},
			receive: function(event, ui) 
			{
	            if ( $(this).children().length > 1 )
	            {
	                $(ui.sender).sortable('cancel');
	            }
        	}
		});

		$(match.game_container_field_name).delegate('.btn-test-submit', 'click', function() {

			if ($('.test-content-question-dock').children().length != $('.test-content-question-content').length)
				return false;
			var results = match.grade();

			$(this).attr('disabled', true);
			$.ajax({
				url: match.game_finish_url,
				data: results,
				dataType: 'json',
				type: 'post',
				success: function(data) {
					$(match.game_container_field_name).undelegate('.btn-test-submit', 'click');
					if (results.passed == 1)
					{
						match.passed_state(data.next_url, data.next_caption);
					}
					else
						match.failed_state();
				}                  
			});
			return false;
		});
		
	},
	grade: function() {
		var grade = 0;
		var passed = 0;
		
		if (match.is_random_select)
			var total = match.random_select_max;
		else
			var total = match.words.length;

		var total_right = 0;
		$('.test-content-question').each(function(index) {
			if ( $(this).find('.test-content-question-content').attr('data-index') == 
				 $(this).find('.test-content-answer-portable').attr('data-index')  )
				total_right++;
		});
				
		grade = Math.round(total_right * match.max_score / total);
		passed =  grade >= match.pass_score ? 1 : 0;
		
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
						
		$(match.game_container_field_name + ' .test-result').html(html);
		$(match.game_container_field_name + ' .test-content-buttons .btn-test-next').click(function() {
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
						
		$(match.game_container_field_name + ' .test-result').html(html);
		$(match.game_container_field_name + ' .test-content-buttons .btn-test-repeat').click(function() {
			location.reload();
		});
	}		
};