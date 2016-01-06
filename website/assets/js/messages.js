$(document).ready(function() {
	// Client
	$("#message-form-client input[name=company]").on('input', function() {
		$("#message-form-client input[name=company_id]").val('');
	});	

	$("#message-form-client input[name=company]").autocomplete({
		source: site_url + 'listado_empresas_json', minLength: 2,
		select:function(evt, ui)
		{
			$("#message-form-client input[name=company_id]").val(ui.item.id);
			$("#message-form-client input[name=company]").val(ui.item.label);
		}
	});
	
	$(".message-form-close").click(function() {
		close_message_form_client();
	});

	$("#message-form-client").submit(function(event) {
		var company_id = $("#message-form-client input[name=company_id]").val()
		var message = $("#message-form-client textarea[name=message]").val()
		if (message != "" && company_id != "")
		{
			send_message_from_client(company_id, message, false);
			close_message_form_client();
			$("#message-form-client input[name=company_id]").val("");
			$("#message-form-client textarea[name=message]").val("");
		} else
		{
			var errors = "";
			if (company_id == "")
				errors = errors + "Debe seleccionar una empresa \n";
			
			if (message == "")
				errors = errors + "Debe escribir un mensaje \n";
				
			alert(errors)
			
		}
		event.preventDefault();
	});	
	
	// Company
	$("#message-form-company input[name=company]").on('input', function() {
		$("#message-form-company input[name=client_id]").val('');
	});	

	$("#message-form-company input[name=client]").autocomplete({
		source: site_url + 'empresa/listado_clientes_json', minLength: 2,
		select:function(evt, ui)
		{
			$("#message-form-company input[name=client_id]").val(ui.item.id);
			$("#message-form-company input[name=client]").val(ui.item.label);
		}
	});
	
	$(".message-form-close").click(function() {
		close_message_form_company();
	});

	$("#message-form-company").submit(function(event) {
		var client_id = $("#message-form-company input[name=client_id]").val()
		var message = $("#message-form-company textarea[name=message]").val()
		if (message != "" && client_id != "")
		{
			send_message_from_company(client_id, message, false);
			close_message_form_company();
			$("#message-form-company input[name=client_id]").val("");
			$("#message-form-company textarea[name=message]").val("");
		} else
		{
			var errors = "";
			if (client_id == "")
				errors = errors + "Debe seleccionar un cliente \n";
			
			if (message == "")
				errors = errors + "Debe escribir un mensaje \n";
				
			alert(errors)
			
		}
		event.preventDefault();
	});	
});

// Client

function message_form_client(company, id) {
	if (id !== undefined && id != 0)
	{
		$("#message-form-client input[name=company]").val(company);
		$("#message-form-client input[name=company_id]").val(id);
		$("#message-form-client input[name=company]").attr("disabled", true);
	}
	
	var pos_x = ($(window).width() - $(".message-form-container").width()) / 2;
	var pos_y = ($(window).height() - $(".message-form-container").height()) / 2;
	$(".popup-background").fadeIn("fast").css('height', $(document).height() + 'px');
	$(".message-form-container").fadeIn("fast").css('left', pos_x + 'px').css('top', pos_y + 'px').css('position', 'fixed');
}

function close_message_form_client() {
	$(".popup-background").fadeOut("fast");
	$(".message-form-container").fadeOut("fast");
}

function send_message_from_client(company_id, message, append) {
	$.ajax({
	  url: site_url + 'enviar_mensaje/' + company_id,
	  dataType: "json",
	  data: {message: message},
	  type: "POST",
	  context: document.body
	}).done(function(data) {
		if (data.success)
		{
			var html = '<div class="messages-chat-element">';
			html = html + '<div class="chat-title"><strong>' + data.last_message.client_name + ':</strong> ' + data.last_message.message + '</div><div class="chat-date">' + data.last_message.creation_date + '</div>';
			html = html + '</div>';

			if (append)
			{
				$("#messages-chat").append(html);
				$("#messages-chat").stop().animate({scrollTop: $("#messages-chat")[0].scrollHeight}, 800);
				$("#messages-chat .messages-chat-element:last-child").effect("highlight", {color: "#DCDCDC"}, 3000);				
			}
		}
	});
}

// Company

function message_form_company(client, id) {
	if (id !== undefined && id != 0)
	{
		$("#message-form-company input[name=client]").val(client);
		$("#message-form-company input[name=client_id]").val(id);
		$("#message-form-company input[name=client]").attr("disabled", true);
	}
	
	var pos_x = ($(window).width() - $(".message-form-container").width()) / 2;
	var pos_y = ($(window).height() - $(".message-form-container").height()) / 2;
	$(".popup-background").fadeIn("fast").css('height', $(document).height() + 'px');
	$(".message-form-container").fadeIn("fast").css('left', pos_x + 'px').css('top', pos_y + 'px').css('position', 'fixed');
}

function close_message_form_company() {
	$(".popup-background").fadeOut("fast");
	$(".message-form-container").fadeOut("fast");
}

function send_message_from_company(client_id, message, append) {
	$.ajax({
	  url: site_url + 'empresa/enviar_mensaje/' + client_id,
	  dataType: "json",
	  data: {message: message},
	  type: "POST",
	  context: document.body
	}).done(function(data) {
		if (data.success)
		{
			var html = '<div class="messages-chat-element">';
			html = html + '<div class="chat-title"><strong>' + data.last_message.commercial_name + ':</strong> ' + data.last_message.message + '</div><div class="chat-date">' + data.last_message.creation_date + '</div>';
			html = html + '</div>';

			if (append)
			{
				$("#messages-chat").append(html);
				$("#messages-chat").stop().animate({scrollTop: $("#messages-chat")[0].scrollHeight}, 800);
				$("#messages-chat .messages-chat-element:last-child").effect("highlight", {color: "#DCDCDC"}, 3000);				
			}
		}
	});
}