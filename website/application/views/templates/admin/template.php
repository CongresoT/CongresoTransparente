<!DOCTYPE html>
<html>
    <head>
    	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" />
        <?php echo $header; ?>
    </head>
    <body>
		<div id="header">
			<?php echo $header_menu; ?>
		</div>
		<div id="header-space">
		</div>
		<div id="header-logo">
			<a href="<?php echo site_url('admin'); ?>"><img src="<?php echo site_url('/assets/images/admin/logo-small.png'); ?>" id="header-img-logo" alt="Freequent" border="0" /></a>
			<h1 id="header-title"><?php echo $data_parts['title']; ?></h1>
			<?php if ($data_parts['is_authenticated'] && $data_parts['usertype'] == USER_TYPE_ADMIN): ?>
			<div id="header-user">
				<img src="<?php echo site_url('assets/images/admin/users/' . preg_replace('/(.*)(\.[\w\d]{3})/', '$1_thumb$2', $data_parts['userinfo']->photo)); ?>" id="header-img-user" alt="Usuario" border="0">
				<div id="header-user-info">
					<img src="<?php echo site_url('assets/images/admin/users/' . preg_replace('/(.*)(\.[\w\d]{3})/', '$1_small$2', $data_parts['userinfo']->photo)); ?>" id="menu-img-user" alt="Usuario" border="0">
					<div id="user-info-container">
						<div id="user-info-name" class="header-user-info-data"><?php echo $data_parts['userinfo']->name . ' ' . $data_parts['userinfo']->last_name; ?></div>
						<div id="user-info-username" class="header-user-info-data">Administrador</div>
						<div id="user-info-email" class="header-user-info-data"><?php echo $data_parts['userinfo']->email; ?></div>
					</div>
					<div style="clear: both"></div>
					<div id="header-user-options">
						<a href="<?php echo site_url('admin/user_profile/index/edit/' . $data_parts['userinfo']->admin_id); ?>">
						<button type="button" class="btn btn-default" id="btn-update-data">
							<i class="icon-user"></i> Actualizar datos
						</button>
						</a>
						<a href="<?php echo site_url('admin/logout'); ?>">
						<button type="button" class="btn btn-default" id="btn-log-off">
							<i class="icon-off"></i> Cerrar sesión
						</button>
						</a>
					</div>
				</div>
			</div>
			<?php endif; ?>
		</div>	
		<div class="main-container">
			<?php if ($browser_warning): ?>
			<div id="header-browser-warning">
				<div class="warning-image"><img src="<?php echo site_url('assets/images/warning.png'); ?>" alt="Advertencia" /></div><div class="warning-text"><h3><?php echo lang('warning_browser_title'); ?></h3><?php echo $browser_mesage; ?></div>
				<div class="warning-browsers">
					<a href="https://www.google.com/intl/es/chrome/browser/?hl=es" target="_blank"><img class="warning-browser-image" src="<?php echo site_url('assets/images/chrome.png'); ?>" alt="Chrome" border="0" /></a>
					<a href="http://www.mozilla.org/es-ES/firefox" target="_blank"><img class="warning-browser-image" src="<?php echo site_url('assets/images/firefox.png'); ?>" alt="Firefox" border="0" /></a>
					<a href="http://windows.microsoft.com/es-ES/internet-explorer/download-ie" target="_blank"><img class="warning-browser-image" src="<?php echo site_url('assets/images/ie.png'); ?>" alt="Internet Explorer" border="0" /></a>
					<a href="http://www.opera.com/download/" target="_blank"><img class="warning-browser-image" src="<?php echo site_url('assets/images/opera.png'); ?>" alt="Opera" border="0" /></a>
					<a href="http://www.apple.com/safari/" target="_blank"><img class="warning-browser-image" src="<?php echo site_url('assets/images/safari.png'); ?>" alt="Safari" border="0" /></a>
				</div>
			</div>
			<?php endif; ?>
			<div id="system-messages">
				<?php echo isset($system_messages)?$system_messages:''; ?>
			</div>
			<div>
				<?php echo $content; ?>
			</div>
		</div>
		<div class="footer-push">
		</div>
        </div>
		<div id="footer">
			<?php echo $footer; ?>
		</div>
		<?php if (count($js_bottom) > 0) : ?>
		<script type="text/javascript">
		<?php echo implode(PHP_EOL, $js_bottom); ?>
		</script>
		<?php endif; ?>		
		<div id="debuginfo"></div>
    </div>
    </body>
</html>