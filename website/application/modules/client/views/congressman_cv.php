<div class="main-container">	
	<?php echo $congressman_info; ?>
	<div class="congressman-cv">
		<div class="col-md-6 title-container">
			<div class="section-title">
				<img src="<?php echo site_url('assets/images/title-cv.png'); ?>" alt="CV" />
			</div>	
		</div>
		<div class="col-md-6 back-container">
			<a href="<?php echo site_url('diputado/' . $congressman_id); ?>"><img src="<?php echo site_url('assets/images/btn-back.png'); ?>" alt="Regresar" /></a>
		</div>
		<div class="congressman-cv-container">
		<?php if ($congressman->curriculum): ?>		
			<iframe src="<?php echo site_url('assets/congressman/' . $congressman->curriculum); ?>" />
		<?php else: ?>
			Este diputado aún no ha subido su CV.
		<?php endif; ?>			
		</div>
	</div>
	<div class="fb-comments" data-href="<?php echo site_url('diputado/' . $congressman_id); ?>">" data-numposts="5"></div>
</div>