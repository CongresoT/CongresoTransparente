<div class="main-container">	
	<?php echo $congressman_info; ?>
	<div class="congressman-citations">
		<div class="col-md-6 title-container">
			<div class="section-title">
				<img src="<?php echo site_url('assets/images/title-citations.png'); ?>" alt="Citaciones" />
			</div>	
		</div>
		<div class="col-md-6 back-container">
			<a href="<?php echo site_url('diputado/' . $congressman_id); ?>"><img src="<?php echo site_url('assets/images/btn-back.png'); ?>" alt="Regresar" /></a>
		</div>
		<div class="congressman-citations">
			<table id="congressman-citations-list">
				<thead>
					<tr>
						<th>Asunto</th>
						<th>Archivos</th>
					</tr>
				</thead>			
				<tbody>
				<?php if ($citations_list): ?>
					<?php foreach ($citations_list as $element): ?>
					<tr class="congressman-citation-row">
						<td><?php echo $element->subject; ?></td>
						<td>
						<?php if ($element->attachment): ?>
						<a href="<?php echo site_url('assets/uploads/citation/' . $element->attachment); ?>" target="_blank"><img src="<?php echo site_url('assets/images/icon-pdf.png'); ?>" alt="Adjunto" /></a>
						<?php endif; ?>
						<?php if ($element->audio): ?>
						<a href="<?php echo site_url('assets/uploads/citation/' . $element->audio); ?>" target="_blank"><img src="<?php echo site_url('assets/images/icon-audio.png'); ?>" alt="Audio" /></a>
						<?php endif; ?>
						</td>
					</tr>
					<?php endforeach; ?>
				<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="fb-comments" data-href="<?php echo site_url('diputado/' . $congressman_id); ?>">" data-numposts="5"></div>
</div>