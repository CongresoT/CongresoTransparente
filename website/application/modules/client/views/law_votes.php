<div class="main-container">	
	<?php echo $law_info; ?>
	<div class="law-votes">
		<div class="col-md-6 title-container">
			<div class="section-title">
				<img src="<?php echo site_url('assets/images/title-votes.png'); ?>" alt="Votaciones" />
			</div>	
		</div>
		<div class="col-md-6 back-container">
			<a href="<?php echo site_url('actividad_legislativa/' . $law_id); ?>"><img src="<?php echo site_url('assets/images/btn-back.png'); ?>" alt="Regresar" /></a>
		</div>
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
			<div class="col-md-4 political_party">
				<h3 class="sub-title">Bancada</h3>
				<?php echo form_dropdown('political_party_id', $political_party_options, $political_party_id, 'id="political_party_id"'); ?>
			</div>
			<?php echo form_close(); ?>
			<div class="clear"></div>
		</div>
		<div class="law-votes">
			<table id="law-votes-list">
				<thead>
					<th>Diputado</th>
					<th>Bancada</th>
					<th>Voto</th>
				</thead>
				<tbody>
				<?php if ($vote_list): ?>
					<?php foreach ($vote_list as $element): ?>
					<tr class="law-vote-row">
						<td congressman-id="<?php echo $element->congressman_id; ?>"><?php echo $element->names; ?> - <?php echo $element->last_names; ?></td>
						<td><?php echo $element->political_party; ?></td>
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
	<div class="fb-comments" data-href="<?php echo site_url('actividad_legislativa/' . $law_id); ?>">" data-numposts="5"></div>
</div>