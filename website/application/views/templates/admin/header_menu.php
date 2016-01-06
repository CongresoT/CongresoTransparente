			<ul class="main-menu">
				<li><a href="<?php echo site_url('admin'); ?>"<?php if (empty($data_parts['selected']) || $data_parts['selected'] == 'main') {$data_parts['selected'] = 'main'; echo ' class="menu-selected"'; } ?>><i class="icon-home"></i> Inicio</a></li>
			<?php 
				if (!empty($data_parts['menu_elements']) && is_array($data_parts['menu_elements'])):
					$i	= 0;
					while ($i < count($data_parts['menu_elements'])): 
						$parent		= $data_parts['menu_elements'][$i];
			?>
				<li>
					<?php 
						$menuChildren = '';
						if (($i + 1 < count($data_parts['menu_elements'])) && ($data_parts['menu_elements'][$i + 1]->parent != 1)):
							$i += 1;
							$module		= $data_parts['menu_elements'][$i];
					
							$menuChildren .=	'<div class="sub-menu-container">';
							$menuChildren .=	'	<ul class="sub-menu">';
							while (($i < count($data_parts['menu_elements'])) && ($data_parts['menu_elements'][$i]->parent != 1)):
								$module		= $data_parts['menu_elements'][$i];
								$menuChildren .=	'		<li>';
								$menuChildren .=	'			<a href="' . site_url('admin/' . $module->internal_name) . '"' . ($module->internal_name == $data_parts['selected'] ? ' class="menu-selected"' : '' ) . '>' . (!empty($module->icon_class) ? '<i class="' . $module->icon_class . '"></i> ' : '') . $module->name . '</a>';
								$menuChildren .=	'		</li>';
								if ($module->internal_name == $data_parts['selected']):
									$selected	= $parent->internal_name;
								endif;
								$i += 1;
							endwhile;
					
							$menuChildren .=	'	</ul>';
							$menuChildren .=	'</div>';
							$i -= 1;
						endif;
					?>
					<a href="" onclick="return false;" <?php echo ($parent->internal_name == $data_parts['selected'] ? ' class="menu-selected"' : '' ); ?>><?php echo (!empty($parent->icon_class) ? '<i class="' . $parent->icon_class . '"></i> ' : ''); echo $parent->name; ?></a>
					<?php
						echo $menuChildren;
					?>
				</li>
			<?php
						$i += 1;
					endwhile;
				endif;
				?>
			</ul>