<div class="congressman-info">
	<div class="congressman-info-container">
		<div class="col-md-12">
			<div class="congressman-photo-container">
				<img class="congressman-photo" src="<?php echo site_url('assets/images/congressman/' . $congressman->photo); ?>" alt="<?php echo htmlspecialchars($congressman->last_names . ' ,' . $congressman->names, ENT_QUOTES); ?>" />
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
			</div>
		</div>
		<div class="col-md-12 congressman-description">
			<?php echo $congressman->description; ?>
		</div>
		<div class="clear"></div>
	</div>
</div>