<div class="attendance-panel">
	<div id="window-error" class="msg-error" style="display: none">
	</div>
	Sesión: 
	<br/>
	<select class="select-search" id="congress_session-search">
		<option></option>
	</select>
	<form id="form-attendance" action="" method="post">
		<input type="hidden" name="congress_session_id" id="congress_session_id" value="<?php echo $congress_session_id; ?>" />
	</form>
	<input type="hidden" id="default_congress_session_text" value="<?php echo htmlspecialchars($default_congress_session_text, ENT_QUOTES); ?>" />
	<?php if (!empty($congressmen) && is_array($congressmen)): ?>	
	<table class="attendance-table">
		<tr class="attendance-table-header">
			<td>Fotografía</td>
			<td>Nombre completo</td>
			<td>Asistencia</td>
			<td></td>
		</tr>
		<?php foreach ($congressmen as $i => $congressman): ?>
		<tr class="attendance-table-data <?php echo (($i % 2 == 0) ? 'even': 'odd'); ?>" data-congressman_id="<?php echo $congressman->congressman_id; ?>">
			<td>
				<img src="<?php echo site_url('assets/images/congressman/thumbnail/' . ($congressman->photo ? $congressman->photo : 'default.png')); ?>" alt="<?php echo htmlspecialchars($congressman->last_names . ', ' . $congressman->names, ENT_QUOTES);?>">
			</td>
			<td>
				<?php echo $congressman->last_names . ', ' . $congressman->names;?>
			</td>
			<td>
				<img id="btn-attendance-yes" data-attendance_state_id="<?php echo ATTENDANCE_STATE_ID_YES; ?>" src="<?php echo site_url('assets/images/admin/icon-attendance-yes.png'); ?>" class="btn-attendance <?php echo ($congressman->attendance_state_id == ATTENDANCE_STATE_ID_YES ? '' : 'grayed'); ?>" alt="Presente" title="Presente" />
				<img id="btn-attendance-no" data-attendance_state_id="<?php echo ATTENDANCE_STATE_ID_NO; ?>" src="<?php echo site_url('assets/images/admin/icon-attendance-no.png'); ?>" class="btn-attendance <?php echo ($congressman->attendance_state_id == ATTENDANCE_STATE_ID_NO ? '' : 'grayed'); ?>" alt="Ausente" title="Ausente" />
				<img id="btn-attendance-no-justified" data-attendance_state_id="<?php echo ATTENDANCE_STATE_ID_NO_JUSTIFIED; ?>" src="<?php echo site_url('assets/images/admin/icon-attendance-no-justified.png'); ?>" class="btn-attendance <?php echo ($congressman->attendance_state_id == ATTENDANCE_STATE_ID_NO_JUSTIFIED ? '' : 'grayed'); ?>" alt="Ausente con justificación" title="Ausente con justificación" />
				<img id="btn-attendance-none" data-attendance_state_id="<?php echo ATTENDANCE_STATE_ID_NONE; ?>" src="<?php echo site_url('assets/images/admin/icon-attendance-none.png'); ?>" class="btn-attendance <?php echo ($congressman->attendance_state_id == ATTENDANCE_STATE_ID_NONE ? '' : 'grayed'); ?>" alt="Indeterminado" title="Indeterminado" />
			</td>
			<td class="btn-actions">
				<img class="btn-delete-congressman" src="<?php echo site_url('assets/images/admin/icon-delete.png'); ?>" alt="Eliminar diputado" title="Eliminar diputado" />
			</td>
		</tr>		
		<?php endforeach; ?>
	</table>
	<?php else: ?>	
	<div class="attendance-no-data error-message">
		No existen datos. Revise que haya seleccionado una sesión.
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