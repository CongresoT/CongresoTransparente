var click_map = {
	click_state: 0,
	x1: 0, 
	y1: 0,
	x2: 0,
	y2: 0,
	drawRectangle: function(mapareaid) {
		$(mapareaid).css('left', Math.min(click_map.x1, click_map.x2) + 'px')
		.css('top', Math.min(click_map.y1, click_map.y2) + 'px')
		.css('width', Math.abs(click_map.x1 - click_map.x2) + 'px')
		.css('height', Math.abs(click_map.y1 - click_map.y2) + 'px')
		.css('border-radius', '0px');	
	},
	drawCircle: function(mapareaid, radius) {
		$(mapareaid).css('left', click_map.x1 - radius + 'px')
		.css('top', click_map.y1 - radius + 'px')
		.css('width', 2 * radius + 'px')
		.css('height', 2 * radius  + 'px')
		.css('border-radius', '1000px');	
	},
	init: function(map, fieldx1, fieldy1, fieldx2, fieldy2, fieldradius, fieldselect, mapareaid, imageselectid, imagegeturl) {
		click_map.x1		= $(fieldx1).find('input').val();
		click_map.y1		= $(fieldy1).find('input').val();
		click_map.x2		= $(fieldx2).find('input').val();
		click_map.y2		= $(fieldy2).find('input').val();
		click_map.radius	= $(fieldradius).find('input').val();
		
		$(fieldselect).change(function() {
			var type = $(this).find('input[name="map-type"]:checked').val();
			if (type == 1)
			{
				$(fieldx1).show();
				$(fieldy1).show();
				$(fieldx2).parent().show();
				$(fieldx2).show();
				$(fieldy2).show();
				$(fieldradius).hide();
				
				if (click_map.click_state == 0) {
					$(fieldx2).find('input').val(click_map.x2);
					$(fieldy2).find('input').val(click_map.y2);
					$(fieldradius).find('input').val(0);
		
					click_map.drawRectangle(mapareaid);
				}				
				
			} else if (type == 2)
			{
				$(fieldx1).show();
				$(fieldy1).show();
				$(fieldx2).parent().hide();
				$(fieldx2).hide();
				$(fieldy2).hide();
				$(fieldradius).show();
				
				if (click_map.click_state == 0) {
					var radius = Math.round(Math.sqrt(Math.pow(click_map.x2 - click_map.x1, 2) + Math.pow(click_map.y2 - click_map.y1, 2)));
					$(fieldx2).find('input').val(click_map.x2);
					$(fieldy2).find('input').val(click_map.y2);
					$(fieldradius).find('input').val(radius);

					click_map.drawCircle(mapareaid, radius);
				}
			}
		});
		$(fieldselect).trigger("change");
		
		$(fieldx1 + ',' + fieldy1 + ',' + fieldx2 + ',' + fieldy2 + ',' + fieldradius).on("keypress keyup blur",function (event) {
			$(this).val($(this).val().replace(/[^0-9]/g,''));
            if ((event.which != 46) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
			click_map.x1 = $(fieldx1).find('input').val();
			click_map.x2 = $(fieldx2).find('input').val();
			click_map.y1 = $(fieldy1).find('input').val();
			click_map.y2 = $(fieldy2).find('input').val();
			var type = $(fieldselect).find('input[name="map-type"]:checked').val();
			if (type == 1)
			{
				click_map.drawRectangle(mapareaid);
			} else if (type == 2)
			{
				click_map.x1 = $(fieldx1).find('input').val();
				click_map.x2 = $(fieldx2).find('input').val();
				var radius = $(fieldradius).find('input').val();
				click_map.drawCircle(mapareaid, radius);
			}			
        });
		
		$(imageselectid).change(function() {
			$.ajax({
				type: "POST",
				dataType: "json",
				url: imagegeturl + '/' + $(this).val(),
				success: function(data, textStatus, jq)
				{
					if (data.success)
					{
						$(map).attr('src', data.data.image);
						$(map).attr('alt', data.data.name);
					}
				}
			})
		});

		$(map).click(function(e) {
			if (click_map.click_state == 0) {
				click_map.x1 = Math.round(e.pageX - $(this).offset().left);
				click_map.y1 = Math.round(e.pageY - $(this).offset().top);
				$(fieldx1).find('input').val(click_map.x1);
				$(fieldy1).find('input').val(click_map.y1);

				click_map.x2 = 0;
				click_map.y2 = 0;
				click_map.radius = 0;
				$(fieldx2).find('input').val("");
				$(fieldy2).find('input').val("");
				$(fieldradius).find('input').val("");
				
				click_map.click_state = 1 - click_map.click_state;
			} else if (click_map.click_state == 1) {
				click_map.x2 = Math.round(e.pageX - $(this).offset().left);
				click_map.y2 = Math.round(e.pageY - $(this).offset().top);
				var type = $(fieldselect).find('input[name="map-type"]:checked').val();
				if (type == 1)
				{
					$(fieldx2).find('input').val(click_map.x2);
					$(fieldy2).find('input').val(click_map.y2);
					$(fieldradius).find('input').val(0);

					click_map.drawRectangle(mapareaid);
				} else if (type == 2)
				{
					var radius = Math.round(Math.sqrt(Math.pow(click_map.x2 - click_map.x1, 2) + Math.pow(click_map.y2 - click_map.y1, 2)));
					$(fieldx2).find('input').val(click_map.x2);
					$(fieldy2).find('input').val(click_map.y2);
					$(fieldradius).find('input').val(radius);

					click_map.drawCircle(mapareaid, radius);
				}
				click_map.click_state = 1 - click_map.click_state;
			}
		});
	}
};