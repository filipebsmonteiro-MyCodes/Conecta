@extends('layouts.app') 

@section('content')
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	
	@if (Auth::check())
		<!-- Button Cadastrar -->
		@can('evento_create')
		<a href="{{route('evento.create')}}" class="btn btn-success"> <i
			class="fa fa-plus"></i> | Cadastrar
		</a>
		@endcan
		<!-- END Button Cadastrar -->
		<!-- Button Gerenciar -->
		@can('evento_list')
		<a href="{{route('evento.listar')}}" class="btn btn-default"> <i
			class="fa fa-cog"></i> | Gerenciar
		</a>
		@endcan
		<!-- END Button Gerenciar -->
	@else
		<!-- br>
		<form method="post" action="{{route('evento.index')}}">
			{!! csrf_field() !!}
			<div class="row">
				<div class=" col-lg-3 col-md-3 col-sm-3 col-xs-3">
					<button type="submit" class="btn btn-success">Carregar Eventos</button>
				</div>
				<div class=" col-lg-9 col-md-9 col-sm-9 col-xs-9">
					<select name="idIgr" class="form-control">
						@foreach($igrejas as $igreja)
							<option value="{{$igreja->id}}">
								<a href="{{route('evento.index', $igreja->id)}}">{{$igreja->nome}}</a>
							</option>
						@endforeach
					</select>
				</div>
			</div>
		</form -->
		<br>
	@endif
	
	@if (isset ( $eventosAtuais )) 
	<div class="panel panel-success">
		<div class="panel-heading">
			<h4>Eventos Atuais</h4>
		</div>
		<div class="panel-body">
			@forelse ($eventosAtuais as $evento)
			<dl class="dl-horizontal">
				<dt>Evento</dt>
				<dd>
					<a href="{{route('evento.show', $evento->id)}}"> <u>{{$evento->Nome}}</u>
					</a>
				</dd>

				<dt>Data Evento</dt>
				<dd>@if(isset($evento->Inicio)){{
								\Carbon\Carbon::createFromFormat('Y-m-d', $evento->Inicio)->format('d/m/Y')
				}}@endif</dd>

				<dt>Local</dt>
				<dd>{{$evento->Local}}</dd>

				<dt>Termino Inscricoes</dt>
				<dd>@if(isset($evento->Final)){{
								\Carbon\Carbon::createFromFormat('Y-m-d', $evento->Final)->format('d/m/Y')
				}}@endif</dd>
			</dl>
			@empty
			 <p>Não há Eventos Atuais no momento!</p>
			@endforelse
		</div>
	</div>
	@endif @if (isset ( $eventosFuturos ) && $eventosFuturos[0]->id != null) 
	
	<div class="panel panel-info">
		<div class="panel-heading">
			<h4>Eventos Futuros</h4>
		</div>
		<div class="panel-body">
			@foreach ($eventosFuturos as $evento) 
			<dl class="dl-horizontal">
				<dt>Evento</dt>
				<dd>
					<a href="{{route('evento.show', $evento->id)}}"> <u>{{$evento->Nome}}</u>
					</a>
				</dd>

				<dt>Data Evento</dt>
				<dd>@if(isset($evento->Inicio)){{
								\Carbon\Carbon::createFromFormat('Y-m-d', $evento->Inicio)->format('d/m/Y')
				}}@endif</dd>

				<dt>Local</dt>
				<dd>{{$evento->Local}}</dd>

				<dt>Inicio Inscrições</dt>
				<dd>@if(isset($evento->Abertura)){{
								\Carbon\Carbon::createFromFormat('Y-m-d', $evento->Abertura)->format('d/m/Y')
				}}@endif</dd>
			</dl>
			@endforeach
		</div>
	</div>
	@endif @if (isset ( $eventosPassados ))
	
	<div class="panel panel-danger">
		<div class="panel-heading">
			<h4>Eventos Passados</h4>
		</div>
		<div class="panel-body">
			@forelse ($eventosPassados as $evento)
			<dl class="dl-horizontal">
				<dt>Evento</dt>
				<dd>
					<a href="{{route('evento.show', $evento->id)}}"> <u>{{$evento->Nome}}</u>
					</a>
				</dd>

				<dt>Ultimo dia do Evento</dt>
				<dd>@if(isset($evento->Final)){{
								\Carbon\Carbon::createFromFormat('Y-m-d', $evento->Final)->format('d/m/Y')
				}}@endif</dd>

				<dt>Local</dt>
				<dd>{{$evento->Local}}</dd>
			</dl>
			@empty
			 <p>Não há Eventos Passados no momento!</p>
			@endforelse
		</div>
	</div>

	@endif @if (!isset ( $eventosAtuais ) && !isset ( $eventosFuturos ) && !isset ( $eventosPassados ))
	<p><b>Não Há Eventos Cadastrados!</b></p>
	@endif

</div>
@endsection
