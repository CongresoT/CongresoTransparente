<div class="main-container">	
	<?php echo $law_info; ?>
	<div class="law-timeline">
		<div class="col-md-6 title-container">
			<div class="section-title">
				<img src="<?php echo site_url('assets/images/title-timeline.png'); ?>" alt="Votaciones" />
			</div>	
		</div>
		<div class="col-md-6 back-container">
			<a href="<?php echo site_url('actividad_legislativa/' . $law_id); ?>"><img src="<?php echo site_url('assets/images/btn-back.png'); ?>" alt="Regresar" /></a>
		</div>
		<div class="law-timeline">
			<table id="law-timeline-list">
				<thead>
					<th>Estado</th>
					<th>Fecha</th>
					<th>Descripción</th>
				</thead>
				<tbody>
				<?php if ($timeline_list): ?>
					<?php foreach ($timeline_list as $element): ?>
					<tr class="law-timeline-row">
						<td><?php echo $element->name; ?></td>
						<td><?php echo $element->date; ?></td>
						<td><?php echo $element->description; ?></td>
					</tr>
					<?php endforeach; ?>
				<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="fb-comments" data-href="<?php echo site_url('actividad_legislativa/' . $law_id); ?>">" data-numposts="5"></div>
</div>