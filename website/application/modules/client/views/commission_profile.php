<div class="main-container">	
	<div class="section-title">
		<img src="<?php echo site_url('assets/images/title-comissions.png'); ?>" alt="Comisiones" />
		<h3><?php echo $commission->name; ?></h3>
	</div>
	<div class="commission-list">
		<div class="search-form">
			<?php echo form_open('', array('method' => 'post', 
			'id' => 'frmSearch')); ?>
			<div class="col-md-8 search">
				<h3 class="sub-title">&nbsp;</h3>
				<?php echo form_input(array('name' => 'searchquery', 
				'id' => 'searchquery',
				'value' => $searchquery,
				'placeholder' => 'BUSCAR')); ?><input type="image" src="<?php echo site_url('assets/images/btn-search.png'); ?>" class="btn-search" />
			</div>
			<?php echo form_close(); ?>
		</div>
		<div class="list">
			<table id="commission-list">
				<thead>
					<tr>
						<th>#</th>
						<th>Diputado</th>
						<th>Partido Político</th>
						<th>Puesto</th>
					</tr>
				</thead>
				<tbody>
				<?php if ($list): ?>
					<?php foreach ($list as $element): ?>
					<tr congressman-id="<?php echo $element->congressman_id; ?>" class="commission-row">
						<td><?php echo $element->order; ?></td>
						<td><?php echo $element->names . ' ' . $element->last_names; ?></td>
						<td><?php echo $element->political_party; ?></td>
						<td><?php echo $element->position; ?></td>
					</tr>
					<?php endforeach; ?>
				<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>	
</div>