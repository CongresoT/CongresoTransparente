<div class="main-container">	
	<?php echo $congressman_info; ?>
	<div class="congressman-commissions">
		<div class="col-md-6 title-container">
			<div class="section-title">
				<img src="<?php echo site_url('assets/images/title-comissions.png'); ?>" alt="Comisiones" />
			</div>	
		</div>
		<div class="col-md-6 back-container">
			<a href="<?php echo site_url('diputado/' . $congressman_id); ?>"><img src="<?php echo site_url('assets/images/btn-back.png'); ?>" alt="Regresar" /></a>
		</div>
		<div class="congressman-commissions">
			<table id="congressman-commissions-list">
				<thead>
					<tr>
						<th>Comisión</th>
						<th>Puesto</th>
						<th>Fecha</th>
					</tr>
				</thead>
				<tbody>
				<?php if ($commissions_list): ?>
					<?php foreach ($commissions_list as $element): ?>
					<tr class="congressman-commission-row">
						<td><?php echo $element->name; ?></td>
						<td><?php echo $element->position; ?></td>
						<td><?php echo date( 'd/m/Y', strtotime($element->date)); ?></td>
					</tr>
					<?php endforeach; ?>
				<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="fb-comments" data-href="<?php echo site_url('diputado/' . $congressman_id); ?>">" data-numposts="5"></div>
</div>