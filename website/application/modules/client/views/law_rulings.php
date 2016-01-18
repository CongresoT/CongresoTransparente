<div class="main-container">	
	<?php echo $law_info; ?>
	<div class="law-rulings">
		<div class="col-md-6 title-container">
			<div class="section-title">
				<img src="<?php echo site_url('assets/images/title-rulings.png'); ?>" alt="Votaciones" />
			</div>	
		</div>
		<div class="col-md-6 back-container">
			<a href="<?php echo site_url('actividad_legislativa/' . $law_id); ?>"><img src="<?php echo site_url('assets/images/btn-back.png'); ?>" alt="Regresar" /></a>
		</div>
		<div class="law-rulings">
			<table id="law-rulings-list">
				<thead>
					<th>Comisión</th>
					<th>Fecha</th>
					<th>Dictamen</th>
				</thead>
				<tbody>
				<?php if ($ruling_list): ?>
					<?php foreach ($ruling_list as $element): ?>
					<tr class="law-ruling-row">
						<td><?php echo $element->names; ?></td>
						<td><?php echo $element->creation_date; ?></td>
						<td><?php echo $element->result; ?></td>
					</tr>
					<?php endforeach; ?>
				<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="fb-comments" data-href="<?php echo site_url('actividad_legislativa/' . $law_id); ?>">" data-numposts="5"></div>
</div>