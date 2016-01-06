<div>
<?php if (!empty($tabs)): ?>
<div id="tabs">
	<ul>
	<?php foreach ($tabs as $i => $tab): ?>
		<li><a id="<?php echo $tab['id']; ?>-btn" href="#<?php echo $tab['id']; ?>"><?php echo $tab['title']; ?></a></li>
	<?php endforeach; ?>
	</ul>
	<?php foreach ($tabs as $i => $tab): ?>
	<div id="<?php echo $tab['id']; ?>">
		<?php switch ($tab['type']) {
			case 'gcrud':
				echo $tab['content']->output;
				break;
			case 'content':
				echo $tab['content'];
				break;
			case 'url':
			?>
			<iframe src="<?php echo $tab['content']; ?>" width="100%" height="100%"></iframe>
			<?php
				break;
		} ?>
	</div>		
	<?php endforeach; ?>
</div>
<?php else: ?>
<?php echo $content->output; ?>
<?php endif; ?>
</div>