@extends('layouts.app') @section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			<i class="fa fa-fw fa-line-chart" aria-hidden="true"></i> Detalhes do Evento
		</h3>
	</div>
	<div class="panel-body">

		<!-- EVE `eveid` -->
		<h3 class="text-center"><b><u>{{$evento->Nome}}</u></b></h3>
		
		@if (
				$prazos->min('Prazo_Data') <= \Carbon\Carbon::now()->format('Y-m-d') && 
				$prazos->max('Prazo_Data') >= \Carbon\Carbon::now()->format('Y-m-d')
			)
		<form method="post" action="{{route('evento.inscrever', $evento->id)}}">
			{!! csrf_field() !!}
			<button type="submit" class="btn btn-block btn-info"> 
				<i class="fa fa-toggle-right"></i><b> - Inscrever - </b> <i class="fa fa-toggle-left"></i>
			</button>
		</form>
	    @endif
	                    <hr>

		<div class="row">
			<div class="col-lg-6">
				<p>
				
				
				<!-- h4>Tipo Evento:</h4> 'tevTipoEvento'</p>
				<hr -->

				<p>
					<h4>Duração:</h4> 
					De {{\Carbon\Carbon::createFromFormat('Y-m-d', $evento->Inicio)->format('d/m/Y')}}
					a {{\Carbon\Carbon::createFromFormat('Y-m-d', $evento->Final)->format('d/m/Y')}}
				</p>
				<hr>

				<p>
					<h4>Inscrições:</h4>
					<ul>
						@if ( isset($prazos) )
						<li>Prazos:</li>
							@foreach ($prazos as $prazo)
							<ul>
								<li>{{\Carbon\Carbon::createFromFormat('Y-m-d', $prazo->Prazo_Data)->format('d/m/Y')}}</li>
								<li>{{$prazo->Prazo_Valor}}<hr></li>
							</ul>
							@endforeach
						@endif
					</ul>
				</p>
			</div>
			<div class="col-lg-6">
				<p>
					<h4>Vagas:</h4>{{$evento->Quantidade_Vagas}}
				</p>
				<hr>

				<p>
					<h4>Restrições:</h4>
					@if ( isset($restricoes->idade_Minima) )Idade Mínima: {{ $restricoes->idade_Minima }} <br>@endif
					@if ( isset($restricoes->idade_Maxima) )Idade Máxima: {{$restricoes->idade_Maxima}} <br>@endif
					@if ( isset($restricoes->genero) )Gênero Permitido: {{$restricoes->genero}} <br>@endif
					@if ( isset($restricoes->EstadoCivils_idEstadoCivils) )Estado Civil Permitido: {{$restricoes->description}} <br>@endif
				</p>
				<p><h4>Detalhes:</h4> {{$evento->description or ''}}</p>
			</div>
		</div>
	</div>
</div>
@endsection
