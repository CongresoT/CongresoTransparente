<div class="main-container">	
	<?php echo $congressman_info; ?>
	<div class="congressman-votes">
		<div class="col-md-6 title-container">
			<div class="section-title">
				<img src="<?php echo site_url('assets/images/title-votes.png'); ?>" alt="Votaciones" />
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
		<div class="congressman-votes">
			<table id="congressman-votes-list">
				<tbody>
				<?php if ($vote_list): ?>
					<?php foreach ($vote_list as $element): ?>
					<tr class="congressman-vote-row">
						<td law-id="<?php echo $element->law_id; ?>">No. <?php echo $element->number; ?> - <?php echo $element->name; ?></td>
						<td><?php 
						switch ($element->vote_result_id)
						{
							case VOTE_RESULT_ID_YES:
								echo $element->vote_result_name . ' <img src="' . site_url('assets/images/icon-check.png') . '" alt="' . $element->vote_result_name . '" />';
							break;
							case VOTE_RESULT_ID_NO:
								echo $element->vote_result_name . ' <img src="' . site_url('assets/images/icon-cross.png') . '" alt="' . $element->vote_result_name . '" />';
							break;
							case VOTE_RESULT_ID_NONE:
								echo $element->vote_result_name . ' <img src="' . site_url('assets/images/icon-circle.png') . '" alt="' . $element->vote_result_name . '" />';
							break;
						}
						?></td>
					</tr>
					<?php endforeach; ?>
				<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="fb-comments" data-href="<?php echo site_url('diputado/' . $congressman_id); ?>">" data-numposts="5"></div>
</div>