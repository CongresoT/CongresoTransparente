$(document).ready(function() {
	$("#header-img-user").click(function() {
		$("#header-user-info").toggle('slow');
	});
	
	$('#header-img-user').bind('click', function(e){return false});
});

$(document).bind({
    keydown:function(e) {
        if (e.keyCode == 27 ) {
            $("#header-user-info").hide("3000");
        }
    }, click: function(e) {
        $("#header-user-info").hide("3000");
    }
});

function showAlert(b)
{	var a=$("<div/>").html(b).text();
	alert(a);
}

var SYS_MSG_STYLE_SUCCESS = 1;
var SYS_MSG_STYLE_WARNING = 2;
var SYS_MSG_STYLE_ERROR = 3;
var SYS_MSG_STYLE_INFO = 0;

function showSystemMessage(msg, type)
{
    class_type = '';
    switch(type)
    {
        case SYS_MSG_STYLE_SUCCESS:
            class_type = 'alert alert-success';
            break;
        case SYS_MSG_STYLE_WARNING:
            class_type = 'alert alert-warning';
            break;
        case SYS_MSG_STYLE_ERROR:
            class_type = 'alert alert-danger';
            break;
        case SYS_MSG_STYLE_INFO:
        default:
            class_type = 'alert alert-info';
    }
    a=$('<div/>').addClass(class_type).html(msg);
    $('#system-messages').html('');
    $('#system-messages').append(a).show();
}



