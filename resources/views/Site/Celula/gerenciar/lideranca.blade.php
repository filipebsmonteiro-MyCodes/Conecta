
	<!-- Inicio SubMenu Liderança -->
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6">
			@forelse ($participantes as $participante) 
				@if ($participante->cargo == 'Lider em Treinamento') 
					<div class="btn-group" style="margin-bottom: 10px;">
						<button type="button" class="btn btn-default">
							{{ $participante->first_name }} {{ $participante->last_name }}
							<span class="badge label-warning">Líder Em Treinamento</span>
						</button>
						<a href="{{route('celula.removeLideranca', $participante->idRelacionamento) }}"
							 class="btn btn-danger">X</a>
					</div>
				@endif
				@if ($participante->cargo == 'Lider')
					<div class="btn-group" style="margin-bottom: 10px;">
						<button type="button" class="btn btn-default">
							{{ $participante->first_name }} {{ $participante->last_name }}
							<span class="badge label-warning">Líder</span>
						</button>
						<a href="{{route('celula.removeLideranca', $participante->idRelacionamento) }}"
							 class="btn btn-danger">X</a>
					</div>
				@endif
			@empty
			@endforelse
		</div>
		
		<div class="col-sm-6">
			<button type="submit" class="btn btn-round btn-success" formaction="{{route('celula.lideranca')}}"> Tornar Líder</button>
			<button type="submit" class="btn btn-round btn-success" formaction="{{route('celula.subLideranca')}}"> Tornar Líder Em Treinamento</button>
		</div>
	</div>
	<br>
	<!-- Fim SubMenu Liderança -->