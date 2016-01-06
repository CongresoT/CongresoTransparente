<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Congreso Transparente</title>
</head>
<body style="margin:0;padding:0;">
<div align="center">
				 <table width="650" border="0" align="center" cellpadding="0" cellspacing="0" style="background: #FFFFFF">
					<tr bgcolor="#95c022">
						<td width="250" height="26" style="color: #FFFFFF; padding-left: 5px">
							<?php echo date('d/m/Y'); ?>
						</td>
						<td width="400" height="26" style="color: #FFFFFF; padding-right: 5px" align="right">
							SIDEM
						</td>
					</tr>
					<tr>
						<td align="left" style="padding: 5px 0 5px 5px">
							<img src="<?php echo site_url('assets/images/logo_mini.png'); ?>" />
						</td>
					</tr>
					<tr>
						<td align="left" colspan="2" style="color: black;font-family: Arial;font-size: 11pt;font-weight: normal; padding-left: 5px">
<?php 
echo $content;
?>
						</td>
					</tr>
				   <tr>
					 <td colspan="2" align="center" ><hr style="background-color: #D1D2D4;border: 1px none; color: #D1D2D4;height: 1px;margin:0;padding:0; margin-top:36px;">
						   Copyright &copy; <?php echo date("Y");?>. Congreso Transparente. Todos los Derechos Reservados</div></td>
				   </tr>					
</table>
</div>
</body>
</html>