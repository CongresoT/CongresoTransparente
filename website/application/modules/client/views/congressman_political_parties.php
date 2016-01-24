<div class="main-container">	
	<?php echo $congressman_info; ?>
	<div class="congressman-parties">
		<div class="col-md-6 title-container">
			<div class="section-title">
				<img src="<?php echo site_url('assets/images/title-parties.png'); ?>" alt="Asistencia" />
			</div>	
		</div>
		<div class="col-md-6 back-container">
			<a href="<?php echo site_url('diputado/' . $congressman_id); ?>"><img src="<?php echo site_url('assets/images/btn-back.png'); ?>" alt="Regresar" /></a>
		</div>
		<div class="congressman-parties-graph">
			<div class="graph-row">
				<div class="graph-party-left top"></div><div class="graph-party-middle top"></div><div class="graph-party-right top"></div>
			</div>
		<?php foreach ($political_parties_list as $i => $element): ?>
			<div class="graph-row">
				<div class="graph-party-left">
					<?php if ($i % 2 == 0): ?>
					<span class="graph-party-text">
						<?php echo date_parse($element->date_begin)['year'] . (($element->date_end == null or $element->date_end == '') ? '' : ' - ' . date_parse($element->date_end)['year']); ?>
					</span>
					<span class="graph-party-image">
						<img src="<?php echo site_url('assets/images/' . ($element->logo ? 'political_party/thumbnail/' . $element->logo : 'political-party.png')); ?>" style="background-color: #<?php echo (!$element->logo ? $element->color : 'FFFFFF'); ?>" alt="<?php echo  htmlspecialchars($element->full_name, ENT_QUOTES); ?>" />
						<br/>
						<?php echo  htmlspecialchars($element->short_name, ENT_QUOTES); ?>
					</span>
					<span class="graph-party-pointer">
					</span>					
					<?php endif; ?>
				</div><div class="graph-party-middle"></div><div class="graph-party-right">
					<?php if ($i % 2 == 1): ?>
					<span class="graph-party-pointer">
					</span>
					<span class="graph-party-image">
						<img src="<?php echo site_url('assets/images/' . ($element->logo ? 'political_party/thumbnail/' . $element->logo : 'political-party.png')); ?>" style="background-color: #<?php echo (!$element->logo ? $element->color : 'FFFFFF'); ?>" alt="<?php echo  htmlspecialchars($element->full_name, ENT_QUOTES); ?>" />
						<br/>
						<?php echo  htmlspecialchars($element->short_name, ENT_QUOTES); ?>						
					</span>
					<span class="graph-party-text">
						<?php echo date_parse($element->date_begin)['year'] . (($element->date_end == null or $element->date_end == '') ? '' : ' - ' . date_parse($element->date_end)['year']); ?>
					</span>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
			<div class="graph-row">
				<div class="graph-party-left bottom"></div><div class="graph-party-middle bottom"></div><div class="graph-party-right bottom"></div>
			</div>		
		</div>
	</div>
	<div class="fb-comments" data-href="<?php echo site_url('diputado/' . $congressman_id); ?>">" data-numposts="5"></div>
</div>