@extends('layouts.app') 

@section('content')
<div class="col-lg-12">
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3>
				<b>Visualizar Célula</b>
			</h3>
		</div>
		<div class="panel-body">

			<u><h3 class="text-center">{{$celula->Nome}}</h3></u>

			<hr>

			<div class="row">
				<div class="col-lg-6">
					<p>
					
					
					<h4>Líder:</h4>
					<blockquote>
						@foreach($membros as $membro)
							<h5>{{($membro->cargo == 'Lider') ? $membro->first_name : ''}}</h5>
						@endforeach
					</blockquote>
					</p>
					<hr>

					<p>
					
					
					<h4>Líder em Treinamento:</h4>
					<blockquote>
						@foreach($membros as $membro)
							<h5>{{($membro->cargo == 'Lider em Treinamento') ? $membro->first_name : ''}}</h5>
						@endforeach
					</blockquote>
					</p>
					<hr>

					<p>
					
					
					<h4>Região:</h4>
					<blockquote>
						<h5>{{$regiao->nome or ''}}</h5>
					</blockquote>
					</p>
				</div>
				<div class="col-lg-6">
					<p>
					
					
					<h4>Data do Útimo Encontro:</h4>
					<blockquote>
						<h5>
						@if(isset($encontro)){{
								\Carbon\Carbon::createFromFormat('Y-m-d H:m:i', $encontro)->format('d/m/Y')
						}}@endif
						</h5>
					</blockquote>
					</p>
					<hr>

					<p>
					
					
					<h4>Participantes:</h4>
					<blockquote>
						<h5>
							<ul>
								@foreach($membros as $membro)
								@if($membro->cargo == 'Membro')
									<li>{{$membro->first_name}}</li>
								@endif
								@endforeach
							</ul>
						</h5>
					</blockquote>
					</p>
				</div>
			</div>

		</div>
		<!-- Panel Body -->
	</div>
</div>
@endsection
