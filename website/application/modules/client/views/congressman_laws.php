<div class="main-container">	
	<?php echo $congressman_info; ?>
	<div class="congressman-laws">
		<div class="col-md-6 title-container">
			<div class="section-title">
				<img src="<?php echo site_url('assets/images/title-proposed-laws.png'); ?>" alt="Leyes" />
			</div>	
		</div>
		<div class="col-md-6 back-container">
			<a href="<?php echo site_url('diputado/' . $congressman_id); ?>"><img src="<?php echo site_url('assets/images/btn-back.png'); ?>" alt="Regresar" /></a>
		</div>
		<div class="search-form">
			<?php echo form_open('', array('method' => 'post', 
			'id' => 'frmSearch')); ?>
			<div class="col-md-12 search">
				<div class="col-md-7 searchtext">
					Historial de todas las votaciones
				</div>
				<div class="col-md-5 searchbox">	
					<?php echo form_input(array('name' => 'searchquery', 
					'id' => 'searchquery',
					'value' => $searchquery,
					'placeholder' => 'BUSCAR')); ?><input type="image" src="<?php echo site_url('assets/images/btn-search.png'); ?>" class="btn-search" />
				</div>
			</div>
			<div class="col-md-12 law-type">
				<?php echo form_input(array('name' => 'law_type_id', 
				'id' => 'law_type_id',
				'value' => $law_type_id,
				'type' => 'hidden')); ?>
				<?php if (count($law_type_list)): ?>
				<ul class="law-type-list">				
					<li class="btn-law-type<?php echo ($law_type_id == 0 ? ' selected' : ''); ?>" style="width: <?php echo 100/(count($law_type_list) + 1); ?>%" law-type-id="0">
						<div class="law-type-text">Todos</div>
					</li>
					<?php foreach ($law_type_list as $item): ?>
					<li class="btn-law-type<?php echo ($law_type_id == $item->law_type_id ? ' selected' : ''); ?>" style="width: <?php echo 100/(count($law_type_list) + 1); ?>%" law-type-id="<?php echo $item->law_type_id; ?>">
						<div class="law-type-text"><?php echo $item->name; ?></div>
					</li>
					<?php endforeach; ?>
				</ul>
				<?php endif; ?>
			</div>
			<?php echo form_close(); ?>
		</div>
		<div class="congressman-laws">
			<table id="congressman-laws-list">
				<thead>
					<tr>
						<th></th>
					</tr>
				</thead>			
				<tbody>
				<?php if ($laws_list): ?>
					<?php foreach ($laws_list as $element): ?>
					<tr class="congressman-law-row" law-id="<?php echo $element->law_id; ?>">
						<td>No.<?php echo $element->number; ?> - <?php echo $element->name; ?></td>
						<td><?php echo $element->law_type_id; ?></td>
					</tr>
					<?php endforeach; ?>
				<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="fb-comments" data-href="<?php echo site_url('diputado/' . $congressman_id); ?>">" data-numposts="5"></div>
</div>