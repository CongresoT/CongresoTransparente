<div class="vote-panel">
	<div id="window-error" class="msg-error" style="display: none">
	</div>
	Actividad legislativa: 
	<br/>
	<select class="select-search" id="law-search">
		<option></option>
	</select>
	<form id="form-vote" action="" method="post">
		<input type="hidden" name="law_id" id="law_id" value="<?php echo $law_id; ?>" />
	</form>
	<input type="hidden" id="default_law_text" value="<?php echo htmlspecialchars($default_law_text, ENT_QUOTES); ?>" />
	<?php if (!empty($congressmen) && is_array($congressmen)): ?>	
	<table class="vote-table">
		<tr class="vote-table-header">
			<td>Fotografía</td>
			<td>Nombre completo</td>
			<td>Votación</td>
			<td></td>
		</tr>
		<?php foreach ($congressmen as $i => $congressman): ?>
		<tr class="vote-table-data <?php echo (($i % 2 == 0) ? 'even': 'odd'); ?>" data-congressman_id="<?php echo $congressman->congressman_id; ?>">
			<td>
				<img src="<?php echo site_url('assets/images/congressman/thumbnail/' . ($congressman->photo ? $congressman->photo : 'default.png')); ?>" alt="<?php echo htmlspecialchars($congressman->last_names . ', ' . $congressman->names, ENT_QUOTES);?>">
			</td>
			<td>
				<?php echo $congressman->last_names . ', ' . $congressman->names;?>
			</td>
			<td>
				<img id="btn-vote-yes" data-vote_result_id="<?php echo VOTE_RESULT_ID_YES; ?>" src="<?php echo site_url('assets/images/admin/icon-vote-yes.png'); ?>" class="btn-vote <?php echo ($congressman->vote_result_id == VOTE_RESULT_ID_YES ? '' : 'grayed'); ?>" alt="A favor" title="A favor" />
				<img id="btn-vote-no" data-vote_result_id="<?php echo VOTE_RESULT_ID_NO; ?>" src="<?php echo site_url('assets/images/admin/icon-vote-no.png'); ?>" class="btn-vote <?php echo ($congressman->vote_result_id == VOTE_RESULT_ID_NO ? '' : 'grayed'); ?>" alt="En contra" title="En contra" />
				<img class="btn-vote-none" data-vote_result_id="<?php echo VOTE_RESULT_ID_NONE; ?>" src="<?php echo site_url('assets/images/admin/icon-vote-none.png'); ?>" class="btn-vote <?php echo ($congressman->vote_result_id == VOTE_RESULT_ID_NONE ? '' : 'grayed'); ?>" alt="Indeterminado" title="Indeterminado" />
			</td>
			<td class="btn-actions">
				<img id="btn-delete-congressman" src="<?php echo site_url('assets/images/admin/icon-delete.png'); ?>" alt="Eliminar diputado" title="Eliminar diputado" />
			</td>
		</tr>		
		<?php endforeach; ?>
	</table>
	<?php else: ?>	
	<div class="vote-no-data error-message">
		No existen datos. Revise que haya seleccionado una iniciativa.
	</div>
	<?php endif; ?>	
	Agregar diputado: <br/> <select class="select-search" id="congressman-search">
		<option></option>
	</select>
	<input type="hidden" id="congressman_id" />
	<img id="btn-add-congressman" src="<?php echo site_url('assets/images/admin/icon-add.png'); ?>" alt="Agregar diputado" title="Agregar diputado" />
	<br /><br />
	<input type="button" id="btn-delete-congressmen" value="Eliminar todos" title="Eliminar todos" />
</div>