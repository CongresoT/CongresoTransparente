<div class="law-info">
	<div class="law-info-container">
		<div class="col-md-12">
			<div class="law-info-container">
				<span class="label-fullname"><?php echo $law->name; ?></span>
				<p></p>
				<span class="law-label">Número: </span><span class="law-value"><?php echo $law->number; ?></span>
				<br/>
				<span class="law-label">Fecha de presentación: </span><span class="law-value"><?php echo $law->presentation_date; ?></span>
				<br/>
				<span class="law-label">Estado: </span><span class="law-value"><?php echo $law->law_status; ?></span>
				<br/>
				<span class="law-label">Ponentes: </span><span class="law-value">
					<?php if ($congressman_list): ?>
					<?php foreach ($congressman_list as $i => $congressman): ?>
					<a href="<?php echo site_url('diputado/' . $congressman->congressman_id); ?>"><?php echo $congressman->names . ' ' . $congressman->last_names; ?></a>
					<?php if ($i < count($congressman_list) - 1): ?>
					,
					<?php endif; ?>
					<?php endforeach; ?>
					<?php endif; ?>
					<?php if ($congressman_list && $person_list): ?>
					,
					<?php endif; ?>					
					<?php if ($person_list): ?>
					<?php foreach ($person_list as $i => $person): ?>
					<?php echo $person->full_name; ?>
					<?php if ($i < count($person) - 1): ?>
					,
					<?php endif; ?>
					<?php endforeach; ?>
					<?php endif; ?>
				</span>
				<br/>
				<span class="law-label">Comisión: </span><span class="law-value"><?php echo $law->commission; ?></span>				
			</div>
		</div>
		<div class="col-md-12 law-description">
			<?php echo $law->description; ?>
		</div>
		<div class="clear"></div>
	</div>
</div>