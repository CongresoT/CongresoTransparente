<div class="main-container">	
	<div class="section-title">
		<img src="<?php echo site_url('assets/images/title-congressman.png'); ?>" alt="Diputados" />
	</div>
	<div class="congressman-list">
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
			<div class="col-md-4 district">
				<h3 class="sub-title">Distrito</h3>
				<?php echo form_dropdown('district_id', $district_options, $district_id, 'id="district_id"'); ?>
			</div>
			<div class="col-md-4 political-party">
				<h3 class="sub-title">Bancada</h3>
				<?php echo form_dropdown('political_party_id', $political_party_options, $political_party_id, 'id="political_party_id"'); ?>
			</div>
			<?php echo form_close(); ?>
		</div>
		<div class="list">
			<table id="congressman-list">
				<thead>
					<tr>
						<th>Nombre</th>
						<th>Bancada</th>
						<th>Distrito</th>
					</tr>
				</thead>
				<tbody>
				<?php if ($list): ?>
					<?php foreach ($list as $element): ?>
					<tr congressman-id="<?php echo $element->congressman_id; ?>" class="congressman-row">
						<td><?php echo $element->names . ' ' . $element->last_names; ?></td>
						<td><?php echo $element->party_name; ?></td>
						<td><?php echo $element->district_name; ?></td>
					</tr>
					<?php endforeach; ?>
				<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>	
</div>