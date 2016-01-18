<div class="main-container">	
	<?php echo $congressman_info; ?>
	<div class="congressman-attendance">
		<div class="col-md-6 title-container">
			<div class="section-title">
				<img src="<?php echo site_url('assets/images/title-attendance.png'); ?>" alt="Asistencia" />
			</div>	
		</div>
		<div class="col-md-6 back-container">
			<a href="<?php echo site_url('diputado/' . $congressman_id); ?>"><img src="<?php echo site_url('assets/images/btn-back.png'); ?>" alt="Regresar" /></a>
		</div>
		<div class="congressman-attendance-report">
			<div id="graph-container">
			</div>
			<div class="congressman-attendance-total-container">
			<?php foreach ($attendance_list as $element): ?>
				<div class="congressman-attendance-total" style="color: #<?php echo $element->color; ?>; border-color: #<?php echo $element->color; ?>">
					<div class="congressman-attendance-total-content">
						<span class="value"><?php echo round($element->total * 100 / ($total> 0 ? $total : 1)) . '%'; ?></span><br/><span class="text"><?php echo $element->name; ?></span>
					</div>
				</div>
			<?php endforeach; ?>
			</div>
		</div>
	</div>
	<div class="fb-comments" data-href="<?php echo site_url('diputado/' . $congressman_id); ?>">" data-numposts="5"></div>
</div>