<div>
<form action="" method="post">
Filtrar por rango de fechas: <input type="" name="date_begin" id="date_begin" value="<?php echo $filters['date_begin']; ?>" readonly="readonly" /> a <input type="" name="date_end" id="date_end" value="<?php echo $filters['date_end']; ?>" readonly="readonly" /> 
<input type="submit" value="Filtrar" />
</form>
<br/><br/>
<?php echo $content->output; ?>
</div>