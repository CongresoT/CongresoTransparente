    <link rel="shortcut icon" href="<?php echo site_url('assets/icons/favicon.ico'); ?>" />
    <meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset'); ?>" />
    <title><?php echo $title; ?></title>
    <?php foreach ($meta as $key => $value) : ?>
    <meta name="<?php echo $key; ?>" content="<?php echo $value; ?>"/>
    <?php endforeach; ?>
	<meta property="og:title" content="<?php echo $title; ?>"/>
	<meta property="og:site_name" content="<?php echo $title; ?>"/>
	<meta property="og:description" content="<?php echo $meta['description']; ?>"/>
    <?php foreach ($css_urls as $url) : ?>
	<?php if (strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0) : ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $url; ?>" />
        <?php else : ?>	
	<link type="text/css" rel="stylesheet" href="<?php echo site_url("assets/css/$url.css"); ?>" />
		<?php endif; ?>
    <?php endforeach; ?>
    <?php if (count($css_scripts) > 0) : ?>
    <style type="text/css">
    <?php echo implode(PHP_EOL, $css_scripts); ?>
    </style>
    <?php endif; ?>
    <?php foreach ($js_urls as $url) : ?>
        <?php if (strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0) : ?>
    <script src="<?php echo $url; ?>" type="text/javascript" defer="defer"></script>
        <?php else : ?>
    <script src="<?php echo site_url("assets/js/$url.js"); ?>" type="text/javascript"></script>
        <?php endif; ?>
    <?php endforeach; ?>
    <?php if (count($js_scripts) > 0) : ?>
    <script type="text/javascript">
    <?php echo implode(PHP_EOL, $js_scripts); ?>
    </script>
    <?php endif; ?>
    <?php if (isset($js_startup) && count($js_startup) > 0) : ?>
    <script type="text/javascript">
        $(document).ready(function() {
            <?php echo implode(PHP_EOL, $js_startup); ?>
        });
    </script>
    <?php endif; ?>
    <?php if (isset($theme) && !empty($theme)) : ?>
    <link type="text/css" rel="stylesheet" href="<?php echo site_url("assets/css/themes/$theme/theme.css"); ?>"/>
    <?php endif; ?>