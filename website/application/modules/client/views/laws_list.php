<div class="main-container">	
	<div class="section-title">
		<img src="<?php echo site_url('assets/images/title-laws.png'); ?>" alt="Actividades legislativas" />
	</div>
	<div class="law-list">
		<div class="search-form">
			<?php echo form_open('', array('method' => 'post', 
			'id' => 'frmSearch')); ?>
			<div class="col-md-4 search">
				<h3 class="sub-title">&nbsp;</h3>
				<?php echo form_input(array('name' => 'searchquery', 
				'id' => 'searchquery',
				'value' => $searchquery,
				'placeholder' => 'BUSCAR')); ?><input type="image" src="<?php echo site_url('assets/images/btn-search.png'); ?>" class="btn-search" />
			</div>
			<div class="col-md-3 law_type">
				<h3 class="sub-title">Tipo</h3>
				<?php echo form_dropdown('law_type_id', $law_type_options, $law_type_id, 'id="law_type_id"'); ?>
			</div>
			<div class="col-md-3 commission">
				<h3 class="sub-title">Comisión</h3>
				<?php echo form_dropdown('commission_id', $commission_options, $commission_id, 'id="commission_id"'); ?>
			</div>
			<div class="col-md-2 law_status">
				<h3 class="sub-title">Estado</h3>
				<?php echo form_dropdown('law_status_id', $law_status_options, $law_status_id, 'id="law_status_id"'); ?>
			</div>
			<?php echo form_close(); ?>
		</div>
		<div class="list">
			<table id="law-list">
				<thead>
					<tr>
						<th>Número</th>
						<th>Nombre</th>
						<th>Fecha presentación</th>
						<th>Estado</th>
						<th>Comisón</th>
					</tr>
				</thead>
				<tbody>
				<?php if ($list): ?>
					<?php foreach ($list as $element): ?>
					<tr law-id="<?php echo $element->law_id; ?>" class="law-row">
						<td><?php echo $element->number; ?></td>
						<td><?php echo $element->name; ?></td>
						<td><?php echo $element->presentation_date; ?></td>
						<td><?php echo $element->law_status; ?></td>
						<td><?php echo $element->commission; ?></td>
					</tr>
					<?php endforeach; ?>
				<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>	
</div>