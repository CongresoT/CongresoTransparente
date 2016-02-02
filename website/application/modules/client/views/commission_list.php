<div class="main-container">	
	<div class="section-title">
		<img src="<?php echo site_url('assets/images/title-comissions.png'); ?>" alt="Comisiones" />
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
						<th>Nombre</th>
						<th>Año</th>
					</tr>
				</thead>
				<tbody>
				<?php if ($list): ?>
					<?php foreach ($list as $element): ?>
					<tr commission-id="<?php echo $element->comission_id; ?>" class="commission-row">
						<td><?php echo $element->name; ?></td>
						<td><?php echo date('Y', strtotime($element->date)); ?></td>
					</tr>
					<?php endforeach; ?>
				<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>	
</div>