	<!-- Inicio SubMenu Presença -->
	<div class="row">
		<div class="col-sm-6">
			<input type="date" class="form-control" name="Data_Encontro">
			<br>
		</div>
		<div class="col-sm-6">
			<button type="submit" class="btn btn-round btn-success" formaction="{{route('celula.presenca')}}"> Confirmar Presenças</button>
			<button type="submit" class="btn btn-round btn-success" formaction="{{ route('celula.carregaPresenca', Request::route('id') ) }}"> Carregar Presentes</button>
			<br>
		</div>
	</div>
	<!-- Fim SubMenu Presença -->