<div>
<div id="tabs">
  <ul>
    <li><a href="#tabs-1">General</a></li>
    <li><a href="#tabs-2">Filtros Demográficos</a></li>
    <!--li><a href="#tabs-3">Opciones de gráfica</a></li-->
  </ul>
  <div id="tabs-1">
    <table>
		<tr>
			<td>Empresa:</td>
			<td><select id="company_id" name="company_id">
			</select></td>
			
			<td>Tipo de datos:</td>
			<td><select id="data_type" name="data_type">
				<option value="1">Satisfacción</option>
				<option value="2">Importancia</option>
				<option value="3">Satisfacción - Importancia</option>
				<option value="4">Importancia - Satisfacción</option>
				<option value="5">Comparativa Satisfacción</option>
				<option value="6">Comparativa Importancia</option>
			</select></td>
		</tr>
		<tr>
			<td>Encuesta:</td>
			<td><select id="survey_id" name="survey_id">
			</select></td>
			
			<td>Tipo de reporte:</td>
			<td><select id="report_type" name="report_type">
				<option value="1">Gráfico</option>
				<option value="2">Tabla</option>
			</select></td>
		</tr>
		<tr>
			<td>Categoría:</td>
			<td><select id="survey_category_id" name="survey_category_id">
			</select></td>
			
			<td><input type="radio" name="dataset" id="dataset_1" value="1" checked="true" /> Datos 1
			<input type="radio" name="dataset" id="dataset_2" value="2" /> Datos 2 </td>
			<td></td>
		</tr>
		<tr>
			<td>Pregunta:</td>
			<td><select id="survey_question_id" name="survey_question_id" style="max-width: 50%">
			</select></td>
			
			<td></td>
			<td></td>
		</tr>
	</table>
  </div>
  <div id="tabs-2">
    <div id="demographic-options">
	</div>
  </div>
  <!--div id="tabs-3">
    <p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
    <p>Duis cursus. Maecenas ligula eros, blandit nec, pharetra at, semper at, magna. Nullam ac lacus. Nulla facilisi. Praesent viverra justo vitae neque. Praesent blandit adipiscing velit. Suspendisse potenti. Donec mattis, pede vel pharetra blandit, magna ligula faucibus eros, id euismod lacus dolor eget odio. Nam scelerisque. Donec non libero sed nulla mattis commodo. Ut sagittis. Donec nisi lectus, feugiat porttitor, tempor ac, tempor vitae, pede. Aenean vehicula velit eu tellus interdum rutrum. Maecenas commodo. Pellentesque nec elit. Fusce in lacus. Vivamus a libero vitae lectus hendrerit hendrerit.</p>
  </div-->
</div>
<button id="btn-generate">Generar</button>
<div class="clear"></div>
<div id="report-data">
</div>
</div>