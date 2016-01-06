<div>
	<table border="1"  class="parameters">
		<thead>
			<th>Parametro</th>
			<th>Valor</th>
		</thead>
		<tbody>
		<?php foreach ($table as $row) {?>
		<tr id="param-<?php echo $row->key; ?>">
			<td class="name">
				<?php echo $row->description; ?>
			</td>
			<td class="value">
				<div id="param-<?php echo $row->key; ?>-value" class="param-value" style="float: left;">
				<?php echo $row->value; ?>
				</div>
				<div id="param-<?php echo $row->key; ?>-edit" class="param-edit">
					<?php 
					switch($row->type)
					{
						case 'string':
						case 'email':
						case 'int':
						?>
						<input type="text" param="<?php echo $row->type; ?>" name="<?php echo $row->key; ?>" value="<?php echo $row->value; ?>">
						<?php
							break;
					}
					?>
				</div>
				<button class="edit-action" style="float:right" value="<?php echo $row->key; ?>">...</button>
				<div style="clear: both"></div>
			</td>
		</tr>
		<?php } ?>
		</tbody>
	</table>
</div>