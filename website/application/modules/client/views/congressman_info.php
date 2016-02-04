<div class="congressman-info">
	<div class="congressman-info-container">
		<div class="col-md-12">
			<div class="congressman-photo-container">
				<?php if ($congressman->photo): ?>
				<img class="congressman-photo" src="<?php echo site_url('assets/images/congressman/' . $congressman->photo); ?>" alt="<?php echo htmlspecialchars($congressman->last_names . ' ,' . $congressman->names, ENT_QUOTES); ?>" />
				<?php else: ?>
					<?php if ($congressman->sex_id == SEX_ID_FEMALE): ?>
					<img class="congressman-photo" src="<?php echo site_url('assets/images/congressman-female.png'); ?>" alt="<?php echo htmlspecialchars($congressman->last_names . ' ,' . $congressman->names, ENT_QUOTES); ?>" />
					<?php else: ?>
					<img class="congressman-photo" src="<?php echo site_url('assets/images/congressman-male.png'); ?>" alt="<?php echo htmlspecialchars($congressman->last_names . ' ,' . $congressman->names, ENT_QUOTES); ?>" />
					<?php endif; ?>
				<?php endif; ?>
				<?php if ($congressman->logo): ?>
					<img class="congressman-party-logo" src="<?php echo site_url('assets/images/political_party/thumbnail/' . $congressman->logo); ?>" alt="<?php echo htmlspecialchars($congressman->party_name, ENT_QUOTES); ?>" />
				<?php endif; ?>
			</div>
			<div class="congressman-info-container">
				<span class="label-fullname"><?php echo $congressman->last_names; ?>, <?php echo $congressman->names; ?></span>
				<p></p>
				<span class="congressman-label">Bancada: </span><span class="congressman-value"><?php echo $congressman->party_name; ?></span>
				<br/>
				<span class="congressman-label">Distrito: </span><span class="congressman-value"><?php echo $congressman->district_name; ?></span>
				<br/>
				<span class="congressman-label">Edad: </span><span class="congressman-value"><?php echo $congressman->age; ?></span>
				<br/>
				<span class="congressman-label">No. de legislaturas: </span><span class="congressman-value"><?php echo $congressman->periods; ?></span>
				<?php if ($congressman->facebook_account || $congressman->twitter_account): ?>
				<br/>
				<span class="congressman-label">Redes sociales: </span>
				<br/>
				<span class="congressman-value">
				<?php endif; ?>
				<?php if ($congressman->facebook_account): ?>
					<a href="<?php echo $congressman->facebook_account; ?>" target="_blank"><img class="social-button" src="<?php echo site_url('assets/images/btn-sn-facebook.png'); ?>" alt="Cuenta de Facebook" /></a>
				<?php endif; ?>
				<?php if ($congressman->twitter_account): ?>
					<a href="<?php echo $congressman->twitter_account; ?>" target="_blank"><img class="social-button" src="<?php echo site_url('assets/images/btn-sn-twitter.png'); ?>" alt="Cuenta de Twitter" /></a>				
				<?php endif; ?>
				<?php if ($congressman->facebook_account || $congressman->twitter_account): ?>
				</span>
				<?php endif; ?>				
				<br/>
			</div>
		</div>
		<div class="col-md-12 congressman-description">
			<?php echo $congressman->description; ?>
		</div>
		<div class="clear"></div>
	</div>
</div>