<div class="main-container">	
	<?php echo $congressman_info; ?>
	<div class="congressman-menu">
		<a href="<?php echo site_url('diputado/votaciones/' . $congressman_id); ?>"><img src="<?php echo site_url('assets/images/btn-congressman-votes.png'); ?>" class="btn-menu" alt="Votaciones" /></a>
		<a href="<?php echo site_url('diputado/asistencia/' . $congressman_id); ?>"><img src="<?php echo site_url('assets/images/btn-congressman-assitance.png'); ?>" class="btn-menu" alt="Asistencia" /></a>
		<a href="<?php echo site_url('diputado/bancadas/' . $congressman_id); ?>"><img src="<?php echo site_url('assets/images/btn-congressman-parties.png'); ?>" class="btn-menu" alt="Bancadas" /></a>
		<a href="<?php echo site_url('diputado/leyes_presentadas/' . $congressman_id); ?>"><img src="<?php echo site_url('assets/images/btn-congressman-laws.png'); ?>" class="btn-menu" alt="Leyes presentadas" /></a>
		<a href="<?php echo site_url('diputado/citaciones/' . $congressman_id); ?>"><img src="<?php echo site_url('assets/images/btn-congressman-citations.png'); ?>" class="btn-menu" alt="Citaciones" /></a>
		<a href="<?php echo site_url('diputado/comisiones/' . $congressman_id); ?>"><img src="<?php echo site_url('assets/images/btn-congressman-comissions.png'); ?>" class="btn-menu" alt="Comisiones" /></a>
		<a href="<?php echo site_url('diputado/cv/' . $congressman_id); ?>"><img src="<?php echo site_url('assets/images/btn-congressman-cv.png'); ?>" class="btn-menu" alt="CV" /></a>
	</div>
	<div class="fb-comments" data-href="<?php echo site_url('diputado/' . $congressman_id); ?>">" data-numposts="5"></div>
</div>