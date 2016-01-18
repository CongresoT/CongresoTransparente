<!DOCTYPE html>
<html>
    <head>
    	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" />
        <?php echo $header; ?>
    </head>

    <body>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.5&appId=124428817652699";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<script>
	  (function() {
		var cx = '004190424078857753329:vcvr9-czw7a';
		var gcse = document.createElement('script');
		gcse.type = 'text/javascript';
		gcse.async = true;
		gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
			'//cse.google.com/cse.js?cx=' + cx;
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(gcse, s);
	  })();
		$('input.gsc-input').attr('placeholder', 'Buscar');
		$('input.gsc-search-button').attr('src', '');	  
	</script>	
	<div id="container">
		<?php echo $header_menu; ?>
		<div class="clear"></div>
		<div id="system-messages">
		</div>
		<div id="main-content">

			<?php echo $content; ?>

		</div>
	<?php echo $footer; ?>
	</div>
    </body>
</html>