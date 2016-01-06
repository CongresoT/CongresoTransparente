<form action="<?php echo site_url('admin/login'); ?>" method="post" name="admin-login" id="admin-login" accept-charset="utf-8"><table class="login-form" cellspacing="0" cellpadding="0">
	<tbody><tr>
		<td colspan="3"><h1><i class="icon-user"></i> Iniciar sesión</h1></td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2"><input type="text" name="login" value="" id="login" maxlength="80" size="30" placeholder="Correo electrónico">
		<div class="error-msg"></div>
		</td>
		<td></td>
	</tr>
	<tr>
		<td colspan="2"><input type="password" name="password" value="" id="password" size="30" placeholder="Contraseña">			
		<div class="error-msg"></div>
		</td>
		<td></td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>	
	<tr>
		<td>
		</td>	
		<td>
			<input type="hidden" name="submitted" value="1" />
			<button type="button" class="btn btn-saqaribal btn-lg" id="admin-login-btn">
				<i class="icon-user"></i> Iniciar sesión
			</button>
			<br /><br /> <a href="#" id="reinit-pw-btn">¿Olvidó su contraseña? Reiníciela acá</a>
		</td>
		<td>
		</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>	
</tbody></table>
</form>