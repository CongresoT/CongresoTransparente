<div class="main-container">	
	<?php echo $law_info; ?>
	<div class="law-status-line">
		<?php foreach($law_status_list as $option): ?>
			<div class="law-status-line-element">
				<span class="image"><img src="<?php echo site_url('assets/images/' . ($option->law_status_id == $law_status_id ? 'timeline-active.png' : 'timeline-inactive.png'));?>" alt="<?php echo $option->name;?>" /></span>
				<span class="text"><?php echo $option->name;?></span>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="law-menu">
		<a href="<?php echo site_url('actividad_legislativa/votaciones/' . $law_id); ?>"><img src="<?php echo site_url('assets/images/btn-law-votes.png'); ?>" class="btn-menu" alt="Votaciones" /></a>
		<a href="<?php echo site_url('actividad_legislativa/dictamenes/' . $law_id); ?>"><img src="<?php echo site_url('assets/images/btn-rulings.png'); ?>" class="btn-menu" alt="Dictámenes" /></a>
		<a href="<?php echo site_url('actividad_legislativa/historial/' . $law_id); ?>"><img src="<?php echo site_url('assets/images/btn-timeline.png'); ?>" class="btn-menu" alt="Historial" /></a>
	</div>
	<div class="fb-comments" data-href="<?php echo site_url('actividad_legislativa/' . $law_id); ?>">" data-numposts="5"></div>
</div>